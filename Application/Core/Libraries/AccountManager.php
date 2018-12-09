<?php
namespace App\Core\Libraries;

use App\Core\Exceptions\AuthException;
use Inno\DataBase\DataBase;
use Inno\Session;

/**
 * Class AccountManager
 * @package App\Core\Libraries
 */
class AccountManager {
    private $isAuthorized;
    private $userId;

    private $accountSSHClient;

    private $session;

    /**
     * @var \Inno\DataBase\DataBase
     */
    private $db;

    /**
     * AccountManager constructor.
     *
     * @param \Inno\Session $session
     * @param \Inno\DataBase\DataBase $db
     */
    public function __construct(Session $session, DataBase $db) {
        $this->session = $session;
        $this->db = $db;

        $this->isAuthorized = false;
        $this->accountSSHClient = new SSHClient();

        if (!empty($this->session->data['user_id'])) {
            try {
                $login = $this->session->data['user_login'];
                $password = $this->session->data['user_password'];

                $this->authorize($login, $password);
            }
            catch (\Exception $error) {
                session_destroy();
            }
        }
    }

    /**
     * @return bool
     */
    public function isAuthorized() : bool {
        return $this->isAuthorized;
    }

    /**
     * @param $login
     * @param $password
     *
     * @throws \App\Core\Exceptions\AuthException
     */
    public function authorize($login, $password) {
        if ($this->isAuthorized())
            throw new AuthException("User is already authorized");

        try {
            $this->accountSSHClient->connect('hpc.cs.vsu.ru');
            $this->accountSSHClient->authorize($login, $password);

            $this->userId = (int)$this->accountSSHClient->execute("id -u");
            $this->isAuthorized = true;

            $this->session->data['user_id'] = $this->userId;
            $this->session->data['user_login'] = $login;
            $this->session->data['user_password'] = $password;

            if (!$this->isUserExists($this->userId)) {
                $this->addUserData([
                    'id' => $this->userId,
                    'login' => $login,
                ]);
            }
        }
        catch (\Exception $error) {
            throw new AuthException("Пользователя с такими данными не существует");
        }
    }

    /**
     *
     */
    public function logout() {
        unset($this->session->data['user_id']);
        unset($this->session->data['user_login']);
        unset($this->session->data['user_password']);
    }

    /**
     * @return int
     */
    public function getUserId() {
        if ($this->isAuthorized)
            return $this->userId;

        return -1;
    }

    /**
     * @param int $userId
     *
     * @return array
     */
    public function getUserData(int $userId) : array {
        return $this->db->query('SELECT * FROM '.$this->db->getTablePrefix().'users WHERE id='.(int)$userId)->fetch();
    }

    /**
     * @return array
     */
    public function getCurrentUserData() : array {
        return $this->getUserData($this->userId);
    }

    /**
     * @return \App\Core\Libraries\SSHClient
     * @throws \Exception
     */
    public function getSSHClient() : SSHClient {
        if (!$this->isAuthorized)
            throw new \Exception("Authorization error!");

        return $this->accountSSHClient;
    }

    public function updateUserData(int $userId, array $data) {
        $this->db->query(
            'UPDATE '.$this->db->getTablePrefix().'users SET 
                name="'.$this->db->escape($data['name']).'",
                surname="'.$this->db->escape($data['surname']).'",
                email="'.$this->db->escape($data['email']).'"
            WHERE id='.(int)$userId
        );
    }

    /**
     * @param array $data
     */
    private function addUserData(array $data)
    {
        $this->db->query(
            'INSERT INTO '.$this->db->getTablePrefix().'users SET 
                id='.(int)$data['id'].', 
                login="'.$this->db->escape($data['login']).'"'
        );
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    private function isUserExists(int $id) : bool {
        $userData = $this->getUserData($id);

        return !empty($userData['id']);
    }
}