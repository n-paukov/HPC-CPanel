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
class Account extends Model {
    /**
     * @param array $data
     *
     * @throws \App\Core\Exceptions\FormValidationException
     */
    public function validateAccountData(array $data) {
        $messages = [
            'name' => 'Имя указано некорректно',
            'surname' => 'Фамилия указана некорректно',
            'email' => 'E-mail указан некорректно',
        ];

        $rules = v::key('name', v::notEmpty()->length(2, 100))
            ->key('surname', v::notEmpty()->length(2, 100))
            ->key('email', v::email());

        ValidationHelper::validate($messages, $rules, $data);
    }
}