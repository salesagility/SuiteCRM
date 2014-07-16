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

///////////////////////////////////////////////////////////////////////////////
////	CANCEL HANDLING
if(!isset($_REQUEST['record']) || empty($_REQUEST['record'])) {
	header("Location: index.php?module=Emails&action=index");
}
////	CANCEL HANDLING
///////////////////////////////////////////////////////////////////////////////


require_once('include/DetailView/DetailView.php');
global $gridline;
global $app_strings;
global $focus;

// SETTING DEFAULTS
$focus		= new Email();
$detailView	= new DetailView();
$offset		= 0;
$email_type	= 'archived';

///////////////////////////////////////////////////////////////////////////////
////	TO HANDLE 'NEXT FREE'
if(!empty($_REQUEST['next_free']) && $_REQUEST['next_free'] == true) {
	$_REQUEST['record'] = $focus->getNextFree();
}
////	END 'NEXT FREE'
///////////////////////////////////////////////////////////////////////////////

if (isset($_REQUEST['offset']) or isset($_REQUEST['record'])) {
	$result = $detailView->processSugarBean("EMAIL", $focus, $offset);
	if($result == null) {
	    sugar_die($app_strings['ERROR_NO_RECORD']);
	}
	$focus=$result;
} else {
	header("Location: index.php?module=Emails&action=index");
	die();
}

/* if the Email status is draft, say as a saved draft to a Lead/Case/etc.,
 * don't show detail view. go directly to EditView */
if($focus->status == 'draft') {
	//header('Location: index.php?module=Emails&action=EditView&record='.$_REQUEST['record']);
	//die();
}

// ACL Access Check
if (!$focus->ACLAccess('DetailView')){
	ACLController::displayNoAccess(true);
	sugar_cleanup(true);
}

//needed when creating a new email with default values passed in
if (isset($_REQUEST['contact_name']) && is_null($focus->contact_name)) {
	$focus->contact_name = $_REQUEST['contact_name'];
}
if (isset($_REQUEST['contact_id']) && is_null($focus->contact_id)) {
	$focus->contact_id = $_REQUEST['contact_id'];
}
if (isset($_REQUEST['opportunity_name']) && is_null($focus->parent_name)) {
	$focus->parent_name = $_REQUEST['opportunity_name'];
}
if (isset($_REQUEST['opportunity_id']) && is_null($focus->parent_id)) {
	$focus->parent_id = $_REQUEST['opportunity_id'];
}
if (isset($_REQUEST['account_name']) && is_null($focus->parent_name)) {
	$focus->parent_name = $_REQUEST['account_name'];
}
if (isset($_REQUEST['account_id']) && is_null($focus->parent_id)) {
	$focus->parent_id = $_REQUEST['account_id'];
}

// un/READ flags
if (!empty($focus->status)) {
	// "Read" flag for InboundEmail
	if($focus->status == 'unread') {
		// creating a new instance here to avoid data corruption below
		$e = new Email();
		$e->retrieve($focus->id);
		$e->status = 'read';
		$e->save();
		$email_type = $e->status;
	} else {
		$email_type = $focus->status;
	}

} elseif (!empty($_REQUEST['type'])) {
	$email_type = $_REQUEST['type'];
}


///////////////////////////////////////////////////////////////////////////////
////	OUTPUT
///////////////////////////////////////////////////////////////////////////////
echo "\n<p>\n";
$GLOBALS['log']->info("Email detail view");
$show_forward = true;
if ($email_type == 'archived') {
	echo getClassicModuleTitle('Emails', array($mod_strings['LBL_ARCHIVED_EMAIL'],$focus->name), true);
	$xtpl=new XTemplate ('modules/Emails/DetailView.html');
} else {
	$xtpl=new XTemplate ('modules/Emails/DetailViewSent.html');
	if($focus->type == 'out') {
		echo getClassicModuleTitle('Emails', array($mod_strings['LBL_SENT_MODULE_NAME'],$focus->name), true);
		//$xtpl->assign('DISABLE_REPLY_BUTTON', 'NONE');
	} elseif ($focus->type == 'draft') {
		$xtpl->assign('DISABLE_FORWARD_BUTTON', 'NONE');
        $show_forward = false;
		echo getClassicModuleTitle('Emails', array($mod_strings['LBL_LIST_FORM_DRAFTS_TITLE'],$focus->name), true);
	} elseif($focus->type == 'inbound') {
		echo getClassicModuleTitle('Emails', array($mod_strings['LBL_INBOUND_TITLE'],$focus->name), true);
	}
}
echo "\n</p>\n";



