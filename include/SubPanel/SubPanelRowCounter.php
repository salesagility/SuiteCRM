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


class SubPanelRowCounter
{
    /**
     * @var SugarBean
     */
    private $focus;

    /**
     * SubPanelRowCounter constructor.
     * @param $focus
     */
    public function __construct($focus)
    {
        $this->focus = $focus;
    }

    /**
     * @param array $subPanelDef
     * @return int
     */
    public function getSubPanelRowCount($subPanelDef)
    {
        if (!isset($subPanelDef['get_subpanel_data'])) {
            foreach ($subPanelDef['collection_list'] as $subSubPanelDef) {
                if($this->getSubPanelRowCount($subSubPanelDef)) {
                    return 1;
                }
            }
            return 0;
        }

        return $this->getSingleSubPanelRowCount($subPanelDef);
    }

    /**
     * @param array $subPanelDef
     * @return int
     */
    public function getSingleSubPanelRowCount($subPanelDef)
    {
        global $db;

        $query = $this->makeSubPanelRowCountQuery($subPanelDef);
        if (!$query) {
            return -1;
        }

        $result = $db->query($query);
        if ($row = $db->fetchByAssoc($result)) {
            return (int)array_shift($row);
        }

        return 0;
    }

    /**
     * @param array $subPanelDef
     * @return string
     */
    public function makeSubPanelRowCountQuery($subPanelDef) {

        $relationshipName = $subPanelDef['get_subpanel_data'];

        if (substr($relationshipName, 0, 9) === 'function:') {
            include_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'utils.php';
            $functionName = substr($relationshipName, 9);
            $qry = [];
            if (method_exists($this->focus, $functionName)) {
                $qry = $this->focus->$functionName($subPanelDef['function_parameters']);
            } elseif (function_exists($functionName)) {
                $qry = call_user_func($functionName, $subPanelDef['function_parameters']);
            }
            if (is_array($qry) && count($qry)) {
                $qry =  $qry['select'] . $qry['from'] . $qry['join'] . $qry['where'];
            }
            return $this->selectQueryToCountQuery($qry);
        }

        $this->focus->load_relationship($relationshipName);
        /** @var Link2 $relationship */
        $relationship = $this->focus->$relationshipName;

        if ($relationship) {
            return $this->selectQueryToCountQuery($relationship->getQuery());
        }

        return '';
    }

    /**
     * @param string $selectQuery
     * @return string
     */
    public function selectQueryToCountQuery($selectQuery)
    {
        if (!is_string($selectQuery)) {
            return '';
        }

        if (0 !== stripos($selectQuery, 'SELECT')) {
            return '';
        }

        $fromPos = strpos($selectQuery, ' FROM');
        if ($fromPos === false) {
            return '';
        }

        $selectPart = trim(substr($selectQuery, 7, $fromPos - 7));
        if (false !== strpos($selectPart, ',')) {
            return '';
        }

        return 'SELECT COUNT(' . $selectPart . ') ' . substr($selectQuery, $fromPos) . ' LIMIT 1';
    }
}