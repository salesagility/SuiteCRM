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

namespace SuiteCRM\api\v8\library;

use Slim\Http\Request;
use League\Url\Components\Query;
/**
 * Class ModulesLib
 * @package SuiteCRM\api\v8\library
 */
class ModulesLib
{
    /**
     * @param Request $req
     * @param null|integer $offset
     * @param null|integer $limit
     * @param null|array $filter
     * @param null|array $sort
     * @param null|array $fields eg array ('fields' => 'Accounts' => array('name', 'description'))
     * @return string
     */
    public function generatePaginationUrl(Request $req, $offset = null, $limit = null, $filter = null, $sort = null, $fields = null)
    {
        global $sugar_config;
        $query = new Query();
        $pagination = array();

        if($offset !== null) {
            $pagination['page']['offset'] = $offset;
        }

        if($limit !== null && $limit > 0 && $limit !== $sugar_config['list_max_entries_per_page']) {
            $pagination['page']['limit'] = $offset;
        }


        if($filter !== null) {
            $query->modify(array('filter' => $filter));
        }

        if($sort !== null) {
            $query->modify(array('sort' => implode(",", $sort)));
        }

        if($fields !== null) {
            $queryFields = array();
            foreach ($fields['fields'] as $module => $moduleFields) {
                $queryFields['fields'][$module] = implode(",", $fields['fields'][$module]);
            }
            $query->modify($queryFields);
        }

        $query->modify($pagination);
        $queryString =  $query->get();
        if($queryString !== null) {
            return $sugar_config['site_url'] . '/api/' . $req->getUri()->getPath() . '?' .$queryString;
        }

        return $sugar_config['site_url'] . '/api/' . $req->getUri()->getPath();
    }



}
