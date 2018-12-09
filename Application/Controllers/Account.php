<?php
namespace App\Controllers;

use App\Core\Exceptions\AuthException;
use App\Core\Exceptions\FormValidationException;
use Inno\Helpers\UrlHelper;
use Respect\Validation\Validator as v;

class Account extends BaseController {
    public function ActionIndex() {
        return $this->ActionSettings();
    }

    public function ActionLogin() {
        $errorMessage = null;

        if ($this->accountManager->isAuthorized())
            $this->redirect(UrlHelper::to(['index', 'index']));

        try {
            if (!empty($this->request->post['account'])) {
                $accountData = $this->request->post['account'];

                if (empty($accountData['login']) || empty($accountData['password'])) {
                    throw new FormValidationException("Пожалуйста, заполните поля формы");
                }

                $this->accountManager->authorize($accountData['login'], $accountData['password']);
                $this->redirect(UrlHelper::to(['index', 'index']));

            }
        } catch (AuthException | FormValidationException $error) {
            $errorMessage = $error->getMessage();
        }

        return $this->renderPage('account/login',
            [
                'errorMessage' => $errorMessage,
            ],
            'views/login');
    }

    public function ActionLogout() {
        $this->accountManager->logout();
        $this->redirect(UrlHelper::to([ 'index', 'index' ]));
    }

    public function ActionSettings() {
        $accountModel = new \App\Models\Account();

        $formData = [];

        $userData = $this->accountManager->getCurrentUserData();

        foreach ([ 'name', 'surname', 'email' ] as $field) {
            $formData[$field] = [
                'status' => true,
                'message' => null,
                'value' => $userData[$field],
            ];
        }

        try {
            if (!empty($this->request->post['account'])) {
                $accountFormData = $this->request->post['account'];
                $accountModel->validateAccountData($accountFormData);

                $this->accountManager->updateUserData($this->accountManager->getUserId(), $accountFormData);
                $this->addUserNotification(self::NOTIFY_SUCCESS, 'Данные успешно сохранены');

                foreach ($accountFormData as $field => $value)
                    $formData[$field]['value'] = $value;
            }
        } catch (FormValidationException $error) {
            $formData = $error->getValidationResult();

            $this->addUserNotification(self::NOTIFY_ERROR, 'Форма заполнена некорректно');
        }

        return $this->renderPage('account/settings', [
            'formData' => $formData,
        ]);
    }
}