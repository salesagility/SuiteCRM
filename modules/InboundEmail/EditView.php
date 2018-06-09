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
require_once 'modules/AOP_Case_Updates/util.php';

$_REQUEST['edit']='true';

require_once('include/SugarFolders/SugarFolders.php');
require_once('include/templates/TemplateGroupChooser.php');

// GLOBALS
global $mod_strings;
global $app_strings;
global $app_list_strings;
global $current_user;

$focus = new InboundEmail();
$focus->checkImap();
$javascript = new Javascript();
$email = new Email();
/* Start standard EditView setup logic */

$domMailBoxType = $app_list_strings['dom_mailbox_type'];

if(isset($_REQUEST['record'])) {
	$GLOBALS['log']->debug("In InboundEmail edit view, about to retrieve record: ".$_REQUEST['record']);
	$result = $focus->retrieve($_REQUEST['record']);
    if($result == null)
    {
    	sugar_die($app_strings['ERROR_NO_RECORD']);
    }
}
else
{
    if(!empty($_REQUEST['mailbox_type']))
        $focus->mailbox_type = $_REQUEST['mailbox_type'];

    //Default to imap protocol for new accounts.
    $focus->protocol = 'imap';
}

if($focus->mailbox_type == 'bounce')
{
    unset($domMailBoxType['pick']);
    unset($domMailBoxType['createcase']);
}
else
    unset($domMailBoxType['bounce']);

$isDuplicate = isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == 'true';
if($isDuplicate) {
	$GLOBALS['log']->debug("isDuplicate found - duplicating record of id: ".$focus->id);
	$origin_id = $focus->id;
	$focus->id = "";
}

$GLOBALS['log']->info("InboundEmail Edit View");
/* End standard EditView setup logic */

/* Start custom setup logic */
// status drop down
$status = get_select_options_with_id_separate_key($app_list_strings['user_status_dom'],$app_list_strings['user_status_dom'], $focus->status);
// default MAILBOX value
if(empty($focus->mailbox)) {
	$mailbox = 'INBOX';
} else {
	$mailbox = $focus->mailbox;
}

// service options breakdown
$tls = '';
$notls = '';
$cert = '';
$novalidate_cert = '';
$ssl = '';
if(!empty($focus->service)) {
	// will always have 2 values: /tls || /notls and /validate-cert || /novalidate-cert
	$exServ = explode('::', $focus->service);
	if($exServ[0] == 'tls') {
		$tls = "CHECKED";
	} elseif($exServ[5] == 'notls') {
		$notls = "CHECKED";
	}
	if($exServ[1] == 'validate-cert') {
		$cert = "CHECKED";
	} elseif($exServ[4] == 'novalidate-cert') {
		$novalidate_cert = 'CHECKED';
	}
	if(isset($exServ[2]) && !empty($exServ[2]) && $exServ[2] == 'ssl') {
		$ssl = "CHECKED";
	}
}
$mark_read = '';
if($focus->delete_seen == 0 || empty($focus->delete_seen)) {
	$mark_read = 'CHECKED';
}

// mailbox type

if ($focus->is_personal) {
	array_splice($domMailBoxType, 1, 1);
} // if
$mailbox_type = get_select_options_with_id($domMailBoxType, $focus->mailbox_type);

// auto-reply email template
$email_templates_arr = get_bean_select_array(true, 'EmailTemplate','name', '','name',true);

