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


if(!ACLController::checkAccess('Calendar', 'list', true)){
	ACLController::displayNoAccess(true);
}

require_once('modules/Calendar/Calendar.php');
require_once('modules/Calendar/CalendarDisplay.php');
require_once("modules/Calendar/CalendarGrid.php");

global $cal_strings, $current_language;
$cal_strings = return_module_language($current_language, 'Calendar');

if(empty($_REQUEST['view'])){
    if (isset($_SESSION['CALENDAR_VIEW']) && in_array($_SESSION['CALENDAR_VIEW'], array("day","week","month","year","shared")))
    {
        $_REQUEST['view'] = $_SESSION['CALENDAR_VIEW'];
    }
    else
    {
        $_REQUEST['view'] = SugarConfig::getInstance()->get('calendar.default_view','week');
    }
}
$_SESSION['CALENDAR_VIEW'] = $_REQUEST['view'];

$cal = new Calendar($_REQUEST['view']);

if(in_array($cal->view,array('day','week','month'))){
	$cal->add_activities($GLOBALS['current_user']);	
}else if($cal->view == 'shared'){
	$cal->init_shared();	
	global $shared_user;				
	$shared_user = new User();	
	foreach($cal->shared_ids as $member){
		$shared_user->retrieve($member);
		$cal->add_activities($shared_user);
	}
}

if(in_array($cal->view, array("day","week","month","shared"))){
	$cal->load_activities();
}

if (!empty($_REQUEST['print']) && $_REQUEST['print'] == 'true') {
    $cal->setPrint(true);
}

$display = new CalendarDisplay($cal);
$display->display_title();
if($cal->view == "shared")
	$display->display_shared_html();
$display->display_calendar_header();
$display->display();
$display->display_calendar_footer();	

?>
