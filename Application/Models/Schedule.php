<?php
namespace App\Models;

use App\Core\Exceptions\NewTaskException;
use App\Core\Libraries\FileCache;
use Inno\Base\Model;
use App\Core\Libraries\SSHClient;

/**
 * Class Schedule
 * @package App\Models
 */
class Schedule extends Model {
    /**
     * @var \App\Core\Libraries\SSHClient
     */
    private $sshClient;

    private const QUEUE_CACHE_TIME = 60 * 5;

    public function __construct(SSHClient $sshClient) {
        parent::__construct();

        $this->sshClient = $sshClient;
    }

    /**
     * @param array $filter
     *
     * @return array
     * @throws \Exception
     */
    public function getTasksQueue($filter = []) : array {
        $queue = [];

        $infoTemp = $this->sshClient->execute("squeue --format=\"%all\"");

        $infoParts = explode("\n", $infoTemp);

        $keys = explode("|", $infoParts[0]);

        $partsCount = count($infoParts);
        $keysCount = count($keys);
        for ($i = 1; $i < $partsCount; $i++) {
            if (empty($infoParts[$i]))
                continue;

            $infoPartData = [];
            $infoPartTempData = explode("|", $infoParts[$i]);

            for ($j = 0; $j < $keysCount; $j++)
                $infoPartData[$keys[$j]] = $infoPartTempData[$j];

            $task = [
                'id' => $infoPartData['JOBID'],
                'name' => $infoPartData['NAME'],
                'user_id' => $infoPartData['USER'],
                'user_name' => $this->getTaskAuthorById((int)$infoPartData['USER']),
                'status' => $infoPartData['STATE'],
                'start_time' => $this->unixDateToDateTime($infoPartData['START_TIME']),
                'registration_time' => $this->unixDateToDateTime($infoPartData['SUBMIT_TIME']),
                'time_limit' => $this->unixIntervalToDateInterval($infoPartData['TIME_LIMIT']),
                'time_left' => $this->unixIntervalToDateInterval($infoPartData['TIME_LEFT']),
                'time_elapsed' => $this->unixIntervalToDateInterval($infoPartData['TIME']),
                'nodes_count' => $infoPartData['NODES'],
                'min_cpus_count' => $infoPartData['MIN_CPUS'],
                'min_memory' => $infoPartData['MIN_MEMORY'],
                'nodes_list' => explode(',', $infoPartData['NODELIST']),
            ];

            $task['end_time'] = ( new \DateTime('@'.$task['start_time']->getTimestamp()) )->add($task['time_limit']);
            $queue[] = $task;
        }

        if (!empty($filter['userId'])) {
            $queue = array_filter($queue, function ($task) use ($filter) {
                return $task['user_id'] == (int)$filter['userId'];
            });
        }

        return $queue;
    }

    /**
     * @param array $queue
     *
     * @return array
     */
    public function getTasksStatistics(array $queue) {
        $waitingTasksCount = count(array_filter($queue, function($task) {
            return $task['status'] != 'RUNNING';
        }));

        return [
            'totalTasks' => count($queue),
            'waitingTasks' => $waitingTasksCount,
        ];
    }

    /**
     * @param array $queue
     * @param int $userId
     *
     * @return array
     */
    public function getUserTasksStatistics(array $queue, int $userId) {
        $userTasksCount = count(array_filter($queue, function($task) use ($userId) {
            return $task['user_id'] == $userId;
        }));

        $userWaitingTasksCount = count(array_filter($queue, function($task) use ($userId) {
            return $task['user_id'] == $userId && $task['status'] != 'RUNNING';
        }));

        return [
            'totalTasks' => $userTasksCount,
            'waitingTasks' => $userWaitingTasksCount,
        ];
    }

    /**
     * @param $queue
     *
     * @return array
     */
    public function groupTasksByNodes($queue) : array {
        $nodesQueue = [];

        foreach ($queue as $taskId => $task) {
            foreach ($task['nodes_list'] as $nodeId) {
                if (empty($nodesQueue[$nodeId]))
                    $nodesQueue[$nodeId] = [];

                $nodesQueue[$nodeId][] = $taskId;
            }
        }

        return $nodesQueue;
    }

    /**
     * @param $queue
     *
     * @return array
     */
    public function convertToDailySchedule($queue) : array {
        $days = [];

        foreach ($queue as $taskId => $task) {
            $startDayId = $task['start_time']->getTimestamp() / (24 * 3600);
            $endDayId = $task['end_time']->getTimestamp() / (24 * 3600);

            if ($endDayId - $startDayId > 1) {
                for ($day = $startDayId + 1; $day <= $endDayId; $day++) {
                    if (empty($days[$day]))
                        $days[$day] = [];

                    $days[$day][] = $taskId;
                }
            }

            if (empty($days[$startDayId]))
                $days[$startDayId] = [];

            $days[$startDayId][] = $taskId;
        }

        return $days;
    }

