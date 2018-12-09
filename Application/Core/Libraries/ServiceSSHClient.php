<?php
namespace App\Core\Libraries;

/**
 * Class ServiceSSHClient
 * @package App\Core\Libraries
 */
class ServiceSSHClient extends SSHClient {
    /**
     * ServiceSSHClient constructor.
     *
     * @param array $parameters
     *
     * @throws \Exception
     */
    public function __construct(array $parameters = []) {
        parent::__construct();

        parent::connect($parameters['host']);
        parent::authorize($parameters['user'], $parameters['password']);
    }
}