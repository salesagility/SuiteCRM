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



class AOW_Action extends Basic {
	var $new_schema = true;
	var $module_dir = 'AOW_Actions';
	var $object_name = 'AOW_Action';
	var $table_name = 'aow_actions';
	var $tracker_visibility = false;
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
	var $action_order;
	var $action;
	var $parameters;
	
	function AOW_Action(){	
		parent::Basic();
	}

    function save_lines($post_data, $parent, $key = ''){

        $line_count = count($post_data[$key.'action']);
        $j = 0;
        for ($i = 0; $i < $line_count; ++$i) {

            if($post_data[$key.'deleted'][$i] == 1){
                $this->mark_deleted($post_data[$key.'id'][$i]);
            } else {
                $action = new AOW_Action();
                foreach($this->field_defs as $field_def) {
                    if(isset($post_data[$key.$field_def['name']][$i])){
                        $action->$field_def['name'] = $post_data[$key.$field_def['name']][$i];
                    }
                }
                $params = array();
                foreach($post_data[$key.'param'][$i] as $param_name => $param_value){
                    if($param_name == 'value'){
                        foreach($param_value as $p_id => $p_value){
                            if($post_data[$key.'param'][$i]['value_type'][$p_id] == 'Value' && is_array($p_value)) $param_value[$p_id] = encodeMultienumValue($p_value);
                        }
                    }
                    $params[$param_name] = $param_value;
                }
                $action->parameters = base64_encode(serialize($params));
                if(trim($action->action) != ''){
                    $action->action_order = ++$j;
                    $action->assigned_user_id = $parent->assigned_user_id;
                    $action->aow_workflow_id = $parent->id;
                    $action->save();
                }
            }
        }
    }
	
	function bean_implements($interface){
		return false;
	}
		
}
?>