if(!empty($focus->stored_options)) {
	$storedOptions = unserialize(base64_decode($focus->stored_options));
	$from_name = $storedOptions['from_name'];
	$from_addr = $storedOptions['from_addr'];

	$reply_to_name = (isset($storedOptions['reply_to_name'])) ? $storedOptions['reply_to_name'] : "";
	$reply_to_addr = (isset($storedOptions['reply_to_addr'])) ? $storedOptions['reply_to_addr'] : "";

	$trashFolder = (isset($storedOptions['trashFolder'])) ? $storedOptions['trashFolder'] : "";
	$sentFolder = (isset($storedOptions['sentFolder'])) ? $storedOptions['sentFolder'] : "";
	$distrib_method = (isset($storedOptions['distrib_method'])) ? $storedOptions['distrib_method'] : "";
    $distribution_user_id = (isset($storedOptions['distribution_user_id'])) ? $storedOptions['distribution_user_id'] : "";
    $distribution_user_name = (isset($storedOptions['distribution_user_name'])) ? $storedOptions['distribution_user_name'] : "";
    $distributionAssignOptions = (isset($storedOptions['distribution_options'])) ? $storedOptions['distribution_options'] : "";


	$create_case_email_template = (isset($storedOptions['create_case_email_template'])) ? $storedOptions['create_case_email_template'] : "";
	$email_num_autoreplies_24_hours = (isset($storedOptions['email_num_autoreplies_24_hours'])) ? $storedOptions['email_num_autoreplies_24_hours'] : $focus->defaultEmailNumAutoreplies24Hours;

	if($storedOptions['only_since']) {
		$only_since = 'CHECKED';
	} else {
		$only_since = '';
	}
	if(isset($storedOptions['filter_domain']) && !empty($storedOptions['filter_domain'])) {
		$filterDomain = $storedOptions['filter_domain'];
	} else {
		$filterDomain = '';
	}
	if(!isset($storedOptions['leaveMessagesOnMailServer']) || $storedOptions['leaveMessagesOnMailServer'] == 1) {
		$leaveMessagesOnMailServer = 1;
	} else {
		$leaveMessagesOnMailServer = 0;
	} // else
} else { // initialize empty vars for template
	$from_name = $current_user->name;
	$from_addr = $current_user->email1;
	$reply_to_name = '';
	$reply_to_addr = '';
	$only_since = '';
	$filterDomain = '';
	$trashFolder = '';
	$sentFolder = '';
	$distrib_method ='';
    $distribution_user_id = '';
    $distribution_user_name = '';
	$create_case_email_template='';
	$leaveMessagesOnMailServer = 1;
    $distributionAssignOptions = array();
	$email_num_autoreplies_24_hours = $focus->defaultEmailNumAutoreplies24Hours;
} // else

// return action
if(isset($focus->id)) {
	$return_action = 'DetailView';
    $validatePass = FALSE;
} else {
	$return_action = 'ListView';
    $validatePass = TRUE;
}

// javascript
$javascript->setSugarBean($focus);
$javascript->setFormName('EditView');

//If we are creating a duplicate, remove the email_password from being required since this
//can be derived from the InboundEmail we are duplicating from
// Bug 47863 - email_password shouldn't be required on a modified Inbound Email account
// either.
if(($isDuplicate || !$validatePass) && isset($focus->required_fields['email_password']))
{
   unset($focus->required_fields['email_password']);
}

$javascript->addRequiredFields();
$javascript->addFieldGeneric('email_user', 'alpha', $mod_strings['LBL_LOGIN'], true);
$javascript->addFieldGeneric('email_password', 'alpha', $mod_strings['LBL_PASSWORD'], $validatePass);
$javascript->addFieldRange('email_num_autoreplies_24_hours', 'int', $mod_strings['LBL_MAX_AUTO_REPLIES'], true, "", 1, $focus->maxEmailNumAutoreplies24Hours);

$r = $focus->db->query('SELECT value FROM config WHERE name = \'fromname\'');
$a = $focus->db->fetchByAssoc($r);
$default_from_name = $a['value'];
$r = $focus->db->query('SELECT value FROM config WHERE name = \'fromaddress\'');
$a = $focus->db->fetchByAssoc($r);
$default_from_addr = $a['value'];

/* End custom setup logic */


