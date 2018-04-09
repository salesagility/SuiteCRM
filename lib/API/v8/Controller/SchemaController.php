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


namespace SuiteCRM\API\v8\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SuiteCRM\API\JsonApi\v1\JsonApi;
use SuiteCRM\API\v8\Exception\ApiException;
use SuiteCRM\API\v8\Exception\InvalidJsonApiResponseException;
use SuiteCRM\API\v8\Exception\NotAcceptableException;
use SuiteCRM\API\v8\Exception\NotFoundException;
use SuiteCRM\API\v8\Exception\UnsupportedMediaTypeException;
use SuiteCRM\Exception\InvalidArgumentException;

class SchemaController extends ApiController
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws InvalidJsonApiResponseException
     * @throws InvalidArgumentException
     * @throws NotAcceptableException
     * @throws UnsupportedMediaTypeException
     */
    public function getJsonApiSchema(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {
            $jsonApi = new JsonApi();
            if(file_exists($jsonApi->getSchemaPath()) === false) {
                throw new NotFoundException(
                    '[SchemaController] unable to find JSON Api Schema file:  '. $jsonApi->getSchemaPath()
                );
            }

            $schemaFile = file_get_contents($jsonApi->getSchemaPath());

            if($schemaFile === false) {
                throw new ApiException(
                    '[SchemaController] unable to read JSON Api Schema file: '.  $jsonApi->getSchemaPath()
                );
            }

            return $response->withHeader(self::CONTENT_TYPE_HEADER, self::CONTENT_TYPE_JSON)->write($schemaFile);
            
        } catch (\Exception $e) {
            $payload = $this->handleExceptionIntoPayloadError($request, $e, isset($payload) ? $payload : []);
        }
        
        return $this->generateJsonApiResponse($request, $response, $payload);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface|static
     * @throws InvalidJsonApiResponseException
     * @throws InvalidArgumentException
     * @throws NotAcceptableException
     * @throws UnsupportedMediaTypeException
     */
    public function getSwaggerSchema(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {
            $path = dirname(__DIR__).'/swagger.json';
            if(file_exists($path) === false) {
                throw new NotFoundException(
                    '[SchemaController] unable to find JSON Api Schema file:  '. $path
                );
            }

            $schemaFile = file_get_contents($path);

            if($schemaFile === false) {
                throw new ApiException(
                    '[SchemaController] unable to read JSON Api Schema file: '.  $path
                );
            }

            return $response->withHeader(self::CONTENT_TYPE_HEADER, self::CONTENT_TYPE_JSON)->write($schemaFile);
            
        } catch (\Exception $e) {
            $payload = $this->handleExceptionIntoPayloadError($request, $e, isset($payload) ? $payload : []);
        }
        
        return $this->generateJsonApiResponse($request, $response, $payload);
    }
}