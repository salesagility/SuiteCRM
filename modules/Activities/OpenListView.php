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

 ********************************************************************************/

require_once('modules/Activities/config.php');
require_once('include/json_config.php');
$json_config = new json_config();

// cn:
global $currentModule, $theme, $focus, $action, $open_status;
global $app_strings;
global $current_language;
global $odd_bg;
global $even_bg;
global $hilite_bg;
global $click_bg;
global $sugar_version, $sugar_config;

$focus_meetings_list = array();
$focus_calls_list = array();
$focus_tasks_list = array();
global $timedate;
//we don't want the parent module's string file, but rather the string file specifc to this subpanel
$current_module_strings = return_module_language($current_language, 'Activities');



///////////////////////////////////////////////////////////////////////////////
////	START LOGIC
if (empty($_REQUEST['appointment_filter'])) {
	if ($current_user->getPreference('appointment_filter') == '') {
		$appointment_filter = 'today';
	} else {
		$appointment_filter = $current_user->getPreference('appointment_filter');
	}
} else {
	$appointment_filter = $_REQUEST['appointment_filter'];
	$current_user->setPreference('appointment_filter', $_REQUEST['appointment_filter']);
}

if ($appointment_filter == 'last this_month') {
    $laterDate = $timedate->getNow(true)->get("last day of this month");
} elseif ($appointment_filter == 'last next_month') {
    $laterDate = $timedate->getNow(true)->get("last day of next month");
} else {
	$laterDate = $timedate->fromString($appointment_filter);
}

$dayEnd = $timedate->asDb($laterDate->get_day_end_time());
$GLOBALS['log']->debug("filter $appointment_filter date $dayEnd");

if(ACLController::checkAccess('Meetings', 'list', true)){
	$meeting = new Meeting();
	$where = '(';
	$or = false;
	foreach ($open_status as $status) {
		if ($or) $where .= ' OR ';
		$or = true;
		$where .= " meetings.status = '$status' ";
	}
	$where .= ") ";
	$where .= " AND meetings_users.user_id='$current_user->id' ";
	$where .= " AND meetings_users.accept_status != 'decline'";

	// allow for differences between MySQL and Oracle 9
	if($sugar_config["dbconfig"]["db_type"] == "mysql") {
		$where .= " HAVING datetime <= '$dayEnd' ";
	} elseif ($sugar_config["dbconfig"]["db_type"] == "oci8") {
	}
	else if ($sugar_config["dbconfig"]["db_type"] == "mssql")
	{
		$where .= " AND meetings.date_start + ' ' +  meetings.time_start <= '$dayEnd' ";
	}
	else {
		$GLOBALS['log']->fatal("No database type identified.");
	}

	$meeting->disable_row_level_security = true;
	$focus_meetings_list = $meeting->get_full_list("time_start", $where);
}

if(ACLController::checkAccess('Calls', 'list', true)) {
	$call = new Call();
	$where = '(';
	$or = false;

	foreach ($open_status as $status) {
		if ($or) $where .= ' OR ';
		$or = true;
		$where .= " calls.status = '$status' ";
	}

	$where .= ") ";
	$where .= " AND calls_users.user_id='$current_user->id' ";
	$where .= " AND calls_users.accept_status != 'decline'";

	// allow for differences between MySQL and Oracle 9
	if($sugar_config["dbconfig"]["db_type"] == "mysql") {
		$where .= " HAVING datetime <= '$dayEnd' ";
	} elseif ($sugar_config["dbconfig"]["db_type"] == "oci8") {
	}else if ($sugar_config["dbconfig"]["db_type"] == "mssql")
	{
		//add condition for MS Sql server.
		$where .= " AND calls.date_start + ' ' + calls.time_start <= '$dayEnd' ";
	} else {
		$GLOBALS['log']->fatal("No database type identified.");
	}

	$call->disable_row_level_security = true;
	$focus_calls_list = $call->get_full_list("time_start", $where);
}

$open_activity_list = array();
if(count($focus_meetings_list)>0) {
	foreach ($focus_meetings_list as $meeting) {
		$td	= $timedate->merge_date_time(from_db_convert($meeting->date_start,'date'),from_db_convert($meeting->time_start, 'time'));
		$tag = 'span';

	 	if($meeting->ACLAccess('view', $meeting->isOwner($current_user->id))){
			$tag = 'a';
		}

		$open_activity_list[] = array(
			'name'				=> $meeting->name,
			'id'				=> $meeting->id,
			'type'				=> 'Meeting',
			'module'			=> 'Meetings',
			'status'			=> $meeting->status,
			'parent_id'			=> $meeting->parent_id,
			'parent_type'		=> $meeting->parent_type,
			'parent_name'		=> $meeting->parent_name,
			'contact_id'		=> $meeting->contact_id,
			'contact_name'		=> $meeting->contact_name,
			'normal_date_start'	=> $meeting->date_start,
			'date_start'		=> $timedate->to_display_date($td),
			'normal_time_start'	=> $meeting->time_start,
			'time_start'		=> $timedate->to_display_time($td,true),
			'required'			=> $meeting->required,
			'accept_status'		=> $meeting->accept_status,
			'tag'				=> $tag,
		);
	}
}

