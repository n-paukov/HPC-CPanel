<?php
namespace App\Controllers;

use App\Core\SCApp;
use Inno\Base\Controller;
use Inno\Helpers\UrlHelper;

class BaseController extends Controller {
    /**
     * @var \App\Core\Libraries\AccountManager
     */
    protected $accountManager;

    /**
     * @var \App\Core\Libraries\ServiceSSHClient
     */
    protected $serviceSSH;

    protected $notifications = [];

    protected const NOTIFY_ERROR = 'danger';
    protected const NOTIFY_WARNINNG = 'warning';
    protected const NOTIFY_INFO = 'info';
    protected const NOTIFY_SUCCESS = 'success';

    public function __construct() {
        parent::__construct();

        $this->accountManager = SCApp::getInstance()->accountManager;
        $this->serviceSSH = SCApp::getInstance()->serviceSSH;
    }

    public function preload() {
        parent::preload();

        if ($this->controllerName != 'notfound' && !$this->accountManager->isAuthorized()) {
            if ($this->request->get['r'] != 'account/login') {
                $this->redirect(UrlHelper::to(['account', 'login']));
            }
        }
    }

    /**
     * @param array $data
     */
    protected function beforeRender(array& $data) {
        $data['page']['alerts'] = $this->notifications;
    }

    /**
     * @param string $type
     * @param string $text
     * @param string|null $title
     */
    protected function addUserNotification(string $type, string $text, string $title = null) {
        $this->notifications[] = [
            'type' => $type,
            'text' => $text,
            'title' => $title,
        ];
    }
}