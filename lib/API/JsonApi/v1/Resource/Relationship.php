<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
use SuiteCRM\API\JsonApi\v1\Enumerator\RelationshipType;
use SuiteCRM\API\JsonApi\v1\Interfaces\JsonApiResponseInterface;
use SuiteCRM\API\JsonApi\v1\Links;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use SuiteCRM\API\JsonApi\v1\Enumerator\ResourceEnum;
use SuiteCRM\API\v8\Exception\ApiException;
use SuiteCRM\API\v8\Exception\BadRequestException;
use SuiteCRM\API\v8\Exception\ConflictException;
use SuiteCRM\API\v8\Exception\ForbiddenException;
use SuiteCRM\API\v8\Exception\NotImplementedException;
use SuiteCRM\Utility\SuiteLogger as Logger;

/** Class ResourceIdentifier
 * @package SuiteCRM\API\JsonApi\v1\Resource
 * @see http://jsonapi.org/format/1.0/#document-resource-identifier-objects
 */
class Relationship extends ResourceIdentifier
{
    /** @var string $link */
    protected $name;

    /** @var RelationshipType $relationshipType */
    protected $relationshipType = RelationshipType::TO_ONE;

    /** @var ResourceIdentifier[] $link */
    protected $link;

    /**
     * @param string $name
     */
    public function setRelationshipName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getRelationshipName()
    {
        return $this->name;
    }

    /**
     * @return RelationshipType
     */
    public function getRelationshipType()
    {
        return $this->relationshipType;
    }

    public function setRelationshipType($type = RelationshipType::TO_ONE)
    {
        if ($type !== RelationshipType::TO_ONE && $type !== RelationshipType::TO_MANY) {
            throw new ApiException('[Relationship] [Unsupported Relationship Type] '. $type);
        }
        $this->relationshipType = $type;
    }

    /**
     * @param ResourceIdentifier $related
     * @return Resource
     * @throws ForbiddenException
     * @throws \SuiteCRM\API\v8\Exception\ApiException
     */
    public function withResourceIdentifier(ResourceIdentifier $related)
    {
        $this->withResourceObject($related);
        return clone $this;
    }

    /**
     * @return array
     */
    public function toJsonApiResponse()
    {
        $payload = array();
        if ($this->getRelationshipType() === RelationshipType::TO_ONE) {
            $payload = $this->link->toJsonApiResponse();
        } elseif ($this->getRelationshipType() === RelationshipType::TO_MANY) {
            foreach ($this->link as $link) {
                $response =  $link->toJsonApiResponse();
                if (empty($response) === false) {
                    $payload[] = $response;
                }
            }
        }
        return $payload;
    }

    /**
     * Sets the link property up
     * @parm Resource|ResourceIdentiifer
     * @throws \SuiteCRM\API\v8\Exception\ApiException
     */
    private function withResourceObject($related)
    {
        if ($this->getType() === null) {
            $this->type = $related->getType();
        } elseif ($this->getType() !== $related->getType()) {
            throw new ForbiddenException('[Relationship] [Incompatible Resource Type] "'. $related->getType().'"');
        }

        $this->id = $related->getId();

        if ($this->relationshipType === RelationshipType::TO_ONE) {
            $this->link = $related;
        } elseif ($this->relationshipType === RelationshipType::TO_MANY) {
            $this->link[] = $related;
        } else {
            throw new ApiException(
                '[Relationship] [Unsupported Relationship Type] ' .
                $this->relationshipType
            );
        }

        if ($this->getType() === null) {
            $this->type = $related->getType();
        } elseif ($this->getType() !== $related->getType()) {
            throw new ForbiddenException('[Relationship] [Incompatible Resource Type] "'. $related->getType().'"');
        }

        return clone $this;
    }
}
