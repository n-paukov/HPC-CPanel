<?php
namespace App\Core\Exceptions;

/**
 * Class NewTaskException
 * @package App\Core\Exceptions
 */
class NewTaskException extends \Exception {
    /**
     * NewTaskException constructor.
     *
     * @param $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message = '', $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}