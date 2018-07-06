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


require_once("modules/AOW_WorkFlow/aow_utils.php");

class SharedSecurityRulesController extends SugarController
{
    
    public function action_fielddefs()
    {
        $request = $_REQUEST;
        
        $bean = BeanFactory::getBean($request['moduletype']);
        $matrix = new SharedSecurityRules();
        $fields = $matrix->getFieldDefs($bean->field_defs, $request['moduletype']);
        asort($fields);
        echo get_select_options_with_id($fields, "");
        die();
    }

    protected function action_getAction()
    {
        global $beanList, $beanFiles;
        $request = $_REQUEST;

        $action_name = 'action' . $request['aow_action'];
        $line = $request['line'];

        if ($request['aow_module'] == '' || !isset($beanList[$request['aow_module']])) {
            echo '';
            die;
        }

        if (file_exists('custom/modules/SharedSecurityRulesActions/actions/' . $action_name . '.php')) {
            require_once('custom/modules/SharedSecurityRulesActions/actions/' . $action_name . '.php');
        } elseif (file_exists('modules/SharedSecurityRulesActions/actions/' . $action_name . '.php')) {
            require_once('modules/SharedSecurityRulesActions/actions/' . $action_name . '.php');
        } else {
            echo '';
            die;
        }

        $custom_action_name = "custom" . $action_name;
        if (class_exists($custom_action_name)) {
            $action_name = $custom_action_name;
        }

        $id = '';
        $params = array();
        if (isset($request['id'])) {
            require_once('modules/AOW_Actions/AOW_Action.php');
            $aow_action = new SharedSecurityRulesActions();
            $aow_action->retrieve($request['id']);
            $id = $aow_action->id;
            $params = unserialize(base64_decode($aow_action->parameters));
        }

        $action = new $action_name($id);

        require_once($beanFiles[$beanList[$request['aow_module']]]);
        $bean = new $beanList[$request['aow_module']];
        echo $action->edit_display($line, $bean, $params);
        die;
    }

    protected function action_getModuleFieldType()
    {
        $request = $_REQUEST;
                
        if (isset($request['rel_field']) && $request['rel_field'] != '') {
            $rel_module = getRelatedModule($request['aow_module'], $request['rel_field']);
        } else {
            $rel_module = $request['aow_module'];
        }
        $module = $request['aow_module'];
        $fieldname = $request['aow_fieldname'];
        $aow_field = $request['aow_newfieldname'];

        if (isset($request['view'])) {
            $view = $request['view'];
        } else {
            $view = 'EditView';
        }

        if (isset($request['aow_value'])) {
            $value = $request['aow_value'];
        } else {
            $value = '';
        }

        switch ($request['aow_type']) {
            case 'Field':
                if (isset($request['alt_module']) && $request['alt_module'] != '') {
                    $module = $request['alt_module'];
                }
                if ($view == 'EditView') {
                    echo "<select type='text'  name='$aow_field' id='$aow_field ' title='' tabindex='116'>" . getModuleFields($module, $view, $value, getValidFieldsTypes($module, $fieldname)) . "</select>";
                } else {
                    echo getModuleFields($module, $view, $value);
                }
                break;
            case 'Any_Change':
            case 'currentUser':
                echo '';
                break;
            case 'Date':
                echo getDateField($module, $aow_field, $view, $value, false);
                break;
            case 'Multi':
                echo getModuleField($rel_module, $fieldname, $aow_field, $view, $value, 'multienum');
                break;
            case 'SecurityGroup':
                $module = 'Accounts';
                $fieldname = 'SecurityGroups';
            case 'Value':
            default:
                echo getModuleField($rel_module, $fieldname, $aow_field, $view, $value);
                break;
        }
        die;
    }

