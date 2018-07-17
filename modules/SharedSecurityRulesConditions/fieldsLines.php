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

/**
 * 
 * @global array $mod_strings
 * @global string $current_language
 * @param SugarBean $focus
 * @param string $field
 * @param mixed $value
 * @param string $view
 * @return string
 */
function display_condition_lines(SugarBean $focus, $field, $value, $view)
{
    global $mod_strings, $current_language;

    if ($field) {
        LoggerManager::getLogger()->warn('Field does not effect for display condition lines: ' . $field);
    }
    
    if ($value) {
        LoggerManager::getLogger()->warn('Value does not effect for display condition lines: ' . $value);
    }
    
    $html = '';

    if (!is_file('cache/jsLanguage/SharedSecurityRulesConditions/' . $current_language . '.js')) {
        require_once('include/language/jsLanguage.php');
        jsLanguage::createModuleStringsCache('SharedSecurityRulesConditions', $current_language);
    }
    $html .= '<script src="cache/jsLanguage/SharedSecurityRulesConditions/' . $current_language . '.js"></script>';

    if ($view == 'EditView') {
        $html .= '<script src="modules/SharedSecurityRulesConditions/conditionLines.js"></script>';
        $html .= "<script>conditionOperator = \"" . trim(preg_replace('/\s+/', ' ', get_select_options_with_id(array("AND" => "AND", "OR" => "OR"), "AND")))
                . "\";</script>";
        $html .= "<table border='0' cellspacing='4' width='100%' id='conditionLines'></table>";

        $html .= '<div class="tab-panels" style="width:100%">';
        $html .= '<div class="edit view edit508" id="detailpanel_conditions">';
        $html .= '<hr>';
        $html .= '<table>';
        $html .= '<tbody id="aor_condition_parenthesis_btn" class="connectedSortableConditions">';
        $html .= '<tr class="parentheses-btn"><td class="condition-sortable-handle">' . $mod_strings["LBL_ADD_PARENTHESIS"] . '</td></tr>';
        $html .= '</tbody>';
        $html .= '</table>';
        $html .= '</div>';
        $html .= '</div>';

        $html .= '<script src="modules/SharedSecurityRulesConditions/parenthesis.js"></script>';


        if (isset($focus->flow_module) && $focus->flow_module != '') {
            require_once("modules/AOW_WorkFlow/aow_utils.php");
            $html .= "<script>";
            $html .= "flow_rel_modules = \"" . trim(preg_replace('/\s+/', ' ', getModuleRelationships($focus->flow_module))) . "\";";
            $html .= "flow_module = \"" . $focus->flow_module . "\";";

            $html .= "document.getElementById('btn_ConditionLine').disabled = '';";
            if ($focus->id != '') {
                $sql = "SELECT id FROM sharedsecurityrulesconditions WHERE sa_shared_sec_rules_id = '" . $focus->id . "' AND deleted = 0 ORDER BY 
condition_order ASC";
                $result = $focus->db->query($sql);

                while ($row = $focus->db->fetchByAssoc($result)) {
                    $condition_name = new SharedSecurityRulesConditions();
                    $condition_name->retrieve($row['id']);
                    $condition_name->module_path = unserialize(base64_decode($condition_name->module_path));
                    if ($condition_name->module_path == '') {
                        $condition_name->module_path = $focus->flow_module;
                    }
                    $html .= "flow_fields = \"" . trim(preg_replace('/\s+/', ' ', getModuleFields(getRelatedModule($focus->flow_module, $condition_name->module_path[0])))) . "\";";
                    if ($condition_name->value_type == 'Date') {
                        $condition_name->value = unserialize(base64_decode($condition_name->value));
                    }
                    $condition_item = json_encode($condition_name->toArray());
                    $html .= "loadConditionLine(" . $condition_item . ");";
                }
            }
            $html .= "flow_fields = \"" . trim(preg_replace('/\s+/', ' ', getModuleFields($focus->flow_module))) . "\";";
            $html .= "</script>";
        }
    } elseif ($view == 'DetailView') {
        $html .= '<script src="modules/SharedSecurityRulesConditions/conditionLines.js"></script>';
        $html .= "<table border='0' cellspacing='0' width='100%' id='conditionLines'></table>";


        if (isset($focus->flow_module) && $focus->flow_module != '') {
            require_once("modules/AOW_WorkFlow/aow_utils.php");
            $html .= "<script>";
            $html .= "flow_rel_modules = \"" . trim(preg_replace('/\s+/', ' ', getModuleRelationships($focus->flow_module))) . "\";";
            $html .= "flow_module = \"" . $focus->flow_module . "\";";
            $sql = "SELECT id FROM sharedsecurityrulesconditions WHERE sa_shared_sec_rules_id = '" . $focus->id . "' AND deleted = 0 ORDER BY condition_order ASC";
            $result = $focus->db->query($sql);

            while ($row = $focus->db->fetchByAssoc($result)) {
                $condition_name = new SharedSecurityRulesConditions();
                $condition_name->retrieve($row['id']);

                $condition_name->module_path = unserialize(base64_decode($condition_name->module_path));
                if (empty($condition_name->module_path)) {
                    $condition_name->module_path[0] = $focus->flow_module;
                }

                $html .= "flow_fields = \"" . trim(preg_replace('/\s+/', ' ', getModuleFields(getRelatedModule($focus->flow_module, $condition_name->module_path[0])))) . "\";";
                $html .= "conditionOperator = \"" . trim(preg_replace('/\s+/', ' ', get_select_options_with_id(array("AND" => "AND", "OR" => "OR"), "AND")))
                        . "\";";
                if ($condition_name->value_type == 'Date') {
                    $condition_name->value = unserialize(base64_decode($condition_name->value));
                }


                $condition_name_array = $condition_name->toArray();

                // Get the rule for the condition
                $ruleBean = BeanFactory::getBean('SharedSecurityRules', $condition_name->sa_shared_sec_rules_id);



                if (!$condition_name->parenthesis) {
                    $display = getDisplayForField($condition_name->module_path, $condition_name->field, $ruleBean->flow_module);
                    $condition_name_array['module_path_display'] = $display['module'];
                    $condition_name_array['field_label'] = $display['field'];
                } elseif ($condition_name->parenthesis === "START") {
                    $condition_name_array['field'] = '(';
                    $condition_name_array['field_label'] = '(';
                } else {
                    $condition_name_array['field'] = ')';
                    $condition_name_array['field_label'] = ')';
                }

                $condition_name_array['logic_op'] = $condition_name->logic_op;
                $condition_item = json_encode($condition_name_array);
                $html .= "loadConditionLine(" . $condition_item . ");";
            }
            $html .= "</script>";
        }
    }
    return $html;
}
