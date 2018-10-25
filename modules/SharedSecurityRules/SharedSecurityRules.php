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
include_once __DIR__ . '/SharedSecurityRulesChecker.php';
include_once __DIR__ . '/SharedSecurityRulesWhereBuilder.php';

class SharedSecurityRules extends Basic
{

    /**
     *
     * @var bool
     */
    public $new_schema = true;

    /**
     *
     * @var string
     */
    public $module_dir = 'SharedSecurityRules';

    /**
     *
     * @var string
     */
    public $object_name = 'SharedSecurityRules';

    /**
     *
     * @var string
     */
    public $table_name = 'sharedsecurityrules';

    /**
     *
     * @var bool
     */
    public $importable = false;

    /**
     *
     * @param boolean $init
     */
    public function __construct($init = true)
    {
        parent::__construct();
        if ($init) {
            $this->load_flow_beans();
        }
    }

    /**
     *
     * @param string $interface
     * @return boolean
     */
    public function bean_implements($interface)
    {
        switch ($interface) {
            case 'ACL':
                return true;
        }

        return false;
    }

    /**
     *
     * @global array $beanList
     * @global array $app_list_strings
     */
    public function load_flow_beans()
    {
        global $beanList, $app_list_strings;

        $app_list_strings['sa_moduleList'] = $app_list_strings['moduleList'];

        if (!empty($app_list_strings['sa_moduleList'])) {
            $saModuleListKeys = array_keys($app_list_strings['sa_moduleList']);
            foreach ($saModuleListKeys as $mkey) {
                if (!isset($beanList[$mkey]) || str_begin($mkey, 'AOW_')) {
                    unset($app_list_strings['sa_moduleList'][$mkey]);
                }
            }
        }

        $app_list_strings['sa_moduleList'] = array_merge(array('' => ''), (array) $app_list_strings['sa_moduleList']);

        asort($app_list_strings['sa_moduleList']);
    }

    /**
     *
     * @param boolean $check_notify
     */
    public function save($check_notify = false)
    {
        if (empty($this->id)) {
            unset($_POST['aow_conditions_id']);
            unset($_POST['aow_actions_id']);
        }

        $returnId = parent::save($check_notify);
        
        $helper = new SharedSecurityRulesHelper($this->db);
        $post = $helper->quote($_POST);

        require_once('modules/SharedSecurityRulesConditions/SharedSecurityRulesConditions.php');
        $condition = new SharedSecurityRulesConditions();
        $condition->save_lines($post, $this, 'aor_conditions_');

        require_once('modules/SharedSecurityRulesActions/SharedSecurityRulesActions.php');
        $action = new SharedSecurityRulesActions();
        $action->save_lines($post, $this, 'shared_rules_actions_');
        
        return $returnId;
    }

    /**
     * @param SugarBean $module
     * @param string $view
     *
     * @return bool
     */
    public function checkRules(SugarBean &$module, $view)
    {
        global $current_user;
        
        $checker = new SharedSecurityRulesChecker($this->db);

        LoggerManager::getLogger()->info('SharedSecurityRules: In checkRules for module: ' . $module->name . ' and view: ' . $view);

        $moduleBean = $checker->getModuleBean($module);
        $result = $checker->getResult($module, $moduleBean, $current_user->id, $view);
        return $result;
    }

    /**
     *
     * @global array $current_user
     * @global Database $db
     * @param SugarBean $module
     * @return array
     */
    public static function buildRuleWhere(SugarBean $module)
    {
        global $current_user;
        $builder = new SharedSecurityRulesWhereBuilder();
        $whereArray = $builder->getWhereArray($module, $current_user->id);
        return $whereArray;
    }

    /**
     *
     * @param string $operator
     * @param string $value
     * @param boolean $reverse
     * @return boolean|string
     */
    public function changeOperator($operator, $value, $reverse)
    {
        switch ($operator) {
            case "Equal_To":
                if ($reverse) {
                    return " != '" . $value . "' ";
                }
                return " = '" . $value . "' ";
            case "Not_Equal_To":
                if ($reverse) {
                    return " = '" . $value . "' ";
                }
                return " != '" . $value . "' ";
            case "Starts_With":
                if ($reverse) {
                    return " NOT LIKE '" . $value . "%'";
                }
                return " LIKE '" . $value . "%'";
            case "Ends_With":
                if ($reverse) {
                    return " NOT LIKE '%" . $value . "'";
                }
                return " LIKE '%" . $value . "'";
            case "Contains":
                if ($reverse) {
                    return " NOT LIKE '%" . $value . "%' ";
                }
                return " LIKE '%" . $value . "%'";
            case "is_null":
                if ($reverse) {
                    return " IS NOT NULL ";
                }
                return " IS NULL ";
        }

        return false;
    }

    /**
     *
     * @param array $fieldDefs
     * @param string $module
     * @return array
     */
    public function getFieldDefs($fieldDefs, $module)
    {
        if ($module == null) {
            return array();
        }
        $defs[''] = "";
        foreach ($fieldDefs as $field) {
            $label = translate($field['vname'], $module);
            if (in_array($field['type'], $this->exemptFields) || in_array($field['dbType'], $this->exemptFields)) {
                continue;
            }
            if (empty($label)) {
                $label = $field['name'];
            }
            if (($module == "Leads" || $module == "Contacts") && ($field['name'] == "full_name" || $field['name'] == "name")) {
                continue;
            }

            $defs[$field['name']] = $label;
        }

        asort($defs);
        return $defs;
    }
}
