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


require_once('include/DetailView/DetailView.php');

require_once('include/SugarFolders/SugarFolders.php');


global $mod_strings;
global $app_strings;
global $sugar_config;
global $timedate;
global $theme;

/* start standard DetailView layout process */
$GLOBALS['log']->info("InboundEmails DetailView");
$focus = new InboundEmail();
$focus->retrieve($_REQUEST['record']);
if (empty($focus->id)) {
	sugar_die($app_strings['ERROR_NO_RECORD']);
} // if
$focus->checkImap();
$detailView = new DetailView();
$offset=0;



/* end standard DetailView layout process */
$exServ = explode('::',$focus->service);
if($focus->delete_seen == 1) {
	$delete_seen = $mod_strings['LBL_MARK_READ_NO'];
} else {
	$delete_seen = $mod_strings['LBL_MARK_READ_YES'];
}

// deferred
//$r = $focus->db->query("SELECT id, name FROM queues WHERE owner_id = '".$focus->id."'");
//$a = $focus->db->fetchByAssoc($r);
//$queue = '<a href="index.php?module=Queues&action=EditView&record='.$a['id'].'">'.$a['name'].'</a>';
$groupName = '';
if($focus->group_id) {
	
	//$group = new Group();
	//$group->retrieve($focus->group_id);
	//$groupName = $group->user_name;
}

if($focus->template_id) {
	
	$et = new EmailTemplate();
	$et->retrieve($focus->template_id);
	$emailTemplate = $et->name;
} else {
	$emailTemplate = $mod_strings['LBL_NONE'];
}
$ssl = $app_list_strings['dom_email_bool']['bool_false'];
$allow_outbound_group_usage = $app_list_strings['dom_email_bool']['bool_false'];
$tls = $app_list_strings['dom_email_bool']['bool_false'];
$ca = $app_list_strings['dom_email_bool']['bool_false'];
if(!empty($focus->service)) {
	// will always have 2 values: /tls || /notls and /validate-cert || /novalidate-cert
	$exServ = explode('::', $focus->service);
	if($exServ[0] == 'tls') {
		$tls = $app_list_strings['dom_email_bool']['bool_true'];
	}
	if($exServ[1] == 'validate-cert') {
		$cert = $app_list_strings['dom_email_bool']['bool_true'];
	}
	if(isset($exServ[2]) && !empty($exServ[2]) && $exServ[2] == 'ssl') {
		$ssl = $app_list_strings['dom_email_bool']['bool_true'];
	}
}

// FROM NAME FROM ADDRESS STRINGS
$email = new Email();
$from = $email->getSystemDefaultEmail();
$default_from_name = $from['name'];
$default_from_addr = $from['email'];
$from_name = '';
$from_addr = '';
$reply_to_name = '';
$reply_to_addr = '';
$distrib_method ='';
$filterDomain = '';
$trashFolder = '';
$sentFolder = '';
$distributionMethod = '';
$create_case_email_template='';
$create_case_email_template_name = $mod_strings['LBL_NONE'];
$leaveMessagesOnMailServer = $app_strings['LBL_EMAIL_NO'];

//$fromNameAddr = $fromName.' &lt;'.$from['email'].'&gt; <br><em>('.$mod_strings['LBL_SYSTEM_DEFAULT'].')</em>';
//$replyNameAddr = $mod_strings['LBL_SAME_AS_ABOVE'];
$onlySince = $mod_strings['LBL_ONLY_SINCE_NO'];

