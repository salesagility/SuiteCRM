<?php
/**
 * Advanced OpenWorkflow, Automating SugarCRM.
 * @package Advanced OpenWorkflow for SugarCRM
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
 * @author SalesAgility <info@salesagility.com>
 */


require_once('modules/AOW_Actions/actions/actionBase.php');
class actionSendEmail extends actionBase {

    private $emailableModules = array();

    function actionSendEmail($id = ''){
        parent::actionBase($id);
    }

    function loadJS(){
        return array('modules/AOW_Actions/actions/actionSendEmail.js');
    }

    function edit_display($line,SugarBean $bean = null, $params = array()){
        global $app_list_strings;
        $email_templates_arr = get_bean_select_array(true, 'EmailTemplate','name');

        if(!in_array($bean->module_dir,getEmailableModules())) unset($app_list_strings['aow_email_type_list']['Record Email']);
        $targetOptions = getRelatedEmailableFields($bean->module_dir);
        if(empty($targetOptions)) unset($app_list_strings['aow_email_type_list']['Related Field']);

        $html = '<input type="hidden" name="aow_email_type_list" id="aow_email_type_list" value="'.get_select_options_with_id($app_list_strings['aow_email_type_list'], '').'">
				  <input type="hidden" name="aow_email_to_list" id="aow_email_to_list" value="'.get_select_options_with_id($app_list_strings['aow_email_to_list'], '').'">';

        $checked = '';
        if(isset($params['individual_email']) && $params['individual_email']) $checked = 'CHECKED';

        $html .= "<table border='0' cellpadding='0' cellspacing='0' width='100%'>";
        $html .= "<tr>";
        $html .= '<td id="relate_label" scope="row" valign="top">'.translate("LBL_INDIVIDUAL_EMAILS","AOW_Actions").':';
        $html .= '</td>';
        $html .= "<td valign='top' width='37.5%'>";
        $html .= "<input type='hidden' name='aow_actions_param[".$line."][individual_email]' value='0' >";
        $html .= "<input type='checkbox' id='aow_actions_param[".$line."][individual_email]' name='aow_actions_param[".$line."][individual_email]' value='1' $checked></td>";
        $html .= '</td>';

        if(!isset($params['email_template'])) $params['email_template'] = '';
        $hidden = "style='visibility: hidden;'";
        if($params['email_template'] != '') $hidden = "";

        $html .= '<td id="name_label" scope="row" valign="top" width="12.5%">'.translate("LBL_EMAIL_TEMPLATE","AOW_Actions").':<span class="required">*</span></td>';
        $html .= "<td valign='top' width='37.5%'>";
        $html .= "<select name='aow_actions_param[".$line."][email_template]' id='aow_actions_param_email_template".$line."' onchange='show_edit_template_link(this,".$line.");' >".get_select_options_with_id($email_templates_arr, $params['email_template'])."</select>";

        $html .= "&nbsp;<a href='javascript:open_email_template_form(".$line.")' >".translate('LBL_CREATE_EMAIL_TEMPLATE','AOW_Actions')."</a>";
        $html .= "&nbsp;<span name='edit_template' id='aow_actions_edit_template_link".$line."' $hidden><a href='javascript:edit_email_template_form(".$line.")' >".translate('LBL_EDIT_EMAIL_TEMPLATE','AOW_Actions')."</a></span>";
        $html .= "</td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= '<td id="name_label" scope="row" valign="top" width="12.5%">'.translate("LBL_EMAIL","AOW_Actions").':<span class="required">*</span></td>';
        $html .= '<td valign="top" scope="row" width="37.5%">';

        $html .='<button type="button" onclick="add_emailLine('.$line.')"><img src="'.SugarThemeRegistry::current()->getImageURL('id-ff-add.png').'"></button>';
        $html .= '<table id="emailLine'.$line.'_table" width="100%"></table>';
        $html .= '</td>';
        $html .= "</tr>";
        $html .= "</table>";

        $html .= "<script id ='aow_script".$line."'>";

        //backward compatible
        if(isset($params['email_target_type']) && !is_array($params['email_target_type'])){
            $email = '';
            switch($params['email_target_type']){
                case 'Email Address':
                    $email = $params['email'];
                    break;
                case 'Specify User':
                    $email = $params['email_user_id'];
                    break;
                case 'Related Field':
                    $email = $params['email_target'];
                    break;
            }
            $html .= "load_emailline('".$line."','to','".$params['email_target_type']."','".$email."');";
        }
        //end backward compatible

        if(isset($params['email_target_type'])){
            foreach($params['email_target_type'] as $key => $field){
                if(is_array($params['email'][$key]))$params['email'][$key] = json_encode($params['email'][$key]);
                $html .= "load_emailline('".$line."','".$params['email_to_type'][$key]."','".$params['email_target_type'][$key]."','".$params['email'][$key]."');";
            }
        }
        $html .= "</script>";

        return $html;

    }

