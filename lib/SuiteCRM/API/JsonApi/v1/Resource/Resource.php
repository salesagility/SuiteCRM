<?php

namespace SuiteCRM\API\JsonApi\v1\Resource;

use SuiteCRM\API\v8\Exception\EmptyBody;
use SuiteCRM\Enumerator\ExceptionCode;
use phpDocumentor\Reflection\Types\This;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use SuiteCRM\API\JsonApi\v1\Enumerator\ResourceEnum;
use SuiteCRM\API\v8\Exception\ApiException;
use SuiteCRM\API\v8\Exception\BadRequest;
use SuiteCRM\API\v8\Exception\Conflict;
use SuiteCRM\Utility\SuiteLogger as Logger;

/**
 * Class Resource
 * @package SuiteCRM\API\JsonApi\v1\Resource
 * @see http://jsonapi.org/format/1.0/#document-resource-objects
 */
class Resource implements LoggerAwareInterface
{
    /**
     * @var LoggerInterface Logger
     */
    protected $logger;

    /**
     * @var string $id
     */
    protected $id;

    /**
     * @var string $type
     */
    protected $type;

    /**
     * @var array $attributes
     */
    protected $attributes;

    /**
     * @var array $relationships
     */
    protected $relationships;

    /**
     * @var Links $links
     */
    protected $links;

    /**
     * @var array $meta
     */
    protected $meta;

    /**
     * @var string $source rfc6901
     * @see https://tools.ietf.org/html/rfc6901
     */
    protected $source;

    /**
     * Resource constructor.
     */
    public function __construct()
    {
        $this->setLogger(new Logger());
    }

    /**
     * @param array $json
     * @param string $source rfc6901
     * @return Resource|$this
     * @throws Conflict
     * @throws BadRequest
     * @see https://tools.ietf.org/html/rfc6901
     */
    public static function fromDataArray($json, $source = ResourceEnum::DEFAULT_SOURCE)
    {
        global $sugar_config;
        $resource = new self();
        if(isset($json['id'])) {
            $resource->id = $json['id'];
        }
        $resource->type = $json['type'];
        $resource->source = $source;

        if ($resource->type === null) {
            $exception = new Conflict('[Missing "type" key in data]');
            $exception->setSource('/data/attributes/type');
            throw $exception;
        }

        if(!isset($json['attributes'] )) {
            $exception = new BadRequest('[Missing attributes]');
            $exception->setSource('/data/attributes');
            throw $exception;
        }

        foreach ($json['attributes'] as $attributeName => $attributeValue) {
            if ($resource->attributes === null) {
                $resource->attributes = array();
            }

            // Filter security sensitive information from attributes
            if (
                isset($sugar_config['filter_module_fields'][$resource->type]) &&
                in_array($attributeName, $sugar_config['filter_module_fields'][$resource->type], true)
            ) {
                continue;
            }

            $resource->attributes[$attributeName] = $attributeValue;
        }

        // TODO: Relationships
        return $resource;
    }

    /**
     * @return array
     */
    public function getArray()
    {
        return $this->getArrayWithFields(array_keys($this->attributes));
    }


    /**
     * @param array $fields
     * @return array
     */
    public function getArrayWithFields(array $fields)
    {
        $response = array();

        $response['id'] = $this->id;
        $response['type'] = $this->type;

        foreach ($this->attributes as $attribute => $value) {
            if ($attribute === 'id') {
                continue;
            }
            if(in_array($attribute, $fields) === true) {
                $response['attributes'][$attribute] = $this->attributes[$attribute];
            }
        }

        if($this->meta !== null) {
            $response['meta'] = $this->meta;
        }

        if($this->relationships !== null) {
            $response['relationships'] = $this->meta;
        }

        if($this->links !== null) {
            $response['links'] = $this->links->getArray();
        }

        return $response;
    }
    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Resource|$this
     */
    public function withId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->id;
    }

    /**
     * @param string $type
     * @return Resource|$this
     */
    public function withType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param Links $links
     * @return $this
     */
    public function withLinks(Links $links) {
        $this->links = $links;

        return $this;
    }

    /**
     * @param self|Resource $resource
     * @throws Conflict
     * @internal param $this|Resource $resource
     */
    protected static function validateResource($resource)
    {
        // Validate ID
        if ($resource->id === null) {
            $exception = new Conflict('[Missing "id" key in data]"');
            $exception->setSource($resource->source . '/attributes/id');
            throw $exception;
        }

        // Validate Type
        if ($resource->type === null) {
            $exception = new Conflict('[Missing "type" key in data]');
            $exception->setSource($resource->source . '/attributes/type');
            throw $exception;
        }
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
}