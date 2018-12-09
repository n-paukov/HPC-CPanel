<?php
namespace App\Models;

use App\Core\SCApp;
use PHPMailer\PHPMailer\PHPMailer;
use Inno\Base\Model;
use Respect\Validation\Validator as v;
use App\Models\ValidationHelper;

/**
 * Class Support
 * @package App\Models
 */
class Support extends Model {
    /**
     * @param $message
     *
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function sendSupportMessage($message) {
        $emailConfig = SCApp::$config['emails'];

        $mail = new PHPMailer(true);

        $mail->setFrom($emailConfig['server']['address'], $emailConfig['server']['name']);

        foreach ($emailConfig['support'] as $address) {
            $mail->addAddress($address['address'], $address['name']);
        }

        $mail->isHTML(false);
        $mail->Subject = 'Вопрос для службы поддержки';
        $mail->Body    = "Вопрос от пользователя {$message['user']['name']} {$message['user']['surname']} ({$message['user']['id']})\n".
            "E-mail: {$message['user']['email']}\n".
            "Текст вопроса:\n{$message['text']}";

        $mail->send();
    }

    /**
     * @param array $data
     *
     * @throws \App\Core\Exceptions\FormValidationException
     */
    public function validateMessageData(array $data) {
        $messages = [
            'question' => 'Текст вопроса составлен некорректно',
        ];

        $rules = v::key('question', v::notEmpty()->length(10, 5000));
        ValidationHelper::validate($messages, $rules, $data);
    }
}