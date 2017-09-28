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
 * Class ModuleNotFound
 * @package SuiteCRM\API\v8\Exception
 */
class ModuleNotFound extends ApiException
{
    /**
     * ModuleNotFound constructor.
     * @param string $message Module Not Found "$message"
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = '', $code = ExceptionCode::API_MODULE_NOT_FOUND, Throwable $previous = null)
    {
        parent::__construct('[Module Not Found] '.$message, $code, $previous);
    }

    /**
     * @return int
     */
    public function getHttpStatus()
    {
        return 406;
    }

    /**
     * @return string
     */
    public function getDetail()
    {
        return 'Json API cannot find resource';
    }
}