    private function getEmailsFromParams(SugarBean $bean, $params){

        $emails = array();
        //backward compatible
        if(isset($params['email_target_type']) && !is_array($params['email_target_type'])){
            $email = '';
            switch($params['email_target_type']){
                case 'Email Address':
                    $params['email'] = array($params['email']);
                    break;
                case 'Specify User':
                    $params['email'] = array($params['email_user_id']);
                    break;
                case 'Related Field':
                    $params['email'] = array($params['email_target']);
                    break;
            }
            $params['email_target_type'] = array($params['email_target_type']);
            $params['email_to_type'] = array('to');
        }
        //end backward compatible
        if(isset($params['email_target_type'])){
            foreach($params['email_target_type'] as $key => $field){
                switch($field){
                    case 'Email Address':
                        if(trim($params['email'][$key]) != '')
                            $emails[$params['email_to_type'][$key]][] = $params['email'][$key];
                        break;
                    case 'Specify User':
                        $user = new User();
                        $user->retrieve($params['email'][$key]);
                        $user_email = $user->emailAddress->getPrimaryAddress($user);
                        if(trim($user_email) != '') {
                            $emails[$params['email_to_type'][$key]][] = $user_email;
                            $emails['template_override'][$user_email] = array('Users' => $user->id);
                        }

                        break;
                    case 'Users':
                        $users = array();
                        switch($params['email'][$key][0]) {
                            Case 'security_group':
                                if(file_exists('modules/SecurityGroups/SecurityGroup.php')){
                                    require_once('modules/SecurityGroups/SecurityGroup.php');
                                    $security_group = new SecurityGroup();
                                    $security_group->retrieve($params['email'][$key][1]);
                                    $users = $security_group->get_linked_beans( 'users','User');
                                    $r_users = array();
                                    if($params['email'][$key][2] != ''){
                                        require_once('modules/ACLRoles/ACLRole.php');
                                        $role = new ACLRole();
                                        $role->retrieve($params['email'][$key][2]);
                                        $role_users = $role->get_linked_beans( 'users','User');
                                        foreach($role_users as $role_user){
                                            $r_users[$role_user->id] = $role_user->name;
                                        }
                                    }
                                    foreach($users as $user_id => $user){
                                        if($params['email'][$key][2] != '' && !isset($r_users[$user->id])){
                                            unset($users[$user_id]);
                                        }
                                    }
                                    break;
                                }
                            //No Security Group module found - fall through.
                            Case 'role':
                                require_once('modules/ACLRoles/ACLRole.php');
                                $role = new ACLRole();
                                $role->retrieve($params['email'][$key][2]);
                                $users = $role->get_linked_beans( 'users','User');
                                break;
                            Case 'all':
                            default:
                                global $db;
                                $sql = "SELECT id from users WHERE status='Active' AND portal_only=0 ";
                                $result = $db->query($sql);
                                while ($row = $db->fetchByAssoc($result)) {
                                    $user = new User();
                                    $user->retrieve($row['id']);
                                    $users[$user->id] = $user;
                                }
                                break;
                        }
                        foreach($users as $user){
                            $user_email = $user->emailAddress->getPrimaryAddress($user);
                            if(trim($user_email) != '') {
                                $emails[$params['email_to_type'][$key]][] = $user_email;
                                $emails['template_override'][$user_email] = array('Users' => $user->id);
                            }
                        }
                        break;
                    case 'Related Field':
                        $emailTarget = $params['email'][$key];
                        $relatedFields = array_merge($bean->get_related_fields(), $bean->get_linked_fields());
                        $field = $relatedFields[$emailTarget];
                        if($field['type'] == 'relate') {
                            $linkedBeans = array();
                            $id = $bean->$field['id_name'];
                            $linkedBeans[] = BeanFactory::getBean($field['module'], $id);
                        }
                        else if($field['type'] == 'link'){
                            if(isset($field['module']) && $field['module'] != '') {
                                $rel_module = $field['module'];
                            } else if($bean->load_relationship($field['name'])){
                                $rel_module = $bean->$field['name']->getRelatedModuleName();
                            }
                            $linkedBeans = $bean->get_linked_beans($field['name'],$rel_module);
                        }else{
                            $linkedBeans = $bean->get_linked_beans($field['link'],$field['module']);
                        }
                        if($linkedBeans){
                            foreach($linkedBeans as $linkedBean) {
                                $rel_email = $linkedBean->emailAddress->getPrimaryAddress($linkedBean);
                                if (trim($rel_email) != '') {
                                    $emails[$params['email_to_type'][$key]][] = $rel_email;
                                    $emails['template_override'][$rel_email] = array($linkedBean->module_dir => $linkedBean->id);
                                }
                            }
                        }
                        break;
                    case 'Record Email':
                        $recordEmail = $bean->emailAddress->getPrimaryAddress($bean);
                        if($recordEmail == '' && isset($bean->email1)) $recordEmail = $bean->email1;
                        if(trim($recordEmail) != '')
                            $emails[$params['email_to_type'][$key]][] = $recordEmail;
                        break;
                }
            }
        }
        return $emails;
    }

