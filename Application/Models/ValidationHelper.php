<?php
namespace App\Models;


use App\Core\Exceptions\FormValidationException;
use Respect\Validation\Exceptions\ValidationException;

class ValidationHelper {
    /**
     * @param array $fields
     * @param \Respect\Validation\Validator $rules
     * @param array $data
     *
     * @throws \App\Core\Exceptions\FormValidationException
     */
    public static function validate($fields, $rules, $data) {
        $result = [];

        foreach ($fields as $fieldName => $message)
            $result[$fieldName] = [
                'status' => true,
                'value' => (!empty($data[$fieldName])) ? $data[$fieldName] : '',
                'message' => null,
            ];

        try {
            $rules->assert($data);
        } catch (ValidationException $exception) {
            $validationMessages = ($exception->findMessages($fields));

            foreach ($validationMessages as $fieldName => $message) {
                if (empty($message))
                    continue;

                $result[$fieldName]['status'] = false;
                $result[$fieldName]['message'] = $message;
            }

            throw new FormValidationException($result);
        }
    }
}