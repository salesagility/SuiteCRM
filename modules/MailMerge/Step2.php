 <?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
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
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/




/*
 * Created on Oct 4, 2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */



//require_once('include/utils.php');
require_once('include/json_config.php');
$json_config = new json_config();

global $app_strings;
global $app_list_strings;
global $mod_strings;
global $current_user;
global $theme;
global $sugar_version, $sugar_config;



$xtpl = new XTemplate('modules/MailMerge/Step2.html');
$xtpl->assign("MOD", $mod_strings);
$xtpl->assign("APP", $app_strings);
$xtpl->assign('JSON_CONFIG_JAVASCRIPT', $json_config->get_static_json_server(false, true));

if(isset($_POST['mailmerge_module']))
{
	$_SESSION['MAILMERGE_MODULE'] = $_POST['mailmerge_module'];	
    if($_SESSION['MAILMERGE_MODULE'] == 'Campaigns'){
        $_SESSION['MAILMERGE_MODULE'] = 'CampaignProspects';
    }
	if($_SESSION['MAILMERGE_MODULE'] == 'Contacts' || $_SESSION['MAILMERGE_MODULE'] == 'Leads'|| $_SESSION['MAILMERGE_MODULE'] == 'CampaignProspects')
	{
		
		$_SESSION['MAILMERGE_SKIP_REL'] = true;
	}
}

$step_txt = "Step 2: ";
if(!empty($_SESSION['SELECTED_OBJECTS_DEF'])){
	$selObjs = $_SESSION['SELECTED_OBJECTS_DEF'];
	$sel_obj = array();
	parse_str($selObjs,$sel_obj);
	$idArray = array();
	$_SESSION['MAILMERGE_WHERE'] = "";
	foreach($sel_obj as $key => $value){
		$value = str_replace("##", "&", $value);
		$idArray[$key] = $value;
        if($_SESSION['MAILMERGE_MODULE'] == 'CampaignProspects'){
            if(isset($_POST['mailmerge_module']) && $_POST['mailmerge_module'] == 'Campaigns'){
                $where = "campaigns.id = '$key'";
                $_SESSION['MAILMERGE_WHERE'] = $where;
                $_SESSION['MAILMERGE_CAMPAIGN_ID'] = $key;
                $idArray = array();
                break; 
            }   
        }
	}
                   
    $xtpl->assign("MAILMERGE_WHERE", $_SESSION['MAILMERGE_WHERE']); 
	$xtpl->assign("MAILMERGE_PRESELECTED_OBJECTS", get_select_options_with_id($idArray, '0'));
	$step_txt .= "Refine list of ".$_SESSION['MAILMERGE_MODULE']." to merge.";
	$xtpl->assign("MAILMERGE_GET_OBJECTS", 0);
}
else
{
	$step_txt .= "Select list of ".$_SESSION['MAILMERGE_MODULE']." to merge.";
	$xtpl->assign("MAILMERGE_GET_OBJECTS", 1);
}

if(isset($_SESSION['MAILMERGE_SKIP_REL']) && $_SESSION['MAILMERGE_SKIP_REL'])
{
	$xtpl->assign("STEP", "4");	
	
}
else
{

	$selected = '';
	if(isset($_SESSION['MAILMERGE_CONTAINS_CONTACT_INFO']) && $_SESSION['MAILMERGE_CONTAINS_CONTACT_INFO']){
		$selected = $_SESSION['MAILMERGE_CONTAINS_CONTACT_INFO'];	
	}
	$xtpl->assign("STEP", "3");	
	//$xtpl->assign("MAIL_MERGE_CONTAINS_CONTACT_INFO", '<table><tr><td><input id="contains_contact_info" name="contains_contact_info" class="checkbox" type="checkbox" '.$checked.'/></td><td>'.$mod_strings['LBL_CONTAINS_CONTACT_INFO'].'</td></tr></table>');
	$rel_options = array(""=>"--None--");
	$seed = loadBean($_SESSION['MAILMERGE_MODULE']);
	if($seed->load_relationship('contacts')){
		$rel_options["Contacts"] = "Contacts";
	}
	if($_SESSION['MAILMERGE_MODULE'] == "Accounts"){
		$rel_options["Opportunities"] = "Opportunities";
	}
	elseif($_SESSION['MAILMERGE_MODULE'] == "Opportunities"){
		$rel_options["Accounts"] = "Accounts";
	}
	$xtpl->assign("MAIL_MERGE_CONTAINS_CONTACT_INFO", '<table><tr><td>'.$mod_strings['LBL_CONTAINS_CONTACT_INFO'].'</td><td><select id="contains_contact_info" name="contains_contact_info">'.get_select_options_with_id($rel_options, $selected).'</select></td></tr></table>');
}

$xtpl->assign("MAILMERGE_MODULE", $_SESSION['MAILMERGE_MODULE']);
$xtpl->assign("MAILMERGE_PREV", SugarThemeRegistry::current()->getImage('previous','border="0" style="margin-left: 1px;" id="prevItems" onClick="decreaseOffset();getObjects();"',null,null,'.gif',$mod_strings['LBL_BACK']));
$xtpl->assign("MAILMERGE_NEXT", SugarThemeRegistry::current()->getImage('next','border="0" style="margin-left: 1px;" alt="Next" id="nextItems" onClick="increaseOffset();getObjects();"',null,null,'.gif',$mod_strings['LBL_NEXT']));
$xtpl->assign("MAILMERGE_RIGHT_TO_LEFT", SugarThemeRegistry::current()->getImage('leftarrow_big','border="0" style="margin-left: 1px;"  onClick="moveLeft();"',null,null,'.gif',$mod_strings['LBL_REMOVE']));
$xtpl->assign("MAILMERGE_LEFT_TO_RIGHT", SugarThemeRegistry::current()->getImage('rightarrow_big','border="0" style="margin-left: 1px;" onClick="moveRight();"',null,null,'.gif',$mod_strings['LBL_ADD']));
$xtpl->assign("MAIL_MERGE_HEADER_STEP_2", $step_txt);
if($_SESSION['MAILMERGE_MODULE'] == 'CampaignProspects'){
    $rel_options = array("Contacts"=>"Contacts", "Leads" => "Leads", "Prospects" => "Prospects", "Users"=>"Users");
    $xtpl->assign("MAIL_MERGE_CAMPAIGN_PROSPECT_SELECTOR", '<select id="campaign_prospect_type" name="campaign_prospect_type">'.get_select_options_with_id($rel_options, 'Prospects').'</select>');
        
}

if(!empty($_POST['document_id']))
{
	$_SESSION['MAILMERGE_DOCUMENT_ID'] = $_POST['document_id'];
}


$xtpl->parse("main");
$xtpl->out("main");

function displaySelectionBox($objectList)
{
	$html = '<select id="display_objs" name="display_objs[]" size="10" multiple="multiple" size="10" >';
	foreach($objectList as $key=>$value)
	{
		$html .= '<option value="'.$key.'">'.$value.'</option>';
	}
	$html .= '</select>';
	return $html;
}

?>
