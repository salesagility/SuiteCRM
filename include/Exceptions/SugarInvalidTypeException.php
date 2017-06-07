<?php

require_once __DIR__ . '/exceptions.php';

/**
 * Class SugarInvalidTypeException
 */
class SugarInvalidTypeException extends SugarException
{
    /**
     * @var string $message
     */
    protected $message = 'Invalid type';
    /**
     * @var int $code
     */
    protected $code = 2;
    /**
     * @var string $userMessage
     */
    protected $userMessage;

    /**
     * SugarInvalidTypeException constructor.
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