///////////////////////////////////////////////////////////////////////////////
////	RETURN NAVIGATION
$uri = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
$start = $focus->getStartPage($uri);
$ret_mod = '';
$ret_action = '';
if (isset($_REQUEST['return_id'])) { // coming from a subpanel, return_module|action is not set
	$xtpl->assign('RETURN_ID', $_REQUEST['return_id']);
	if (isset($_REQUEST['return_module'])){
        $xtpl->assign('RETURN_MODULE', $_REQUEST['return_module']);
        $ret_mod = $_REQUEST['return_module'];
    }
	else {
        $xtpl->assign('RETURN_MODULE', 'Emails');
        $ret_mod = 'Emails';
    }
	if (isset($_REQUEST['return_action'])){
        $xtpl->assign('RETURN_ACTION', $_REQUEST['return_action']);
        $ret_action = $_REQUEST['return_action'];
    }
	else {
        $xtpl->assign('RETURN_ACTION', 'DetailView');
        $ret_action = 'DetailView';
    }
}

if(isset($start['action']) && !empty($start['action'])) {
    $xtpl->assign('DELETE_RETURN_ACTION', $start['action']);
} else {
    $start['action'] = '';
}
if(isset($start['module']) && !empty($start['module'])) {
    $xtpl->assign('DELETE_RETURN_MODULE', $start['module']);
} else {
    $start['module'] = '';
}
if(isset($start['record']) && !empty($start['record'])) {
    $xtpl->assign('DELETE_RETURN_ID', $start['record']);
} else {
    $start['record'] = '';
}
// this is to support returning to My Inbox
if(isset($start['type']) && !empty($start['type'])) {
    $xtpl->assign('DELETE_RETURN_TYPE', $start['type']);
} else {
    $start['type'] = '';
}
if(isset($start['assigned_user_id']) && !empty($start['assigned_user_id'])) {
    $xtpl->assign('DELETE_RETURN_ASSIGNED_USER_ID', $start['assigned_user_id']);
} else {
    $start['assigned_user_id'] = '';
}



////	END RETURN NAVIGATION
///////////////////////////////////////////////////////////////////////////////


// DEFAULT TO TEXT IF NO HTML CONTENT:
$html = trim(from_html($focus->description_html));
if(empty($html)) {
	$xtpl->assign('SHOW_PLAINTEXT', 'true');
} else {
	$xtpl->assign('SHOW_PLAINTEXT', 'false');
}
$show_subpanels=true;
//if the email is of type campaign, process the macros...using the values stored in the relationship table.
//this is is part of the feature that adds support for one email per campaign.
if ($focus->type=='campaign' and !empty($_REQUEST['parent_id']) and !empty($_REQUEST['parent_module'])) {
    $show_subpanels=false;
    $parent_id=$_REQUEST['parent_id'];

	// cn: bug 14300 - emails_beans schema refactor - fixing query
	$query="SELECT * FROM emails_beans WHERE email_id='{$focus->id}' AND bean_id='{$parent_id}' AND bean_module = '{$_REQUEST['parent_module']}' " ;

    $res=$focus->db->query($query);
    $row=$focus->db->fetchByAssoc($res);
    if (!empty($row)) {
        $campaign_data=$row['campaign_data'];
        $macro_values=array();
        if (!empty($campaign_data)) {
            $macro_values=unserialize(from_html($campaign_data));
        }

        if (count($macro_values) > 0) {
            $m_keys=array_keys($macro_values);
            $m_values=array_values($macro_values);

            $focus->name = str_replace($m_keys,$m_values,$focus->name);
            $focus->description = str_replace($m_keys,$m_values,$focus->description);
            $focus->description_html = str_replace($m_keys,$m_values,$focus->description_html);
            if (!empty($macro_values['sugar_to_email_address'])) {
                $focus->to_addrs=$macro_values['sugar_to_email_address'];
            }
        }
    }
}
//if not empty or set to test (from test campaigns)
if (!empty($focus->parent_type) && $focus->parent_type !='test') {
	$xtpl->assign('PARENT_MODULE', $focus->parent_type);
	$xtpl->assign('PARENT_TYPE_UNTRANSLATE', $focus->parent_type);
    $xtpl->assign('PARENT_TYPE', $app_list_strings['record_type_display'][$focus->parent_type] . ':');
}

