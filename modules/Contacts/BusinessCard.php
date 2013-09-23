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

/*********************************************************************************

 * Description:  Business Card Wizard
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
 
global $app_strings;
global $app_list_strings;
global $locale;

global $theme;
$error_msg = '';
global $current_language;
$mod_strings = return_module_language($current_language, 'Contacts');
echo getClassicModuleTitle($mod_strings['LBL_MODULE_NAME'], array($mod_strings['LBL_MODULE_NAME'],$mod_strings['LBL_BUSINESSCARD']), true); 
$xtpl=new XTemplate ('modules/Contacts/BusinessCard.html');
$xtpl->assign("MOD", $mod_strings);
$xtpl->assign("APP", $app_strings);
$xtpl->assign("PRINT_URL", "index.php?".$GLOBALS['request_string']);

$xtpl->assign("HEADER", $mod_strings['LBL_ADD_BUSINESSCARD']);

$xtpl->assign("MODULE", $_REQUEST['module']);
if ($error_msg != '')
{
	$xtpl->assign("ERROR", $error_msg);
	$xtpl->parse("main.error");
}

if(isset($_POST['handle']) && $_POST['handle'] == 'Save'){
	
	require_once('modules/Contacts/ContactFormBase.php');
	$contactForm = new ContactFormBase();
	require_once('modules/Accounts/AccountFormBase.php');
	$accountForm = new AccountFormBase();
	
	require_once('modules/Opportunities/OpportunityFormBase.php');
	$oppForm = new OpportunityFormBase();
	if(!isset($_POST['selectedContact']) && !isset($_POST['ContinueContact'])){
		$duplicateContacts = $contactForm->checkForDuplicates('Contacts');
		if(isset($duplicateContacts)){
			$formBody = $contactForm->buildTableForm($duplicateContacts);
			$xtpl->assign('FORMBODY', $formBody);
			$xtpl->parse('main.formnoborder');
			$xtpl->parse('main');
			$xtpl->out('main');
			return;
		}
	}
	
	if(empty($_POST['selectedAccount']) && empty($_POST['ContinueAccount'])){
		$duplicateAccounts = $accountForm->checkForDuplicates('Accounts');
		
		if(isset($duplicateAccounts)){
			$xtpl->assign('FORMBODY', $accountForm->buildTableForm($duplicateAccounts));
			$xtpl->parse('main.formnoborder');
			$xtpl->parse('main');
			$xtpl->out('main');
			return;
		}
		
	}

	if(isset($_POST['newopportunity']) && $_POST['newopportunity']=='on' &&!isset($_POST['selectedOpportunity']) && !isset($_POST['ContinueOpportunity'])){

		$duplicateOpps = $oppForm->checkForDuplicates('Opportunities');
		if(isset($duplicateOpps)){
			$xtpl->assign('FORMBODY', $oppForm->buildTableForm($duplicateOpps));
			$xtpl->parse('main.formnoborder');
			$xtpl->parse('main');
			$xtpl->out('main');
			return;
		}
	}
	if(!empty($_POST['selectedContact'])){
		$contact = new Contact();
		$contact->retrieve($_POST['selectedContact']);	
	}else{
		$contact= $contactForm->handleSave('Contacts',false, false);
	}
	if(!empty($_POST['selectedAccount'])){
		$account = new Account();
		$account->retrieve($_POST['selectedAccount']);	
	}else if(isset($_POST['newaccount']) && $_POST['newaccount']=='on' ){
		$account= $accountForm->handleSave('Accounts',false, false);
	}
	if(isset($_POST['newopportunity']) && $_POST['newopportunity']=='on' ){
		if(!empty($_POST['selectedOpportunity'])){
			$opportunity = new Opportunity();
			$opportunity->retrieve($_POST['selectedOpportunity']);
		}else{
			if(isset($account)){
				$_POST['Opportunitiesaccount_id'] = $account->id;
				$_POST['Opportunitiesaccount_name'] = $account->name;
				
			}
			if(isset($_POST['Contactslead_source']) && !empty($_POST['Contactslead_source'])){
				$_POST['Opportunitieslead_source'] = $_POST['Contactslead_source'];
			} 
			$opportunity= $oppForm->handleSave('Opportunities',false, false);
			
		}
	}
	require_once('modules/Notes/NoteFormBase.php');

	$noteForm = new NoteFormBase();
	if(isset($account))
		$_POST['AccountNotesparent_id'] = $account->id;
		$accountnote= $noteForm->handleSave('AccountNotes',false, false);
	if(isset($contact))
		$_POST['ContactNotesparent_type'] = "Contacts";
		$_POST['ContactNotesparent_id'] = $contact->id;
		$contactnote= $noteForm->handleSave('ContactNotes',false, false);
	if(isset($opportunity)){
		$_POST['OpportunityNotesparent_type'] = "Opportunities";
		$_POST['OpportunityNotesparent_id'] = $opportunity->id;
		$opportunitynote= $noteForm->handleSave('OpportunityNotes',false, false);
		}
	if(isset($_POST['newappointment']) && $_POST['newappointment']=='on' ){	
	if(isset($_POST['appointment']) && $_POST['appointment'] == 'Meeting'){
		require_once('modules/Meetings/MeetingFormBase.php');
		$meetingForm = new MeetingFormBase();
		$meeting= $meetingForm->handleSave('Appointments',false, false);
	}else{
		require_once('modules/Calls/CallFormBase.php');
		$callForm = new CallFormBase();
		$call= $callForm->handleSave('Appointments',false, false);	
	}
	}
	
	if(isset($call)){
		if(isset($contact)) {
			$call->load_relationship('contacts');
			$call->contacts->add($contact->id);
		} else if(isset($account)){
			$call->load_relationship('account');
			$call->account->add($account->id);
		}else if(isset($opportunity)){
			$call->load_relationship('opportunity');
			$call->opportunity->add($opportunity->id);			
		}
	}
	if(isset($meeting)){
		if(isset($contact)) {
			$meeting->load_relationship('contacts');
			$meeting->contacts->add($contact->id);
		} else if(isset($account)){
			$meeting->load_relationship('account');
			$meeting->account->add($account->id);
		}else if(isset($opportunity)){
			$meeting->load_relationship('opportunity');
			$meeting->opportunity->add($opportunity->id);			
		}
	}
	if(isset($account)){
		if(isset($contact)) {
			$account->load_relationship('contacts');
			$account->contacts->add($contact->id);
		} else if(isset($accountnote)){
			$account->load_relationship('notes');
			$account->notes->add($accountnote->id);
		}else if(isset($opportunity)){
			$account->load_relationship('opportunities');
			$account->opportunities->add($opportunity->id);			
		}
	}
	if(isset($opportunity)){
		if(isset($contact)) {
			$opportunity->load_relationship('contacts');
			$opportunity->contacts->add($contact->id);
		} else if(isset($accountnote)){
			$opportunity->load_relationship('notes');
			$opportunity->notes->add($accountnote->id);
		}		
	}
	if(isset($contact)){
		if(isset($contactnote)){
			$contact->load_relationship('notes');
			$contact->notes->add($contactnote->id);
		}				
	}
	
	if(isset($contact)){
		$contact->track_view($current_user->id, 'Contacts');
		if(isset($_POST['selectedContact']) && $_POST['selectedContact'] == $contact->id){
			$xtpl->assign('ROWVALUE', "<LI>".$mod_strings['LBL_EXISTING_CONTACT']." - <a href='index.php?action=DetailView&module=Contacts&record=".$contact->id."'>".$locale->getLocaleFormattedName($contact->first_name, $contact->last_name)."</a>" );
			$xtpl->parse('main.row');
		}else{
			
			$xtpl->assign('ROWVALUE', "<LI>".$mod_strings['LBL_CREATED_CONTACT']." - <a href='index.php?action=DetailView&module=Contacts&record=".$contact->id."'>".$locale->getLocaleFormattedName($contact->first_name, $contact->last_name)."</a>" );
			$xtpl->parse('main.row');
		}
	}
	if(isset($account)){
		$account->track_view($current_user->id, 'Accounts');
		if(isset($_POST['selectedAccount']) && $_POST['selectedAccount'] == $account->id){
			$xtpl->assign('ROWVALUE', "<LI>".$mod_strings['LBL_EXISTING_ACCOUNT']. " - <a href='index.php?action=DetailView&module=Accounts&record=".$account->id."'>".$account->name."</a>");
			$xtpl->parse('main.row');
		}else{
			$xtpl->assign('ROWVALUE', "<LI>".$mod_strings['LBL_CREATED_ACCOUNT']. " - <a href='index.php?action=DetailView&module=Accounts&record=".$account->id."'>".$account->name."</a>");		
			$xtpl->parse('main.row');
		}
		
	}
	if(isset($opportunity)){
		$opportunity->track_view($current_user->id, 'Opportunities');
		if(isset($_POST['selectedOpportunity']) && $_POST['selectedOpportunity'] == $opportunity->id){
			$xtpl->assign('ROWVALUE', "<LI>".$mod_strings['LBL_EXISTING_OPPORTUNITY']. " - <a href='index.php?action=DetailView&module=Opportunities&record=".$opportunity->id."'>".$opportunity->name."</a>");
			$xtpl->parse('main.row');
		}else{
			$xtpl->assign('ROWVALUE', "<LI>".$mod_strings['LBL_CREATED_OPPORTUNITY']. " - <a href='index.php?action=DetailView&module=Opportunities&record=".$opportunity->id."'>".$opportunity->name."</a>");
			$xtpl->parse('main.row');
		}

	}

	if(isset($call)){
		$call->track_view($current_user->id, 'Calls');
		$xtpl->assign('ROWVALUE', "<LI>".$mod_strings['LBL_CREATED_CALL']. " - <a href='index.php?action=DetailView&module=Calls&record=".$call->id."'>".$call->name."</a>");	
		$xtpl->parse('main.row');
		}
	if(isset($meeting)){
		$meeting->track_view($current_user->id, 'Meetings');
		$xtpl->assign('ROWVALUE', "<LI>".$mod_strings['LBL_CREATED_MEETING']. " - <a href='index.php?action=DetailView&module=Calls&record=".$meeting->id."'>".$meeting->name."</a>");	
		$xtpl->parse('main.row');
		}
		$xtpl->assign('ROWVALUE',"&nbsp;");	
		$xtpl->parse('main.row');
		$xtpl->assign('ROWVALUE',"<a href='index.php?module=Contacts&action=BusinessCard'>{$mod_strings['LBL_ADDMORE_BUSINESSCARD']}</a>");	
	$xtpl->parse('main.row');
	$xtpl->parse('main');
	$xtpl->out('main');	
}
	
else{

//CONTACT
$xtpl->assign('FORMHEADER',$mod_strings['LNK_NEW_CONTACT']);
$xtpl->parse("main.startform");
$xtpl->parse("main.savebegin");
require_once('modules/Contacts/ContactFormBase.php');
$xtpl->assign('OPPNEEDSACCOUNT',$mod_strings['NTC_OPPORTUNITY_REQUIRES_ACCOUNT']);
if ($sugar_config['require_accounts']) {
	$xtpl->assign('CHECKOPPORTUNITY', "&& checkOpportunity()");
}
else {
	$xtpl->assign('CHECKOPPORTUNITY', "");
}
$contactForm = new ContactFormBase();
$xtpl->assign('FORMBODY',$contactForm->getWideFormBody('Contacts', 'Contacts', 'BusinessCard', '', false));
$xtpl->assign('TABLECLASS', 'edit view');
$xtpl->assign('CLASS', 'dataLabel');
require_once('modules/Notes/NoteFormBase.php');
$noteForm = new NoteFormBase();
$postform = "<h5 class='dataLabel'><input class='checkbox' type='checkbox' name='newcontactnote' onclick='toggleDisplay(\"contactnote\");'> ${mod_strings['LNK_NEW_NOTE']}</h5>";
$postform .= '<div id="contactnote" style="display:none">'.$noteForm->getFormBody('ContactNotes','Notes','BusinessCard', 85).'</div>';

$xtpl->assign('POSTFORM',$postform);
$xtpl->parse("main.form");


$xtpl->assign('HEADER', $app_strings['LBL_RELATED_RECORDS']);
$xtpl->parse("main.hrrow");
$popup_request_data = array(
	'call_back_function' => 'set_return',
	'form_name' => 'BusinessCard',
	'field_to_name_array' => array(
		'id' => 'selectedAccount',
		'name' => 'display_account_name',
		),
	);
	
$json = getJSONobj();
$encoded_contact_popup_request_data = $json->encode($popup_request_data);

//Account
require_once('include/QuickSearchDefaults.php');
$qsd = QuickSearchDefaults::getQuickSearchDefaults();
$qsd->setFormName('BusinessCard');
$sqs_objects = array('BusinessCard_display_account_name' => $qsd->getQSParent());
$sqs_objects['BusinessCard_display_account_name']['populate_list'] = array('display_account_name', 'selectedAccount');
$quicksearch_js = '<script type="text/javascript" language="javascript">
                       sqs_objects = ' . $json->encode($sqs_objects) . ';
				       addToValidateBinaryDependency(\'BusinessCard\', \'display_account_name\', \'alpha\', false, \'' . $app_strings['ERR_SQS_NO_MATCH_FIELD'] . $app_strings['LBL_ACCOUNT'] . '\', \'selectedAccount\' );
				   </script>';

$selectAccountButton = $quicksearch_js;
$selectAccountButton .= "<div id='newaccountdivlink' style='display:inline' class='dataLabel'>{$mod_strings['LNK_SELECT_ACCOUNT']}:&nbsp;<input class='sqsEnabled' name='display_account_name' id='display_account_name' type=\"text\" value=\"\"><input name='selectedAccount' id='selectedAccount' type=\"hidden\" value=''>&nbsp;<input type='button' title=\"{$app_strings['LBL_SELECT_BUTTON_TITLE']}\"  type=\"button\"  class=\"button\" value='{$app_strings['LBL_SELECT_BUTTON_LABEL']}' name=btn1 LANGUAGE=javascript onclick='open_popup(\"Accounts\", 600, 400, \"\", true, false, $encoded_contact_popup_request_data);'/> <input type='button' title=\"{$app_strings['LBL_CLEAR_BUTTON_TITLE']}\" accessKey=\"{$app_strings['LBL_CLEAR_BUTTON_KEY']}\" type=\"button\"  class=\"button\" value='{$app_strings['LBL_CLEAR_BUTTON_LABEL']}' name=btn1 LANGUAGE=javascript onclick='document.forms[\"BusinessCard\"].selectedAccount.value=\"\";document.forms[\"BusinessCard\"].display_account_name.value=\"\"; '><br><b>{$app_strings['LBL_OR']}</b></div><br><br>";
$xtpl->assign('FORMHEADER',get_form_header($mod_strings['LNK_NEW_ACCOUNT'], '', ''));
require_once('modules/Accounts/AccountFormBase.php');
$accountForm = new AccountFormBase();
$xtpl->assign('CLASS', 'evenListRow');
$xtpl->assign('FORMBODY',$selectAccountButton."<slot class='dataLabel'><input class='checkbox' type='checkbox' name='newaccount' onclick='document.forms[\"BusinessCard\"].selectedAccount.value=\"\";document.forms[\"BusinessCard\"].display_account_name.value=\"\";toggleDisplay(\"newaccountdiv\");'>&nbsp;".$mod_strings['LNK_NEW_ACCOUNT']."</slot>&nbsp;<div id='newaccountdiv' style='display:none'>".$accountForm->getWideFormBody('Accounts', 'Accounts','BusinessCard', '' ));
require_once('modules/Notes/NoteFormBase.php');
$noteForm = new NoteFormBase();
$postform = "<div id='accountnotelink'><p><a href='javascript:toggleDisplay(\"accountnote\");'>${mod_strings['LNK_NEW_NOTE']}</a></p></div>";
$postform .= '<div id="accountnote" style="display:none">'.$noteForm->getFormBody('AccountNotes', 'Notes', 'BusinessCard', 85).'</div>';
$xtpl->assign('POSTFORM',$postform);
$xtpl->parse("main.headlessform");

//OPPORTUNITTY
$xtpl->assign('FORMHEADER',get_form_header($mod_strings['LNK_NEW_OPPORTUNITY'], '', ''));
require_once('modules/Opportunities/OpportunityFormBase.php');
$oppForm = new OpportunityFormBase();
$xtpl->assign('CLASS', 'evenListRow');
$xtpl->assign('FORMBODY',"<slot class='dataLabel'><input class='checkbox' type='checkbox' name='newopportunity' onclick='toggleDisplay(\"newoppdiv\");'>&nbsp;".$mod_strings['LNK_NEW_OPPORTUNITY']."</slot><div id='newoppdiv' style='display:none'>".$oppForm->getWideFormBody('Opportunities', 'Opportunities','BusinessCard', '' , false));
require_once('modules/Notes/NoteFormBase.php');
$noteForm = new NoteFormBase();
$postform = "<div id='oppnotelink'><a href='javascript:toggleDisplay(\"oppnote\");'>${mod_strings['LNK_NEW_NOTE']}</a></div>";
$postform .= '<div id="oppnote" style="display:none">'.$noteForm->getFormBody('OpportunityNotes', 'Notes','BusinessCard', 85).'</div><br>';
$xtpl->assign('POSTFORM',$postform);
$xtpl->parse("main.headlessform");

//Appointment
$xtpl->assign('FORMHEADER',$mod_strings['LNK_NEW_APPOINTMENT']);
require_once('modules/Calls/CallFormBase.php');
$callForm = new CallFormBase();
$xtpl->assign('FORMBODY', "<input class='checkbox' type='checkbox' name='newappointment' onclick='toggleDisplay(\"newappointmentdiv\");'>&nbsp;".$mod_strings['LNK_NEW_APPOINTMENT']."<div id='newappointmentdiv' style='display:none'>".$callForm->getWideFormBody('Appointments', 'Calls',85));
$xtpl->assign('POSTFORM','');
$xtpl->parse("main.headlessform");
$xtpl->parse("main.saveend");
$xtpl->parse("main.endform");
$xtpl->parse("main");

$xtpl->out("main");

}
?>
