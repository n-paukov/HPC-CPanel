<?php
namespace App\Controllers;

use App\Core\Libraries\ServiceSSHClient;

class Index extends BaseController {
    public function ActionIndex() {
        $filter = [];

        if (!empty($this->request->get['user'])) {
            $filter['userId'] = (int)$this->request->get['user'];
        }

        $scheduleModel = new \App\Models\Schedule($this->serviceSSH);

        $queue = $scheduleModel->getTasksQueue($filter);
        $dailySchedule = $scheduleModel->convertToDailySchedule($queue);

        ksort($dailySchedule);

        $commonStats = $scheduleModel->getTasksStatistics($queue);
        $currentUserStats = $scheduleModel->getUserTasksStatistics($queue, $this->accountManager->getUserId());

        $this->template->setHeading('Общая очередь задач');

        $currentUserId = $this->accountManager->getUserId();

        $queue = array_map(function($task) use ($currentUserId) {
            $task['accessManage'] = ($task['user_id'] == $currentUserId);

            return $task;
        }, $queue);

        return $this->renderPage('schedule/schedule', [
            'queue' => $queue,
            'dailySchedule' => $dailySchedule,
            'commonStats' => $commonStats,
            'currentUserStats' => $currentUserStats,
            'filter' => $filter,
        ]);
    }
}