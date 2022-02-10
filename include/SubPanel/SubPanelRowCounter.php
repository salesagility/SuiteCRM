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

namespace SuiteCRM\SubPanel;

class SubPanelRowCounter
{
    /**
     * @var \SugarBean
     */
    private $focus;

    /**
     * @var array
     */
    private $subPanelDef;

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
        $this->setSubPanelDefs($subPanelDef);

        try {
            $count = $this->doGetSubPanelRowCount($this->subPanelDef);
            if ($count < 0) {
                throw new \Exception('sub panel row count can not be negative');
            }
            return $count;
        } catch (\Exception $e) {
            \LoggerManager::getLogger()->error($e->getMessage());
            return -1;
        }
    }

    /**
     * @param string[] $subPanelDef
     */
    public function setSubPanelDefs($subPanelDef)
    {
        $this->subPanelDef = $subPanelDef;
    }

    /**
     * @param array $subPanelDef
     * @return int
     */
    private function doGetSubPanelRowCount($subPanelDef)
    {
        if (!isset($subPanelDef['get_subpanel_data'])) {
            foreach ($subPanelDef['collection_list'] as $subSubPanelDef) {
                $subPanelRowCount = $this->doGetSubPanelRowCount($subSubPanelDef);
                if ($subPanelRowCount) {
                    return $subPanelRowCount;
                }
            }
            return 0;
        }

        return $this->getSingleSubPanelRowCount();
    }

    /**
     * @return int
     */
    public function getSingleSubPanelRowCount()
    {
        global $db;

        $query = $this->makeSubPanelRowCountQuery();
        if (!$query) {
            return -1;
        }

        $result = $db->query($query);
        if ($result === false) {
            return -1;
        }

        if ($row = $db->fetchByAssoc($result)) {
            return (int)array_shift($row);
        }

        return 0;
    }

    /**
     * @return string
     */
    public function makeSubPanelRowCountQuery()
    {
        $relationshipName = isset($this->subPanelDef['get_subpanel_data']) && $this->subPanelDef['get_subpanel_data'] ? $this->subPanelDef['get_subpanel_data'] : null;
        if (!$relationshipName) {
            throw new \Exception('relationship name can not be empty');
        }

        if (0 === strpos($relationshipName, 'function:')) {
            return $this->makeFunctionCountQuery($relationshipName);
        }

        if ($this->focus->load_relationship($relationshipName) !== false) {
            /** @var \Link2 $relationship */
            $relationship = $this->focus->$relationshipName;
            return $this->selectQueryToCountQuery($relationship->getQuery());
        }

        return '';
    }

    /**
     * @param $relationshipName
     * @return string
     */
    public function makeFunctionCountQuery($relationshipName)
    {
        include_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'utils.php';
        $functionName = substr($relationshipName, 9);
        $qry = [];
        $functionParameters = isset($this->subPanelDef['function_parameters']) && $this->subPanelDef['function_parameters'] ? $this->subPanelDef['function_parameters'] : null;
        if (null === $functionParameters) {
            \LoggerManager::getLogger()->warn('Function parameters is empty');
        }
        if (method_exists($this->focus, $functionName)) {
            $qry = $this->focus->$functionName($functionParameters);
        } elseif (\function_exists($functionName)) {
            $qry = $functionName($functionParameters);
        }
        if (\is_array($qry) && \count($qry)) {
            $qry = $qry['select'] . $qry['from'] . $qry['join'] . $qry['where'];
        }
        return $this->selectQueryToCountQuery($qry);
    }

    /**
     * @param string $selectQuery
     * @return string
     */
    public function selectQueryToCountQuery($selectQuery)
    {
        if (!\is_string($selectQuery)) {
            return '';
        }

        $selectQuery = trim(str_replace(["\n", "\t", "\r", '  '], ' ', $selectQuery));

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

        $selectArr = explode(' ', $selectPart);
        $selectPartFirst = $selectArr[0];

        if (strpos($selectPartFirst, '*') !== false) {
            $selectPartFirst = \str_replace('*', 'id', $selectPartFirst);
        }

        return 'SELECT COUNT(' . $selectPartFirst . ')' . substr($selectQuery, $fromPos) . ' LIMIT 1';
    }
}
