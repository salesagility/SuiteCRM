<?php
 /**
 * 
 * 
 * @package 
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
require_once 'modules/InboundEmail/InboundEmail.php';
require_once 'include/clean.php';
class AOPInboundEmail extends InboundEmail {

    /**
     * Replaces embedded image links with links to the appropriate note in the CRM.
     * @param $string
     * @param $noteIds A whitelist of note ids to replace
     * @return mixed
     */
    function processImageLinks($string, $noteIds){
        global $sugar_config;
        if(!$noteIds){
            return $string;
        }
        $matches = array();
        preg_match('/cid:([[:alnum:]-]*)/',$string,$matches);
        if(!$matches){
            return $string;
        }
        array_shift($matches);
        $matches = array_unique($matches);
        foreach($matches as $match){
            if(in_array($match,$noteIds)){
                $string = str_replace('cid:'.$match,$sugar_config['site_url']."/index.php?entryPoint=download&id={$match}&type=Notes&",$string);
            }
        }
        return $string;
    }


    function handleCreateCase($email, $userId) {
        $GLOBALS['log']->debug('AOPInboundEmail::handleCreateCase($email, $userId)');
        echo "Start of handle create case\n";

        global $current_user, $mod_strings, $current_language, $sugar_config;
        $mod_strings = return_module_language($current_language, "Emails");

        if (!$this->handleCaseAssignment($email) && $this->isMailBoxTypeCreateCase()) {
            // Get Email
            $GLOBALS['log']->debug('retrieving email');
            $email->retrieve($email->id);

            // Create Case
            $GLOBALS['log']->debug('Create Case');
            $caseBean = BeanFactory::newBean('Cases');
            $caseBean->assigned_user_id = $userId;
            $caseBean->name = $email->name;
            $caseBean->status = 'New';
            $caseBean->priority = 'P1';

            // Generate Case Number
            $GLOBALS['log']->debug('Generate Case Number');
            $this->getCaseIdFromCaseNumber($email->name, $caseBean);

            // Get Email Attachments (using notes module)
            $GLOBALS['log']->debug('Get Attachments (using notes)');
            $notesBean = $email->get_linked_beans('notes','Notes');
            $emailAttachmentIDs = array();
            foreach($notesBean as $note) {
                // Set up array of email attachment IDs
                $emailAttachmentIDs[] = $note->id;

                // Link notes to case also
                $newNote = BeanFactory::newBean('Notes');
                $newNote->name = $note->name;
                $newNote->file_mime_type = $note->file_mime_type;
                $newNote->filename = $note->filename;
                $newNote->parent_type = 'Cases';
                $newNote->parent_id = $caseBean->id;
                $newNote->save();
                $srcFile = "upload://{$note->id}";
                $destFile = "upload://{$newNote->id}";
                copy($srcFile, $destFile);
            }

            // Process case description
            if($email->description_html) {
                // Process case description with attachments
                $GLOBALS['log']->debug('Process case description with attachments'.print_r($emailAttachmentIDs, 1));
                $caseBean->description = $this->processImageLinks(SugarCleaner::cleanHtml($email->description_html), $emailAttachmentIDs);
            } else {
                // Process case description without attachments
                $GLOBALS['log']->debug('Process case description without attachments');
                $caseBean->description = $email->description;
            }

            if(!empty($email->reply_to_email)) {
                $contactEmailAddress = $email->reply_to_email;
            } else {
                $contactEmailAddress = $email->from_addr;
            }

            // Get related contact using email address
            $GLOBALS['log']->debug('Finding related contacts with address ' . $contactEmailAddress);
            $contactIds = $this->getRelatedId($contactEmailAddress, 'contacts');
            if(empty($contactIds)) {
                $GLOBALS['log']->debug('No contacts creating contact address ' . $contactEmailAddress);
                // create contact
                $contactBean = BeanFactory::newBean('Contacts');
                $contactBean->email1 = $email->from_addr;
                $contactBean->last_name = $email->from_addr_name;
                $contactBean->save(false);

                $caseBean->contact_created_by_id = $contactBean->id;
                $contactIds = array();
                $contactIds[] = $contactBean->id;

                // Load cases contact relationship
                $caseBean->load_relationship('contacts');
            }


            $GLOBALS['log']->debug('Finding related accounts with address ' . $contactEmailAddress);
            if($accountIds = $this->getRelatedId($contactEmailAddress, 'accounts')) {
                $GLOBALS['log']->debug('Found related accounts with address ' . $contactEmailAddress);

                if (sizeof($accountIds) == 1) {
                    $accountBean = BeanFactory::newBean('Accounts');
                    $accountBean->retrieve($caseBean->account_id);
                    $caseBean->account_id = $accountIds[0];
                    $caseBean->account_name = $accountBean->name;
                }
            } else {
                // Set default account ID
                if(!empty($sugar_config['inbound_email_default_account_id'])) {
                    $accountBean = BeanFactory::newBean('Accounts');
                    $accountBean->retrieve($sugar_config['inbound_email_default_account_id']);
                    $caseBean->account_name = $accountBean->name;
                    $caseBean->account_id = $accountBean->id;
                    // Load cases accounts relationship
                    $caseBean->load_relationship('accounts');

                    $accountIds = array();
                    $accountIds[] = $accountBean->id;
                }
            }

            // Get contacts related to accounts
            if(!empty($accountBean)) {
                $GLOBALS['log']->debug('Finding contacts related  to accounts ' . $accountBean->name);
                if ($accountBean->load_relationship('contacts')) {
                    $accountBean->contacts->get();
                    if(empty($contactBean)) {
                        $contactBean = BeanFactory::getBean('Contacts', $contactIds[0]);
                    }
                    $accountBean->contacts->add($contactBean);
                }
            }

            // Save and notify users
            $caseBean->save(true);

            // if case doesn't have a related account but it does have a related contact
            // then relate the account of the contact to case instead
            // and relate the contact to the case
            if(empty($accountBean) && !empty($contactBean)) {
                // load the relationship contacts accounts
                if ($contactBean->load_relationship('accounts')) {
                    $accountsList = $contactBean->accounts->get();
                    if ($caseBean->load_relationship('accounts') && !empty($accountsList[0])) {
                        $caseBean->accounts->add($accountsList[0]);
                    }
                }

                $caseBean->contacts->add($contactIds);
            } else if(!empty($contactBean)) {
                // Relate Contact To Case
                $caseBean->contacts->add($contactBean);
            }

            // relate contact to case
            if(!empty($contactBean)) {
                $caseBean->contacts->add($contactIds);
            }

            // Relate the email with the case
            if($caseBean->load_relationship('emails')) {
                $caseBean->emails->add($email->id);
            }

            // Create email
            $caseBean->email_id = $email->id;
            $email->parent_type = "Cases";
            $email->parent_id = $caseBean->id;

            // Assign the email to the case owner
            $email->assigned_user_id = $caseBean->assigned_user_id;
            $email->name = str_replace('%1', $caseBean->case_number, $caseBean->getEmailSubjectMacro()) . " ". $email->name;
            $email->save();

            $GLOBALS['log']->debug('InboundEmail get stored options: '.$caseBean->case_number);
            $createCaseTemplateId = $this->get_stored_options('create_case_email_template', "");
            if(!empty($this->stored_options)) {
                $storedOptions = unserialize(base64_decode($this->stored_options));
            }

            if(!empty($createCaseTemplateId)) {
                $fromName = "";
                $fromAddress = "";
                if (!empty($this->stored_options)) {
                    $fromAddress = $storedOptions['from_addr'];
                    $fromName = from_html($storedOptions['from_name']);
                    $replyToName = (!empty($storedOptions['reply_to_name']))? from_html($storedOptions['reply_to_name']) :$fromName ;
                    $replyToAddr = (!empty($storedOptions['reply_to_addr'])) ? $storedOptions['reply_to_addr'] : $fromAddress;
                } // if
                $defaults = $current_user->getPreferredEmail();
                $fromAddress = (!empty($fromAddress)) ? $fromAddress : $defaults['email'];
                $fromName = (!empty($fromName)) ? $fromName : $defaults['name'];
                $to[0]['email'] = $contactEmailAddress;

                // handle to name: address, prefer reply-to
                if(!empty($email->reply_to_name)) {
                    $to[0]['display'] = $email->reply_to_name;
                } elseif(!empty($email->from_name)) {
                    $to[0]['display'] = $email->from_name;
                }

                $et = new EmailTemplate();
                $et->retrieve($createCaseTemplateId);
                if(empty($et->subject))		{ $et->subject = ''; }
                if(empty($et->body))		{ $et->body = ''; }
                if(empty($et->body_html))	{ $et->body_html = ''; }

                $et->subject = "Re:" . " " . str_replace('%1', $caseBean->case_number, $caseBean->getEmailSubjectMacro() . " ". $caseBean->name);

                $html = trim($email->description_html);
                $plain = trim($email->description);

                // Parse email template
                $casesBeanArray = array('Cases' => $caseBean->id);
                $et->body = EmailTemplate::parse_template($et->body, $casesBeanArray);
                $et->body_html = EmailTemplate::parse_template($et->body_html, $casesBeanArray);

                $email->email2init();
                $email->from_addr = $email->from_addr_name;
                $email->to_addrs = $email->to_addrs_names;
                $email->cc_addrs = $email->cc_addrs_names;
                $email->bcc_addrs = $email->bcc_addrs_names;
                $email->from_name = $email->from_addr;

                $email = $email->et->handleReplyType($email, "reply");
                $ret = $email->et->displayComposeEmail($email);
                $ret['description'] = empty($email->description_html) ?  str_replace("\n", "\n<BR/>", $email->description) : $email->description_html;

                $reply = new Email();
                $reply->type				= 'out';
                $reply->to_addrs			= $to[0]['email'];
                $reply->to_addrs_arr		= $to;
                $reply->cc_addrs_arr		= array();
                $reply->bcc_addrs_arr		= array();
                $reply->from_name			= $fromName;
                $reply->from_addr			= $fromAddress;
                $reply->reply_to_name		= $replyToName;
                $reply->reply_to_addr		= $replyToAddr;
                $reply->name				= $et->subject;
                $reply->description			= $et->body . "<div><hr /></div>" .  $email->description;
                if (!$et->text_only) {
                    $reply->description_html	= $et->body_html .  "<div><hr /></div>" . $email->description;
                }

                // Send Email
                $GLOBALS['log']->debug('saving and sending auto-reply email');
                //$reply->save(); // don't save the actual email.
                $reply->send();
            }

        } else {
            $GLOBALS['log']->debug('"First if not matching');
            echo "First if not matching\n";
            if(!empty($email->reply_to_email)) {
                $contactEmailAddress = $email->reply_to_email;
            } else {
                $contactEmailAddress = $email->from_addr;
            }
            $this->handleAutoresponse($email, $contactEmailAddress);
        }
        echo "End of handle create case\n";

    }
}