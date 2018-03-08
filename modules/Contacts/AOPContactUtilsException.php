<?php


/**
 * class AOPContactUtilsException
 */
class AOPContactUtilsException extends Exception {

    const UNABLE_READ_PORTAL_VERSION = 100;

    public function __construct($message = '', $code = AOPContactUtilsException::UNABLE_READ_PORTAL_VERSION, $previous = null)
    {
        parent::__construct('[Unable to Read Portal Version] '.$message.'', $code, $previous);
    }
    
}