// TEMPLATE ASSIGNMENTS
if ($focus->mailbox_type == 'template') {
	$xtpl = new XTemplate('modules/InboundEmail/EmailAccountTemplateEditView.html');
} else {
	$xtpl = new XTemplate('modules/InboundEmail/EditView.html');
}
// if no IMAP libraries available, disable Save/Test Settings
if(!function_exists('imap_open')) {
	$xtpl->assign('IE_DISABLED', 'DISABLED');
}
// standard assigns
$xtpl->assign('MOD', $mod_strings);
$xtpl->assign('APP', $app_strings);
$xtpl->assign('THEME', SugarThemeRegistry::current()->__toString());
$xtpl->assign('GRIDLINE', $gridline);
$xtpl->assign('MODULE', 'InboundEmail');
$xtpl->assign('RETURN_MODULE', 'InboundEmail');
$xtpl->assign('RETURN_ID', $focus->id);
$xtpl->assign('RETURN_ACTION', $return_action);
// module specific
//$xtpl->assign('ROLLOVER', $email->rolloverStyle);
$xtpl->assign("EMAIL_OPTIONS", $mod_strings['LBL_EMAIL_OPTIONS']);
$xtpl->assign('MODULE_TITLE', getClassicModuleTitle('InboundEmail', array($mod_strings['LBL_MODULE_NAME'],$focus->name), true));
$xtpl->assign('ID', $focus->id);
$xtpl->assign('NAME', $focus->name);
$xtpl->assign('STATUS', $status);
$xtpl->assign('SERVER_URL', $focus->server_url);
$xtpl->assign('USER', $focus->email_user);
$xtpl->assign('ORIGIN_ID', isset($origin_id)?$origin_id:'');
// Don't send password back
$xtpl->assign('HAS_PASSWORD', empty($focus->email_password)?0:1);
$xtpl->assign('TRASHFOLDER', $trashFolder);
$xtpl->assign('SENTFOLDER', $sentFolder);
$xtpl->assign('MAILBOX', $mailbox);
$xtpl->assign('TLS', $tls);
$xtpl->assign('NOTLS', $notls);
$xtpl->assign('CERT', $cert);
$xtpl->assign('NOVALIDATE_CERT', $novalidate_cert);
$xtpl->assign('SSL', $ssl);

$protocol = filterInboundEmailPopSelection($app_list_strings['dom_email_server_type']);
$xtpl->assign('PROTOCOL', get_select_options_with_id($protocol, $focus->protocol));
$xtpl->assign('MARK_READ', $mark_read);
$xtpl->assign('MAILBOX_TYPE', $focus->mailbox_type);
$xtpl->assign('TEMPLATE_ID', $focus->template_id);
$xtpl->assign('EMAIL_TEMPLATE_OPTIONS', get_select_options_with_id($email_templates_arr, $focus->template_id));
$xtpl->assign('ONLY_SINCE', $only_since);
$xtpl->assign('FILTER_DOMAIN', $filterDomain);
$xtpl->assign('EMAIL_NUM_AUTOREPLIES_24_HOURS', $email_num_autoreplies_24_hours);
if(!empty($focus->port)) {
	$xtpl->assign('PORT', $focus->port);
}
// groups
$groupId = "";
$is_auto_import = "";
$allow_outbound = '';
if(isset($focus->id))
	$groupId = $focus->group_id;
else
{
	$groupId = create_guid();
	$is_auto_import = 'checked';
    $xtpl->assign('EMAIL_PASS_REQ_SYMB', $app_strings['LBL_REQUIRED_SYMBOL']);
}

