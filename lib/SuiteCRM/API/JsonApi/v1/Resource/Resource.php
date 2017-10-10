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

use Interop\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use SuiteCRM\API\JsonApi\v1\Links;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use SuiteCRM\API\JsonApi\v1\Enumerator\ResourceEnum;
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
    protected static $JSON_API_SKIP_RESERVED_KEYWORDS = array(
        'id',
        'type',
    );

    protected static $JSON_API_RESERVED_KEYWORDS = array(
        'id',
        'type',
        'data',
        'meta',
        'jsonapi',
        'links',
        'included',
        'self',
        'related',
        'attributes',
        'relationships',
        'href',
        'first',
        'last',
        'prev',
        'next',
        'related',
        'errors',
    );

    /**
     * @var ContainerInterface $containers
     */
    protected $containers;

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
    public function __construct(ContainerInterface $containers)
    {
        $this->containers = $containers;
    }

    /**
     * @param array $json
     * @param string $source rfc6901
     * @return Resource
     * @throws Conflict
     * @throws BadRequest
     * @see https://tools.ietf.org/html/rfc6901
     */
    public function fromDataArray($json, $source = ResourceEnum::DEFAULT_SOURCE)
    {
        global $sugar_config;
        if(isset($json['id'])) {
            $this->id = $json['id'];
        }
        $this->type = $json['type'];
        $this->source = $source;

        if ($this->type === null) {
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
            if ($this->attributes === null) {
                $this->attributes = array();
            }

            // Filter security sensitive information from attributes
            if (
                isset($sugar_config['filter_module_fields'][$this->type]) &&
                in_array($attributeName, $sugar_config['filter_module_fields'][$this->type], true)
            ) {
                continue;
            }

            $this->attributes[$attributeName] = $attributeValue;
        }

        $this->relationships = $json['relationships'];

        // TODO: Relationships
        return clone $this;
    }

    /**
     * @param Resource $resource
     */
    public function mergeAttributes(Resource $resource)
    {
        $resourceArray = $resource->getArray();
        $this->attributes = array_merge($this->attributes, $resourceArray['attributes']);
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
     * @return array - Return only the fields which exist in the $fields
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

        if($this->links !== null) {
            $response['links'] = $this->links->getArray();
        }

        if($this->relationships !== null) {
            $response['relationships'] = $this->relationships;
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

        return clone $this;
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

        return clone $this;
    }

    /**
     * @param Links $links
     * @return $this
     */
    public function withLinks(Links $links) {
        $this->links = $links;

        return clone $this;
    }

    /**
     * @throws Conflict
     */
    protected function validateResource()
    {
        // Validate ID
        if ($this->id === null) {
            $exception = new Conflict('[Missing "id" key in data]"');
            $exception->setSource($this->source . '/attributes/id');
            throw $exception;
        }

        // Validate Type
        if ($this->type === null) {
            $exception = new Conflict('[Missing "type" key in data]');
            $exception->setSource($this->source . '/attributes/type');
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