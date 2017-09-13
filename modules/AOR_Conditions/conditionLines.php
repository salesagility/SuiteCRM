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

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

function display_condition_lines($focus, $field, $value, $view){

    global $locale, $app_list_strings, $mod_strings;

    $html = '';

    if (!is_file('cache/jsLanguage/AOR_Conditions/' . $GLOBALS['current_language'] . '.js')) {
        require_once ('include/language/jsLanguage.php');
        jsLanguage::createModuleStringsCache('AOR_Conditions', $GLOBALS['current_language']);
    }
    $html .= '<script src="cache/jsLanguage/AOR_Conditions/'. $GLOBALS['current_language'] . '.js"></script>';

    if($view == 'EditView'){

        $html .= '<script src="modules/AOR_Conditions/conditionLines.js"></script>';
        $html .= "<table border='0' cellspacing='4' width='100%' id='aor_conditionLines'></table>";

        $html .= "<div style='padding-top: 10px; padding-bottom:10px;'>";
        $html .= "<input type=\"button\" tabindex=\"116\" class=\"button\" value=\"".$mod_strings['LBL_ADD_CONDITION']."\" id=\"btn_ConditionLine\" onclick=\"insertConditionLine()\" disabled/>";
        $html .= "</div>";


        if(isset($focus->report_module) && $focus->report_module != ''){
            require_once("modules/AOW_WorkFlow/aow_utils.php");
            $html .= "<script>";
            $html .= "report_module = \"".$focus->report_module."\";";
            $html .= "document.getElementById('btn_ConditionLine').disabled = '';";
            if($focus->id != ''){
                $sql = "SELECT id FROM aor_conditions WHERE aor_report_id = '".$focus->id."' AND deleted = 0 ORDER BY condition_order ASC";
                $result = $focus->db->query($sql);

                while ($row = $focus->db->fetchByAssoc($result)) {
                    $condition_name = new AOR_Condition();
                    $condition_name->retrieve($row['id']);
                    $condition_name->module_path = unserialize(base64_decode($condition_name->module_path));
                    $html .= "report_fields = \"".trim(preg_replace('/\s+/', ' ', getModuleFields(getRelatedModule($focus->report_module,$condition_name->module_path[0]))))."\";";
                    if($condition_name->value_type == 'Date'){
                        $condition_name->value = unserialize(base64_decode($condition_name->value));
                    }
                    $condition_item = json_encode($condition_name->toArray());
                    $html .= "loadConditionLine(".$condition_item.");";
                }
            }
            $html .= "report_fields = \"".trim(preg_replace('/\s+/', ' ', getModuleFields($focus->report_module)))."\";";
            $html .= "</script>";
        }

    } else if($view == 'DetailView'){
        $html .= '<script src="modules/AOR_Conditions/conditionLines.js"></script>';
        $html .= "<table border='0' cellspacing='0' width='100%' id='aor_conditionLines'></table>";


        if(isset($focus->report_module) && $focus->report_module != ''){
            require_once("modules/AOW_WorkFlow/aow_utils.php");
            $html .= "<script>";
            $html .= "report_fields = \"".trim(preg_replace('/\s+/', ' ', getModuleFields($focus->report_module)))."\";";
            $html .= "report_module = \"".$focus->report_module."\";";
            $sql = "SELECT id FROM aor_conditions WHERE aor_report_id = '".$focus->id."' AND deleted = 0 ORDER BY condition_order ASC";
            $result = $focus->db->query($sql);

            while ($row = $focus->db->fetchByAssoc($result)) {
                $condition_name = new AOR_Condition();
                $condition_name->retrieve($row['id']);
                $condition_name->module_path = unserialize(base64_decode($condition_name->module_path));
                if($condition_name->value_type == 'Date'){
                    $condition_name->value = unserialize(base64_decode($condition_name->value));
                }
                $condition_item = json_encode($condition_name->toArray());
                $html .= "loadConditionLine(".$condition_item.");";
            }
            $html .= "</script>";
        }
    }
    return $html;
}

?>
