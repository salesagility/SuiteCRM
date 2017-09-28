<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 25/09/17
 * Time: 17:14
 */

namespace SuiteCRM\Exception;


use Psr\Log\LogLevel;
use SuiteCRM\API\v8\Controller\ApiController;
use SuiteCRM\Enumerator\ExceptionCode;
use Throwable;

/**
 * Class Exception
 * @package SuiteCRM\Exception
 */
class Exception extends \Exception
{
    /**
     * ApiException constructor.
     * @param string $message API Exception "$message"
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = '', $code = ExceptionCode::APPLICATION_UNHANDLED_BEHAVIOUR, Throwable $previous = null)
    {
        parent::__construct('[SuiteCRM] '.$message.'', $code, $previous);
    }

    /**
     * Gives addition details to what caused the exception
     * @see ApiController::generateJsonApiExceptionResponse()
     * @return string
     */
    public function getDetail()
    {
        return 'SuiteCRM Exception';
    }

    /**
     * Determines the output message in log files.
     * @return string PSR-3 log level
     * @see LogLevel
     */
    public function getLogLevel()
    {
        return LogLevel::ERROR;
    }
}