$to_addr = !empty($focus->to_addrs_names) ? htmlspecialchars($focus->to_addrs_names, ENT_COMPAT, 'UTF-8') : nl2br($focus->to_addrs);
$from_addr = !empty($focus->from_addr_name) ? htmlspecialchars($focus->from_addr_name, ENT_COMPAT, 'UTF-8') : nl2br($focus->from_addr);
$cc_addr = !empty($focus->cc_addrs_names) ? htmlspecialchars($focus->cc_addrs_names, ENT_COMPAT, 'UTF-8') : nl2br($focus->cc_addrs);
$bcc_addr = !empty($focus->bcc_addrs_names) ? htmlspecialchars($focus->bcc_addrs_names, ENT_COMPAT, 'UTF-8') : nl2br($focus->bcc_addrs);

$xtpl->assign('MOD', $mod_strings);
$xtpl->assign('APP', $app_strings);
$xtpl->assign('GRIDLINE', $gridline);
$xtpl->assign('PRINT_URL', 'index.php?'.$GLOBALS['request_string']);
$xtpl->assign('ID', $focus->id);
$xtpl->assign('TYPE', $email_type);
$xtpl->assign('PARENT_NAME', $focus->parent_name);
$xtpl->assign('PARENT_ID', $focus->parent_id);
$xtpl->assign('NAME', $focus->name);
$xtpl->assign('ASSIGNED_TO', $focus->assigned_user_name);
$xtpl->assign('DATE_MODIFIED', $focus->date_modified);
$xtpl->assign('DATE_ENTERED', $focus->date_entered);
$xtpl->assign('DATE_START', $focus->date_start);
$xtpl->assign('TIME_START', $focus->time_start);
$xtpl->assign('FROM', $from_addr);
$xtpl->assign('TO', $to_addr);
$xtpl->assign('CC', $cc_addr);
$xtpl->assign('BCC', $bcc_addr);
$xtpl->assign('CREATED_BY', $focus->created_by_name);
$xtpl->assign('MODIFIED_BY', $focus->modified_by_name);
$xtpl->assign('DATE_SENT', $focus->date_entered);
$xtpl->assign('EMAIL_NAME', 'RE: '.$focus->name);
$xtpl->assign("TAG", $focus->listviewACLHelper());

$show_raw = FALSE;
if(!empty($focus->raw_source)) {
    $xtpl->assign("RAW_METADATA", $focus->id);
    $show_raw = TRUE;
}

if(!empty($focus->reply_to_email)) {
	$replyTo = "
		<tr>
        <td class=\"tabDetailViewDL\"><slot>".$mod_strings['LBL_REPLY_TO_NAME']."</slot></td>
        <td colspan=3 class=\"tabDetailViewDF\"><slot>".$focus->reply_to_email."</slot></td>
        </tr>";
 	$xtpl->assign("REPLY_TO", $replyTo);
}



