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

namespace SuiteCRM\API\v8\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use SuiteCRM\API\JsonApi\v1\Links;
use SuiteCRM\API\JsonApi\v1\Resource\Resource;
use SuiteCRM\API\JsonApi\v1\Resource\SuiteBeanResource;
use SuiteCRM\API\v8\Exception\ApiException;
use SuiteCRM\API\v8\Exception\BadRequest;
use SuiteCRM\API\v8\Exception\Conflict;
use SuiteCRM\API\v8\Exception\EmptyBody;
use SuiteCRM\API\v8\Exception\Forbidden;
use SuiteCRM\API\v8\Exception\InvalidJsonApiRequest;
use SuiteCRM\API\v8\Exception\InvalidJsonApiResponse;
use SuiteCRM\API\v8\Exception\ModuleNotFound;
use SuiteCRM\API\v8\Exception\NotAcceptable;
use SuiteCRM\API\v8\Exception\NotFound;
use SuiteCRM\API\v8\Exception\UnsupportedMediaType;
use SuiteCRM\API\v8\Library\ModulesLib;
use SuiteCRM\Enumerator\ExceptionCode;
use SuiteCRM\Exception\Exception;

class ModuleController extends ApiController
{
    const FIELDS = 'fields';
    const MISSING_ID = '["id" does not exist]';
    const SOURCE_TYPE = '/data/attributes/type';
    const MODULE = 'module';
    const LINKS = 'links';
    /**
     * GET /api/v8/modules
     * @param Request $req
     * @param Response $res
     * @return Response
     * @throws ApiException
     * @throws NotAcceptable
     * @throws UnsupportedMediaType
     * @throws ModuleNotFound
     * @throws InvalidJsonApiResponse
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function getModules(Request $req, Response $res)
    {
        require_once __DIR__ . '/../../../../../include/modules.php';
        global $moduleList;

        $payload = array(
            'meta' => array('modules' => $moduleList)
        );

        $this->negotiatedJsonApiContent($req, $res);
        return $this->generateJsonApiResponse($req, $res, $payload);
    }

    /**
     * GET /api/v8/modules/{module_name}
     * @param Request $req
     * @param Response $res
     * @param array $args
     * @return Response
     * @throws ModuleNotFound
     * @throws ApiException
     * @throws NotAcceptable
     * @throws UnsupportedMediaType
     * @throws \InvalidArgumentException
     * @throws InvalidJsonApiResponse
     */
    public function getModuleRecords(Request $req, Response $res, array $args)
    {
        global $sugar_config;
        $lib = new ModulesLib();
        $payload = array(
//            'meta' => array(),
            'links' => array(),
            'data' => array()
        );

        $this->negotiatedJsonApiContent($req, $res);
        $paginatedModuleRecords = $lib->generatePaginatedModuleRecords($req, $res, $args);
        $payload['data'] = $paginatedModuleRecords['list'];

        $links = $lib->generatePaginatedLinksFromModuleRecords($req, $res, $args, $paginatedModuleRecords);
        $payload[self::LINKS] = $links->getArray();

        $page = $req->getParam('page');
        $currentOffset = (integer)$paginatedModuleRecords['current_offset'] < 0 ? 0 : (integer)$paginatedModuleRecords['current_offset'];
        $limit = isset($page['limit']) ? (integer)$page['limit'] : -1;
        $limitOffset = ($limit <= 0) ? $sugar_config['list_max_entries_per_page'] : $limit;
        $lastOffset = (integer)floor((integer)$paginatedModuleRecords['row_count'] / $limitOffset);

        $payload['meta']['offsets'] = array(
            'current' => $currentOffset,
            'count' => $lastOffset
        );

        // TODO: use generateJsonApiResponse instead
        return $this->generateJsonApiListResponse($req, $res, $payload);
    }


