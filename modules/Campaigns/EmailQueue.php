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







global $timedate;
global $current_user;


$campaign = new Campaign();
$campaign->retrieve($_REQUEST['record']);

$query = "SELECT prospect_list_id as id FROM prospect_list_campaigns WHERE campaign_id='$campaign->id' AND deleted=0";

$fromName = $_REQUEST['from_name'];
$fromEmail = $_REQUEST['from_address'];
$date_start = $_REQUEST['date_start'];
$time_start = $_REQUEST['time_start'];
$template_id = $_REQUEST['email_template'];

$dateval = $timedate->merge_date_time($date_start, $time_start);


$listresult = $campaign->db->query($query);

while($list = $campaign->db->fetchByAssoc($listresult))
{
	$prospect_list = $list['id'];
	$focus = new ProspectList();
	
	$focus->retrieve($prospect_list);

	$query = "SELECT prospect_id,contact_id,lead_id FROM prospect_lists_prospects WHERE prospect_list_id='$focus->id' AND deleted=0";
	$result = $focus->db->query($query);

	while($row = $focus->db->fetchByAssoc($result))
	{
		$prospect_id = $row['prospect_id'];
		$contact_id = $row['contact_id'];
		$lead_id = $row['lead_id'];
		
		if($prospect_id <> '')
		{
			$moduleName = "Prospects";
			$moduleID = $row['prospect_id'];
		}
		if($contact_id <> '')
		{
			$moduleName = "Contacts";
			$moduleID = $row['contact_id'];
		}
		if($lead_id <> '')
		{
			$moduleName = "Leads";
			$moduleID = $row['lead_id'];
		}
		
		$mailer = new EmailMan();
		$mailer->module = $moduleName;
		$mailer->module_id = $moduleID;
		$mailer->user_id = $current_user->id;
		$mailer->list_id = $prospect_list;
		$mailer->template_id = $template_id;
		$mailer->from_name = $fromName;
		$mailer->from_email = $fromEmail;
		$mailer->send_date_time = $dateval;
		$mailer->save();
	}
	
	
}


$header_URL = "Location: index.php?action=DetailView&module=Campaigns&record={$_REQUEST['record']}";
$GLOBALS['log']->debug("about to post header URL of: $header_URL");
SugarApplication::headerRedirect($header_URL);