if(!empty($focus->stored_options)) {
	// FROM NAME and Address
	$storedOptions = unserialize(base64_decode($focus->stored_options));

	$from_name = (isset($storedOptions['from_name']) ? $storedOptions['from_name'] : "");
	$from_addr = (isset($storedOptions['from_addr']) ? $storedOptions['from_addr'] : "");

	$reply_to_name = (isset($storedOptions['reply_to_name'])) ? $storedOptions['reply_to_name'] : "";
	$reply_to_addr = (isset($storedOptions['reply_to_addr'])) ? $storedOptions['reply_to_addr'] : "";
		// only-since option
	if($storedOptions['only_since']) {
		$onlySince = $mod_strings['LBL_ONLY_SINCE_YES'];
	} else {
		$onlySince = $mod_strings['LBL_ONLY_SINCE_NO'];
	}
	// filter-domain
	if(isset($storedOptions['filter_domain']) && !empty($storedOptions['filter_domain'])) {
		$filterDomain = $storedOptions['filter_domain'];
	} else {
		$filterDomain = $app_strings['NTC_NO_ITEMS_DISPLAY'];
	}
	// Trash Folder
	if(isset($storedOptions['trashFolder']) && !empty($storedOptions['trashFolder'])) {
		$trashFolder = $storedOptions['trashFolder'];
	} else {
		$trashFolder = $mod_strings['LBL_NONE'];
	}
	// Sent Folder
	if(isset($storedOptions['sentFolder']) && !empty($storedOptions['sentFolder'])) {
		$sentFolder = $storedOptions['sentFolder'];
	} else {
		$sentFolder = $mod_strings['LBL_NONE'];
	}

	if(!isset($storedOptions['leaveMessagesOnMailServer']) || $storedOptions['leaveMessagesOnMailServer'] == 1) {
		$leaveMessagesOnMailServer = $app_strings['LBL_EMAIL_YES'];
	} else {
		$leaveMessagesOnMailServer = $app_strings['LBL_EMAIL_NO'];
	} // else
	if(!isset($storedOptions['leaveMessagesOnMailServer']) || $storedOptions['leaveMessagesOnMailServer'] == 1) {
		$leaveMessagesOnMailServer = $app_strings['LBL_EMAIL_YES'];
	} else {
		$leaveMessagesOnMailServer = $app_strings['LBL_EMAIL_NO'];
	} // else
	$distrib_method = (isset($storedOptions['distrib_method'])) ? $storedOptions['distrib_method'] : "";
	$create_case_email_template = (isset($storedOptions['create_case_email_template'])) ? $storedOptions['create_case_email_template'] : "";
	$email_num_autoreplies_24_hours = (isset($storedOptions['email_num_autoreplies_24_hours'])) ? $storedOptions['email_num_autoreplies_24_hours'] : $focus->defaultEmailNumAutoreplies24Hours;
    
	if( isset($storedOptions['allow_outbound_group_usage']) && $storedOptions['allow_outbound_group_usage'] == 1) 
	   $allow_outbound_group_usage = $app_list_strings['dom_email_bool']['bool_true'];
	
}

if(!empty($create_case_email_template)) {
	
	$et = new EmailTemplate();
	$et->retrieve($create_case_email_template);
	$create_case_email_template_name = $et->name;
}
if (!empty($distrib_method)) {
	$distributionMethod = $app_list_strings['dom_email_distribution_for_auto_create'][$distrib_method];
} // if
$xtpl = new XTemplate('modules/InboundEmail/DetailView.html');
////	ERRORS from Save
if(isset($_REQUEST['error'])) {
	$xtpl->assign('ERROR', "<div class='error'>".$mod_strings['ERR_NO_OPTS_SAVED']."</div>");
}
//cma, June 24,2008 - Fix bug 21670. User status and group/personal statements are not localized.
$userStatus = $mod_strings['LBL_STATUS_ACTIVE'];
if('Inactive' == $focus->status) {
    $userStatus = $mod_strings['LBL_STATUS_INACTIVE'];
}

$xtpl->assign('MODULE_TITLE', getClassicModuleTitle('InboundEmail', array($mod_strings['LBL_MODULE_NAME'],$focus->name), true));
$xtpl->assign('MOD', $mod_strings);
$xtpl->assign('APP', $app_strings);
$xtpl->assign('CREATED_BY', $focus->created_by_name);
$xtpl->assign('MODIFIED_BY', $focus->modified_by_name);
$xtpl->assign('GRIDLINE', $gridline);
$xtpl->assign('PRINT_URL', 'index.php?'.$GLOBALS['request_string']);
$xtpl->assign('ID', $focus->id);
$xtpl->assign('STATUS', $userStatus);
$xtpl->assign('SERVER_URL', $focus->server_url);
$xtpl->assign('USER', $focus->email_user);
$xtpl->assign('NAME', $focus->name);
$xtpl->assign('MAILBOX', $focus->mailbox);
$xtpl->assign('TRASHFOLDER', $trashFolder);
$xtpl->assign('SENTFOLDER', $sentFolder);

