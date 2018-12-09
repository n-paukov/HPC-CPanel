<?php
namespace App\Core\Exceptions;

/**
 * Class NotFoundException
 * @package App\Core\Exceptions
 */
class NotFoundException extends \Exception {
    /**
     * NotFoundException constructor.
     *
     * @param $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message = '', $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}