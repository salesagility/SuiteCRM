<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 25/09/17
 * Time: 17:14
 */

namespace SuiteCRM\API\v8\Exception;

use SuiteCRM\Enumerator\ExceptionCode;
use Throwable;

class Forbidden extends ApiException
{
    /**
     * Conflict constructor.
     * @param string $message Module Not Found "$message"
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = '', $code = ExceptionCode::API_MISSING_REQUIRED, Throwable $previous = null)
    {
        parent::__construct('[Forbidden] '.$message, $code, $previous);
    }

    /**
     * @return int
     */
    public function getHttpStatus()
    {
        return 403;
    }

    /**
     * @return string
     */
    public function getDetail()
    {
        return '';
    }
}