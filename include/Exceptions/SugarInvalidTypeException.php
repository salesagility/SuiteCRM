<?php

require_once 'include/Exceptions/SugarEmptyException.php';
require_once 'include/Exceptions/SugarErrorHandler.php';
require_once 'include/Exceptions/SugarException.php';
require_once 'include/Exceptions/SugarInvalidTypeException.php';

class SugarInvalidTypeException extends SugarException
{
    /**
     * @var string $message
     */
    protected $message = 'Invalid type';
    /**
     * @var int $code
     */
    protected $code = 1;
    /**
     * @var string $userMessage
     */
    protected $userMessage;

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        global $app_strings;
        $this->userMessage = $app_strings['ERR_AJAX_LOAD'];
        parent::__construct($this->message, $code, $previous);
    }
}