    function run_action(SugarBean $bean, $params = array(), $in_save=false){

        include_once('modules/EmailTemplates/EmailTemplate.php');
        $emailTemp = new EmailTemplate();
        $emailTemp->retrieve($params['email_template']);

        if($emailTemp->id == ''){
            return false;
        }

        $emails = $this->getEmailsFromParams($bean,$params);

        if(!isset($emails['to']) || empty($emails['to']))
            return false;

        $attachments = $this->getAttachments($emailTemp);

        if(isset($params['individual_email']) && $params['individual_email']){

            foreach($emails['to'] as $email_to){
                $emailTemp = new EmailTemplate();
                $emailTemp->retrieve($params['email_template']);
                $template_override = isset($emails['template_override'][$email_to]) ? $emails['template_override'][$email_to] : array();
                $this->parse_template($bean, $emailTemp,$template_override);
                $this->sendEmail(array($email_to), $emailTemp->subject, $emailTemp->body_html, $emailTemp->body, $bean, $emails['cc'],$emails['bcc'],$attachments);
            }

        } else {
            $this->parse_template($bean, $emailTemp);
            return $this->sendEmail($emails['to'], $emailTemp->subject, $emailTemp->body_html, $emailTemp->body, $bean, $emails['cc'],$emails['bcc'],$attachments);
        }
        return true;
    }

