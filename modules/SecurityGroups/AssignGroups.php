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


class AssignGroups {

function popup_select(&$bean, $event, $arguments)
{
	global $sugar_config;

	//only process if action is Save (meaning a user has triggered this event and not the portal or automated process)
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'Save' 
		&& isset($sugar_config['securitysuite_popup_select']) && $sugar_config['securitysuite_popup_select'] == true
		&& empty($bean->fetched_row['id']) && $bean->module_dir != "Users" && $bean->module_dir != "SugarFeed") {		
		//Upload an attachment to an Email Template and save. If user with multi groups - popup select option
		//it will redirect to notes instead of EmailTemplate and relationship will fail...check below to avoid
		if(!empty($_REQUEST['module']) && $_REQUEST['module'] != $bean->module_dir) return;

		if(!empty($_REQUEST['securitygroup_list'])) {
			require_once('modules/SecurityGroups/SecurityGroup.php');
			$groupFocus = new SecurityGroup();
			$security_modules = $groupFocus->getSecurityModules();
			//sanity check
			if(in_array($bean->module_dir,array_keys($security_modules))) {
				//add each group in securitygroup_list to new record
				$rel_name = $groupFocus->getLinkName($bean->module_dir,"SecurityGroups");

				$bean->load_relationship($rel_name);
				foreach($_REQUEST['securitygroup_list'] as $group_id) {
					$bean->$rel_name->add($group_id);
				}
			}
		} else if(!empty($_REQUEST['dup_checked'])) {
			//well...ShowDuplicates doesn't pass through request vars unless they are defined in the module vardefs
			//so we are screwed here...
			global $current_language;
			$ss_mod_strings = return_module_language($current_language, 'SecurityGroups');	
			unset($_SESSION['securitysuite_error']); //to be safe
			$_SESSION['securitysuite_error'] = $ss_mod_strings['LBL_ERROR_DUPLICATE'];
		}
	}

	else if(isset($sugar_config['securitysuite_user_popup']) && $sugar_config['securitysuite_user_popup'] == true
		&& empty($bean->fetched_row['id']) && $bean->module_dir == "Users"
		&& isset($_REQUEST['action']) && $_REQUEST['action'] != 'SaveSignature' ) { //Bug: 589

		//$_REQUEST['return_module'] = $bean->module_dir;
		//$_REQUEST['return_action'] = "DetailView";
		//$_REQUEST['return_id'] = $bean->id;
		
		//$_SESSION['securitygroups_popup_'.$bean->module_dir] = $bean->id;
		
		if(!isset($_SESSION['securitygroups_popup'])) {
			$_SESSION['securitygroups_popup'] = array();
		}
		$_SESSION['securitygroups_popup'][] = array(
			'module' => $bean->module_dir,
			'id' => $bean->id
		);
	}
} 


function popup_onload($event, $arguments)
{
	if(!empty($_REQUEST['to_pdf']) || !empty($_REQUEST['sugar_body_only'])) return;

/** //test user popup
	//always have this loaded
	echo '<script type="text/javascript" src="modules/SecurityGroups/javascript/popup_relate.js"></script>';
*/
	global $sugar_config;

        $action = null;
        if (isset($_REQUEST['action'])) {
            $action = $_REQUEST['action'];
        } else {
            LoggerManager::getLogger()->warn('Not defined action in request');
        }
        
        $module = null;
        if (isset($_REQUEST['module'])) {
            $module = $_REQUEST['module'];
        } else {
            LoggerManager::getLogger()->warn('Not defined module in request');
        }
        

	if(isset($action) && ($action == "Save" || $action == "SetTimezone")) return;  

	if( (
			//(isset($sugar_config['securitysuite_popup_select']) && $sugar_config['securitysuite_popup_select'] == true)
			//|| 
			($module == "Users" && isset($sugar_config['securitysuite_user_popup']) && $sugar_config['securitysuite_user_popup'] == true)
		)
	
		//&& isset($_SESSION['securitygroups_popup_'.$module]) && !empty($_SESSION['securitygroups_popup_'.$module])
		&& !empty($_SESSION['securitygroups_popup'])
	) {	

		foreach($_SESSION['securitygroups_popup'] as $popup_index => $popup) {
			$record_id = $popup['id'];
			$module = $popup['module'];
			unset($_SESSION['securitygroups_popup'][$popup_index]);
			
			require_once('modules/SecurityGroups/SecurityGroup.php');
			$groupFocus = new SecurityGroup();
			if($module == 'Users') {
				$rel_name = "SecurityGroups";
			} else {
				$rel_name = $groupFocus->getLinkName($module,"SecurityGroups");
			}

				//this only works if on the detail view of the record actually saved...
				//so ajaxui breaks this as it stays on the parent
				$auto_popup = <<<EOQ
<script type="text/javascript" language="javascript">
	open_popup("SecurityGroups",600,400,"",true,true,{"call_back_function":"securitysuite_set_return_and_save_background","form_name":"DetailView","field_to_name_array":{"id":"subpanel_id"},"passthru_data":{"module":"$module","record":"$record_id","child_field":"$rel_name","return_url":"","link_field_name":"$rel_name","module_name":"$rel_name","refresh_page":"1"}},"MultiSelect",true);
</script>
EOQ;

			echo $auto_popup;

		}
		unset($_SESSION['securitygroups_popup']);
		
	}

}

