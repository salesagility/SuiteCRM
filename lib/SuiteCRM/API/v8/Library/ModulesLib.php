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

namespace SuiteCRM\API\v8\Library;

use Slim\Http\Request as Request;
use Slim\Http\Response as Response;
use League\Url\Components\Query as Query;
use SuiteCRM\API\JsonApi\v1\Links as Links;

/**
 * Class ModulesLib
 * @package SuiteCRM\API\v8\Library
 */
class ModulesLib
{
    /**
     * @param Request $req
     * @param Response $res
     * @param array $args
     * @return array list => SugarBean[], current_offset => 0, row_count => 0
     * @throws \Exception
     */
    public function generatePaginatedModuleRecords(Request $req, Response $res, $args)
    {
        global $sugar_config;
        global $db;
        global $timedate;
        $response = array();
        $page = $req->getParam('page');
        $currentOffset = isset($page['offset']) ? (integer)$page['offset'] : -1;
        $limit = isset($page['limit']) ? (integer)$page['limit'] : -1;

        // Handle Sorting
        $orderBy = '';
        if (!empty($req->getParam('sort'))) {
            $sortField = explode(',', $req->getParam('sort'));
            foreach ($sortField as $sortKey => $sortValue) {

                if ($sortValue[0] === '-') {
                    $sortField[$sortKey] = $db->quote(substr($sortValue, 1)) . ' DESC';
                } else {
                    $sortField[$sortKey] = $db->quote($sortValue). ' ASC';
                }
            }
            $orderBy = implode(',', $sortField);
        }

        // TODO: handle filtering
        $filter = $req->getParam('filter');

        // handle deleted field
        $show_deleted = 0;
        if (isset($filter['deleted'])) {
            $show_deleted = (integer)$filter['deleted'];
        }

        /**
         * @var \SugarBean $module
         */
        $module = \BeanFactory::newBean($args['module']);

        if($module === false) {
            $res = $res->withStatus(404);
            throw new \Exception('Module "'.$args['module'].'" Not Found', 404);
        }
        /**
         * @var array $moduleList
         */
        $moduleList = $module->get_list($orderBy, '', $currentOffset, $limit, -1, $show_deleted);

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

            if (isset($selectFields[$moduleBean->module_name])) {
                // only return the fields requested
                $fields['fields'][$moduleBean->module_name] = explode(',', $selectFields[$moduleBean->module_name]);
            } else {
                $fields['fields'][$moduleBean->module_name] = $moduleBean->column_fields;
            }

            // add attributes
            foreach ($fields['fields'][$moduleBean->module_name] as $fieldName) {
                // Filter security sensitive information from attributes
                if(
                    isset($sugar_config['filter_module_fields'][$moduleBean->module_name]) &&
                    in_array($fieldName, $sugar_config['filter_module_fields'][$moduleBean->module_name], true)
                ) {
                    continue;
                }

                // Convert date, datetime, times to ISO 8601
                if(
                    isset($moduleBean->field_defs[$fieldName]) &&
                    !empty($moduleBean->$fieldName) &&
                    $moduleBean->field_defs[$fieldName]['type'] === 'datetime'
                ) {
                        $date = $timedate->fromUser($moduleBean->$fieldName);
                        $fieldValue = $date->format('c');

                } else {
                    $fieldValue = $moduleBean->$fieldName;
                    $bean['attributes'][$fieldName] = $fieldValue;
                }
                $bean['attributes'][$fieldName] = $fieldValue;

            }

            // add links object to $bean
            $bean['links'] = Links::get()->withSelf($sugar_config['site_url'] . '/api/' . $req->getUri()->getPath() . '/' . $moduleBean->id)->getArray();

            // append bean to data
            $response['list'][] = $bean;
        }
        $response['current_offset'] = $moduleList['current_offset'];
        $response['row_count'] = $moduleList['row_count'];

