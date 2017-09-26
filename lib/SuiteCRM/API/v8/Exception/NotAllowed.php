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

class NotAllowed extends ApiException
{
    /**
     * NotAllowed constructor.
     * @param string $message Module Not Found "$message"
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = '', $code = ExceptionCode::API_CONTENT_NEGOTIATION_FAILED, Throwable $previous = null)
    {
        parent::__construct('[Not Allowed] '.$message, $code, $previous);
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