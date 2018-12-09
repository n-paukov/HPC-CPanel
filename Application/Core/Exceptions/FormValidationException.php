<?php
namespace App\Core\Exceptions;

/**
 * Class FormValidationException
 * @package App\Core\Exceptions
 */
class FormValidationException extends \Exception {
    private $messages = [];

    /**
     * FormValidationException constructor.
     *
     * @param array $messages
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($messages = [], $code = 0, \Exception $previous = null) {
        parent::__construct('', $code, $previous);

        $this->messages = $messages;
    }

    public function getValidationResult() {
        return $this->messages;
    }
}