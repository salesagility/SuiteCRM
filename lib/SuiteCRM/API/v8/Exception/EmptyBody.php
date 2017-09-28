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
 * Class EmptyBody
 * @package SuiteCRM\API\v8\Exception
 */
class EmptyBody extends ApiException
{
    /**
     * EmptyBody constructor.
     * @param string $message Module Not Found "$message"
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = '', $code = ExceptionCode::API_MODULE_NOT_FOUND, Throwable $previous = null)
    {
        parent::__construct('[EmptyBody] '.$message, $code, $previous);
    }

    /**
     * @return int
     */
    public function getHttpStatus()
    {
        return 400;
    }

    /**
     * @return string
     */
    public function getDetail()
    {
        return 'Json API expects body of the request to be JSON';
    }
}