    protected function action_getFieldTypeOptions()
    {
        global $app_list_strings, $beanFiles, $beanList;
        $request = $_REQUEST;

        if (isset($request['rel_field']) && $request['rel_field'] != '') {
            $module = getRelatedModule($request['aow_module'], $request['rel_field']);
        } else {
            $module = $request['aow_module'];
        }
        $fieldname = $request['aow_fieldname'];
        $aow_field = $request['aow_newfieldname'];

        if (isset($request['view'])) {
            $view = $request['view'];
        } else {
            $view = 'EditView';
        }

        if (isset($request['aow_value'])) {
            $value = $request['aow_value'];
        } else {
            $value = '';
        }


        require_once($beanFiles[$beanList[$module]]);
        $focus = new $beanList[$module];
        $vardef = $focus->getFieldDefinition($fieldname);

        // Usetting these as they are not required
        //unset($app_list_strings['aow_condition_type_list']['Field']);
        unset($app_list_strings['aow_condition_type_list']['Any_Change']);
        unset($app_list_strings['aow_condition_type_list']['SecurityGroup']);
        unset($app_list_strings['aow_condition_type_list']['Date']);
        unset($app_list_strings['aow_condition_type_list']['Multi']);


        switch ($vardef['type']) {
            case 'double':
            case 'decimal':
            case 'float':
            case 'currency':
                $valid_opp = array('Value', 'Field', 'Any_Change');
                break;
            case 'uint':
            case 'ulong':
            case 'long':
            case 'short':
            case 'tinyint':
            case 'int':
                $valid_opp = array('Value', 'Field', 'Any_Change');
                break;
            case 'date':
            case 'datetime':
            case 'datetimecombo':
                $valid_opp = array('Value', 'Field', 'Any_Change', 'Date');
                break;
            case 'enum':
            case 'dynamicenum':
            case 'multienum':
                $valid_opp = array('Value', 'Field', 'Any_Change', 'Multi');
                break;
            case 'relate':
            case 'id':
                $valid_opp = array('Value', 'Field', 'Any_Change', 'SecurityGroup', 'currentUser');
                break;
            default:
                $valid_opp = array('Value', 'Field', 'Any_Change');
                break;
        }

        if (!file_exists('modules/SecurityGroups/SecurityGroup.php')) {
            unset($app_list_strings['aow_condition_type_list']['SecurityGroup']);
        }
        foreach ($app_list_strings['aow_condition_type_list'] as $key => $keyValue) {
            if (!in_array($key, $valid_opp)) {
                unset($app_list_strings['aow_condition_type_list'][$key]);
            }
        }

        if ($view == 'EditView') {
            echo "<select type='text'  name='$aow_field' id='$aow_field' title='' tabindex='116'>" . get_select_options_with_id($app_list_strings['aow_condition_type_list'], $value) . "</select>";
        } else {
            echo $app_list_strings['aow_condition_type_list'][$value];
        }
        die;
    }

    protected function action_getModuleOperatorField()
    {
        global $app_list_strings, $beanFiles, $beanList;
        $request = $_REQUEST;

        if (isset($request['rel_field']) && $request['rel_field'] != '') {
            $module = getRelatedModule($request['aor_module'], $request['rel_field']);
        } else {
            $module = $request['aor_module'];
        }
        $fieldname = $request['aor_fieldname'];
        $aor_field = $request['aor_newfieldname'];

        if (isset($request['view'])) {
            $view = $request['view'];
        } else {
            $view = 'EditView';
        }

        if (isset($request['aor_value'])) {
            $value = $request['aor_value'];
        } else {
            $value = '';
        }


        require_once($beanFiles[$beanList[$module]]);
        $focus = new $beanList[$module];
        $vardef = $focus->getFieldDefinition($fieldname);

        switch ($vardef['type']) {
            case 'double':
            case 'decimal':
            case 'float':
            case 'currency':
                $valid_opp = array(
                    'Equal_To',
                    'Not_Equal_To',
                    'Greater_Than',
                    'Less_Than',
                    'Greater_Than_or_Equal_To',
                    'Less_Than_or_Equal_To'
                );
                break;
            case 'uint':
            case 'ulong':
            case 'long':
            case 'short':
            case 'tinyint':
            case 'int':
                $valid_opp = array(
                    'Equal_To',
                    'Not_Equal_To',
                    'Greater_Than',
                    'Less_Than',
                    'Greater_Than_or_Equal_To',
                    'Less_Than_or_Equal_To'
                );
                break;
            case 'date':
            case 'datetime':
            case 'datetimecombo':
                $valid_opp = array(
                    'Equal_To',
                    'Not_Equal_To',
                    'Greater_Than',
                    'Less_Than',
                    'Greater_Than_or_Equal_To',
                    'Less_Than_or_Equal_To'
                );
                break;
            case 'enum':
            case 'multienum':
                $valid_opp = array('Equal_To', 'Not_Equal_To');
                break;
            default:
                $valid_opp = array('Equal_To', 'Not_Equal_To', 'Contains', 'Not_Contains', 'Starts_With', 'Ends_With',);
                break;
        }

        foreach ($app_list_strings['aor_operator_list'] as $key => $keyValue) {
            if (!in_array($key, $valid_opp)) {
                unset($app_list_strings['aor_operator_list'][$key]);
            }
        }

        $onchange = "";
        if ($request['m'] != "aomr") {
            $onchange = "UpdatePreview(\"preview\");";
        }

        $app_list_strings['aor_operator_list'];
        if ($view == 'EditView') {
            echo "<select type='text' style='width:178px;' name='{$aor_field}' id='{$aor_field}' title='' 
            onchange='{$onchange}' tabindex='116'>"
            . get_select_options_with_id($app_list_strings['aor_operator_list'], $value) . "</select>";
        } else {
            echo $app_list_strings['aor_operator_list'][$value];
        }
        die;
    }
}
