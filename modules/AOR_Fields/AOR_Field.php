<?php
/**
 * Advanced OpenReports, SugarCRM Reporting.
 * @package Advanced OpenReports for SugarCRM
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

class AOR_Field extends Basic {
	var $new_schema = true;
	var $module_dir = 'AOR_Fields';
	var $object_name = 'AOR_Field';
	var $table_name = 'aor_fields';
    var $tracker_visibility = false;
	var $importable = true;
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
    var $field_order;
    var $field;
    var $display;
    var $label;
    var $field_function;
    var $sort_by;
    var $sort_order;
    var $group_by;
    var $group_order;
		
	function AOR_Field(){
		parent::Basic();
	}

    function save_lines($post_data, $parent, $key = ''){

        require_once('modules/AOW_WorkFlow/aow_utils.php');

        $line_count = count($post_data[$key.'field']);
        $j = 0;
        for ($i = 0; $i < $line_count; ++$i) {

            if($post_data[$key.'deleted'][$i] == 1){
                $this->mark_deleted($post_data[$key.'id'][$i]);
            } else {
                $field = new AOR_Field();
                $field->group_display = false;

                if($key == 'aor_fields_') {
                    foreach($post_data['aor_fields_group_display'] as $gdKey => $gdValue) {
                        if($gdValue == $i) {
                            $field->group_display = $gdKey+1;
                            break;
                        }
                    }
                }

                foreach($this->field_defs as $field_def) {
                    if(is_array($post_data[$key.$field_def['name']])) {
                        if ($field_def['name'] != 'group_display' && isset($post_data[$key . $field_def['name']][$i])) {
                            if (is_array($post_data[$key . $field_def['name']][$i])) {
                                $post_data[$key . $field_def['name']][$i] = base64_encode(serialize($post_data[$key . $field_def['name']][$i]));
                            } else if ($field_def['name'] == 'value') {
                                $post_data[$key . $field_def['name']][$i] = fixUpFormatting($_REQUEST['report_module'], $field->field, $post_data[$key . $field_def['name']][$i]);
                            }
                            if ($field_def['name'] == 'module_path') {
                                $post_data[$key . $field_def['name']][$i] = base64_encode(serialize(explode(":", $post_data[$key . $field_def['name']][$i])));
                            }

                            $field->$field_def['name'] = $post_data[$key . $field_def['name']][$i];
                        }
                    }
                    else if(is_null($post_data[$key.$field_def['name']])) {
                        // do nothing
                    }
                    else {
                        throw new Exception('illegal type in post data at key ' . $key.$field_def['name'] . ' ' . gettype($post_data[$key.$field_def['name']]));
                    }

                }
                if(trim($field->field) != ''){
                    $field->aor_report_id = $parent->id;
                    $field->save();
                }
            }
        }
    }
		
}
?>
