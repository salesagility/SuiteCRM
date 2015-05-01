<?php
/**
 *
 * @package Advanced OpenPortal
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
 * @author Salesagility Ltd <support@salesagility.com>
 */

function getAOPAssignField($assignField, $value){
    global $app_list_strings;


    $roles = get_bean_select_array(true, 'ACLRole','name', '','name',true);

    if(!file_exists('modules/SecurityGroups/SecurityGroup.php')){
        unset($app_list_strings['aow_assign_options']['security_group']);
    }
    else{
        $securityGroups = get_bean_select_array(true, 'SecurityGroup','name', '','name',true);
    }

    $field = '';

    $field .= "<select type='text' name='$assignField".'[0]'."' id='$assignField".'[0]'."' onchange='assign_field_change(\"$assignField\")' title='' tabindex='116'>". get_select_options_with_id($app_list_strings['aow_assign_options'], $value[0]) ."</select>&nbsp;&nbsp;";
    if(!file_exists('modules/SecurityGroups/SecurityGroup.php')){
        $field .= "<input type='hidden' name='$assignField".'[1]'."' id='$assignField".'[1]'."' value=''  />";
    }
    else {
        $display = 'none';
        if($value[0] == 'security_group'){
            $display = '';
        }
        $field .= "<select type='text' style='display:$display' name='$assignField".'[1]'."' id='$assignField".'[1]'."' title='' tabindex='116'>". get_select_options_with_id($securityGroups, $value[1]) ."</select>&nbsp;&nbsp;";
    }
    $display = 'none';
    if($value[0] == 'role' || $value[0] == 'security_group') $display = '';
    $field .= "<select type='text' style='display:$display' name='$assignField".'[2]'."' id='$assignField".'[2]'."' title='' tabindex='116'>". get_select_options_with_id($roles, $value[2]) ."</select>&nbsp;&nbsp;";
    return $field;

}

function isAOPEnabled(){
    global $sugar_config;
    if(array_key_exists("aop",$sugar_config) && array_key_exists('enable_aop',$sugar_config['aop'])){
        return !empty($sugar_config['aop']['enable_aop']);
    }
    return true;//Defaults to enabled.
}

function getPortalEmailSettings(){
    global $sugar_config;
    $settings = array('from_name'=>'','from_address'=>'');

    if(array_key_exists("aop",$sugar_config)){
        if(array_key_exists('support_from_address',$sugar_config['aop'])){
            $settings['from_address'] = $sugar_config['aop']['support_from_address'];
        }
        if(array_key_exists('support_from_name',$sugar_config['aop'])){
            $settings['from_name'] = $sugar_config['aop']['support_from_name'];
        }
    }
    if($settings['from_name'] && $settings['from_address']){
        return $settings;
    }

    //Fallback to sugar settings
    $admin = new Administration();
    $admin->retrieveSettings();
    if(!$settings['from_name']){
        $settings['from_name'] = $admin->settings['notify_fromname'];
    }
    if(!$settings['from_address']){
        $settings['from_address'] = $admin->settings['notify_fromaddress'];
    }
    return $settings;
}

/**
 * Custom parse template method since sugars own doesn't deal with custom fields.
 */
function aop_parse_template($string, &$bean_arr) {
    global $beanFiles, $beanList;

    $typeMap = array('dynamicenum' => 'enum');

    foreach($bean_arr as $bean_name => $bean_id) {
        require_once($beanFiles[$beanList[$bean_name]]);

        $focus = new $beanList[$bean_name];
        $result = $focus->retrieve($bean_id);

        if($bean_name == 'Leads' || $bean_name == 'Prospects') {
            $bean_name = 'Contacts';
        }

        foreach($focus->field_defs as $key => $field_def) {

            if(array_key_exists($field_def['type'],$typeMap)){
                $focus->field_defs[$key]['type'] = $typeMap[$field_def['type']];
            }
        }

        if(isset($this) && isset($this->module_dir) && $this->module_dir == 'EmailTemplates') {
            $string = $this->parse_template_bean($string, $bean_name, $focus);
        } else {
            $string = EmailTemplate::parse_template_bean($string, $bean_name, $focus);
        }
    }
    return $string;
}