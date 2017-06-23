<?php
/**
 * Products, Quotations & Invoices modules.
 * Extensions to SugarCRM
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
 * @author Salesagility Ltd <support@salesagility.com>
 */
 
class sendEmail{
	function send_email($module,$module_type,$printable,$file_name,$attach){
	
	require_once('modules/Emails/Email.php');
	global $current_user, $mod_strings, $sugar_config;
	
		//First Create e-mail draft
		$email = new Email();
		// set the id for relationships
		$email->id = create_guid();
		$email->new_with_id = true;
	
		//subject
		$email->name = $mod_strings['LBL_EMAIL_NAME'].' '.$module->name;
		//body
		$email->description_html = $printable;
		//type is draft
		$email->type = "draft";
		$email->status = "draft";
	
		if(!empty($module->billing_contact_id) && $module->billing_contact_id!="")
            $contact_id = $module->billing_contact_id;
        else if(!empty($module->contact_id) && $module->contact_id!="")
            $contact_id = $module->contact_id;

            require_once('modules/Contacts/Contact.php');
            $contact = new Contact;
            if($contact->retrieve($contact_id)){
                $email->parent_type = 'Contacts';
                $email->parent_id = $contact->id;

                if(!empty($contact->email1)){
                    $email->to_addrs_emails = $contact->email1.";";
                    $email->to_addrs = $module->billing_contact_name." <".$contact->email1.">";
                }
            }

	
		//team id
		$email->team_id  = $current_user->default_team;
		//assigned_user_id
		$email->assigned_user_id = $current_user->id;
		//Save the email object
		global $timedate;
		$email->date_start = $timedate->to_display_date_time(gmdate($GLOBALS['timedate']->get_db_date_time_format()));
		$email->save(FALSE);
		$email_id = $email->id;
		
		if($attach)
		{
			$note = new Note();
			$note->modified_user_id = $current_user->id;
			$note->created_by = $current_user->id;
			$note->name = $file_name;
			$note->parent_type = 'Emails';
			$note->parent_id = $email_id;
			$note->file_mime_type = 'application/pdf';
			$note->filename = $file_name;
			$note->save();
			
			rename($sugar_config['upload_dir'].'attachfile.pdf',$sugar_config['upload_dir'].$note->id);
		}
	
		//redirect
		if($email_id=="") {
			echo "Unable to initiate Email Client";
			exit; 
		} else {
		header("Location: index.php?action=Compose&module=Emails&return_module=".$module_type."&return_action=DetailView&return_id=".$_REQUEST['record']."&recordId=".$email_id);
		}
	}
}
?>
