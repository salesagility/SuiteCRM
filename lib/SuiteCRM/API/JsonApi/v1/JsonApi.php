<?php

namespace SuiteCRM\API\JsonApi\v1;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use SuiteCRM\Utility\SuiteLogger as Logger;

/**
 * Class JsonApi
 * @package SuiteCRM\API\JsonApi\v1
 * @see http://jsonapi.org/format/1.0/#document-meta
 */
class JsonApi implements LoggerAwareInterface
{
    const VERSION = '1.0';
    /**
     * @var JsonApi Logger
     */
    private $logger;

    /**
     * Resource constructor.
     */
    public function __construct()
    {
        $this->setLogger(new Logger());
    }

    /**
     * @return array
     */
    public function getArray()
    {
        $response = array();
        $response['jsonapi'] = array(
            'version' => self::VERSION
        );
        return $response;
    }

    /**
     * Sets a logger instance on the object.
     *
     * @param LoggerInterface $logger
     *
     * @return void
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return string
     */
    public function getSchemaPath() {
        return __DIR__ . '/schema.json';
    }
}