$xtpl->assign('GROUP_ID', $groupId);
// auto-reply stuff
$xtpl->assign('FROM_NAME', $from_name);
$xtpl->assign('FROM_ADDR', $from_addr);
$xtpl->assign('DEFAULT_FROM_NAME', $default_from_name);
$xtpl->assign('DEFAULT_FROM_ADDR', $default_from_addr);
$xtpl->assign('REPLY_TO_NAME', $reply_to_name);
$xtpl->assign('REPLY_TO_ADDR', $reply_to_addr);
$createCaseRowStyle = "display:none";
if($focus->template_id) {
	$xtpl->assign("EDIT_TEMPLATE","visibility:inline");
} else {
	$xtpl->assign("EDIT_TEMPLATE","visibility:hidden");
}
if($focus->port == 110 || $focus->port == 995) {
	$xtpl->assign('DISPLAY', "display:''");
} else {
	$xtpl->assign('DISPLAY', "display:none");
}
$leaveMessagesOnMailServerStyle = "display:none";
if($focus->is_personal) {
	$xtpl->assign('DISABLE_GROUP', 'DISABLED');
	$xtpl->assign('EDIT_GROUP_FOLDER_STYLE', "display:none");
	$xtpl->assign('CREATE_GROUP_FOLDER_STYLE', "display:none");
	$xtpl->assign('MAILBOX_TYPE_STYLE', "display:none");
	$xtpl->assign('AUTO_IMPORT_STYLE', "display:none");
} else {
	$folder = new SugarFolder();
	$xtpl->assign('CREATE_GROUP_FOLDER_STYLE', "display:''");
	$xtpl->assign('MAILBOX_TYPE_STYLE', "display:''");
	$xtpl->assign('AUTO_IMPORT_STYLE', "display:''");
	$ret = $folder->getFoldersForSettings($current_user);

	//For existing records, do not allow
	$is_auto_import_disabled = "";
	if (!empty($focus->groupfolder_id))
	{
		$is_auto_import = "checked";
	    $xtpl->assign('EDIT_GROUP_FOLDER_STYLE', "visibility:inline");
		$leaveMessagesOnMailServerStyle = "display:''";
		$allow_outbound = (isset($storedOptions['allow_outbound_group_usage']) && $storedOptions['allow_outbound_group_usage'] == 1) ? 'CHECKED'  : '';
	}
	else
	{
		$xtpl->assign('EDIT_GROUP_FOLDER_STYLE', "visibility:hidden");
	}

	$xtpl->assign('ALLOW_OUTBOUND_USAGE', $allow_outbound);
	$xtpl->assign('IS_AUTO_IMPORT', $is_auto_import);

	if ($focus->isMailBoxTypeCreateCase())
		$createCaseRowStyle = "display:''";

}


$xtpl->assign('hasGrpFld',$focus->groupfolder_id == null ? '' : 'checked="1"');
$xtpl->assign('LEAVEMESSAGESONMAILSERVER_STYLE', $leaveMessagesOnMailServerStyle);
$xtpl->assign('LEAVEMESSAGESONMAILSERVER', get_select_options_with_id($app_list_strings['dom_int_bool'], $leaveMessagesOnMailServer));

$distributionMethod = get_select_options_with_id($app_list_strings['dom_email_distribution_for_auto_create'], $distrib_method);
$xtpl->assign('DISTRIBUTION_METHOD', $distributionMethod);
$xtpl->assign('DISTRIBUTION_OPTIONS', getAOPAssignField('distribution_options',$distributionAssignOptions));
$xtpl->assign('distribution_user_name', $distribution_user_name);
$xtpl->assign('distribution_user_id', $distribution_user_id);



$xtpl->assign('CREATE_CASE_ROW_STYLE', $createCaseRowStyle);
$xtpl->assign('CREATE_CASE_EMAIL_TEMPLATE_OPTIONS', get_select_options_with_id($email_templates_arr, $create_case_email_template));
if(!empty($create_case_email_template)) {
	$xtpl->assign("CREATE_CASE_EDIT_TEMPLATE","visibility:inline");
} else {
	$xtpl->assign("CREATE_CASE_EDIT_TEMPLATE","visibility:hidden");
}

// Email Reply Assignment
$xtpl->assign('REPLY_ASSIGNING_BEHAVIOR', get_select_options_with_id($app_list_strings['inboundmail_assign_replies_to_admin'], $focus->assignment_behavior));

$quicksearch_js = "";

//$javascript = get_set_focus_js(). $javascript->getScript() . $quicksearch_js;
$xtpl->assign('JAVASCRIPT', get_set_focus_js(). $javascript->getScript() . $quicksearch_js);

