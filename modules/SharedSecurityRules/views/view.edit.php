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
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

include_once __DIR__ . '/../SharedSecurityRulesHelper.php';

require_once('include/MVC/View/views/view.edit.php');
require_once("modules/SharedSecurityRules/SharedSecurityRules.php");

class SharedSecurityRulesViewEdit extends ViewEdit
{

    /**
     *
     * @return array
     */
    private function getConditionLines()
    {
        if (!is_object($this->bean)) {
            LoggerManager::getLogger()->warn('bean of SharedSecurityRulesViewEdit is not an object');
            return array();
        }
        if (!$this->bean->id) {
            return array();
        }
        $sql = "SELECT id FROM sharedsecurityrulesconditions WHERE sa_shared_sec_rules_id = '" . $this->bean->id . "' AND deleted = 0 ORDER BY condition_order ASC";
        $result = $this->bean->db->query($sql);
        $conditions = array();
        while ($row = $this->bean->db->fetchByAssoc($result)) {
            $condition_name = new SharedSecurityRulesConditions();

            $condition_name->retrieve($row['id']);
            if ($condition_name->value_type == 'Date') {
                $helper = new SharedSecurityRulesHelper($this->bean->db);
                $condition_name->value = $helper->unserializeIfSerialized($condition_name->value);
            }
            $condition_item = $condition_name->toArray();

            if (!$condition_name->parenthesis) {
                $beanFlowModule = null;
                if (isset($this->bean->flow_module)) {
                    $beanFlowModule = $this->bean->flow_module;
                } else {
                    LoggerManager::getLogger()->warn('SharedSecurityRulesViewDetail::getConditionLines() bean did not has flow module');
                }

                $display = $this->getDisplayForField($condition_name->module_path, $condition_name->field, $beanFlowModule);
                $condition_item['module_path_display'] = $display['module'];
                $condition_item['field_label'] = $display['field'];
            }
            if (isset($conditions[$condition_item['condition_order']])) {
                $conditions[] = $condition_item;
            } else {
                $conditions[$condition_item['condition_order']] = $condition_item;
            }
        }
        return $conditions;
    }

    /**
     *
     */
    public function preDisplay()
    {
        $conditions = $this->getConditionLines();
        echo "<script>var conditionLines = " . json_encode($conditions) . "</script>";

        parent::preDisplay();
    }

    /**
     *
     * @global array $app_list_strings
     * @param string $modulePath
     * @param string $field
     * @param string $reportModule
     * @return array
     */
    private function getDisplayForField($modulePath, $field, $reportModule)
    {
        global $app_list_strings;
        $fieldDisplay = null;
        $modulePathDisplay = array();
        $currentBean = BeanFactory::getBean($reportModule);
        if (!$currentBean) {
            LoggerManager::getLogger()->warn('SharedSecurityRulesViewEdit::getDisplayForField() did not get module parameter');
        } else {
            $modulePathDisplay[] = $currentBean->module_name;
            if (is_array($modulePath)) {
                $split = $modulePath;
            } else {
                $split = explode(':', $modulePath);
            }
            if ($split && $split[0] == $currentBean->module_dir) {
                array_shift($split);
            }
            foreach ($split as $relName) {
                if (empty($relName)) {
                    continue;
                }
                if (!empty($currentBean->field_name_map[$relName]['vname'])) {
                    $moduleLabel = trim(translate($currentBean->field_name_map[$relName]['vname'], $currentBean->module_dir), ':');
                }
                $thisModule = getRelatedModule($currentBean->module_dir, $relName);
                $currentBean = BeanFactory::getBean($thisModule);

                if (!empty($moduleLabel)) {
                    $modulePathDisplay[] = $moduleLabel;
                } else {
                    $modulePathDisplay[] = $currentBean->module_name;
                }
            }

            $currentBeanFieldNamMapVName = null;
            if (!isset($currentBean->field_name_map[$field]['vname'])) {
                if (!isset($currentBean->field_name_map[$field])) {
                    if (!isset($field)) {
                        LoggerManager::getLogger()->warn('editview: current bean field map index is not set');
                    } else {
                        LoggerManager::getLogger()->warn('editview: current bean field map is not set at index: ' . $field);
                    }
                } else {
                    LoggerManager::getLogger()->warn('editview: current bean field map index error');
                }
            } else {
                $currentBeanFieldNamMapVName = $currentBean->field_name_map[$field]['vname'];
            }

            $fieldDisplay = $currentBeanFieldNamMapVName;
            $fieldDisplay = translate($fieldDisplay, $currentBean->module_dir);
            $fieldDisplay = trim($fieldDisplay, ':');
            foreach ($modulePathDisplay as &$module) {
                $module = isset($app_list_strings['aor_moduleList'][$module]) ? $app_list_strings['aor_moduleList'][$module] : (
                        isset($app_list_strings['moduleList'][$module]) ? $app_list_strings['moduleList'][$module] : $module
                        );
            }
        }
        return array('field' => $fieldDisplay, 'module' => str_replace(' ', '&nbsp;', implode(' : ', $modulePathDisplay)));
    }
}
