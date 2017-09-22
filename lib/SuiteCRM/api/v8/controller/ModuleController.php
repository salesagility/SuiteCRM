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

namespace SuiteCRM\api\v8\controller;

use League\Url\Components\Query;
use Slim\Http\Request;
use Slim\Http\Response;
use SuiteCRM\api\core\Api;
use SuiteCRM\api\JsonApi\v1\Links;
use SuiteCRM\api\v8\library\ModulesLib;

class ModuleController extends Api
{
    /**
     * GET /api/v8/modules
     * @param Request $req
     * @param Response $res
     * @return Response
     */
    public function getModules(Request $req, Response $res)
    {
        require_once __DIR__ .'/../../../../../include/modules.php';
        global $moduleList;

        $response = array(
            'meta' => array('modules' => $moduleList)
        );

        $res = $this->generateJsonApiResponse($req, $res, $response);
        return $res;
    }

    /**
     * GET /api/v8/modules/{module_name}
     * @param Request $req
     * @param Response $res
     * @param array $args
     * @return Response
     */
    public function getModuleRecords(Request $req, Response $res, array $args)
    {
        global $sugar_config;
        $lib = new ModulesLib();
        /**
         * Build and handle request
         * ====
         */
        // handle offset and handle limit
        $page = $req->getParam('page');
        $currentOffset = isset($page['offset']) ? (integer)$page['offset'] : -1;
        $limit = isset($page['limit']) ? (integer)$page['limit'] : -1;

        // TODO: handle sorting
        $sort = $req->getParam('sort');
        if(!empty($sort)) {
            $sort = explode(',', $sort);
        }

        // TODO: handle filtering
        $filter = $req->getParam('filter');

        // handle deleted field
        $show_deleted  = 0;
        if(isset($filter['deleted'])) {
            $show_deleted = (integer) $filter['deleted'];
        }

        /**
         * @var \SugarBean $module
         */
        $module = \BeanFactory::newBean($args['module']);

        /**
         * @var array $moduleList
         */
        $moduleList = $module->get_list("", "", $currentOffset, $limit, -1, $show_deleted);

        /**
         * create response
         * ====
         */
        $response = array(
            'meta' => array(),
            'links' => array(),
            'data' => array()
        );

        // populate data field
        $fields = array('fields' => array());
        $selectFields = $req->getParam('fields');
        foreach ($moduleList['list'] as $moduleBean) {
            /**
             * @var \SugarBean $moduleBean
             */
            // Create data item
            $bean = array(
                'type' => $moduleBean->module_name,
                'id' => $moduleBean->id,
                'attributes' => array()
            );

            if(isset($selectFields[$moduleBean->module_name])) {
                // only return the fields requested
                $fields['fields'][$moduleBean->module_name] = explode(',', $selectFields[$moduleBean->module_name]);
            } else {
                $fields['fields'][$moduleBean->module_name] = $moduleBean->column_fields;
            }

            // add attributes
            foreach ($fields['fields'][$moduleBean->module_name] as $fieldName) {
                // TODO: Filter security sensitive information from attributes
                $fieldValue = $moduleBean->$fieldName;
                $bean['attributes'][$fieldName] = $fieldValue;
            }

            // add links object to $bean
            $bean['links'] = Links::get()->withSelf($sugar_config['site_url'] . '/api/' . $req->getUri()->getPath() . '/' . $moduleBean->id)->getArray();

            // append bean to data
            $response['data'][] = $bean;
        }

        if(!isset($selectFields[$args['module']])) {
            $fields = null;
        }

        // populate pagination in to links key
        $currentOffset = (integer)$moduleList['current_offset'] < 0 ? 0 : (integer)$moduleList['current_offset'];
        $firstOffset = 0;
        $limitOffset = ($limit <= 0) ? $sugar_config['list_max_entries_per_page'] : $limit;
        $lastOffset = floor((integer)$moduleList['row_count'] / $limitOffset);
        $prevOffset = $currentOffset - 1 < $firstOffset ? $firstOffset : $currentOffset - 1;
        $nextOffset = $currentOffset + 1 > $lastOffset ? $lastOffset : $currentOffset + 1;

        $links = Links::get();
        $links->withSelf($lib->generatePaginationUrl($req, $currentOffset, $limitOffset, $filter, $sort, $fields));
        $links->withFirst($lib->generatePaginationUrl($req, $firstOffset, $limitOffset, $filter, $sort, $fields));
        $links->withLast($lib->generatePaginationUrl($req, $lastOffset, $limitOffset, $filter, $sort, $fields));

        if($currentOffset > $firstOffset) {
            $links->withPrev($lib->generatePaginationUrl($req, $prevOffset, $limitOffset, $filter, $sort, $fields));
        }

        if($currentOffset < $lastOffset) {
            $links->withNext($lib->generatePaginationUrl($req, $nextOffset, $limitOffset, $filter, $sort, $fields));
        }

        $response['links'] = $links->getArray();
        $response['meta']['offsets'] = array(
            'current' => $currentOffset,
            'count' => $lastOffset
        );

        // send response
        $res = $this->generateJsonApiResponse($req, $res, $response);
        return $res;
    }
}
