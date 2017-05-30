<?php

require_once 'include/Exceptions/SugarEmptyException.php';
require_once 'include/Exceptions/SugarErrorHandler.php';
require_once 'include/Exceptions/SugarException.php';
require_once 'include/Exceptions/SugarInvalidTypeException.php';


/**
 * Class OldFeature
 * Challenge add error handling without throwing exceptions
 */
class OldFeature
{
    /**
     * Typical horrible code
     * @param $a
     * @return array()
     */
    function old_function($a)
    {
        $arr = array();

        if (is_null($a)) {
            // bad error message
            $GLOBALS['log']->fatal('cannot find old feature...');
            // for testing
            SugarErrorHandler::throwError(new SugarEmptyException());
        }

        // 100 lines of spaghetti code

        if (gettype($a) !== 'boolean') {
            // Even worse error message
            $GLOBALS['log']->fatal('Unknown $a');
            SugarErrorHandler::throwError(new SugarInvalidTypeException());
        } else {
            if ($a === true) {
                $arr['ID'] = '1';
                $arr['NAME'] = 'Daniel';
                $arr['DELETED'] = '1';
            } else {
                $arr['ID'] = '';
                $arr['NAME'] = '';
                $arr['DELETED'] = '';
            }
        }

        return $arr;
    }
}