<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/**
 * Advanced, robust set of sales and support modules.
 * Extensions to OpenSales for SugarCRM
 * @package Advanced OpenSales for SugarCRM
 * @subpackage Products
 * @copyright SalesAgility Ltd http://www.salesagility.com
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * @author Greg Soper <greg.soper@salesagility.com>
 */

//Shorten name.
$data = $_REQUEST; 

if (!empty($data['listViewExternalClient'])) {
    $email = new Email();
    echo $email->getNamePlusEmailAddressesForCompose($_REQUEST['action_module'], (explode(",", $_REQUEST['uid'])));
}
//For the full compose/email screen, the compose package is generated and script execution
//continues to the Emails/index.php page.
else if(!isset($data['forQuickCreate'])) {
	$ret = generateComposeDataPackage($data);
}

/**
 * Initialize the full compose window by creating the compose package 
 * and then including Emails index.php file.  
 *
 * @param Array $ret
 */
function initFullCompose($ret)
{
	global $current_user;
	$json = getJSONobj();
	$composeOut = $json->encode($ret);

	//For listview 'Email' call initiated by subpanels, just returned the composePackage data, do not
	//include the entire Emails page
	if ( isset($_REQUEST['ajaxCall']) && $_REQUEST['ajaxCall'])
	{
	    echo $composeOut;
	}
	else 
	{
	   //For normal full compose screen
	   include('modules/Emails/index.php');
	   echo "<script type='text/javascript' language='javascript'>\ncomposePackage = {$composeOut};\n</script>";
	}
}

/**
 * Generate the compose data package consumed by the full and quick compose screens.
 *
 * @param Array $data 
 * @param Bool $forFullCompose If full compose is set to TRUE, then continue execution and include the full Emails UI.  Otherwise
 *             the data generated is returned.
 */