if (count($focus_calls_list)>0) {
	foreach ($focus_calls_list as $call) {

	 	$td = $timedate->merge_date_time(from_db_convert($call->date_start,'date'),from_db_convert($call->time_start, 'time'));
		$tag = 'span';

	 	if($call->ACLAccess('view', $call->isOwner($current_user->id))) {
			$tag = 'a';
		}

	 	$open_activity_list[] = array(
			'name'				=> $call->name,
			'id'				=> $call->id,
			'type'				=> 'Call',
			'module'			=> 'Calls',
			'status'			=> $call->status,
			'parent_id'			=> $call->parent_id,
			'parent_type'		=> $call->parent_type,
			'parent_name'		=> $call->parent_name,
			'contact_id'		=> $call->contact_id,
			'contact_name'		=> $call->contact_name,
			'date_start'		=> $timedate->to_display_date($td),
			'normal_date_start'	=> $call->date_start,
			'normal_time_start'	=> $call->time_start,
			'time_start'		=> $timedate->to_display_time($td,true),
			'required'			=> $call->required,
			'accept_status'		=> $call->accept_status,
			'tag'				=> $tag,
		);
	}
}

///////////////////////////////////////////////////////////////////////////////
////	START OUTPUT

$xtpl=new XTemplate ('modules/Activities/OpenListView.html');
$xtpl->assign("MOD", $current_module_strings);
$xtpl->assign("APP", $app_strings);
$xtpl->assign('JSON_CONFIG_JAVASCRIPT', $json_config->get_static_json_server());
$xtpl->assign("SUGAR_VERSION", $sugar_version);
$xtpl->assign("JS_CUSTOM_VERSION", $sugar_config['js_custom_version']);

// Stick the form header out there.
$filter = get_select_options_with_id($current_module_strings['appointment_filter_dom'], $appointment_filter );
echo "<form method='POST' action='index.php'>\n";
echo "<input type='hidden' name='module' value='Home'>\n";
echo "<input type='hidden' name='action' value='index'>\n";
$day_filter = "<select name='appointment_filter' language='JavaScript' onchange='this.form.submit();'>$filter</select>";

echo get_form_header($current_module_strings['LBL_UPCOMING'], $current_module_strings['LBL_TODAY'].$day_filter.' ('.$timedate->to_display_date($later, false).') ', false);
echo "</form>\n";

$xtpl->assign("RETURN_URL", "&return_module=$currentModule&return_action=DetailView&return_id=" . ((is_object($focus) && ! empty($focus->id)) ? $focus->id : ""));

$oddRow = true;
if(count($open_activity_list) > 0) {
	$open_activity_list = array_csort($open_activity_list, 'normal_date_start', 'normal_time_start', SORT_ASC);
}

$today = $timedate->handle_offset('today', $timedate->dbDayFormat.' '.$timedate->dbTimeFormat, false);
$todayOffset = $timedate->handleOffsetMax('today', $timedate->dbDayFormat.' '.$timedate->dbTimeFormat, true);

