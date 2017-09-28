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

class InvalidJsonApiResponse extends ApiException
{
    /**
     * InvalidJsonApiResponse constructor.
     * @param string $message Module Not Found "$message"
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = '', $code = ExceptionCode::API_INVALID_BODY, Throwable $previous = null)
    {
        parent::__construct('[InvalidJsonApiResponse] '.$message, $code, $previous);
    }

    /**
     * @return int
     */
    public function getHttpStatus()
    {
        return 500;
    }

    /**
     * @return string
     */
    public function getDetail()
    {
        return 'Unable to validate the Json Api Payload Response';
    }
}