function generateComposeDataPackage($data,$forFullCompose = TRUE)
{
	// we will need the following:
	if( isset($data['parent_type']) && !empty($data['parent_type']) &&
	isset($data['parent_id']) && !empty($data['parent_id']) &&
	!isset($data['ListView']) && !isset($data['replyForward'])) {
		global $beanList;
		global $beanFiles;
		global $mod_strings;

		$parentName = '';
		$class = $beanList[$data['parent_type']];
		require_once($beanFiles[$class]);

		$bean = new $class();
		$bean->retrieve($data['parent_id']);
		if (isset($bean->full_name)) {
			$parentName = $bean->full_name;
		} elseif(isset($bean->name)) {
			$parentName = $bean->name;
		}else{
			$parentName = '';
		}
		$parentName = from_html($parentName);
		$namePlusEmail = '';
		if (isset($data['to_email_addrs'])) {
			$namePlusEmail = $data['to_email_addrs'];
			$namePlusEmail = from_html(str_replace("&nbsp;", " ", $namePlusEmail));
		} else {
			if (isset($bean->full_name)) {
				$namePlusEmail = from_html($bean->full_name) . " <". from_html($bean->emailAddress->getPrimaryAddress($bean)).">";
			} else  if(isset($bean->emailAddress)){
				$namePlusEmail = "<".from_html($bean->emailAddress->getPrimaryAddress($bean)).">";
			}
		}

		$subject = "";
		$body = "";
		$email_id = "";
		$attachments = array();
		if ($bean->module_dir == 'Cases') {
			$subject = str_replace('%1', $bean->case_number, $bean->getEmailSubjectMacro() . " ". from_html($bean->name)) ;//bug 41928 
			$bean->load_relationship("contacts");
			$contact_ids = $bean->contacts->get();
			$contact = new Contact();
			foreach($contact_ids as $cid)
			{
				$contact->retrieve($cid);
				$namePlusEmail .= empty($namePlusEmail) ? "" : ", ";
				$namePlusEmail .= from_html($contact->full_name) . " <".from_html($contact->emailAddress->getPrimaryAddress($contact)).">";
			}
		}
		if ($bean->module_dir == 'KBDocuments') {

			require_once("modules/Emails/EmailUI.php");
			$subject = $bean->kbdocument_name;
			$article_body = str_replace('/'.$GLOBALS['sugar_config']['cache_dir'].'images/',$GLOBALS['sugar_config']['site_url'].'/'.$GLOBALS['sugar_config']['cache_dir'].'images/',KBDocument::get_kbdoc_body_without_incrementing_count($bean->id));
			$body = from_html($article_body);
			$attachments = KBDocument::get_kbdoc_attachments_for_newemail($bean->id);
			$attachments = $attachments['attachments'];
		} // if
		if ($bean->module_dir == 'Quotes' && isset($data['recordId'])) {
			$quotesData = getQuotesRelatedData($data);
			global $current_language;
			$namePlusEmail = $quotesData['toAddress'];
			$subject = $quotesData['subject'];
			$body = $quotesData['body'];
			$attachments = $quotesData['attachments'];
			$email_id = $quotesData['email_id'];
		} // if
		$ret = array(
		'to_email_addrs' => $namePlusEmail,
		'parent_type'	 => $data['parent_type'],
		'parent_id'	     => $data['parent_id'],
		'parent_name'    => $parentName,
		'subject'		 => $subject,
		'body'			 => $body,
		'attachments'	 => $attachments,
		'email_id'		 => $email_id,

	);
}else if(isset($data['recordId'])) {


        $quotesData = getQuotesRelatedData($data);
        $namePlusEmail = $quotesData['toAddress'];
        $subject = $quotesData['subject'];
        $body = $quotesData['body'];
        $attachments = $quotesData['attachments'];
        $email_id = $quotesData['email_id'];

		$ret = array(
            'to_email_addrs' => $namePlusEmail,
            'parent_type'	 => $quotesData['parent_type'],
            'parent_id'	     => $quotesData['parent_id'],
            'parent_name'    => $quotesData['parent_name'],
            'subject'		 => $subject,
            'body'			 => $body,
            'attachments'	 => $attachments,
            'email_id'		 => $email_id,
	    );

}  else if(isset($_REQUEST['ListView'])) {
  	
	$email = new Email();
	$namePlusEmail = $email->getNamePlusEmailAddressesForCompose($_REQUEST['action_module'], (explode(",", $_REQUEST['uid'])));
	$ret = array(
		'to_email_addrs' => $namePlusEmail,
		);
	} else if (isset($data['replyForward'])) {

		require_once("modules/Emails/EmailUI.php");

		$ret = array();
		$ie = new InboundEmail();
		$ie->email = new Email();
		$ie->email->email2init();
		$replyType = $data['reply'];
		$email_id = $data['record'];
		$ie->email->retrieve($email_id);
		$emailType = "";
		if ($ie->email->type == 'draft') {
			$emailType = $ie->email->type;
		}
		$ie->email->from_addr = $ie->email->from_addr_name;
		$ie->email->to_addrs = to_html($ie->email->to_addrs_names);
		$ie->email->cc_addrs = to_html($ie->email->cc_addrs_names);
		$ie->email->bcc_addrs = $ie->email->bcc_addrs_names;
		$ie->email->from_name = $ie->email->from_addr;
		$preBodyHTML = "&nbsp;<div><hr></div>";
		if ($ie->email->type != 'draft') {
			$email = $ie->email->et->handleReplyType($ie->email, $replyType);
		} else {
			$email = $ie->email;
			$preBodyHTML = "";
		} // else
		if ($ie->email->type != 'draft') {
			$emailHeader = $email->description;
		}
		$ret = $ie->email->et->displayComposeEmail($email);
		if ($ie->email->type != 'draft') {
			$ret['description'] = $emailHeader;
		}
		if ($replyType == 'forward' || $emailType == 'draft') {
			$ret = $ie->email->et->getDraftAttachments($ret);
		}
		$return = $ie->email->et->getFromAllAccountsArray($ie, $ret);

		if ($replyType == "forward") {
			$return['to'] = '';
		} else {
			if ($email->type != 'draft') {
				$return['to'] = from_html($ie->email->from_addr);
			}
		} // else
		$ret = array(
		'to_email_addrs' => $return['to'],
		'parent_type'	 => $return['parent_type'],
		'parent_id'	     => $return['parent_id'],
		'parent_name'    => $return['parent_name'],
		'subject'		 => $return['name'],
		'body'			 => $preBodyHTML . $return['description'],
		'attachments'	 => (isset($return['attachments']) ? $return['attachments'] : array()),
		'email_id'		 => $email_id,
		'fromAccounts'   => $return['fromAccounts'],
		);

	} else {
		$ret = array(
		'to_email_addrs' => '',
		);
	}
	
	if($forFullCompose)
		initFullCompose($ret);
	else
		return $ret;
}

function getQuotesRelatedData($data) {
	$return = array();
	$emailId = $data['recordId'];
  	
  	require_once("modules/Emails/EmailUI.php");
	$email = new Email();
	$email->retrieve($emailId);
	$return['subject'] = $email->name;
	$return['body'] = from_html($email->description_html);
	$return['toAddress'] = $email->to_addrs;
	$ret = array();
	$ret['uid'] = $emailId;
	$ret = EmailUI::getDraftAttachments($ret);
	$return['attachments'] = $ret['attachments'];
	$return['email_id'] = $emailId;
    $return['parent_type'] = $email->parent_type;
    $return['parent_id'] = $email->parent_id;
    $return['parent_name'] = '';

    if(isset($return['parent_type']) && !empty($return['parent_type']) && isset($return['parent_id']) && !empty($return['parent_id'])){
        global $beanList;
        global $beanFiles;

        $class = $beanList[$return['parent_type']];
        require_once($beanFiles[$class]);

        $bean = new $class();
        $bean->retrieve($return['parent_id']);
        if (isset($bean->full_name)) {
            $parentName = $bean->full_name;
        } elseif(isset($bean->name)) {
            $parentName = $bean->name;
        }else{
            $parentName = '';
        }
        $parentName = from_html($parentName);

        $return['parent_name'] = $parentName;
        $return['toAddress'] = from_html($bean->full_name) . " <".from_html($bean->emailAddress->getPrimaryAddress($bean)).">";
    }


	return $return;
}
 // fn
