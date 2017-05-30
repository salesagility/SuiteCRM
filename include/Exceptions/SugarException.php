<?php

require_once 'include/Exceptions/SugarEmptyException.php';
require_once 'include/Exceptions/SugarErrorHandler.php';
require_once 'include/Exceptions/SugarException.php';
require_once 'include/Exceptions/SugarInvalidTypeException.php';

class SugarException extends Exception
{
    /**
     * @var string $message
     */
    protected $message = 'Unhandled Exception';

    /**
     * @var int $code
     */
    protected $code = 0;

    /**
     * @var string $userMessage
     */
    protected $userMessage;

    /**
     * SugarException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        global $app_strings;
        $this->userMessage = $app_strings['ERR_AJAX_LOAD'];
        parent::__construct($this->message, $code, $previous);
    }

    /**
     * @return string
     */
    protected function getUserMessage()
    {
        return $this->userMessage;
    }
}
