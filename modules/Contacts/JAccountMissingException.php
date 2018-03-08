<?php


class JAccountMissingException extends Exception {
  
    const JACCOUNT_MISSING = 100;

    public function __construct($message = '', $code = JAccountMissingException::JACCOUNT_MISSING, $previous = null)
    {
        parent::__construct('[JAccount missing] '.$message.'', $code, $previous);
    }
}

