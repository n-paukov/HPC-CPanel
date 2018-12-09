<?php
namespace App\Core\Exceptions;

/**
 * Class AuthException
 * @package App\Core\Exceptions
 */
class AuthException extends \Exception {
    /**
     * AuthException constructor.
     *
     * @param $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message = '', $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}