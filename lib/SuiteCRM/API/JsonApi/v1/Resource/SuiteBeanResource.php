<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

namespace SuiteCRM\API\JsonApi\v1\Resource;

use Faker\Provider\DateTime;
use SuiteCRM\Enumerator\ExceptionCode;
use SuiteCRM\API\JsonApi\v1\Enumerator\ResourceEnum;
use SuiteCRM\API\v8\Exception\ApiException;
use SuiteCRM\API\v8\Exception\BadRequest;
use SuiteCRM\API\v8\Exception\Conflict;

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
     * @return SuiteBeanResource
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
                if (empty($datetime)) {
                    $datetime = $timedate->fromDb($sugarBean->$field);
                }

                if (empty($datetime)) {
                    throw new ApiException(
                        '[Unable to convert datetime field using SugarBean] "' . $field . '"',
                        ExceptionCode::API_DATE_CONVERTION_SUGARBEAN
                    );
                }

                $datetimeISO8601 = $datetime->format('c');
                if ($datetime === false) {
                    throw new ApiException(
                        '[Unable to convert datetime field to ISO 8601] "' . $field . '"',
                        ExceptionCode::API_DATE_CONVERTION_SUGARBEAN);
                }
                $resource->attributes[$field] = $datetimeISO8601;
            } else {
                $resource->attributes[$field] = $sugarBean->$field;
            }

            // Validate Required fields
            // Skip "id" as this method may be used to populate a new bean before the bean is saved
            if (
                empty($sugarBean->$field) &&
                $field !== 'id' &&
                $definition['required'] === true &&
                !isset($resource->attributes[$field])
            ) {
                $exception = new BadRequest('[Missing Required Field] "' . $field . '"');
                $exception->setSource($resource->source . '/attributes/' . $field);
                throw $exception;
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
            if ($definition === null) {
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
                if ($definition['type'] === 'datetime' && !empty($this->attributes[$field])) {
                    // Convert to DB date
                    $datetime = \DateTime::createFromFormat(\DateTime::ATOM, $this->attributes[$field]);
                    if (empty($datetime)) {
                        $exception = new ApiException(
                            '[Unable to convert datetime field to SugarBean DbFormat] "' . $field . '"',
                            ExceptionCode::API_DATE_CONVERTION_SUGARBEAN
                        );
                        $exception->setSource(ResourceEnum::DEFAULT_SOURCE . '/attributes/' . $field);
                    }
                    $sugarBean->$field = $datetime->format('Y-m-d H:i:s');
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
     * @param string $source
     * @return SuiteBeanResource
     * @throws BadRequest
     * @throws Conflict
     */
    public static function fromDataArray($json, $source = ResourceEnum::DEFAULT_SOURCE)
    {
        return self::fromResource(parent::fromDataArray($json, $source));
    }

    /**
     * @param Resource $resource
     * @return SuiteBeanResource
     */
    private static function fromResource(Resource $resource)
    {
        $sugarBeanResource = new self();
        $objValues = get_object_vars($resource); // return array of object values
        foreach ($objValues AS $key => $value) {
            $sugarBeanResource->$key = $value;
        }

        return $sugarBeanResource;
    }
}
