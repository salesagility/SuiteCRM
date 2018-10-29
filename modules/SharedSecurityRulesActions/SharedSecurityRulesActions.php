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

class SharedSecurityRulesActions extends Basic
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
    public $module_dir = 'SharedSecurityRulesActions';
    
    /**
     *
     * @var string
     */
    public $object_name = 'SharedSecurityRulesActions';
    
    /**
     *
     * @var string
     */
    public $table_name = 'sharedsecurityrulesactions';
    
    /**
     *
     * @var bool
     */
    public $importable = false;
    
    /**
     *
     * @var string
     */
    public $id;
    
    /**
     *
     * @var string 
     */
    public $name;
    
    /**
     *
     * @var string 
     */
    public $date_entered;
    
    /**
     *
     * @var string 
     */
    public $date_modified;
    
    /**
     *
     * @var string 
     */
    public $modified_user_id;
    
    /**
     *
     * @var string 
     */
    public $modified_by_name;
    
    /**
     *
     * @var string 
     */
    public $created_by;
    
    /**
     *
     * @var string 
     */
    public $created_by_name;
    
    /**
     *
     * @var string 
     */
    public $description;
    
    /**
     *
     * @var bool 
     */
    public $deleted;
    
    /**
     *
     * @var string 
     */
    public $created_by_link;
    
    /**
     *
     * @var string 
     */
    public $modified_user_link;
    
    /**
     *
     * @var string 
     */
    public $assigned_user_id;
    
    /**
     *
     * @var string 
     */
    public $assigned_user_name;
    
    /**
     *
     * @var type 
     */
    public $assigned_user_link;
    
    /**
     *
     * @var mixed 
     */
    public $SecurityGroups;

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
     * @param array $post_data
     * @param SugarBean $parent
     * @param string $key
     * @return string
     */
    public function save_lines($post_data, $parent, $key = '')
    {
        $ret = null;
        
        $postDataKeyAction = null;
        if (!isset($post_data[$key . 'action'])) {
            LoggerManager::getLogger()->warn('key action needed for saving lines');
        } else {
            $postDataKeyAction = $post_data[$key . 'action'];
        }

        // THIS IS WHERE THE ISSUE IS - should be shared_rules_actions_action (but do i change that in the call to this save lines function or in here
        // need to look at the other post data calls in here
        $line_count = count((array)$postDataKeyAction);
        $j = 0;
        for ($i = 0; $i < $line_count; ++$i) {
            if ($post_data[$key . 'deleted'][$i] == 1) {
                $this->mark_deleted($post_data[$key . 'id'][$i]);
            } else {
                $action = new SharedSecurityRulesActions();
                foreach ($this->field_defs as $field_def) {
                    $field_name = $field_def['name'];
                    if (isset($post_data[$key . $field_name][$i])) {
                        $action->$field_name = $post_data[$key . $field_name][$i];
                    }
                }
                $params = array();
                foreach ($post_data[$key . 'param'][$i] as $param_name => $param_value) {
                    if ($param_name == 'value') {
                        foreach ($param_value as $p_id => $p_value) {
                            if ($post_data[$key . 'param'][$i]['value_type'][$p_id] == 'Value' && is_array($p_value)) {
                                $param_value[$p_id] = encodeMultienumValue($p_value);
                            }
                        }
                    }
                    $params[$param_name] = $param_value;
                }
                $action->parameters = base64_encode(serialize($params));
                if (trim($action->action) != '') {
                    $action->action_order = ++$j;
                    $action->sa_shared_security_rules_id = $parent->id;
                    $ret = $action->save();
                }
            }
        }
        return $ret;
    }
}
