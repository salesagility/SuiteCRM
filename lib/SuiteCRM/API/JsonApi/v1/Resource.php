<?php

namespace SuiteCRM\API\JsonApi\v1;

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
 * @package SuiteCRM\API\JsonApi\v1
 * @see http://jsonapi.org/format/1.0/#document-resource-objects
 */
class Resource implements LoggerAwareInterface
{
    /**
     * @var LoggerInterface Logger
     */
    private $logger;

    /**
     * @var string $id
     */
    private $id;

    /**
     * @var string $type
     */
    private $type;

    /**
     * @var array $attributes
     */
    private $attributes;

    /**
     * @var array $relationships
     */
    private $relationships;

    /**
     * @var Links $links
     */
    private $links;

    /**
     * @var array $meta
     */
    private $meta;

    /**
     * @var string $source rfc6901
     * @see https://tools.ietf.org/html/rfc6901
     */
    private $source;

    /**
     * Resource constructor.
     */
    public function __construct()
    {
        $this->setLogger(new Logger());
    }

    /**
     * @param \SugarBean $sugarBean
     * @param string $source rfc6901
     * @return Resource|$this
     * @throws ApiException
     * @see https://tools.ietf.org/html/rfc6901
     */
    public static function fromSugarBean($sugarBean, $source = ResourceEnum::DEFAULT_SOURCE)
    {
        global $sugar_config;
        global $timedate;
        $resource = new self();
        $resource->id = $sugarBean->id;
        $resource->type = $sugarBean->module_name;
        $resource->source = $source;
        try {
            $resource::validateResource($resource);
        } catch (ApiException $e) {
            throw $e;
        }

        // Set the attributes
        foreach ($sugarBean->field_defs as $field => $definition) {
            // Filter security sensitive information from attributes
            if (
                isset($sugar_config['filter_module_fields'][$sugarBean->module_name]) &&
                in_array($field, $sugar_config['filter_module_fields'][$sugarBean->module_name], true)
            ) {
                continue;
            }

            if (!empty($sugarBean->$field) && $definition['type'] === 'datetime') {
                // Convert to DB date
                $datetime = $timedate->fromUser($sugarBean->$field);
                if(empty($datetime)) {
                    $datetime = $timedate->fromDb($sugarBean->$field);
                }

                if(empty($datetime)) {
                    throw new ApiException(
                        '[Unable to convert datetime field using SugarBean] "'.$field.'"',
                        ExceptionCode::API_DATE_CONVERTION_SUGARBEAN
                    );
                }

                $datetimeISO8601 = $datetime->format('c');
                if($datetime === false) {
                    throw new ApiException(
                        '[Unable to convert datetime field to ISO 8601] "'.$field.'"',
                        ExceptionCode::API_DATE_CONVERTION_SUGARBEAN);
                }
                $resource->attributes[$field] = $datetimeISO8601;
            } else {
                $resource->attributes[$field] = $sugarBean->$field;
            }

            // Validate Required fields
            // Skip "id" as this method may be used to populate a new bean before the bean is saved
            if ($field !== 'id' && $definition['required'] === true) {
                if (!isset( $resource->attributes[$field]) && empty($sugarBean->$field)) {
                    $exception = new BadRequest('[Missing Required Field] "' . $field . '"');
                    $exception->setSource($resource->source . '/attributes/' . $field);
                    throw $exception;
                }
            }
        }

        // TODO: Set the relationships


        return $resource;
    }

    /**
     * @return \SugarBean
     * @throws BadRequest
     * @throws ApiException
     */
    public function toSugarBean()
    {
        global $sugar_config;
        $sugarBean = \BeanFactory::getBean($this->type, $this->id);

        if (empty($sugarBean)) {
            $sugarBean = \BeanFactory::newBean($this->type);
        }

        foreach ($sugarBean->field_defs as $field => $definition) {
            if(!isset($definition)) {
                throw new ApiException('Unable to read variable definitions');
            }
            // Filter security sensitive information from attributes
            if (
                isset($sugar_config['filter_module_fields'][$sugarBean->module_name]) &&
                in_array($field, $sugar_config['filter_module_fields'][$sugarBean->module_name], true)
            ) {
                continue;
            }

            if (isset($this->attributes[$field])) {
                if ($definition['type'] === 'datetime' &&  !empty($this->attributes[$field])) {
                    // Convert to DB date
                    $datetime = \DateTime::createFromFormat('c', $this->attributes[$field]);
                    if(empty($datetime)) {
                       $exception = new ApiException(
                           '[Unable to convert datetime field to SugarBean DbFormat] "'.$field.'"',
                           ExceptionCode::API_DATE_CONVERTION_SUGARBEAN
                       );
                       $exception->setSource(ResourceEnum::DEFAULT_SOURCE . '/attributes/' . $field);
                        $sugarBean->$field = $datetime->format('Y-m-d H:i:s');
                    }
                } else {
                    $sugarBean->$field = $this->attributes[$field];
                }
            }

            // Validate Required fields
            // Skip "id" as this method may be used to populate a new bean before the bean is saved
            if (
                $field !== 'id' &&
                $definition['required'] === true &&
                !isset($this->attributes[$field]) &&
                empty($this->attributes[$field])
            ) {
                    $exception = new BadRequest('[Missing Required Field] "' . $field . '"');
                    $exception->setSource($this->source . '/attributes/' . $field);
                    throw $exception;
                }
            }

        // TODO: Set the relationships

        return $sugarBean;
    }

    /**
     * @param array $json
     * @param string $source rfc6901
     * @return Resource|$this
     * @throws Conflict
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
    private static function validateResource($resource)
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