    /**
     * @param Request $req
     * @param Response $res
     * @param array $args
     * @return Response
     * @throws ApiException
     * @throws ModuleNotFound
     * @throws EmptyBody
     * @throws Conflict
     * @throws NotAcceptable
     * @throws UnsupportedMediaType
     * @throws BadRequest
     * @throws Forbidden
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws InvalidJsonApiRequest
     * @throws InvalidJsonApiResponse
     */
    public function createModuleRecord(Request $req, Response $res, array $args)
    {
        global $sugar_config;
        $this->negotiatedJsonApiContent($req, $res);

        $res = $res->withStatus(202);
        $moduleName = $args[self::MODULE];
        $module = \BeanFactory::newBean($moduleName);
        $body = json_decode($req->getBody()->getContents(), true);
        $payload = array();

        // Validate module
        if(empty($module)) {
            throw new ModuleNotFound($moduleName);
        }

        // Validate JSON
        if(empty($body)) {
            throw new EmptyBody();
        }

        // Validate Type
        if (!isset($body['data']['type'])) {
            $exception = new Conflict('[Missing "type" key in data]');
            $exception->setSource(self::SOURCE_TYPE);
            throw $exception;
        }

        if (isset($body['data']['type']) && $body['data']['type'] !== $module->module_name) {
            $exception = new Conflict('["type" does not exist]"', ExceptionCode::API_MODULE_NOT_FOUND);
            $exception->setSource(self::SOURCE_TYPE);
            throw $exception;
        }

        // Validate ID
        if (isset($body['data']['id'])) {
            $exception = new Forbidden('[creating a record with client id not allowed] "'.$body['data']['id'].'"');
            $exception->setSource('/data/attributes/id');
            throw $exception;
        }

        // Handle Request
        $resource = SuiteBeanResource::fromDataArray($body['data']);
        $sugarBean = $resource->toSugarBean();
        try {
            $sugarBean->save();
        } catch (Exception $e) {
            throw new ApiException($e->getMessage(), $e->getCode(), $e);
        }

        $links = new Links();
        $self = $sugar_config['site_url'] . '/api/' . $req->getUri()->getPath() . '/' . $sugarBean->id;
        $links = $links->withSelf($self);
        $selectFields = $req->getParam(self::FIELDS);
        $resource =  SuiteBeanResource::fromSugarBean($sugarBean);
        if ($selectFields !== null && isset($selectFields[$moduleName])) {
            $fields = explode(',', $selectFields[$moduleName]);
            $payload['data'] = $resource->getArrayWithFields($fields);
        } else {
            $payload['data'] = $resource->getArray();
        }
        $payload[self::LINKS] = $links->getArray();
        $res = $res->withStatus(201);
        return $this->generateJsonApiResponse($req, $res, $payload);
    }

    /**
     * @param Request $req
     * @param Response $res
     * @param array $args
     * @return Response
     * @throws Conflict
     * @throws NotFound
     * @throws EmptyBody
     * @throws ApiException
     * @throws NotAcceptable
     * @throws UnsupportedMediaType
     * @throws ModuleNotFound
     * @throws InvalidJsonApiRequest
     * @throws InvalidJsonApiResponse
     * @throws \InvalidArgumentException
     */
    public function getModuleRecord(Request $req, Response $res, array $args)
    {
        $this->negotiatedJsonApiContent($req, $res);
        $res = $res->withStatus(202);
        $moduleName = $args[self::MODULE];
        $moduleId = $args['id'];
        $module = \BeanFactory::newBean($moduleName);
        $payload = array();

        // Validate module
        if(empty($module)) {
            throw new ModuleNotFound($moduleName);
        }

        $sugarBean = \BeanFactory::getBean($moduleName, $moduleId);
        if ($sugarBean ->new_with_id === true) {
            $exception = new NotFound(self::MISSING_ID);
            $exception->setSource('');
            throw $exception;
        }

        // Handle Request
        $resource = SuiteBeanResource::fromSugarBean($sugarBean);

        // filter fields
        $selectFields = $req->getParam(self::FIELDS);
        if ($selectFields !== null && isset($selectFields[$moduleName])) {
            $fields = explode(',', $selectFields[$moduleName]);
            $payload['data'] = $resource->getArrayWithFields($fields);
        } else {
            $payload['data'] = $resource->getArray();
        }

        $res = $res->withStatus(200);
        return $this->generateJsonApiResponse($req, $res, $payload);
    }

