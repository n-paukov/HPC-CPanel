<?php
namespace App\Core\Libraries;

set_include_path(get_include_path() . PATH_SEPARATOR . LIBRARIES_DIR.DIRECTORY_SEPARATOR.'phpseclib');
include(LIBRARIES_DIR.DIRECTORY_SEPARATOR.'phpseclib'.DIRECTORY_SEPARATOR.'Net'.DIRECTORY_SEPARATOR.'SSH2.php');
include(LIBRARIES_DIR.DIRECTORY_SEPARATOR.'phpseclib'.DIRECTORY_SEPARATOR.'Net'.DIRECTORY_SEPARATOR.'SCP.php');

/**
 * Class SSHClient
 * @package App\Core\Libraries
 */
class SSHClient {
    /**
     * @var \Net_SSH2
     */
    protected $ssh = null;

    /**
     * SSHClient constructor.
     */
    public function __construct() {
    }

    /**
     *
     */
    public function __destruct() {
        if ($this->ssh != null)
            $this->ssh->disconnect();
    }

    /**
     * @param $host
     *
     * @throws \Exception
     */
    public function connect($host) {
        $this->ssh = new \Net_SSH2($host);
    }

    /**
     * @param $login
     * @param $password
     *
     * @throws \Exception
     */
    public function authorize($login, $password) {
        if (!$this->ssh->login($login, $password))
            throw new \Exception("Ошибка авторизации");
    }

    /**
     * @param $command
     *
     * @return string
     * @throws \Exception
     */
    public function execute($command) : string {
        return $this->ssh->exec($command);
    }

    /**
     * @param $sourceFilename
     * @param $destinationFilename
     *
     * @throws \Exception
     */
    public function uploadFile($sourceFilename, $destinationFilename) {
        $scp = new \Net_SCP($this->ssh);

        if (!$scp->put($destinationFilename, $sourceFilename,NET_SCP_LOCAL_FILE)) {
            throw new \Exception("Failed to send file.");
        }
    }

    /**
     * @throws \Exception
     */
    public function disconnect() {
        $this->ssh = null;
    }
}