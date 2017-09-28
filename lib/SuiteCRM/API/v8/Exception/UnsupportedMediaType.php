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

/**
 * Class UnsupportedMediaType
 * @package SuiteCRM\API\v8\Exception
 */
class UnsupportedMediaType extends ApiException
{
    /**
     * UnsupportedMediaType constructor.
     * @param string $message Module Not Found "$message"
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = '', $code = ExceptionCode::API_CONTENT_NEGOTIATION_FAILED, Throwable $previous = null)
    {
        parent::__construct('Unsupported Media Type '.$message, $code, $previous);
    }

    /**
     * @return int
     */
    public function getHttpStatus()
    {
        return 415;
    }

    /**
     * @return string
     */
    public function getDetail()
    {
        return 'Json API expects the "Content-Type" header to be application/vnd.API+json';
    }
}