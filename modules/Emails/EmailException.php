<?php

// TODO: licence header

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

/**
 * Class EmailException
 */
class EmailException extends Exception
{
    const BEAN_SAVE_ERROR = 10;
    const NO_DEFAULT_FROM_ADDR = 20;
    const NO_DEFAULT_FROM_EMAIL = 30;

}