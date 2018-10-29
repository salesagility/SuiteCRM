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

include_once __DIR__ . '/SharedSecurityRulesHelper.php';

require_once("modules/AOW_WorkFlow/aow_utils.php");

class SharedSecurityRulesController extends SugarController
{
    /**
     *
     * @param array $request
     * @return array
     */
    protected function getRequestFields($request)
    {
        $requestModuleType = $this->getRequestVar($request, 'moduletype');
        if (!$requestModuleType) {
            LoggerManager::getLogger()->warn('moduletype is not defined in request for SharedSecurityRulesController::getRequestFields()');
            $fields = [];
        } else {
            $bean = BeanFactory::getBean($requestModuleType);
            $matrix = new SharedSecurityRules();
            $fields = $matrix->getFieldDefs($bean->field_defs, $requestModuleType);
        }
        asort($fields);
        return $fields;
    }
    
    /**
     *
     * @return null
     */
    public function action_fielddefs()
    {
        $request = $_REQUEST;
        $fields = $this->getRequestFields($request);
        echo get_select_options_with_id($fields, "");
        return $this->protectedDie();
    }
    
    /**
     *
     * @param array $request
     * @param string $key
     * @return mixed
     */
    protected function getRequestVar($request, $key, $default = null)
    {
        if (!isset($request[$key])) {
            LoggerManager::getLogger()->warn('Requested key for Share Security Rules controller is not set: ' . $key);
            return $default;
        }
        return $request[$key];
    }

    /**
     *
     * @param SharedSecurityRulesActions $aow_action
     * @return array
     */
    protected function getAOWActionParameters(SharedSecurityRulesActions $aow_action)
    {
        $aowActionParameters = null;
        if (!isset($aow_action->parameters)) {
            LoggerManager::getLogger()->warn('Shared Security Rules controller needs an aow_action parameter');
        } else {
            $aowActionParameters = $aow_action->parameters;
        }
        return $aowActionParameters;
    }
    
    /**
     *
     * @param array $request
     * @return array
     */
    protected function getParams($request)
    {
        $id = '';
        $requestId = $this->getRequestVar($request, 'id');
        $params = array();
        if ($requestId) {
            require_once('modules/AOW_Actions/AOW_Action.php');
            $aow_action = new SharedSecurityRulesActions();
            $aow_action->retrieve($requestId);
            $id = $aow_action->id;
            
            $aowActionParameters = $this->getAOWActionParameters($aow_action);
            
            $helper = new SharedSecurityRulesHelper($aow_action->db);
            $params = $helper->unserializeIfSerialized($aowActionParameters);
        }
        return $params;
    }
    
    /**
     *
     * @global array $beanList
     * @global array $beanFiles
     * @return null
     */
    protected function action_getAction()
    {
        global $beanList, $beanFiles;
        $request = $_REQUEST;
        
        $requestAOWAction = $this->getRequestVar($request, 'aow_action');
        $requestLine = $this->getRequestVar($request, 'line');

        $action_name = 'action' . $requestAOWAction;
        $line = $requestLine;
        
        
        $requestAOWModule = $this->getRequestVar($request, 'aow_module');

        if ($requestAOWModule == '' || !isset($beanList[$requestAOWModule])) {
            echo '';
            return $this->protectedDie();
        }

        if (file_exists('custom/modules/SharedSecurityRulesActions/actions/' . $action_name . '.php')) {
            require_once('custom/modules/SharedSecurityRulesActions/actions/' . $action_name . '.php');
        } elseif (file_exists('modules/SharedSecurityRulesActions/actions/' . $action_name . '.php')) {
            require_once('modules/SharedSecurityRulesActions/actions/' . $action_name . '.php');
        } else {
            echo '';
            return $this->protectedDie();
        }

        $custom_action_name = "custom" . $action_name;
        if (class_exists($custom_action_name)) {
            $action_name = $custom_action_name;
        }

        $params = $this->getParams($request);

        $action = new $action_name($id);

        require_once($beanFiles[$beanList[$requestAOWModule]]);
        $bean = new $beanList[$requestAOWModule];
        echo $action->edit_display($line, $bean, $params);
        return $this->protectedDie();
    }

