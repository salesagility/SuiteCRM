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

class SharedSecurityRulesConditions extends Basic
{
    /**
     *
     * @var boolean
     */
    public $new_schema = true;
    
    /**
     *
     * @var string 
     */
    public $module_dir = 'SharedSecurityRulesConditions';
    
    /**
     *
     * @var string 
     */
    public $object_name = 'SharedSecurityRulesConditions';
    
    /**
     *
     * @var string 
     */
    public $table_name = 'sharedsecurityrulesconditions';
    
    /**
     *
     * @var boolean 
     */
    public $importable = false;
    

    /**
     *
     * @var string 
     */
    public $logic_op;
    
    /**
     *
     * @var string 
     */
    public $parenthesis;
    
    /**
     *
     * @var string
     */
    public $assigned_user_name;
    
    /**
     *
     * @var mixed 
     */
    public $assigned_user_link;
    
    /**
     *
     * @var mixed 
     */
    public $SecurityGroups;
    
    /**
     *
     * @var string
     */
    public $value_type;
    
    /**
     *
     * @var string|array 
     */
    public $module_path;
    
    /**
     *
     * @var string
     */
    public $field;

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
     * @throws Exception
     */
    public function save_lines($post_data, SugarBean $parent, $key = '')
    {
        $request = $_REQUEST;
        $post = $_POST;
        
        require_once('modules/AOW_WorkFlow/aow_utils.php');

        $j = 0;
        $lastParenthesisStartConditionIdArray = array();
        if (isset($post_data[$key . 'field']) && !empty($post_data[$key . 'field'])) {
            $postDataKeyFieldKeys = array_keys($post_data[$key . 'field']);
            foreach ($postDataKeyFieldKeys as $i) {
                if ($post_data[$key . 'deleted'][$i] == 1) {
                    $this->mark_deleted($post_data[$key . 'id'][$i]);
                } else {
                    $condition = new SharedSecurityRulesConditions();


                    foreach ($this->field_defs as $field_def) {
                        $field_name = $field_def['name'];
                        if (isset($post_data[$key . $field_name][$i])) {
                            if (is_array($post_data[$key . $field_name][$i])) {
                                switch ($condition->value_type) {
                                    case 'Date':
                                        $post_data[$key . $field_name][$i] = base64_encode(serialize($post_data[$key . $field_name][$i]));
                                        break;
                                    default:
                                        $post_data[$key . $field_name][$i] = encodeMultienumValue($post_data[$key . $field_name][$i]);
                                }
                            } else {
                                if ($field_name == 'value' && $post_data[$key . 'value_type'][$i] === 'Value') {
                                    $post_data[$key . $field_name][$i] = fixUpFormatting(
                                            $request['flow_module'], $condition->field, $post_data[$key . $field_name][$i]
                                    );
                                } else {
                                    if ($field_name == 'parameter') {
                                        $post_data[$key . $field_name][$i] = isset($post_data[$key . $field_name][$i]);
                                    } else {
                                        if ($field_name == 'module_path') {
                                            if ($parent->fetched_row['flow_module'] !== $post_data['flow_module']) {
                                                $post_data[$key . $field_name][$i] = base64_encode(
                                                        serialize(explode(":", $post_data[$key . $field_name][$i]))
                                                );
                                            }
                                        }
                                    }
                                }
                            }
                            if ($field_name == 'parenthesis' && $post_data[$key . $field_name][$i] == 'END') {
                                if (empty($lastParenthesisStartConditionIdArray)) {
                                    throw new Exception('a closure parenthesis has no starter pair');
                                }

                                $condition->parenthesis = array_pop($lastParenthesisStartConditionIdArray);
                            } else {
                                $condition->$field_name = $post_data[$key . $field_name][$i];
                            }
                        } else {
                            if ($field_name == 'parameter') {
                                $condition->$field_name = 0;
                            }
                        }
                    }
                    // Period must be saved as a string instead of a base64 encoded datetime.
                    // Overwriting value
                    if ((!isset($condition->parenthesis) || !$condition->parenthesis) &&
                            isset($condition->value_type) &&
                            $condition->value_type == 'Period') {
                        $condition->value = base64_encode($post['aor_conditions_value'][$i]);
                    }
                    if (trim($condition->field) != '' || $condition->parenthesis) {
                        if (isset($post['aor_conditions_order'][$i])) {
                            $condition->condition_order = (int) $post['aor_conditions_order'][$i];
                        } else {
                            $condition->condition_order = ++$j;
                        }
                        $condition->sa_shared_sec_rules_id = $parent->id;

                        // Set first condition logic operator to be null on the rule (first condition does not require a logic operator)

                        $conditionId = $condition->save();



                        if ($condition->parenthesis == 'START') {
                            array_push($lastParenthesisStartConditionIdArray, $conditionId);
                        }
                    }
                }
            }
        }
        
        return $lastParenthesisStartConditionIdArray;
    }
    
    public function save($check_notify = false) {
        if (is_array($this->module_path)) {
            $this->module_path = implode(':', $this->module_path);
        }
        return parent::save($check_notify);
    }
    
}