function mass_assign($event, $arguments)
{
    
        
        $action = null;
        if (isset($_REQUEST['action'])) {
            $action = $_REQUEST['action'];
        } else {
            LoggerManager::getLogger()->warn('Not defined action in request');
        }
        
        $module = null;
        if (isset($_REQUEST['module'])) {
            $module = $_REQUEST['module'];
        } else {
            LoggerManager::getLogger()->warn('Not defined module in request');
        }
        
  
  	$no_mass_assign_list = array("Emails"=>"Emails","ACLRoles"=>"ACLRoles"); //,"Users"=>"Users");
    //check if security suite enabled
    $action = strtolower($action);
    if(isset($module) && ($action == "list" || $action == "index" || $action == "listview") 
    	&& (!isset($_REQUEST['search_form_only']) || $_REQUEST['search_form_only'] != true)
    	&& !array_key_exists($module,$no_mass_assign_list)
    	) {
   		global $current_user;
   		if(is_admin($current_user) || ACLAction::getUserAccessLevel($current_user->id,"SecurityGroups", 'access') == ACL_ALLOW_ENABLED) {

			require_once('modules/SecurityGroups/SecurityGroup.php');
			$groupFocus = new SecurityGroup();
			$security_modules = $groupFocus->getSecurityModules();
			//if(in_array($module,$security_modules)) {
			if(in_array($module,array_keys($security_modules))) {

				global $app_strings;

				global $current_language;
				$current_module_strings = return_module_language($current_language, 'SecurityGroups');

				$form_header = get_form_header($current_module_strings['LBL_MASS_ASSIGN'], '', false);

				$groups = $groupFocus->get_list("name","",0,-99,-99);
				$options = array(""=>"");
				foreach($groups['list'] as $group) {
					$options[$group->id] = $group->name;
				}
				$group_options =  get_select_options_with_id($options, "");

				$mass_assign = <<<EOQ

<script type="text/javascript" language="javascript">
function confirm_massassign(del,start_string, end_string) {
	if (del == 1) {
		return confirm( start_string + sugarListView.get_num_selected()  + end_string);
	}
	else {
		return confirm( start_string + sugarListView.get_num_selected()  + end_string);
	}
}

function send_massassign(mode, no_record_txt, start_string, end_string, del) {

	if(!sugarListView.confirm_action(del, start_string, end_string))
		return false;

	if(document.MassAssign_SecurityGroups.massassign_group.selectedIndex == 0) {
		alert("${current_module_strings['LBL_SELECT_GROUP_ERROR']}");
		return false;	
	}
	 
	if (document.MassUpdate.select_entire_list &&
		document.MassUpdate.select_entire_list.value == 1)
		mode = 'entire';
	else if (document.MassUpdate.massall.checked == true)
		mode = 'page';
	else
		mode = 'selected';

	var ar = new Array();
	if(del == 1) {
		var deleteInput = document.createElement('input');
		deleteInput.name = 'Delete';
		deleteInput.type = 'hidden';
		deleteInput.value = true;
		document.MassAssign_SecurityGroups.appendChild(deleteInput);
	}

	switch(mode) {
		case 'page':
			document.MassAssign_SecurityGroups.uid.value = '';
			for(wp = 0; wp < document.MassUpdate.elements.length; wp++) {
				if(typeof document.MassUpdate.elements[wp].name != 'undefined'
					&& document.MassUpdate.elements[wp].name == 'mass[]' && document.MassUpdate.elements[wp].checked) {
							ar.push(document.MassUpdate.elements[wp].value);
				}
			}
			document.MassAssign_SecurityGroups.uid.value = ar.join(',');
			if(document.MassAssign_SecurityGroups.uid.value == '') {
				alert(no_record_txt);
				return false;
			}
			break;
		case 'selected':
			for(wp = 0; wp < document.MassUpdate.elements.length; wp++) {
				if(typeof document.MassUpdate.elements[wp].name != 'undefined'
					&& document.MassUpdate.elements[wp].name == 'mass[]'
						&& document.MassUpdate.elements[wp].checked) {
							ar.push(document.MassUpdate.elements[wp].value);
				}
			}
			if(document.MassAssign_SecurityGroups.uid.value != '') document.MassAssign_SecurityGroups.uid.value += ',';
			document.MassAssign_SecurityGroups.uid.value += ar.join(',');
			if(document.MassAssign_SecurityGroups.uid.value == '') {
				alert(no_record_txt);
				return false;
			}
			break;
		case 'entire':
			var entireInput = document.createElement('input');
			entireInput.name = 'entire';
			entireInput.type = 'hidden';
			entireInput.value = 'index';
			document.MassAssign_SecurityGroups.appendChild(entireInput);
			//confirm(no_record_txt);
			break;
	}

	document.MassAssign_SecurityGroups.submit();
	return false;
}

</script>

		<form action='index.php' method='post' name='MassAssign_SecurityGroups'  id='MassAssign_SecurityGroups'>
			<input type='hidden' name='action' value='MassAssign' />
			<input type='hidden' name='module' value='SecurityGroups' />
			<input type='hidden' name='return_action' value='${action}' />
			<input type='hidden' name='return_module' value='${module}' />
			<textarea style='display: none' name='uid'></textarea>


		<div id='massassign_form'>$form_header
		<table cellpadding='0' cellspacing='0' border='0' width='100%'>
		<tr>
		<td style='padding-bottom: 2px;' class='listViewButtons'>
		<input type='submit' name='Assign' value='${current_module_strings['LBL_ASSIGN']}' onclick="return send_massassign('selected', '{$app_strings['LBL_LISTVIEW_NO_SELECTED']}','${current_module_strings['LBL_ASSIGN_CONFIRM']}','${current_module_strings['LBL_CONFIRM_END']}',0);" class='button'>
		<input type='submit' name='Remove' value='${current_module_strings['LBL_REMOVE']}' onclick="return send_massassign('selected', '{$app_strings['LBL_LISTVIEW_NO_SELECTED']}','${current_module_strings['LBL_REMOVE_CONFIRM']}','${current_module_strings['LBL_CONFIRM_END']}',1);" class='button'>


		</td></tr></table>
		<table cellpadding='0' cellspacing='0' border='0' width='100%' class='tabForm' id='mass_update_table'>
		<tr><td><table width='100%' border='0' cellspacing='0' cellpadding='0'>
		<tr>
		<td>${current_module_strings['LBL_GROUP']}</td>
		<td><select name='massassign_group' id="massassign_group" tabindex='1'>${group_options}</select></td>
		</tr>
		</table></td></tr></table></div>			
		</form>		
EOQ;


				echo $mass_assign;
			}
		}
    }

	//if after a save...
	if(!empty($_SESSION['securitysuite_error'])) {
		$lbl_securitysuite_error = $_SESSION['securitysuite_error'];
		unset($_SESSION['securitysuite_error']);
		echo <<<EOQ
<script>
				

var oNewP = document.createElement("div");
oNewP.className = 'error';

var oText = document.createTextNode("${lbl_securitysuite_error}");
oNewP.appendChild(oText);

var beforeMe = document.getElementsByTagName("div")[0];
document.body.insertBefore(oNewP, beforeMe);
</script>
EOQ;
	}
}

}
