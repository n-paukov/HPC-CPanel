<?php
namespace App\Core;

use Inno\DataBase\DataBase;
use Inno\DataBase\MySQLi as MySQLiDriver;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Class SCApp
 * @package App\Core
 */
class SCApp {
    /**
     * @var \Inno\Web\Template
     */
    public $template;

    /**
     * @var \Inno\Request
     */
    public $request;

    /**
     * @var \Inno\Session
     */
    public $session;

    /**
     * @var \Inno\DataBase\
     */
    public $db;

    /**
     * @var \App\Core\Libraries\ServiceSSHClient
     */
    public $serviceSSH;

    /**
     * @var \App\Core\Libraries\AccountManager
     */
    public $accountManager;

    /**
     * @var array
     */
    public static $config = [];

    /**
     * @return \App\Core\SCApp
     * @throws \Exception
     */
    public static function getInstance() : SCApp {
        static $instance = null;

        if ($instance == null) {
            $instance = new self(static::$config);
        }

        return $instance;
    }

    /**
     * @param array $config
     */
    public static function initialize(array $config) {
        static::$config = $config;

        require LIBRARIES_DIR.DIRECTORY_SEPARATOR.'PHPMailer'.DIRECTORY_SEPARATOR.'PHPMailer'.DIRECTORY_SEPARATOR.'PHPMailer.php';
        require TEMPLATES_DIR.DIRECTORY_SEPARATOR.'functions.php';
    }

    /**
     * SCApp constructor.
     *
     * @param array $config
     *
     * @throws \Exception
     */
    private function __construct(array $config = []) {
        $this->template = \Inno::$app->template;

        $this->request = \Inno::$app->request;
        $this->session = \Inno::$app->session;

        $this->db = new DataBase(new MySQLiDriver($config['db']));
        $this->db->connect();

        $this->serviceSSH = new \App\Core\Libraries\ServiceSSHClient($config['ssh']);
        $this->accountManager = new \App\Core\Libraries\AccountManager($this->session, $this->db);
    }
}