<?php

require_once 'include/Exceptions/SugarEmptyValueException.php';
require_once 'include/Exceptions/SugarErrorHandler.php';
require_once 'include/Exceptions/SugarException.php';
require_once 'include/Exceptions/SugarInvalidTypeException.php';

/**
 * Class SugarEmptyValueException
 */
class SugarEmptyValueException extends SugarException
{
    /**
     * @var string $message
     */
    protected $message = 'Empty value';

    /**
     * @var int $code
     */
    protected $code = 1;

    /**
     * @var string $userMessage
     */
    protected $userMessage;

    /**
     * SugarEmptyValueException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        global $app_strings;
        $this->userMessage = $app_strings['ERR_AJAX_LOAD'];
        parent::__construct($this->message .': '. $message, $code, $previous);
    }
}
