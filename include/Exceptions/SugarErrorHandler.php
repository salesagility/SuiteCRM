<?php

require_once 'include/Exceptions/SugarEmptyException.php';
require_once 'include/Exceptions/SugarErrorHandler.php';
require_once 'include/Exceptions/SugarException.php';
require_once 'include/Exceptions/SugarInvalidTypeException.php';

/**
 * Class SugarErrorHandler
 * Soft Exception handler
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
        self::$errors[] = $type;

        $GLOBALS['log']->fatal(
            'PHP ' . $type->getMessage() . ' in ' . $type->getFile() . ':' . $type->getLine() . PHP_EOL .
            'PHP Stack trace:' . PHP_EOL . $type->getTraceAsString() . PHP_EOL
        );
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
     * @param $arr = array
     */
    protected static function traceToString($arr)
    {

    }
}