require_once('include/Smarty/plugins/function.sugar_help.php');
$tipsStrings = array(
    'LBL_SSL_DESC',
    'LBL_ASSIGN_TO_TEAM_DESC',
    'LBL_ASSIGN_TO_GROUP_FOLDER_DESC',
    'LBL_FROM_ADDR_DESC',
    'LBL_CREATE_CASE_HELP',
    'LBL_CREATE_CASE_REPLY_TEMPLATE_HELP',
    'LBL_ALLOW_OUTBOUND_GROUP_USAGE_DESC',
    'LBL_AUTOREPLY_HELP',
    'LBL_FILTER_DOMAIN_DESC',
    'LBL_MAX_AUTO_REPLIES_DESC',
    'LBL_REPLY_ASSIGNING_BEHAVIOR_HELP',
);
$smarty = null;
$tips = array();
foreach ($tipsStrings as $string)
{
    if (!empty($mod_strings[$string]))
    {
        $tips[$string] = smarty_function_sugar_help(array(
            'text' => $mod_strings[$string]
        ), $smarty);
    }
}
$xtpl->assign('TIPS', $tips);

// WINDOWS work arounds
//if(is_windows()) {
//	$xtpl->assign('MAYBE', '<style> div.maybe { display:none; }</style>');
//}
// PARSE AND PRINT
//Overrides for bounce mailbox accounts
if ($focus->mailbox_type == 'bounce')
{
    $xtpl->assign('MODULE_TITLE', getClassicModuleTitle('InboundEmail', array($mod_strings['LBL_BOUNCE_MODULE_NAME'],$focus->name), true));
    $xtpl->assign("EMAIL_OPTIONS", $mod_strings['LBL_EMAIL_BOUNCE_OPTIONS']);
    $xtpl->assign('MAILBOX_TYPE_STYLE', "display:none");
    $xtpl->assign('AUTO_IMPORT_STYLE', "display:none");
}
elseif ($focus->mailbox_type == 'createcase')
    $xtpl->assign("IS_CREATE_CASE", 'checked');

else if( $focus->is_personal == '1')
     $xtpl->assign('MODULE_TITLE', getClassicModuleTitle('InboundEmail', array($mod_strings['LBL_PERSONAL_MODULE_NAME'],$focus->name), true));

//else


$xtpl->parse("main");
$xtpl->out("main");

?>
<script>

    function hideElem(id){
        if(document.getElementById(id)){
            document.getElementById(id).style.display = "none";
        }
    }

    function showElem(id){
        if(document.getElementById(id)){
            document.getElementById(id).style.display = "";
        }
    }

    function assign_field_change(field){
        hideElem(field + '[1]');
        hideElem(field + '[2]');

        if(document.getElementById(field + '[0]').value == 'role'){
            showElem(field + '[2]');
        }
        else if(document.getElementById(field + '[0]').value == 'security_group'){
            showElem(field + '[1]');
            showElem(field + '[2]');
        }
    }
    function displayDistributionOptions(display){
        if(display) {
            $('#distribution_options\\[0\\]').show();
            $('#distribution_options\\[1\\]').show();
            $('#distribution_options\\[2\\]').show();
            assign_field_change('distribution_options');
        }else{
            $('#distribution_options\\[0\\]').hide();
            $('#distribution_options\\[1\\]').hide();
            $('#distribution_options\\[2\\]').hide();
        }
    }

    function displayDistributionUser(display){
        if(display) {
            $('#distribution_user').show();
        }else{
            $('#distribution_user').hide();
        }
    }
    $(document).ready(function(){
        displayDistributionOptions(false);
        $('#distrib_method').change(function(){
            var val = $('#distrib_method').val();
            switch(val){
                case 'roundRobin':
                case 'leastBusy':
                case 'random':
                    displayDistributionOptions(true);
                    displayDistributionUser(false);
                    break;
                case 'singleUser':
                    displayDistributionOptions(false);
                    displayDistributionUser(true);
                    break;
                case 'AOPDefault':
                default:
                    displayDistributionOptions(false);
                    displayDistributionUser(false);
                    break;
            }
        });
        $('#distrib_method').change();
    });
</script>