foreach($open_activity_list as $activity) {
	$concatActDate = $activity['normal_date_start'].' '.$activity['normal_time_start'];

	if($concatActDate < $today) {
		$time = "<font class='overdueTask'>".$activity['date_start'].' '.$activity['time_start']."</font>";
	} elseif(($concatActDate >= $todayOffset['min']) && ($concatActDate <= $todayOffset['max'])) {
		$time = "<font class='todaysTask'>".$activity['date_start'].' '.$activity['time_start']."</font>";
	} else {
		$time = "<font class='futureTask'>".$activity['date_start'].' '.$activity['time_start']."</font>";
	}

	$activity_fields = array(
		'ID'			=> $activity['id'],
		'NAME'			=> $activity['name'],
		'TYPE'			=> $activity['type'],
		'MODULE'		=> $activity['module'],
		'STATUS'		=> $activity['status'],
		'CONTACT_NAME'	=> $activity['contact_name'],
		'CONTACT_ID'	=> $activity['contact_id'],
		'PARENT_TYPE'	=> $activity['parent_type'],
		'PARENT_NAME'	=> $activity['parent_name'],
		'PARENT_ID'		=> $activity['parent_id'],
		'TIME'			=> $time,
		'TAG'			=> $activity['tag'],
	);

	switch ($activity['parent_type']) {
		case 'Accounts':
			$activity_fields['PARENT_MODULE'] = 'Accounts';
			break;
		case 'Cases':
			$activity_fields['PARENT_MODULE'] = 'Cases';
			break;
		case 'Opportunities':
			$activity_fields['PARENT_MODULE'] = 'Opportunities';
			break;
		case 'Quotes':
			$activity_fields['PARENT_MODULE'] = 'Quotes';
			break;
	}
	switch ($activity['type']) {
		case 'Call':
			$activity_fields['SET_COMPLETE'] = "<a href='index.php?return_module=$currentModule&return_action=$action&return_id=" . ((is_object($focus) && ! empty($focus->id)) ? $focus->id : "")."&action=EditView&module=Calls&status=Held&record=".$activity['id']."&status=Held'>".SugarThemeRegistry::current()->getImage("close_inline","title=".translate('LBL_LIST_CLOSE','Activities')." border='0'", null, null, '.gif', $mod_strings['LBL_LIST_CLOSE'])."</a>";
			break;
		case 'Meeting':
			$activity_fields['SET_COMPLETE'] = "<a href='index.php?return_module=$currentModule&return_action=$action&return_id=" . ((is_object($focus) && ! empty($focus->id)) ? $focus->id : "")."&action=EditView&module=Meetings&status=Held&record=".$activity['id']."&status=Held'>".SugarThemeRegistry::current()->getImage("close_inline","title=".translate('LBL_LIST_CLOSE','Activities')." border='0'",null,null,'.gif',$mod_strings['LBL_LIST_CLOSE'])."</a>";
			break;
	}

	if (! empty($activity['accept_status'])) {
		if ( $activity['accept_status'] == 'none') {
			$activity_fields['SET_ACCEPT_LINKS'] = "<div id=\"accept".$activity['id']."\"><a title=\"".$app_list_strings['dom_meeting_accept_options']['accept']."\" href=\"javascript:setAcceptStatus('".$activity_fields['MODULE']."','".$activity['id']."','accept');\">". SugarThemeRegistry::current()->getImage("accept_inline","title='".$app_list_strings['dom_meeting_accept_options']['accept']."' border='0'", null,null,'.gif',$mod_strings['LBL_ACCEPT']). "</a>&nbsp;<a title=\"".$app_list_strings['dom_meeting_accept_options']['tentative']."\" href=\"javascript:setAcceptStatus('".$activity_fields['MODULE']."','".$activity['id']."','tentative');\">".SugarThemeRegistry::current()->getImage("tentative_inline","alt='".$app_list_strings['dom_meeting_accept_options']['tentative']."' border='0'", null,null,'.gif',$mod_strings['LBL_ACCEPT'])."</a>&nbsp;<a title=\"".$app_list_strings['dom_meeting_accept_options']['decline']."\" href=\"javascript:setAcceptStatus('".$activity_fields['MODULE']."','".$activity['id']."','decline');\">".SugarThemeRegistry::current()->getImage("decline_inline","alt='".$app_list_strings['dom_meeting_accept_options']['decline']."' border='0'", null,null,'.gif',$mod_strings['LBL_ACCEPT'])."</a></div>";
		} else {
			$activity_fields['SET_ACCEPT_LINKS'] = $app_list_strings['dom_meeting_accept_status'][$activity['accept_status']];
		}
	}

	$activity_fields['TITLE'] = '';
	if (!empty($activity['contact_name'])) {
		$activity_fields['TITLE'] .= $current_module_strings['LBL_LIST_CONTACT'].": ".$activity['contact_name'];
	}
	if (!empty($activity['parent_name'])) {
		$activity_fields['TITLE'] .= "\n".$app_list_strings['record_type_display'][$activity['parent_type']].": ".$activity['parent_name'];
	}

	$xtpl->assign("ACTIVITY_MODULE_PNG", SugarThemeRegistry::current()->getImage($activity_fields['MODULE'].'','border="0"', null,null,'.gif',$activity_fields['NAME']));
	$xtpl->assign("ACTIVITY", $activity_fields);
	$xtpl->assign("BG_HILITE", $hilite_bg);
	$xtpl->assign("BG_CLICK", $click_bg);

	if($oddRow) {
		$xtpl->assign("ROW_COLOR", 'oddListRow');
		$xtpl->assign("BG_COLOR", $odd_bg);
	} else {
		$xtpl->assign("ROW_COLOR", 'evenListRow');
		$xtpl->assign("BG_COLOR", $even_bg);
	}
	$oddRow = !$oddRow;
	$xtpl->parse("open_activity.row");
} // END FOREACH()

$xtpl->parse("open_activity");
if (count($open_activity_list)>0) $xtpl->out("open_activity");
else echo "<i>".$current_module_strings['NTC_NONE_SCHEDULED']."</i>";
?>