// Using action menu (new UI) instead of buttons for Archived Email DetailView.
$buttons = array(
    <<<EOD
            <input	title="{$app_strings['LBL_EDIT_BUTTON_TITLE']}" accessKey="{$app_strings['LBL_EDIT_BUTTON_KEY']}" class="button"
                    id="edit_button"
					onclick="	this.form.return_module.value='Emails';
								this.form.return_action.value='DetailView';
								this.form.return_id.value='{$focus->id}';
								this.form.action.value='EditView'"
					type="submit" name="Edit" value=" {$app_strings['LBL_EDIT_BUTTON_LABEL']}">
EOD
,
    <<<EOD
            <input title="{$app_strings['LBL_DELETE_BUTTON_TITLE']}"
					accessKey="{$app_strings['LBL_DELETE_BUTTON_KEY']}"
					class="button"
					id="delete_button"
					onclick="this.form.return_module.value='{$start['module']}';
											this.form.return_action.value='{$start['action']}';
											this.form.return_id.value='{$start['record']}';
											this.form.type.value='{$start['type']}';
											this.form.assigned_user_id.value='{$start['assigned_user_id']}';
											this.form.action.value='Delete';
											return confirm('{$app_strings['NTC_DELETE_CONFIRMATION']}')"
					type="submit" name="button"
					value="{$app_strings['LBL_DELETE_BUTTON_LABEL']}"
			>
EOD
);

// Bug #52046: Disable the 'Show Raw' link where it does not need to be shown.
if($show_raw) {
    $buttons[] = <<<EOD
        <input type="button" name="button" class="button"
            id="rawButton"
            title="{$mod_strings['LBL_BUTTON_RAW_TITLE']}"
            value="{$mod_strings['LBL_BUTTON_RAW_LABEL']}"
            onclick="open_popup('Emails', 800, 600, '', true, true, '', 'show_raw', '', '{$focus->id}');"
        />
EOD;
}

require_once('include/Smarty/plugins/function.sugar_action_menu.php');
$action_button = smarty_function_sugar_action_menu(array(
    'id' => 'detail_header_action_menu',
    'buttons' => $buttons,
    'class' => 'clickMenu fancymenu',
), $xtpl);

$xtpl->assign("ACTION_BUTTON", $action_button);

/////////
///Using action menu (new UI) instead of buttons for Sent Email DetailView.
$buttons_sent_email = array();
if($show_forward){
$buttons_sent_email[] = <<<EOD
            <input title="{$mod_strings['LBL_BUTTON_FORWARD']}"
					class="button" onclick="this.form.return_module.value='{$ret_mod}';
											this.form.return_action.value='{$ret_action}';
											this.form.return_id.value='{$focus->id}';
											this.form.action.value='EditView';
											this.form.type.value='forward'"
					type="submit" name="button"
					value="  {$mod_strings['LBL_BUTTON_FORWARD']}  "
					style="display:{DISABLE_FORWARD_BUTTON};"
			>
EOD;
}
$buttons_sent_email[] = <<<EOD
            <input title="{$mod_strings['LBL_BUTTON_REPLY_TITLE']}"
					class="button" onclick="this.form.return_module.value='{$ret_mod}';
											this.form.return_action.value='{$ret_action}';
											this.form.return_id.value='{$focus->id}';
											this.form.action.value='EditView';
											this.form.type.value='reply'"
					type="submit" name="button"
					value="  {$mod_strings['LBL_BUTTON_REPLY']}  "
			>
EOD;
$buttons_sent_email[] = <<<EOD
            <input title="{$mod_strings['LBL_BUTTON_REPLY_ALL']}"
					class="button" onclick="this.form.return_module.value='{$ret_mod}';
											this.form.return_action.value='{$ret_action}';
											this.form.return_id.value='{$focus->id}';
											this.form.action.value='EditView';
											this.form.type.value='replyAll'"
					type="submit" name="button"
					value="  {$mod_strings['LBL_BUTTON_REPLY_ALL']}  "
			>
EOD;
$buttons_sent_email[] = <<<EOD
            <input title="{$app_strings['LBL_DELETE_BUTTON_TITLE']}"
					accessKey="{$app_strings['LBL_DELETE_BUTTON_KEY']}"
					class="button" onclick="this.form.return_module.value='{$start['module']}';
											this.form.return_action.value='{$start['action']}';
											this.form.return_id.value='{$start['record']}';
											this.form.type.value='{$start['type']}';
											this.form.assigned_user_id.value='{$start['assigned_user_id']}';
											this.form.action.value='Delete';
											return confirm('{$app_strings['NTC_DELETE_CONFIRMATION']}')"
					type="submit" name="button"
					value="    {$app_strings['LBL_DELETE_BUTTON']}    "
			>
