<?PHP
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

/**
 * THIS CLASS IS FOR DEVELOPERS TO MAKE CUSTOMIZATIONS IN
 */
require_once 'modules/AOP_Case_Updates/AOP_Case_Updates_sugar.php';
require_once 'util.php';
require_once 'include/clean.php';
class AOP_Case_Updates extends AOP_Case_Updates_sugar {

    function AOP_Case_Updates(){
        parent::AOP_Case_Updates_sugar();
    }

    function save($check_notify = false){
        $this->name = SugarCleaner::cleanHtml($this->name);
        $this->description = SugarCleaner::cleanHtml($this->description);
        global $current_user, $sugar_config;
        parent::save($check_notify);
        $email_template = new EmailTemplate();
        if($_REQUEST['module'] == 'Import'){
            //Don't send email on import
            return;
        }
        if(!isAOPEnabled()){
            return;
        }
        if($this->internal){
            return;
        }
        $signature = array();
        $addDelimiter = true;
        $aop_config = $sugar_config['aop'];
        if($this->assigned_user_id){
            if($aop_config['contact_email_template_id']){
                $email_template = $email_template->retrieve($aop_config['contact_email_template_id']);
                $signature = $current_user->getDefaultSignature();
            }
            if($email_template) {
                foreach ($this->getContacts() as $contact) {
                    $GLOBALS['log']->info("AOPCaseUpdates: Calling send email");
                    $emails = array();
                    $emails[] = $contact->emailAddress->getPrimaryAddress($contact);
                    $res = $this->sendEmail($emails, $email_template, $signature, $this->case_id, $addDelimiter, $contact->id);
                }
            }
        }else{
            $emails = $this->getEmailForUser();
            if($aop_config['user_email_template_id']){
                $email_template = $email_template->retrieve($aop_config['user_email_template_id']);
            }
            $addDelimiter = false;
            if($emails && $email_template){
                $GLOBALS['log']->info("AOPCaseUpdates: Calling send email");
                $res = $this->sendEmail($emails, $email_template, $signature, $this->case_id, $addDelimiter,$this->contact_id);
            }
        }

    }

    /**
     * @return aCase
     */
    public function getCase(){
        $case = BeanFactory::getBean("Cases",$this->case_id);
        return $case;
    }

    public function getContacts(){
        $case = $this->getCase();
        if($case){
            return $case->get_linked_beans("contacts","Contacts");
        }
        return null;
    }

    public function getUpdateContact(){
        if($this->contact_id){
            return BeanFactory::getBean("Contacts",$this->contact_id);
        }
        return null;
    }
    public function getUser(){
        $user = BeanFactory::getBean('Users',$this->getCase()->assigned_user_id);
        return $user;
    }
    public function getUpdateUser(){
        $user = BeanFactory::getBean('Users',$this->assigned_user_id);
        return $user;
    }

    private function getEmailForUser(){
        $user = $this->getUser();
        if($user){
            return array($user->emailAddress->getPrimaryAddress($user));
        }
        return array();
    }

    private function populateTemplate(EmailTemplate $template, $addDelimiter = true, $contactId = null){
        global $app_strings, $sugar_config;
        //Order of beans seems to matter here so we place contact first.
        $userId = '';
        $user = $this->getUpdateUser();
        if(!$user){
            $this->getUser();
        }
        $beans = array("Contacts" => $contactId,"Cases" => $this->getCase()->id, "Users" => $user->id, "AOP_Case_Updates" => $this->id);
        $ret = array();
        $ret['subject'] = from_html(aop_parse_template($template->subject,$beans));
        $body = aop_parse_template(str_replace("\$sugarurl",$sugar_config['site_url'],$template->body_html),$beans);
        $bodyAlt = aop_parse_template(str_replace("\$sugarurl",$sugar_config['site_url'],$template->body),$beans);
        if($addDelimiter){
            $body = $app_strings['LBL_AOP_EMAIL_REPLY_DELIMITER'] . $body;
            $bodyAlt = $app_strings['LBL_AOP_EMAIL_REPLY_DELIMITER'] . $bodyAlt;
        }
        $ret['body'] = from_html($body);
        $ret['body_alt'] = strip_tags(from_html($bodyAlt));
        return $ret;
    }

    private function sendEmail($emails, $template, $signature = array(), $caseId = null, $addDelimiter = true, $contactId = null){
        $GLOBALS['log']->info("AOPCaseUpdates: sendEmail called");
        require_once("include/SugarPHPMailer.php");
        $mailer=new SugarPHPMailer();
        $admin = new Administration();
        $admin->retrieveSettings();

        $mailer->prepForOutbound();
        $mailer->setMailerForSystem();

        $signatureHTML = "";
        if($signature && array_key_exists("signature_html",$signature)){
            $signatureHTML = from_html($signature['signature_html']);
        }
        $signaturePlain = "";
        if($signature && array_key_exists("signature",$signature)){
            $signaturePlain = $signature['signature'];
        }
        $emailSettings = getPortalEmailSettings();
        $GLOBALS['log']->info("AOPCaseUpdates: sendEmail email portal settings are ".print_r($emailSettings,true));
        $text = $this->populateTemplate($template, $addDelimiter, $contactId);
        $mailer->Subject = $text['subject'];
        $mailer->Body = $text['body'] . $signatureHTML;
        $mailer->IsHTML(true);
        $mailer->AltBody = $text['body_alt'] . $signaturePlain;
        $mailer->From     = $emailSettings['from_address'];
        $mailer->FromName = $emailSettings['from_name'];
        foreach($emails as $email){
            $mailer->AddAddress($email);
        }
        if ($mailer->Send()){
            require_once('modules/Emails/Email.php');
            $emailObj = new Email();
            $emailObj->to_addrs = implode(",",$emails);
            $emailObj->type= 'out';
            $emailObj->deleted = '0';
            $emailObj->name = $mailer->Subject;
            $emailObj->description = $mailer->AltBody;
            $emailObj->description_html = $mailer->Body;
            $emailObj->from_addr = $mailer->From;
            if ( $caseId) {
                $emailObj->parent_type = "Cases";
                $emailObj->parent_id = $caseId;
            }
            $emailObj->date_sent = TimeDate::getInstance()->nowDb();
            $emailObj->modified_user_id = '1';
            $emailObj->created_by = '1';
            $emailObj->status = 'sent';
            $emailObj->save();
        }else{
            $GLOBALS['log']->info("AOPCaseUpdates: Could not send email:  " . $mailer->ErrorInfo);
            return false;
        }
        return true;
    }

}
