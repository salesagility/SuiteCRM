<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 25/09/17
 * Time: 17:31
 */

namespace SuiteCRM\Enumerator;


/**
 * Class ExceptionCode
 * @package SuiteCRM\Enumerator
 * Holds all the error codes for exceptions
 * Convention: [Sub_System]_[Error_Name] = unique integer
 */
class ExceptionCode
{
    const APPLICATION_UNHANDLED_BEHAVIOUR = 6000;
    const API_EXCEPTION = 8000;
    const API_CONTENT_NEGOTIATION_FAILED = 8001;
    const API_INVALID_BODY = 8002;
    const API_MODULE_NOT_FOUND = 8003;
    const API_MISSING_REQUIRED = 8006;
}