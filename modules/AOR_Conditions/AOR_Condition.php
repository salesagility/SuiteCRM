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
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
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
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */
class AOR_Condition extends Basic
{
    var $new_schema = true;
    var $module_dir = 'AOR_Conditions';
    var $object_name = 'AOR_Condition';
    var $table_name = 'aor_conditions';
    var $tracker_visibility = false;
    var $importable = true;
    var $disable_row_level_security = true;

    var $id;
    var $name;
    var $date_entered;
    var $date_modified;
    var $modified_user_id;
    var $modified_by_name;
    var $created_by;
    var $created_by_name;
    var $description;
    var $deleted;
    var $created_by_link;
    var $modified_user_link;
    var $aor_report_id;
    var $condition_order;
    var $field;
    var $logic_op;
    var $parenthesis;
    var $operator;
    var $value;
    var $value_type;

    function __construct()
    {
        parent::__construct();
    }

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function AOR_Condition(){
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if(isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        }
        else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }


    function save_lines($post_data, $parent, $key = '')
    {

        require_once('modules/AOW_WorkFlow/aow_utils.php');

        $j = 0;
        if(!isset($post_data[$key . 'field']) || !is_array($post_data[$key . 'field'])){
            return;
        }
        foreach ($post_data[$key . 'field'] as $i => $field) {

            if (isset($post_data[$key . 'deleted'][$i]) && $post_data[$key . 'deleted'][$i] == 1) {
                $this->mark_deleted($post_data[$key . 'id'][$i]);
            } else {
                $condition = new AOR_Condition();
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
                        } else if ($field_name == 'value' && $post_data[$key . 'value_type'][$i] === 'Value') {
                            $post_data[$key . $field_name][$i] = fixUpFormatting($_REQUEST['report_module'], $condition->field, $post_data[$key . $field_name][$i]);
                        } else if ($field_name == 'parameter') {
                            $post_data[$key . $field_name][$i] = isset($post_data[$key . $field_name][$i]);
                        } else if ($field_name == 'module_path') {
                            $post_data[$key . $field_name][$i] = base64_encode(serialize(explode(":", $post_data[$key . $field_name][$i])));
                        }
                        if ($field_name == 'parenthesis' && $post_data[$key . $field_name][$i] == 'END') {
                            if (!isset($lastParenthesisStartConditionId)) {
                                throw new Exception('a closure parenthesis has no starter pair');
                            }
                            $condition->parenthesis = $lastParenthesisStartConditionId;
                        } else {
                            $condition->$field_name = $post_data[$key . $field_name][$i];
                        }
                    } else if ($field_name == 'parameter') {
                        $condition->$field_name = 0;
                    }

                }
                // Period must be saved as a string instead of a base64 encoded datetime.
                // Overwriting value
                if ((!isset($condition->parenthesis) || !$condition->parenthesis) && isset($condition->value_type) && $condition->value_type == 'Period') {
                    $condition->value = base64_encode($_POST['aor_conditions_value'][$i]);
                }
                if (trim($condition->field) != '' || $condition->parenthesis) {
                    if (isset($_POST['aor_conditions_order'][$i])) {
                        $condition->condition_order = (int)$_POST['aor_conditions_order'][$i];
                    } else {
                        $condition->condition_order = ++$j;
                    }
                    $condition->aor_report_id = $parent->id;
                    $conditionId = $condition->save();
                    if ($condition->parenthesis == 'START') {
                        $lastParenthesisStartConditionId = $conditionId;
                    }
                }
            }
        }
    }

}