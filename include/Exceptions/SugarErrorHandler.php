<?php

require_once 'include/Exceptions/SugarEmptyValueException.php';
require_once 'include/Exceptions/SugarErrorHandler.php';
require_once 'include/Exceptions/SugarException.php';
require_once 'include/Exceptions/SugarInvalidTypeException.php';

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
 * Only use SugarErrorHandler for old or legacy code.
 */
class SugarErrorHandler
{
    /**
     * @var array $errors
     */
    protected static $errors = array();

    /**
     * @param SugarException $type
     */
    public static function throwError($type)
    {
        global $sugar_config;
        self::$errors[] = $type;

        $errorMessage = 'PHP ' . $type->getMessage() . ' in ' . $type->getFile() . ':' . $type->getLine() . PHP_EOL;
        if(isset($sugar_config['show_log_trace']) && $sugar_config['show_log_trace'] === true) {
            $errorMessage .= 'PHP Stack trace:' . PHP_EOL . $type->getTraceAsString() . PHP_EOL;
        }

        $GLOBALS['log']->fatal($errorMessage);
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
     * Clears errors
     */
    public static function clearErrors()
    {
        self::$errors = array();
    }
}