    /**
     *
     * @return null
     */
    protected function action_getModuleFieldType()
    {
        $request = $_REQUEST;
        
        $requestAOWModule = $this->getRequestVar($request, 'aow_module');
        $requestAOWFieldname = $this->getRequestVar($request, 'aow_fieldname');
        $requestAOWNewFieldname = $this->getRequestVar($request, 'aow_newfieldname');
        $rel_module = $this->getModuleByRequest($request, $requestAOWModule);
        $module = $requestAOWModule;
        $fieldname = $requestAOWFieldname;
        $aow_field = $requestAOWNewFieldname;
        $view = $this->getRequestVar($request, 'view', 'EditView');
        $value = $this->getRequestVar($request, 'aow_value', '');
        $requestAOWType = $this->getRequestVar($request, 'aow_type');

        switch ($requestAOWType) {
            case 'Field':
                $altModule = $this->getRequestVar($beanFiles, 'alt_module');
                if ($altModule) {
                    $module = $altModule;
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
        return $this->protectedDie();
    }

    /**
     *
     * @param array $request
     * @param string $requestAOWModule
     * @return string
     */
    protected function getModuleByRequest($request, $requestAOWModule)
    {
        $relFiled = $this->getRequestVar($request, 'rel_field');
        $module = $relFiled ?
            getRelatedModule($requestAOWModule, $relFiled) :
            $requestAOWModule;
        return $module;
    }
    
    /**
     *
     * @param array $vardef
     * @return array
     */
    protected function getValidOpp($vardef)
    {
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
        return $valid_opp;
    }
    
    /**
     *
     * @param array $app_list_strings
     * @param array $valid_opp
     * @return array
     */
    protected function updateAppListStrings($app_list_strings, $valid_opp)
    {
        if (!file_exists('modules/SecurityGroups/SecurityGroup.php')) {
            unset($app_list_strings['aow_condition_type_list']['SecurityGroup']);
        }
        $keys = array_keys($app_list_strings['aow_condition_type_list']);
        foreach ($keys as $key) {
            if (!in_array($key, $valid_opp)) {
                unset($app_list_strings['aow_condition_type_list'][$key]);
            }
        }
        return $app_list_strings;
    }

    /**
     *
     * @global array $app_list_strings
     * @global array $beanFiles
     * @global array $beanList
     * @return null
     */
    protected function action_getFieldTypeOptions()
    {
        global $app_list_strings, $beanFiles, $beanList;
        $request = $_REQUEST;
        
        $requestAOWModule = $this->getRequestVar($request, 'aow_module');
        $requestAOWFieldname = $this->getRequestVar($request, 'aow_fieldname');
        $requestAOWNewFieldname = $this->getRequestVar($request, 'aow_newfieldname');
        $module = $this->getModuleByRequest($request, $requestAOWModule);
        
        $fieldname = $requestAOWFieldname;
        $aow_field = $requestAOWNewFieldname;

        $view = $this->getRequestVar($request, 'view', 'EditView');
        $value = $this->getRequestVar($request, 'aow_value', '');
        
        if (!isset($beanList[$module]) || !isset($beanFiles[$beanList[$module]])) {
            LoggerManager::getLogger()->warn('bean file not set in bean list for module: ' . $module . ' in SharedSecurityRulesController::action_getFieldTypeOptions()');
            return $this->protectedDie();
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

        $valid_opp = $this->getValidOpp($vardef);

        $app_list_strings = $this->updateAppListStrings($app_list_strings, $valid_opp);

        if ($view == 'EditView') {
            echo "<select type='text'  name='$aow_field' id='$aow_field' title='' tabindex='116'>" . get_select_options_with_id($app_list_strings['aow_condition_type_list'], $value) . "</select>";
        } else {
            echo $app_list_strings['aow_condition_type_list'][$value];
        }
        return $this->protectedDie();
    }
    
    /**
     *
     * @param array $vardef
     * @return array
     */
    protected function getValidOppForModuleOpField($vardef)
    {
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
        return $valid_opp;
    }
    
    /**
     *
     * @param array $app_list_strings
     * @param array $valid_opp
     * @return array
     */
    protected function updateAppListStringsAOROpList($app_list_strings, $valid_opp)
    {
        $keys = array_keys($app_list_strings['aor_operator_list']);
        foreach ($keys as $key) {
            if (!in_array($key, $valid_opp)) {
                unset($app_list_strings['aor_operator_list'][$key]);
            }
        }
        return $app_list_strings;
    }
    
    /**
     *
     * @param array $request
     * @return string
     */
    protected function getOnChange($request)
    {
        $onchange = "";
        
        $m = $this->getRequestVar($request, 'm');
        
        if ($m != "aomr") {
            $onchange = "UpdatePreview(\"preview\");";
        }
        return $onchange;
    }
    
    /**
     *
     * @global array $app_list_strings
     * @global array $beanFiles
     * @global array $beanList
     * @return null
     */
    protected function action_getModuleOperatorField()
    {
        global $app_list_strings, $beanFiles, $beanList;
        $request = $_REQUEST;
        
        $requestedAORModule = $this->getRequestVar($request, 'aor_module');
        $module = $this->getModuleByRequest($request, $requestedAORModule);
        $requestAorFieldName = $this->getRequestVar($request, 'aor_fieldname');
        
        $fieldname = $requestAorFieldName;
        
        $requestAorNewFieldName = $this->getRequestVar($request, 'aor_newfieldname');
        
        $aor_field = $requestAorNewFieldName;

        $view = $this->getRequestVar($request, 'view', 'EditView');
        $value = $this->getRequestVar($request, 'aor_value', '');

        if (!isset($module) || !isset($beanList[$module]) && !isset($beanFiles[$beanList[$module]])) {
            LoggerManager::getLogger()->error('Bean module is not defined in beanlist');
            return $this->protectedDie();
        }
                
        if (!file_exists($beanFiles[$beanList[$module]])) {
            LoggerManager::getLogger()->error('Bean file not found: ' . $beanFiles[$beanList[$module]]);
            return $this->protectedDie();
        }
        
        require_once($beanFiles[$beanList[$module]]);
        $focus = new $beanList[$module];
        $vardef = $focus->getFieldDefinition($fieldname);

        $valid_opp = $this->getValidOppForModuleOpField($vardef);

        $app_list_strings = $this->updateAppListStringsAOROpList($app_list_strings, $valid_opp);

        $onchange = $this->getOnChange($request);
        
        if ($view == 'EditView') {
            echo "<select type='text' style='width:178px;' name='{$aor_field}' id='{$aor_field}' title=''
            onchange='{$onchange}' tabindex='116'>"
            . get_select_options_with_id($app_list_strings['aor_operator_list'], $value) . "</select>";
        } else {
            echo $app_list_strings['aor_operator_list'][$value];
        }
        return $this->protectedDie();
    }
    
    /**
     *
     */
    protected function protectedDie()
    {
        die();
    }
}
