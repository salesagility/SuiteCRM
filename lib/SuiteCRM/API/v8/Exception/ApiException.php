<?php

namespace SuiteCRM\API\v8\Exception;


use Psr\Log\LogLevel;
use SuiteCRM\API\v8\Controller\ApiController;
use SuiteCRM\Enumerator\ExceptionCode;
use SuiteCRM\Exception\Exception;
use Throwable;

/**
 * Class ApiException
 * @package SuiteCRM\API\v8\Exception
 */
class ApiException extends Exception
{
    /**
     * @var array $source
     * @see https://tools.ietf.org/html/rfc6901
     */
    private $source = array('pointer' => '');

    /**
     * @var string $detail
     */
    private $detail = 'Api Version: 8';

    /**
     * ApiException constructor.
     * @param string $message API Exception "$message"
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = '', $code = ExceptionCode::API_EXCEPTION, Throwable $previous = null)
    {
        parent::__construct('[API] '.$message.'', $code, $previous);
    }

    /**
     * Gives addition details to what caused the exception
     * @see ApiController::generateJsonApiExceptionResponse()
     * @return string
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * @param string $detail
     */
    public function setDetail($detail)
    {
        $this->detail = $detail;
    }

    /**
     * @see ApiController::generateJsonApiExceptionResponse()
     * @see https://tools.ietf.org/html/rfc6901
     * @return array
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param $source
     * @see https://tools.ietf.org/html/rfc6901
     */
    public function setSource($source)
    {
        $this->source['pointer'] = $source;
    }

    /**
     * @return int http status code that should be returned back to the client
     * @see ApiController::generateJsonApiExceptionResponse()
     */
    public function getHttpStatus()
    {
        return 500;
    }
}