    function parse_template(SugarBean $bean, &$template, $object_override = array()){
        global $sugar_config;

        require_once('modules/AOW_Actions/actions/templateParser.php');

        $object_arr[$bean->module_dir] = $bean->id;

        foreach($bean->field_defs as $bean_arr){
            if($bean_arr['type'] == 'relate'){
                if(isset($bean_arr['module']) &&  $bean_arr['module'] != '' && isset($bean_arr['id_name']) &&  $bean_arr['id_name'] != '' && $bean_arr['module'] != 'EmailAddress'){
                    if(isset($bean->field_defs[$bean_arr['id_name']]) && $bean->field_defs[$bean_arr['id_name']]['source'] != 'non-db'){
                        if(!isset($object_arr[$bean_arr['module']])) $object_arr[$bean_arr['module']] = $bean->$bean_arr['id_name'];
                    }
                }
            }
            else if($bean_arr['type'] == 'link'){
                if(!isset($bean_arr['module']) || $bean_arr['module'] == '') $bean_arr['module'] = getRelatedModule($bean->module_dir,$bean_arr['name']);
                if(isset($bean_arr['module']) &&  $bean_arr['module'] != ''&& !isset($object_arr[$bean_arr['module']])&& $bean_arr['module'] != 'EmailAddress'){
                    $linkedBeans = $bean->get_linked_beans($bean_arr['name'],$bean_arr['module'], array(), 0, 1);
                    if($linkedBeans){
                        $linkedBean = $linkedBeans[0];
                        if(!isset($object_arr[$linkedBean->module_dir])) $object_arr[$linkedBean->module_dir] = $linkedBean->id;
                    }
                }
            }
        }

        $object_arr['Users'] = is_a($bean, 'User') ? $bean->id : $bean->assigned_user_id;

        $object_arr = array_merge($object_arr, $object_override);

        $parsedSiteUrl = parse_url($sugar_config['site_url']);
        $host = $parsedSiteUrl['host'];
        if(!isset($parsedSiteUrl['port'])) {
            $parsedSiteUrl['port'] = 80;
        }

        $port		= ($parsedSiteUrl['port'] != 80) ? ":".$parsedSiteUrl['port'] : '';
        $path		= !empty($parsedSiteUrl['path']) ? $parsedSiteUrl['path'] : "";
        $cleanUrl	= "{$parsedSiteUrl['scheme']}://{$host}{$port}{$path}";

        $url =  $cleanUrl."/index.php?module={$bean->module_dir}&action=DetailView&record={$bean->id}";

        $template->subject = str_replace("\$contact_user","\$user",$template->subject);
        $template->body_html = str_replace("\$contact_user","\$user",$template->body_html);
        $template->body = str_replace("\$contact_user","\$user",$template->body);
        $template->subject = aowTemplateParser::parse_template($template->subject, $object_arr);
        $template->body_html = aowTemplateParser::parse_template($template->body_html, $object_arr);
        $template->body_html = str_replace("\$url",$url,$template->body_html);
        $template->body = aowTemplateParser::parse_template($template->body, $object_arr);
        $template->body = str_replace("\$url",$url,$template->body);
    }

    function getAttachments(EmailTemplate $template){

        $attachments = array();
        if($template->id != ''){
            $note_bean = new Note();
            $notes = $note_bean->get_full_list('',"parent_type = 'Emails' AND parent_id = '".$template->id."'");

            if($notes != null){
                foreach ($notes as $note) {
                    $attachments[] = $note;
                }
            }
        }
        return $attachments;
    }

    function sendEmail($emailTo, $emailSubject, $emailBody, $altemailBody, SugarBean $relatedBean = null, $emailCc = array(), $emailBcc = array(), $attachments = array())
    {
        require_once('modules/Emails/Email.php');
        require_once('include/SugarPHPMailer.php');

        $emailObj = new Email();
        $defaults = $emailObj->getSystemDefaultEmail();
        $mail = new SugarPHPMailer();
        $mail->setMailerForSystem();
        $mail->From = $defaults['email'];
        $mail->FromName = $defaults['name'];
        $mail->ClearAllRecipients();
        $mail->ClearReplyTos();
        $mail->Subject=from_html($emailSubject);
        $mail->Body=$emailBody;
        $mail->AltBody = $altemailBody;
        $mail->handleAttachments($attachments);
        $mail->prepForOutbound();

        if(empty($emailTo)) return false;
        foreach($emailTo as $to){
            $mail->AddAddress($to);
        }
        if(!empty($emailCc)){
            foreach($emailCc as $email){
                $mail->AddCC($email);
            }
        }
        if(!empty($emailBcc)){
            foreach($emailBcc as $email){
                $mail->AddBCC($email);
            }
        }

        //now create email
        if (@$mail->Send()) {
            $emailObj->to_addrs= implode(',',$emailTo);
            $emailObj->cc_addrs= implode(',',$emailCc);
            $emailObj->bcc_addrs= implode(',',$emailBcc);
            $emailObj->type= 'out';
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

            return true;
        }
        return false;
    }

}