    /**
     * @param array $filter
     *
     * @return bool
     * @throws \Exception
     */
    public function canStartTask($filter=[]) : bool {
        $queue = $this->getTasksQueue();

        $nodesQueue = $this->groupTasksByNodes($queue);

        $currentTimestamp = (int)$this->sshClient->execute('date +%s');

        $numInstances = !empty($filter['instances']) ? (int)$filter['instances'] : 1;

        // TODO: custom start time
        $startTime = !empty($filter['startTime']) ? $filter['startTime'] : $currentTimestamp;

        // TODO: end time
        $endTime = !empty($filter['timeLimit']) ? $currentTimestamp + $filter['timeLimit'] : $currentTimestamp;

        $numFreeNodes = 10;

        foreach ($nodesQueue as $nodeTasks) {
            $nodeIsSuitableByTime = true;

            foreach ($nodeTasks as $taskId) {
                $task = $queue[$taskId];

                $taskStartTime = $task['start_time']->getTimestamp();
                $taskEndTime = $task['end_time']->getTimestamp();

                if ($taskStartTime >= $startTime && $taskStartTime <= $endTime || $taskStartTime < $startTime && $taskEndTime >= $startTime && $taskEndTime <= $endTime) {
                    $nodeIsSuitableByTime = false;
                }
            }

            if (!$nodeIsSuitableByTime)
                $numFreeNodes-- ;
        }

        return $numFreeNodes >= $numInstances;
    }

    /**
     * @param array $taskData
     * @param string $sourcePath
     * @param string $scriptPath
     *
     * @throws \App\Core\Exceptions\NewTaskException
     */
    public function startNewTask(array $taskData, string $sourcePath, string $scriptPath) {
        $task = $taskData;

        $canStartTask = $this->canStartTask([
            'startTime' => (!empty($task['startTime'])) ? strtotime($task['startTime']) : null,
            'timeLimit' => $task['timeLimit'],
        ]);

        //$canStartTask = true;

        if (!$canStartTask)
            throw new NewTaskException("Выбранное время недоступно");

        $taskLimitMinutes = $task['timeLimit'] / 60;
        $taskLimitSeconds = $task['timeLimit'] % 60;

        $startTime = date("Y-m-d\TH:i:s", strtotime($task['startTime']));

        $cpusCount = (int)$taskData['maxCores'];
        $memoryLimit = (int)$taskData['memoryLimit'] * 1024;

        $slurmScript = "#!/bin/bash\n#\n#SBATCH " .
            "--job-name=\"{$task['name']}\"\n#SBATCH --output=output.txt\n#\n" .
            "#SBATCH --ntasks=1\n".
            "#SBATCH --cpus-per-task={$cpusCount}\n".
            "#SBATCH --mem={$memoryLimit}\n".
            "#SBATCH --begin={$startTime}\n".
            "#SBATCH --time={$taskLimitMinutes}:{$taskLimitSeconds}\n\n" .
            "gcc program.c -o program{$task['compilerOptions']}\nsrun program\n";

        file_put_contents($scriptPath, $slurmScript);

        $sshClient = $this->sshClient;

        $sshClient->execute("cd ~/");
        $sshClient->uploadFile($scriptPath, "script.slurm");
        $sshClient->uploadFile($sourcePath, "program.c");

        $sshClient->execute("sbatch script.slurm");
    }

    /**
     * @param int $taskId
     *
     * @throws \Exception
     */
    public function cancelTask(int $taskId) {
        $this->sshClient->execute('scancel '.$taskId);
    }

    /**
     * @param int $id
     *
     * @return string
     * @throws \Exception
     */
    protected function getTaskAuthorById(int $id) : string {
        return trim($this->sshClient->execute('getent passwd | awk -F: \'$3 == '.$id.' { print $1 }\''));
    }

    /**
     * @param string $limit
     *
     * @return \DateInterval
     * @throws \Exception
     */
    protected function unixIntervalToDateInterval(string $limit) : \DateInterval {
        $parts = explode(' ', str_replace([':','-'], [' ',' '], $limit));
        $parts = array_reverse($parts);

        $seconds = $parts[0];
        $minutes = $parts[1] ?? 0;
        $hours = $parts[2] ?? 0;
        $days = $parts[3] ?? 0;

        return new \DateInterval('P'.$days.'DT'.$hours.'H'.$minutes.'M'.$seconds.'S');
    }

    /**
     * @param string $dateTime
     *
     * @return \DateTime
     * @throws \Exception
     */
    protected function unixDateToDateTime(string $dateTime) : \DateTime {
        try {
            return new \DateTime($dateTime);
        }
        catch (\Exception $error) {
            return new \DateTime();
        }
    }
}