$protocol = filterInboundEmailPopSelection($app_list_strings['dom_email_server_type']);
$xtpl->assign('SERVER_TYPE', $protocol[$focus->protocol]);
$xtpl->assign('SSL', $ssl);
$xtpl->assign('TLS', $tls);
$xtpl->assign('CERT', $ca);
$xtpl->assign('MARK_READ', $delete_seen);
$xtpl->assign('ALLOW_OUTBOUND_GROUP_USAGE', $allow_outbound_group_usage);

// deferred
//$xtpl->assign('QUEUE', $queue);
$createCaseRowStyle = "display:none";
$leaveMessagesOnMailServerStyle = "display:none";
if ($focus->is_personal) {
	$xtpl->assign('EDIT_GROUP_FOLDER_STYLE', "display:none");
} else {
	$is_auto_import = $app_list_strings['checkbox_dom']['2'];
	
	if (!empty($focus->groupfolder_id)) {
		$is_auto_import = $app_list_strings['checkbox_dom']['1'];
		$leaveMessagesOnMailServerStyle = "display:''";
	} // if
	$xtpl->assign('IS_AUTO_IMPORT_ENABLED', $is_auto_import);
	$xtpl->assign('EDIT_GROUP_FOLDER_STYLE', "display:''");
	if ($focus->isMailBoxTypeCreateCase()) {
		$createCaseRowStyle = "display:''";
	}

}
$xtpl->assign('LEAVEMESSAGESONMAILSERVER_STYLE', $leaveMessagesOnMailServerStyle);
$xtpl->assign('LEAVEMESSAGESONMAILSERVER', $leaveMessagesOnMailServer);
$xtpl->assign('CREATE_CASE_ROW_STYLE', $createCaseRowStyle);
$xtpl->assign('DISTRIBUTION_METHOD', $distributionMethod);
$xtpl->assign('CREATE_CASE_EMAIL_TEMPLATE', $create_case_email_template_name);
if ($focus->isPop3Protocol()) {
	$xtpl->assign('TRASH_SENT_FOLDER_STYLE', "display:none");
} else {
	$xtpl->assign('TRASH_SENT_FOLDER_STYLE', "display:''");
} // else

$possibleAction = "pick";
if (!isset($app_list_strings['dom_mailbox_type'][$focus->mailbox_type])) {
	$possibleAction = $app_list_strings['dom_mailbox_type']['pick'];
} else {
	$possibleAction = $app_list_strings['dom_mailbox_type'][$focus->mailbox_type];
}

if($focus->mailbox_type == 'createcase')
    $is_create_case = $app_list_strings['checkbox_dom']['1'];
else 
    $is_create_case = $app_list_strings['checkbox_dom']['2'];


$xtpl->assign('GROUP_NAME', $groupName);
$xtpl->assign('IS_CREATE_CASE', $is_create_case);
$xtpl->assign('EMAIL_TEMPLATE', $emailTemplate);
$xtpl->assign('FROM_NAME', $from_name);
$xtpl->assign('FROM_ADDR', $from_addr);
$xtpl->assign('DEFAULT_FROM_NAME', $default_from_name);
$xtpl->assign('DEFAULT_FROM_ADDR', $default_from_addr);
$xtpl->assign('REPLY_TO_NAME', $reply_to_name);
$xtpl->assign('REPLY_TO_ADDR', $reply_to_addr);
$xtpl->assign('ONLY_SINCE', $onlySince);
$xtpl->assign('FILTER_DOMAIN', $filterDomain);
$xtpl->assign('EMAIL_NUM_AUTOREPLIES_24_HOURS', $email_num_autoreplies_24_hours);
if(!empty($focus->port)) {
	$xtpl->assign('PORT', $focus->port);
}
if($focus->handleIsPersonal()) {
	$xtpl->assign('LBL_GROUP_QUEUE', $mod_strings['LBL_ASSIGN_TO_USER']);
} else {
	$xtpl->assign('LBL_GROUP_QUEUE', $mod_strings['LBL_GROUP_QUEUE']);
}

//Overrides for bounce mailbox accounts
if ($focus->mailbox_type == 'bounce')
{
    $xtpl->assign('MODULE_TITLE', getClassicModuleTitle('InboundEmail', array($mod_strings['LBL_BOUNCE_MODULE_NAME'],$focus->name), true));
}
else if( $focus->is_personal == '1')
     $xtpl->assign('MODULE_TITLE', getClassicModuleTitle('InboundEmail', array($mod_strings['LBL_PERSONAL_MODULE_NAME'],$focus->name), true));

$xtpl->parse('main');
$xtpl->out('main');
?>