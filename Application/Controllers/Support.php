<?php
namespace App\Controllers;


use App\Core\Exceptions\FormValidationException;

class Support extends BaseController {
    public function ActionIndex() {
        $userData = $this->accountManager->getCurrentUserData();
        $messageFormActive = true;

        if (empty($userData['email']) || empty($userData['name']) || empty($userData['surname'])) {
            $this->addUserNotification(self::NOTIFY_ERROR,
                'Перед обращением в службу поддержки необходимо заполнить свои контактные данные на странице настроек аккаунта');

            $messageFormActive = false;
        }

        $supportModel = new \App\Models\Support();
        $formData = [];
        $userData = $this->accountManager->getCurrentUserData();

        foreach ([ 'question' ] as $field) {
            $formData[$field] = [
                'status' => true,
                'message' => null,
                'value' => '',
            ];
        }

        try {
            if (!empty($this->request->post['message'])) {
                $messageFormData = $this->request->post['message'];
                $supportModel->validateMessageData($messageFormData);

                $supportModel->sendSupportMessage([
                    'user' => $userData,
                    'text' => $messageFormData['question'],
                ]);

                $this->addUserNotification(self::NOTIFY_SUCCESS, 'Ваше сообщение успешно отправлено!');

                foreach ($messageFormData as $field => $value)
                    $formData[$field]['value'] = '';
            }
        } catch (FormValidationException $error) {
            $formData = $error->getValidationResult();

            $this->addUserNotification(self::NOTIFY_ERROR, 'Форма заполнена некорректно');
        }

        return $this->renderPage('support/question', [
            'formData' => $formData,
            'messageFormActive' => $messageFormActive,
        ]);
    }
}