    /**
     * @param Request $req
     * @param Response $res
     * @param array $args
     * @return Response
     * @throws Conflict
     * @throws NotFound
     * @throws EmptyBody
     * @throws ApiException
     * @throws NotAcceptable
     * @throws UnsupportedMediaType
     * @throws InvalidJsonApiRequest
     * @throws InvalidJsonApiResponse
     * @throws ModuleNotFound
     * @throws BadRequest
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function updateModuleRecord(Request $req, Response $res, array $args)
    {
        $this->negotiatedJsonApiContent($req, $res);
        $res = $res->withStatus(202);
        $moduleName = $args[self::MODULE];
        $moduleId = $args['id'];
        $module = \BeanFactory::newBean($moduleName);
        $body = json_decode($req->getBody()->getContents(), true);
        $payload = array();

        // Validate module
        if(empty($module)) {
            throw new ModuleNotFound($moduleName);
        }

        // Validate JSON
        if(empty($body)) {
            throw new EmptyBody();
        }

        // Validate Type
        if (!isset($body['data']['type'])) {
            $exception = new Conflict('[Missing "type" key in data]');
            $exception->setSource(self::SOURCE_TYPE);
            throw $exception;
        }

        if (isset($body['data']['type']) && $body['data']['type'] !== $module->module_name) {
            $exception = new Conflict('["type" does not exist]"', ExceptionCode::API_MODULE_NOT_FOUND);
            $exception->setSource(self::SOURCE_TYPE);
            throw $exception;
        }

        // Validate ID
        $sugarBean = \BeanFactory::getBean($moduleName, $moduleId);
        if ($sugarBean ->new_with_id === true) {
            $exception = new NotFound('["id" does not exist]');
            $exception->setSource('');
            throw $exception;
        }

        $resource = SuiteBeanResource::fromSugarBean($sugarBean);
        $resource->mergeAttributes(Resource::fromDataArray($body['data']));
        $sugarBean = $resource->toSugarBean();
        // Handle Request
        try {
            if (empty($sugarBean->save())) {
                throw new ApiException('[Unable to update record]');
            }
        } catch (Exception $e) {
            throw new ApiException($e->getMessage(), $e->getCode(), $e);
        }

        $resource = SuiteBeanResource::fromSugarBean($sugarBean);
        $selectFields = $req->getParam(self::FIELDS);

        if ($selectFields !== null && isset($selectFields[$moduleName])) {
            $fields = explode(',', $selectFields[$moduleName]);
            $payload['data'] = $resource->getArrayWithFields($fields);
        } else {
            $payload['data'] = $resource->getArray();
        }

        $res = $res->withStatus(200);
        return $this->generateJsonApiResponse($req, $res, $payload);
    }

    /**
     * @param Request $req
     * @param Response $res
     * @param array $args
     * @return Response
     * @throws Conflict
     * @throws NotFound
     * @throws EmptyBody
     * @throws ApiException
     * @throws NotAcceptable
     * @throws UnsupportedMediaType
     * @throws ModuleNotFound
     * @throws InvalidJsonApiResponse
     * @throws \InvalidArgumentException
     */
    public function deleteModuleRecord(Request $req, Response $res, array $args)
    {
        $this->negotiatedJsonApiContent($req, $res);
        $res = $res->withStatus(202);
        $moduleName = $args[self::MODULE];
        $moduleId = $args['id'];
        $module = \BeanFactory::newBean($moduleName);
        $payload = array();

        // Validate module
        if(empty($module)) {
            throw new ModuleNotFound($moduleName);
        }

        // Validate ID
        $sugarBean = \BeanFactory::getBean($moduleName, $moduleId);
        if ($sugarBean ->new_with_id === true) {
            $exception = new NotFound(self::MISSING_ID);
            $exception->setSource('');
            throw $exception;
        }

        // Handle Request
        $sugarBean->deleted = 1;

        try {
            if (empty($sugarBean->save())) {
                throw new ApiException('[Unable to delete record]');
            }
        } catch (Exception $e) {
            throw new ApiException($e->getMessage(), $e->getCode(), $e);
        }

        $payload['meta'] = array(
            'status' => 200
        );
        $res = $res->withStatus(200);
        return $this->generateJsonApiResponse($req, $res, $payload);
    }


}
