<?php
/**
 * Advanced OpenWorkflow, Automating SugarCRM.
 * @package Advanced OpenWorkflow for SugarCRM
 * @copyright SalesAgility Ltd http://www.salesagility.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * @author SalesAgility <info@salesagility.com>
 */



class AOW_Condition extends Basic {
	var $new_schema = true;
	var $module_dir = 'AOW_Conditions';
	var $object_name = 'AOW_Condition';
	var $table_name = 'aow_conditions';
	var $importable = false;
	var $disable_row_level_security = true ;
	
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
	var $aow_workflow_id;
	var $condition_order;
    var $module_path;
	var $field;
	var $operator;
	var $value;
	var $condition_operator;
	
	function AOW_Condition(){
		parent::Basic();
	}
	
	function bean_implements($interface){
		return false;
	}

    function save_lines($post_data, $parent, $key = ''){

        require_once('modules/AOW_WorkFlow/aow_utils.php');

        $line_count = count($post_data[$key.'field']);
        $j = 0;
        for ($i = 0; $i < $line_count; ++$i) {

            if($post_data[$key.'deleted'][$i] == 1){
                $this->mark_deleted($post_data[$key.'id'][$i]);
            } else {
                $condition = new AOW_Condition();
                foreach($this->field_defs as $field_def) {
                    if(isset($post_data[$key.$field_def['name']][$i])){
                        if(is_array($post_data[$key.$field_def['name']][$i])){
                            if($field_def['name'] == 'module_path'){
                                $post_data[$key.$field_def['name']][$i] = base64_encode(serialize($post_data[$key.$field_def['name']][$i]));
                            }else {
                                switch($condition->value_type) {
                                    case 'Date':
                                        $post_data[$key.$field_def['name']][$i] = base64_encode(serialize($post_data[$key.$field_def['name']][$i]));
                                    default:
                                        $post_data[$key.$field_def['name']][$i] = encodeMultienumValue($post_data[$key.$field_def['name']][$i]);
                                }
                            }
                        } else if($field_def['name'] === 'value' && $post_data[$key.'value_type'][$i] === 'Value') {
                            $post_data[$key.$field_def['name']][$i] = fixUpFormatting($_REQUEST['flow_module'], $condition->field, $post_data[$key.$field_def['name']][$i]);
                        }
                        $condition->$field_def['name'] = $post_data[$key.$field_def['name']][$i];
                    }

                }
                if(trim($condition->field) != ''){
                    $condition->condition_order = ++$j;
                    $condition->assigned_user_id = $parent->assigned_user_id;
                    $condition->aow_workflow_id = $parent->id;
                    $condition->save();
                }
            }
        }
    }


}
?>