        return $response;
    }

    /**
     * @param Request $req
     * @param Response $res
     * @param array $args
     * @param array $paginatedModuleRecords return value from ModulesLib::generatePaginatedLinksFromModuleRecords
     * @see ModulesLib::generatePaginatedLinksFromModuleRecords
     * @return Links
     */
    public function generatePaginatedLinksFromModuleRecords(Request $req, Response $res, $args, $paginatedModuleRecords)
    {
        global $sugar_config;
        $page = $req->getParam('page');
        $limit = isset($page['limit']) ? (integer)$page['limit'] : -1;
        $sort = $req->getParam('sort');
        $filter = $req->getParam('filter');
        $fields = $req->getParam('fields');
        $currentOffset = (integer)$paginatedModuleRecords['current_offset'] < 0 ? 0 : (integer)$paginatedModuleRecords['current_offset'];
        $firstOffset = 0;
        $limitOffset = ($limit <= 0) ? $sugar_config['list_max_entries_per_page'] : $limit;
        $lastOffset = (integer)floor((integer)$paginatedModuleRecords['row_count'] / $limitOffset);
        $prevOffset = $currentOffset - 1 < $firstOffset ? $firstOffset : $currentOffset - 1;
        $nextOffset = $currentOffset + 1 > $lastOffset ? $lastOffset : $currentOffset + 1;

        $links = Links::get()->withPagination();
        $links->withSelf($this->generatePaginationUrl($req, $currentOffset, $limitOffset, $filter, $sort, $fields));

        if ($firstOffset !== $lastOffset) {
            if ($currentOffset !== $firstOffset) {
                $links->withFirst(
                    $this->generatePaginationUrl(
                        $req,
                        $firstOffset,
                        $limitOffset,
                        $filter,
                        $sort,
                        $fields
                    )
                );
            }

            if ($currentOffset !== $lastOffset) {
                $links->withLast(
                    $this->generatePaginationUrl(
                        $req,
                        $lastOffset,
                        $limitOffset,
                        $filter,
                        $sort,
                        $fields
                    )
                );
            }

            if ($currentOffset > $firstOffset) {
                $links->withPrev(
                    $this->generatePaginationUrl(
                        $req,
                        $prevOffset,
                        $limitOffset,
                        $filter,
                        $sort,
                        $fields
                    )
                );
            }

            if ($currentOffset < $lastOffset) {
                $links->withNext(
                    $this->generatePaginationUrl(
                        $req,
                        $nextOffset,
                        $limitOffset,
                        $filter,
                        $sort,
                        $fields
                    )
                );
            }
        }

        return $links;
    }

    /**
     * @param Request $req
     * @param null|integer $offset
     * @param null|integer $limit
     * @param null|array $filter
     * @param null|array $sort
     * @param null|array $fields eg array ('fields' => 'Accounts' => array('name', 'description'))
     * @return string
     */
    private function generatePaginationUrl(
        Request $req,
        $offset = null,
        $limit = null,
        $filter = null,
        $sort = null,
        $fields = null
    ) {
        global $sugar_config;
        $query = new Query();
        $pagination = array();

        if ($offset !== null) {
            $pagination['page']['offset'] = $offset;
        }

        if ($limit !== null && $limit > 0 && $limit !== $sugar_config['list_max_entries_per_page']) {
            $pagination['page']['limit'] = $offset;
        }


        if ($filter !== null) {
            $query->modify(array('filter' => $filter));
        }

        if ($sort !== null) {
            $query->modify(array('sort' => implode(",", $sort)));
        }


        if ($fields !== null) {
            $queryFields = array();
            foreach ($fields as $module => $moduleFields) {
                $queryFields['fields'][$module] = $fields[$module];
            }
            $query->modify($queryFields);
        }

        $query->modify($pagination);
        $queryString = $query->get();
        if ($queryString !== null) {
            return $sugar_config['site_url'] . '/api/' . $req->getUri()->getPath() . '?' . $queryString;
        }

        return $sugar_config['site_url'] . '/api/' . $req->getUri()->getPath();
    }
}
