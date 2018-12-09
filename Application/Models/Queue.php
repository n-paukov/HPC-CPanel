<?php
namespace App\Models;

use Inno\Base\Model;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator as v;
use App\Models\ValidationHelper;

/**
 * Class Support
 * @package App\Models
 */
class Queue extends Model {
    /**
     * @param array $data
     *
     * @throws \App\Core\Exceptions\FormValidationException
     */
    public function validateTaskData(array $data) {
        $messages = [
            'name' => 'Название задачи указано некорректно',
            'memoryLimit' => 'Лимит памяти указан некорректно',
            'maxCores' => 'Число процессорных ядер указано некорректно',
            'timeLimit' => 'Максимальная продолжительность выполнения указана некорректно',
            'startTime' => 'Время начала указано некорректно',
            'source' => '',
            'compilerOptions' => '',
        ];

        $rules = v::key('name', v::notEmpty()->length(2, 100))
            ->key('memoryLimit', v::optional(v::numeric()->positive()))
            ->key('maxCores', v::optional(v::numeric()->positive()))
            ->key('timeLimit', v::optional(v::numeric()->positive()))
            ->key('startTime', v::optional(v::date("d.m.Y H:i:s")));

        ValidationHelper::validate($messages, $rules, $data);
    }
}