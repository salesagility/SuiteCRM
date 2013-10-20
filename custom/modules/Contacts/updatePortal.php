<?php
/**
 *
 * @package Advanced OpenPortal
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
 * @author Salesagility Ltd <support@salesagility.com>
 */
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once("modules/AOP_Case_Updates/util.php");
class updatePortal{
    function updateUser($bean, $event, $arguments){

		if(isset($bean->joomla_account_access) && $bean->joomla_account_access != ''){
            global $sugar_config;
            $aop_config = $sugar_config['aop'];

            $template = new EmailTemplate();
            $template->retrieve($aop_config['joomla_account_creation_email_template_id']);

            $object_arr['Contacts'] = $bean->id;
            $body_html = aop_parse_template($template->body_html, $object_arr);
            $body_html = str_replace("\$joomla_pass",$bean->joomla_account_access,$body_html);
            $body_html = str_replace("\$portal_address",$aop_config['joomla_url'],$body_html);

            $body_plain = aop_parse_template($template->body, $object_arr);
            $body_plain = str_replace("\$joomla_pass",$bean->joomla_account_access,$body_plain);
            $body_plain = str_replace("\$portal_address",$aop_config['joomla_url'],$body_plain);

            $this->sendEmail($bean->email1, $template->subject, $body_html, $body_plain, $bean);
        }
    }

 function sendEmail($emailTo, $emailSubject, $emailBody, $altemailBody, SugarBean $relatedBean = null)
	{
	   	require_once('modules/Emails/Email.php');
    	require_once('include/SugarPHPMailer.php');
    	
		$emailObj = new Email();
        $emailSettings = getPortalEmailSettings();

		$mail = new SugarPHPMailer();
		$mail->setMailerForSystem();
        $mail->From = $emailSettings['from_address'];
        $mail->FromName = $emailSettings['from_name'];
		$mail->ClearAllRecipients();
		$mail->ClearReplyTos();
		$mail->Subject=from_html($emailSubject);
		$mail->Body=$emailBody;
		$mail->AltBody = $altemailBody;
		$mail->prepForOutbound();
		$mail->AddAddress($emailTo); 

		//now create email
		if (@$mail->Send()) {
		    $emailObj->to_addrs= '';
		    $emailObj->type= 'archived';
		    $emailObj->deleted = '0';
		    $emailObj->name = $mail->Subject;
			$emailObj->description = $mail->AltBody;
			$emailObj->description_html = $mail->Body;
		    $emailObj->from_addr = $mail->From;
		    if ( $relatedBean instanceOf SugarBean && !empty($relatedBean->id) ) {
		        $emailObj->parent_type = $relatedBean->module_dir;
		        $emailObj->parent_id = $relatedBean->id;
		    }
		    $emailObj->date_sent = TimeDate::getInstance()->nowDb();
		    $emailObj->modified_user_id = '1';
		    $emailObj->created_by = '1';
		    $emailObj->status = 'sent';
		    $emailObj->save();
		}
	}
}
?>
