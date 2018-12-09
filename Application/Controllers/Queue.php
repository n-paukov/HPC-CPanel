<?php
namespace App\Controllers;

use App\Core\Exceptions\FormValidationException;
use App\Core\Exceptions\NewTaskException;
use App\Models\Schedule;
use Inno\Helpers\UrlHelper;

class Queue extends BaseController {
    public function ActionIndex() {
        $scheduleModel = new \App\Models\Schedule($this->serviceSSH);

        $queue = $scheduleModel->getTasksQueue([
            'userId' => $this->accountManager->getUserId()
        ]);

        $currentUserStats = $scheduleModel->getUserTasksStatistics($queue, $this->accountManager->getUserId());

        $currentUserId = $this->accountManager->getUserId();

        $queue = array_map(function($task) use ($currentUserId) {
            $task['accessManage'] = ($task['user_id'] == $currentUserId);

            return $task;
        }, $queue);

        $this->template->setHeading('Мои задачи');

        return $this->renderPage('schedule/schedule', [
            'queue' => $queue,
            'currentUserStats' => $currentUserStats,
            'filter' => [],
        ]);
    }

    public function ActionAdd() {
        $queueModel = new \App\Models\Queue();

        $formData = [];

        foreach ([ 'name', 'source', 'compilerOptions', 'memoryLimit', 'maxCores', 'timeLimit', 'startTime' ] as $field) {
            $formData[$field] = [
                'status' => true,
                'message' => null,
                'value' => '',
            ];
        }

        try {
            if (!empty($this->request->post['task'])) {
                $taskFormData = $this->request->post['task'];
                $queueModel->validateTaskData($taskFormData);

                foreach ($taskFormData as $field => $value)
                    $formData[$field]['value'] = $value;

                $sheduler = new Schedule($this->accountManager->getSSHClient());

                if (empty($this->request->files['task'])) {
                    throw new NewTaskException("Файл с исходным кодом не указан");
                }

                $uniqKey = uniqid();

                $sourcePath = UPLOADS_DIR.DIRECTORY_SEPARATOR.$uniqKey.".c";
                $scriptPath = UPLOADS_DIR.DIRECTORY_SEPARATOR.$uniqKey.".slurm";

                if (!move_uploaded_file($this->request->files['task']['tmp_name']['source'], $sourcePath)) {
                    $sourcePath = null;

                    throw new NewTaskException('Ошибка загрузки файла');
                }

                $sheduler->startNewTask($taskFormData, $sourcePath, $scriptPath);


                $this->redirect(UrlHelper::to(['queue', 'index']));
            }
        } catch (FormValidationException $error) {
            $formData = $error->getValidationResult();

            $this->addUserNotification(self::NOTIFY_ERROR, 'Форма заполнена некорректно');
        }
        catch (NewTaskException $error) {
            $this->addUserNotification(self::NOTIFY_ERROR, $error->getMessage());
        }
        catch (\Exception $error) {
            $this->addUserNotification(self::NOTIFY_ERROR, 'Невозможно поставить данную задачу в очередь. Обратитесь к администраторам.');
        }

        return $this->renderPage('tasks/add', [
            'formData' => $formData,
        ]);

    }

    public function ActionCancel() {
        if (empty($this->request->get['task']))
            $this->redirect(UrlHelper::to(['queue', 'index']));

        $taskId = (int)$this->request->get['task'];

        $scheduleModel = new \App\Models\Schedule($this->serviceSSH);
        $scheduleModel->cancelTask($taskId);

        $this->redirect(UrlHelper::to(['queue', 'index']));
    }
}