<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
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
 ********************************************************************************/

/*********************************************************************************

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/



require_once("include/upload_file.php");

global $currentModule;

global $theme;
global $focus;
global $action;

global $app_strings;
global $app_list_strings;
//we don't want the parent module's string file, but rather the string file specific to this subpanel
global $current_language;
$current_module_strings = return_module_language($current_language, 'Activities');
global $timedate;



// history_list is the means of passing data to a SubPanelView.
global $focus_tasks_list;
global $focus_meetings_list;
global $focus_calls_list;
global $focus_emails_list;

$open_activity_list = Array();
$history_list = Array();

foreach ($focus_tasks_list as $task) {
	if ($task->status != "Not Started" && $task->status != "In Progress" && $task->status != "Pending Input") {
		$history_list[] = Array('name' => $task->name,
									 'id' => $task->id,
									 'type' => "Task",
									 'direction' => '',
									 'module' => "Tasks",
									 'status' => $task->status,
									 'parent_id' => $task->parent_id,
									 'parent_type' => $task->parent_type,
									 'parent_name' => $task->parent_name,
									 'contact_id' => $task->contact_id,
									 'contact_name' => $task->contact_name,
									 'date_modified' => $timedate->to_display_date($task->date_modified, true),
									 );
	}
	else {
		if ($task->date_due == '0000-00-00') $date_due = '';
		else {
			$date_due = $task->date_due;

		}
		$open_activity_list[] = Array('name' => $task->name,
									 'id' => $task->id,
									 'type' => "Task",
									 'direction' => '',
									 'module' => "Tasks",
									 'status' => $task->status,
									 'parent_id' => $task->parent_id,
									 'parent_type' => $task->parent_type,
									 'parent_name' => $task->parent_name,
									 'contact_id' => $task->contact_id,
									 'contact_name' => $task->contact_name,
									 'date_due' => $date_due
									 );
	}
}

foreach ($focus_meetings_list as $meeting) {
		if ($meeting->status != "Planned") {
		$history_list[] = Array('name' => $meeting->name,
									 'id' => $meeting->id,
									 'type' => "Meeting",
									 'direction' => '',
									 'module' => "Meetings",
									 'status' => $meeting->status,
									 'parent_id' => $meeting->parent_id,
									 'parent_type' => $meeting->parent_type,
									 'parent_name' => $meeting->parent_name,
									 'contact_id' => $meeting->contact_id,
									 'contact_name' => $meeting->contact_name,
									 'date_modified' => $meeting->date_modified
									 );
	}
	else {
		$open_activity_list[] = Array('name' => $meeting->name,
									 'id' => $meeting->id,
									 'type' => "Meeting",
									 'direction' => '',
									 'module' => "Meetings",
									 'status' => $meeting->status,
									 'parent_id' => $meeting->parent_id,
									 'parent_type' => $meeting->parent_type,
									 'parent_name' => $meeting->parent_name,
									 'contact_id' => $meeting->contact_id,
									 'contact_name' => $meeting->contact_name,
									 'date_due' => $meeting->date_start
									 );
	}
}

foreach ($focus_calls_list as $call) {
	if ($call->status != "Planned") {
		$history_list[] = Array('name' => $call->name,
									 'id' => $call->id,
									 'type' => "Call",
									 'direction' => $call->direction,
									 'module' => "Calls",
									 'status' => $call->status,
									 'parent_id' => $call->parent_id,
									 'parent_type' => $call->parent_type,
									 'parent_name' => $call->parent_name,
									 'contact_id' => $call->contact_id,
									 'contact_name' => $call->contact_name,
									 'date_modified' => $call->date_modified
									 );
	}
	else {
		$open_activity_list[] = Array('name' => $call->name,
									 'id' => $call->id,
									 'direction' => $call->direction,
									 'type' => "Call",
									 'module' => "Calls",
									 'status' => $call->status,
									 'parent_id' => $call->parent_id,
									 'parent_type' => $call->parent_type,
									 'parent_name' => $call->parent_name,
									 'contact_id' => $call->contact_id,
									 'contact_name' => $call->contact_name,
									 'date_due' => $call->date_start
									 );
	}
}

foreach ($focus_emails_list as $email) {
	$history_list[] = Array('name' => $email->name,
									 'id' => $email->id,
									 'type' => "Email",
									 'direction' => '',
									 'module' => "Emails",
									 'status' => '',
									 'parent_id' => $email->parent_id,
									 'parent_type' => $email->parent_type,
									 'parent_name' => $email->parent_name,
									 'contact_id' => $email->contact_id,
									 'contact_name' => $email->contact_name,
									 'date_modified' => $email->date_start." ".$email->time_start
									 );
}

foreach ($focus_notes_list as $note) {
	$history_list[] = Array('name' => $note->name,
									 'id' => $note->id,
									 'type' => "Note",
									 'direction' => '',
									 'module' => "Notes",
									 'status' => '',
									 'parent_id' => $note->parent_id,
									 'parent_type' => $note->parent_type,
									 'parent_name' => $note->parent_name,
									 'contact_id' => $note->contact_id,
									 'contact_name' => $note->contact_name,
									 'date_modified' => $note->date_modified
									 );
	if (!empty($note->filename))
	{
		$count = count($history_list);
		$count--;
		$history_list[$count]['filename'] = $note->filename;
		$history_list[$count]['fileurl'] = UploadFile::get_upload_url($note);
	}

}

if ($currentModule == 'Contacts')
{
	$xtpl=new XTemplate ('modules/Activities/SubPanelViewContacts.html');
	$xtpl->assign("CONTACT_ID", $focus->id);
}
else
{
	$xtpl=new XTemplate ('modules/Activities/SubPanelView.html');
}

$xtpl->assign("DELETE_INLINE_PNG",  SugarThemeRegistry::current()->getImage('delete_inline','align="absmiddle" border="0"', null,null,'.gif',$app_strings['LNK_DELETE']));
$xtpl->assign("EDIT_INLINE_PNG",  SugarThemeRegistry::current()->getImage('edit_inline','align="absmiddle" border="0"', null,null,'.gif',$app_strings['LNK_EDIT']));

$xtpl->assign("MOD", $current_module_strings);
$xtpl->assign("APP", $app_strings);

$button  = "<form border='0' action='index.php' method='post' name='form' id='form'>\n";
$button .= "<input type='hidden' name='module'>\n";
$button .= "<input type='hidden' name='type'>\n";
if ($currentModule == 'Accounts')
{
	$button .= "<input type='hidden' name='parent_type' value='Accounts'>\n<input type='hidden' name='parent_id' value='$focus->id'>\n<input type='hidden' name='parent_name' value='$focus->name'>\n";
}
elseif ($currentModule == 'Opportunities')
{
	$button .= "<input type='hidden' name='parent_type' value='Opportunities'>\n<input type='hidden' name='parent_id' value='$focus->id'>\n<input type='hidden' name='parent_name' value='$focus->name'>\n";
}
elseif ($currentModule == 'Cases')
{
	$button .= "<input type='hidden' name='parent_type' value='Cases'>\n<input type='hidden' name='parent_id' value='$focus->id'>\n<input type='hidden' name='parent_name' value='$focus->name'>\n";
}
elseif ($currentModule == 'Contacts')
{
	$button .= "<input type='hidden' name='contact_id' value='$focus->id'>\n<input type='hidden' name='contact_name' value='$focus->first_name $focus->last_name'>\n";
	$button .= "<input type='hidden' name='parent_type' value='Accounts'>\n<input type='hidden' name='parent_id' value='$focus->account_id'>\n<input type='hidden' name='parent_name' value='$focus->account_name'>\n";
	$button .= "<input type='hidden' name='to_email_addrs' value='$focus->email1'>\n";
}
else
{
	$button .= "<input type='hidden' name='parent_type' value='$currentModule'>\n<input type='hidden' name='parent_id' value='$focus->id'>\n<input type='hidden' name='parent_name' value='$focus->name'>\n";
}

$button .= "<input type='hidden' name='return_module' value='".$currentModule."'>\n";
$button .= "<input type='hidden' name='return_action' value='".$action."'>\n";
$button .= "<input type='hidden' name='return_id' value='".$focus->id."'>\n";
$button .= "<input type='hidden' name='type' value='out'>\n";
$button .= "<input type='hidden' name='action'>\n";

if($currentModule != 'Project' && $currentModule != 'ProjectTask')
{
	$button .= "<input title='".$current_module_strings['LBL_NEW_TASK_BUTTON_TITLE']."'  class='button' onclick=\"this.form.action.value='EditView';this.form.module.value='Tasks'\" type='submit' name='button' value='".$current_module_strings['LBL_NEW_TASK_BUTTON_LABEL']."'>\n";
}

$button .= "<input title='".$current_module_strings['LBL_SCHEDULE_MEETING_BUTTON_TITLE']."'  class='button' onclick=\"this.form.action.value='EditView';this.form.module.value='Meetings'\" type='submit' name='button' value='".$current_module_strings['LBL_SCHEDULE_MEETING_BUTTON_LABEL']."'>\n";

$button .= "<input title='".$current_module_strings['LBL_SCHEDULE_CALL_BUTTON_LABEL']."'  class='button' onclick=\"this.form.action.value='EditView';this.form.module.value='Calls'\" type='submit' name='button' value='".$current_module_strings['LBL_SCHEDULE_CALL_BUTTON_LABEL']."'>\n";

$button .= "<input title='".$app_strings['LBL_COMPOSE_EMAIL_BUTTON_TITLE']."'  class='button' onclick=\"this.form.type.value='out';this.form.action.value='EditView';this.form.module.value='Emails';\" type='submit' name='button' value='".$app_strings['LBL_COMPOSE_EMAIL_BUTTON_LABEL']."'>\n";

$button .= "</form>\n";

// Stick the form header out there.
echo get_form_header($current_module_strings['LBL_OPEN_ACTIVITIES'], $button, false);

$xtpl->assign("RETURN_URL", "&return_module=$currentModule&return_action=DetailView&return_id=$focus->id");

$oddRow = true;
if (count($open_activity_list) > 0) $open_activity_list = array_csort($open_activity_list, 'date_due', SORT_DESC);
foreach($open_activity_list as $activity)
{
	$activity_fields = array(
		'ID' => $activity['id'],
		'NAME' => $activity['name'],
		'MODULE' => $activity['module'],
		'CONTACT_NAME' => $activity['contact_name'],
		'CONTACT_ID' => $activity['contact_id'],
		'PARENT_TYPE' => $activity['parent_type'],
		'PARENT_NAME' => $activity['parent_name'],
		'PARENT_ID' => $activity['parent_id'],
		'DATE' => $activity['date_due']
	);

	if (empty($activity['direction'])) {
		$activity_fields['TYPE'] = $app_list_strings['activity_dom'][$activity['type']];
	}
	else {
		$activity_fields['TYPE'] = $app_list_strings['call_direction_dom'][$activity['direction']].' '.$app_list_strings['activity_dom'][$activity['type']];
	}
	if (isset($activity['parent_type'])) $activity_fields['PARENT_MODULE'] = $activity['parent_type'];
	switch ($activity['type']) {
		case 'Call':
			$activity_fields['SET_COMPLETE'] = "<a href='index.php?return_module=$currentModule&return_action=$action&return_id=$focus->id&action=EditView&module=Calls&status=Held&record=".$activity['id']."&status=Held'>".SugarThemeRegistry::current()->getImage("close_inline","title=".translate('LBL_LIST_CLOSE','Activities')." border='0'",null,null,'.gif',$mod_strings['LBL_LIST_CLOSE'])."</a>";
			$activity_fields['STATUS'] = $app_list_strings['call_status_dom'][$activity['status']];
			break;
		case 'Meeting':
			$activity_fields['SET_COMPLETE'] = "<a href='index.php?return_module=$currentModule&return_action=$action&return_id=$focus->id&action=EditView&module=Meetings&status=Held&record=".$activity['id']."&status=Held'>".SugarThemeRegistry::current()->getImage("close_inline","title=".translate('LBL_LIST_CLOSE','Activities')." border='0'", null,null,'.gif',$mod_strings['LBL_LIST_CLOSE'])."</a>";
			$activity_fields['STATUS'] = $app_list_strings['meeting_status_dom'][$activity['status']];
			break;
		case 'Task':
			$activity_fields['SET_COMPLETE'] = "<a href='index.php?return_module=$currentModule&return_action=$action&return_id=$focus->id&action=EditView&module=Tasks&status=Completed&record=".$activity['id']."&status=Completed'>".SugarThemeRegistry::current()->getImage("close_inline","title=".translate('LBL_LIST_CLOSE','Activities')." border='0'", null,null,'.gif',$mod_strings['LBL_LIST_CLOSE'])."</a>";
			$activity_fields['STATUS'] = $app_list_strings['task_status_dom'][$activity['status']];
			break;
	}

 global $odd_bg;
 global $even_bg;
 global $hilite_bg;
 global $click_bg;
$xtpl->assign("BG_HILITE", $hilite_bg);
$xtpl->assign("BG_CLICK", $click_bg);
$xtpl->assign("ACTIVITY_MODULE_PNG", SugarThemeRegistry::current()->getImage($activity_fields['MODULE'].'','border="0"', null,null,'.gif',$activity_fields['NAME']));
	$xtpl->assign("ACTIVITY", $activity_fields);

	if($oddRow)
    {
        //todo move to themes
		$xtpl->assign("ROW_COLOR", 'oddListRow');
		$xtpl->assign("BG_COLOR", $odd_bg);
    }
    else
    {
        //todo move to themes
		$xtpl->assign("ROW_COLOR", 'evenListRow');
		$xtpl->assign("BG_COLOR", $even_bg);
    }
    $oddRow = !$oddRow;

	$xtpl->parse("open_activity.row");
// Put the rows in.
}

$xtpl->parse("open_activity");
$xtpl->out("open_activity");
echo "<BR>";


//requestdata
$popup_request_data = array(
		'call_back_function' => 'set_return',
		'form_name' => 'EditView',
		'field_to_name_array' => array(),
		);

$json = getJSONobj();
$encoded_popup_request_data = $json->encode($popup_request_data);

$button  = "<form border='0' action='index.php' method='post' name='form' id='form'>\n";
$button .= "<input type='hidden' name='module'>\n";
$button .= "<input type='hidden' name='type' value='archived'>\n";
if ($currentModule == 'Accounts') $button .= "<input type='hidden' name='parent_type' value='Accounts'>\n<input type='hidden' name='parent_id' value='$focus->id'>\n<input type='hidden' name='parent_name' value='$focus->name'>\n";
if ($currentModule == 'Opportunities') $button .= "<input type='hidden' name='parent_type' value='Opportunities'>\n<input type='hidden' name='parent_id' value='$focus->id'>\n<input type='hidden' name='parent_name' value='$focus->name'>\n";
elseif ($currentModule == 'Cases') $button .= "<input type='hidden' name='parent_type' value='Cases'>\n<input type='hidden' name='parent_id' value='$focus->id'>\n<input type='hidden' name='parent_name' value='$focus->name'>\n";
elseif ($currentModule == 'Contacts') {
	$button .= "<input type='hidden' name='contact_id' value='$focus->id'>\n<input type='hidden' name='contact_name' value='$focus->first_name $focus->last_name'>\n";
  $button .= "<input type='hidden' name='to_email_addrs' value='$focus->email1'>\n";
	$button .= "<input type='hidden' name='parent_type' value='Accounts'>\n<input type='hidden' name='parent_id' value='$focus->account_id'>\n<input type='hidden' name='parent_name' value='$focus->account_name'>\n";
}else{
	$button .= "<input type='hidden' name='parent_type' value='$currentModule'>\n<input type='hidden' name='parent_id' value='$focus->id'>\n<input type='hidden' name='parent_name' value='$focus->name'>\n";
}
$button .= "<input type='hidden' name='return_module' value='".$currentModule."'>\n";
$button .= "<input type='hidden' name='return_action' value='".$action."'>\n";
$button .= "<input type='hidden' name='return_id' value='".$focus->id."'>\n";
$button .= "<input type='hidden' name='action'>\n";
$button .= "<input title='".$current_module_strings['LBL_NEW_NOTE_BUTTON_TITLE']."'  class='button' onclick=\"this.form.action.value='EditView';this.form.module.value='Notes'\" type='submit' name='button' value='".$current_module_strings['LBL_NEW_NOTE_BUTTON_LABEL']."'>\n";
$button .= "<input title='".$current_module_strings['LBL_TRACK_EMAIL_BUTTON_TITLE']."'  class='button' onclick=\"this.form.type.value='archived';this.form.action.value='EditView';this.form.module.value='Emails'\" type='submit' name='button' value='".$current_module_strings['LBL_TRACK_EMAIL_BUTTON_LABEL']."'>\n";
$button .= "<input title='".$current_module_strings['LBL_ACCUMULATED_HISTORY_BUTTON_TITLE']."'  class='button' type='button' onclick='open_popup(\"Activities\", \"600\", \"400\", \"&record=$focus->id&module_name=$currentModule\", true, false, $encoded_popup_request_data);' name='button' value='".$current_module_strings['LBL_ACCUMULATED_HISTORY_BUTTON_LABEL']."'>\n";
$button .= "</form>\n";

// Stick the form header out there.
echo get_form_header($current_module_strings['LBL_HISTORY'], $button, false);

$xtpl->assign("RETURN_URL", "&return_module=$currentModule&return_action=DetailView&return_id=$focus->id");

$oddRow = true;
if (count($history_list) > 0) $history_list = array_csort($history_list, 'date_modified', SORT_DESC);
foreach($history_list as $activity)
{
	$activity_fields = array(
		'ID' => $activity['id'],
		'NAME' => $activity['name'],
		'MODULE' => $activity['module'],
		'CONTACT_NAME' => $activity['contact_name'],
		'CONTACT_ID' => $activity['contact_id'],
		'PARENT_TYPE' => $activity['parent_type'],
		'PARENT_NAME' => $activity['parent_name'],
		'PARENT_ID' => $activity['parent_id'],
		'DATE' => $activity['date_modified'],
	);
	if (empty($activity['direction'])) {
		$activity_fields['TYPE'] = $app_list_strings['activity_dom'][$activity['type']];
	}
	else {
		$activity_fields['TYPE'] = $app_list_strings['call_direction_dom'][$activity['direction']].' '.$app_list_strings['activity_dom'][$activity['type']];
	}

	switch ($activity['type']) {
		case 'Call':
			$activity_fields['STATUS'] = $app_list_strings['call_status_dom'][$activity['status']];
			break;
		case 'Meeting':
			$activity_fields['STATUS'] = $app_list_strings['meeting_status_dom'][$activity['status']];
			break;
		case 'Task':
			$activity_fields['STATUS'] = $app_list_strings['task_status_dom'][$activity['status']];
			break;
	}

	if (isset($activity['location'])) $activity_fields['LOCATION'] = $activity['location'];
	if (isset($activity['filename'])) {
		$activity_fields['ATTACHMENT'] = "<a href='".$activity['fileurl']."' target='_blank'>".SugarThemeRegistry::current()->getImage("attachment","border='0' align='absmiddle'",null,null,'.gif',$activity['filename'])."</a>";
    }

	if (isset($activity['parent_type'])) $activity_fields['PARENT_MODULE'] = $activity['parent_type'];

	$xtpl->assign("ACTIVITY", $activity_fields);
	$xtpl->assign("ACTIVITY_MODULE_PNG", SugarThemeRegistry::current()->getImage($activity_fields['MODULE'].'','border="0"', null,null,'.gif',$activity_fields['NAME']));

	if($oddRow)
    {
        //todo move to themes
		$xtpl->assign("ROW_COLOR", 'oddListRow');
		$xtpl->assign("BG_COLOR", $odd_bg);
    }
    else
    {
        //todo move to themes
		$xtpl->assign("ROW_COLOR", 'evenListRow');
		$xtpl->assign("BG_COLOR", $even_bg);
    }
    $oddRow = !$oddRow;

	$xtpl->parse("history.row");
// Put the rows in.
}

$xtpl->parse("history");
$xtpl->out("history");

?>
