<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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

/*********************************************************************************

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/






global $app_strings;
global $mod_strings;

$focus = new CampaignTracker();
$focus->retrieve($_REQUEST['record']);

if (isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == 'true') {
    $focus->id = "";
}

echo getClassicModuleTitle($mod_strings['LBL_MODULE_NAME'], array($mod_strings['LBL_MODULE_NAME'],$focus->tracker_name), true);



$GLOBALS['log']->info("campaign tracker detail view");

$xtpl=new XTemplate('modules/CampaignTrackers/DetailView.html');
$xtpl->assign("MOD", $mod_strings);
$xtpl->assign("APP", $app_strings);

if (isset($_REQUEST['return_module'])) {
    $xtpl->assign("RETURN_MODULE", $_REQUEST['return_module']);
} else {
    $xtpl->assign("RETURN_MODULE", 'Campaigns');
}
if (isset($_REQUEST['return_action'])) {
    $xtpl->assign("RETURN_ACTION", $_REQUEST['return_action']);
} else {
    $xtpl->assign("RETURN_ACTION", 'DetailView');
}
if (isset($_REQUEST['return_id'])) {
    $xtpl->assign("RETURN_ID", $_REQUEST['return_id']);
} else {
    $xtpl->assign("RETURN_ID", $focus->campaign_id);
}
 
$xtpl->assign("GRIDLINE", $gridline);
$xtpl->assign("PRINT_URL", "index.php?".$GLOBALS['request_string']);
$xtpl->assign("ID", $focus->id);
if (!empty($_REQUEST['campaign_name'])) {
    $xtpl->assign("CAMPAIGN_NAME", $_REQUEST['campaign_name']);
} else {
    $xtpl->assign("CAMPAIGN_NAME", $focus->campaign_name);
}

if (!empty($_REQUEST['campaign_id'])) {
    $xtpl->assign("CAMPAIGN_ID", $_REQUEST['campaign_id']);
} else {
    $xtpl->assign("CAMPAIGN_ID", $focus->campaign_id);
}
$xtpl->assign("TRACKER_NAME", $focus->tracker_name);
$xtpl->assign("TRACKER_URL", $focus->tracker_url);
$xtpl->assign("MESSAGE_URL", $focus->message_url);
$xtpl->assign("TRACKER_KEY", $focus->tracker_key);

if (!empty($focus->is_optout) && $focus->is_optout == 1) {
    $xtpl->assign("IS_OPTOUT_CHECKED", "checked");
}


//$xtpl->assign("CREATED_BY", $focus->created_by_name);
//$xtpl->assign("MODIFIED_BY", $focus->modified_by_name);
//$xtpl->assign("DATE_MODIFIED", $focus->date_modified);
//$xtpl->assign("DATE_ENTERED", $focus->date_entered);

$xtpl->parse("main");
$xtpl->out("main");