EOD;

if($show_raw) {
    $buttons_sent_email[] = <<<EOD
            <input type="button" name="button" class="button"
				id="rawButton"
				title="{$mod_strings['LBL_BUTTON_RAW_TITLE']}"
				value=" {$mod_strings['LBL_BUTTON_RAW_LABEL']} "
				onclick="open_popup('Emails', 800, 600, '', true, true, '', 'show_raw', '', '{$focus->id}');"
			/>
EOD;
}

require_once('include/Smarty/plugins/function.sugar_action_menu.php');
$action_button_sent_email = smarty_function_sugar_action_menu(array(
    'id' => 'detail_header_action_menu',
    'buttons' => $buttons_sent_email,
    'class' => 'clickMenu fancymenu',
), $xtpl);

$xtpl->assign("ACTION_BUTTON_SENT_EMAIL", $action_button_sent_email);

///////////////////////////////////////////////////////////////////////////////
////	JAVASCRIPT VARS
$jsVars  = '';
$jsVars .= "var showRaw = '{$mod_strings['LBL_BUTTON_RAW_LABEL']}';";
$jsVars .= "var hideRaw = '{$mod_strings['LBL_BUTTON_RAW_LABEL_HIDE']}';";
$xtpl->assign("JS_VARS", $jsVars);


// ADMIN EDIT
if(is_admin($GLOBALS['current_user']) && $_REQUEST['module'] != 'DynamicLayout' && !empty($_SESSION['editinplace'])){
	$xtpl->assign("ADMIN_EDIT","<a href='index.php?action=index&module=DynamicLayout&from_action=".$_REQUEST['action'] ."&from_module=".$_REQUEST['module'] ."&record=".$_REQUEST['record']. "'>".SugarThemeRegistry::current()->getImage("EditLayout","border='0' align='bottom'",null,null,'.gif',$mod_strings['LBL_EDIT_LAYOUT'])."</a>");
}

if(isset($_REQUEST['offset']) && !empty($_REQUEST['offset'])) { $offset = $_REQUEST['offset']; }
else $offset = 1;
$detailView->processListNavigation($xtpl, "EMAIL", $offset, false);



// adding custom fields:
require_once('modules/DynamicFields/templates/Files/DetailView.php');
$do_open = true;
if ($do_open) {
	$xtpl->parse("main.open_source");
}

///////////////////////////////////////////////////////////////////////////////
////	NOTES (attachements, etc.)
///////////////////////////////////////////////////////////////////////////////

$note = new Note();
$where = "notes.parent_id='{$focus->id}'";
//take in account if this is from campaign and the template id is stored in the macros.

if(isset($macro_values) && isset($macro_values['email_template_id'])){
    $where = "notes.parent_id='{$macro_values['email_template_id']}'";
}
$notes_list = $note->get_full_list("notes.name", $where, true);

if(! isset($notes_list)) {
	$notes_list = array();
}

$attachments = '';
for($i=0; $i<count($notes_list); $i++) {
	$the_note = $notes_list[$i];
	if(!empty($the_note->filename))
    	$attachments .= "<a href=\"index.php?entryPoint=download&id=".$the_note->id."&type=Notes\">".$the_note->name."</a><br />";
    $focus->cid2Link($the_note->id, $the_note->file_mime_type);
}

$xtpl->assign('DESCRIPTION', nl2br($focus->description));
$xtpl->assign('DESCRIPTION_HTML', from_html($focus->description_html));
$xtpl->assign("ATTACHMENTS", $attachments);
$xtpl->parse("main");
$xtpl->out("main");

$sub_xtpl = $xtpl;
$old_contents = ob_get_contents();
ob_end_clean();
ob_start();
echo $old_contents;

///////////////////////////////////////////////////////////////////////////////
////    SUBPANELS
///////////////////////////////////////////////////////////////////////////////
if ($show_subpanels) {
    require_once('include/SubPanel/SubPanelTiles.php');
    $subpanel = new SubPanelTiles($focus, 'Emails');
    echo $subpanel->display();
}
?>