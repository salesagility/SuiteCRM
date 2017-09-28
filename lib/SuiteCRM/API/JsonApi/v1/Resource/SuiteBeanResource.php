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
 * Class SuiteBeanResource
 * @package SuiteCRM\API\JsonApi\v1\Resource
 * @see http://jsonapi.org/format/1.0/#document-resource-objects
 */
class SuiteBeanResource extends Resource
{

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

    public static function fromDataArray($json, $source = ResourceEnum::DEFAULT_SOURCE)
    {
        return self::fromResource(parent::fromDataArray($json, $source));
    }

    private static function fromResource(Resource $resource)
    {
        $sugarBeanResource = new self();
        $objValues = get_object_vars($resource); // return array of object values
        foreach($objValues AS $key=>$value)
        {
            $sugarBeanResource->$key = $value;
        }
        return $sugarBeanResource;
    }
}
