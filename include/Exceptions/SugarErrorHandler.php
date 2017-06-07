<?php

require_once __DIR__ . '/exceptions.php';

/**
 * Class SugarErrorHandler
 * Soft Exception handler
 *
 * Since old code does not handle exceptions, We cannot throw exceptions  without potentially
 * breaking old customisations.
 *
 * SugarErrorHandler allows us to check for exceptions without breaking legacy code.  SugarErrorHandler can give us
 * a stack trace or at least where the in the code base should throw exceptions.
 *
 * Typical usage:
 * SugarErrorHandler::throwError(new SugarException('Custom message');
 *
 */
class SugarErrorHandler
{
    /**
     * @var array $errors
     */
    protected static $errors = array();

    /**
     * Throws and logs the error.
     *
     * @param SugarException $exception The error presented as a exception
     * @param int $sugarErrorLevel determines the log level reported in the log file(s)
     * @param boolean $throwException offers a means for new code to throw exception and keep the same log convention
     * @throws Exception
     */
    public static function throwError($exception, $sugarErrorLevel = SugarErrorLevel::fatal, $throwException = false)
    {
        global $sugar_config;
        self::$errors[] = $exception;

        $errorMessage = 'PHP ' . $exception->getMessage() . ' in ' . $exception->getFile() . ':' . $exception->getLine() . PHP_EOL;
        if(isset($sugar_config['show_log_trace']) && $sugar_config['show_log_trace'] === true) {
            $errorMessage .= 'PHP Stack trace:' . PHP_EOL . $exception->getTraceAsString() . PHP_EOL;
        }

        $logFunction = SugarErrorLevel::toString($sugarErrorLevel);
        $GLOBALS['log']->{$logFunction}($errorMessage);

        if ($throwException === true) {
            throw $exception;
        }
    }

    /**
     * @param SugarException $type
     * @return bool
     */
    public static function hasThrownError($type)
    {
        foreach (self::$errors as $error) {
            if ($error instanceof $type) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public static function hasErrors()
    {
        return !empty(self::$errors);
    }

    /**
     * @return string
     */
    public static function getStackTraceMessage()
    {

        $stackTraceString = '';
        if (!empty(self::$errors)) {
            foreach (self::$errors as $error) {
                $stackTraceString .= 'PHP ' . $error->getMessage() . ' in ' . $error->getFile() . ':'
                    . $error->getLine() . PHP_EOL .
                    'PHP Stack trace:' . PHP_EOL . $error->getTraceAsString() . PHP_EOL;
            }
        }
        return $stackTraceString;
    }

    /**
     * Clears errors (used for testing)
     */
    public static function clearErrors()
    {
        self::$errors = array();
    }
}
