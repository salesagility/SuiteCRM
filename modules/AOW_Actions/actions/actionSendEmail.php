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
        global $beanFiles, $beanList, $app_list_strings;

        foreach($app_list_strings['aow_moduleList'] as $bean_name => $bean_dis) {

            if(isset($beanList[$bean_name]) && isset($beanFiles[$beanList[$bean_name]])){
                require_once($beanFiles[$beanList[$bean_name]]);
                $obj = new $beanList[$bean_name];
                if($obj instanceof Person || $obj instanceof Company){
                    $this->emailableModules[] = $bean_name;
                }
            }
        }
        asort($this->emailableModules);
        parent::actionBase($id);
    }

    function loadJS(){
        return array('modules/AOW_Actions/actions/actionSendEmail.js');
    }

    function edit_display($line,SugarBean $bean = null, $params = array()){
        global $mod_strings, $app_list_strings;
        $email_templates_arr = get_bean_select_array(true, 'EmailTemplate','name');

        $targetOptions = array();
        foreach($bean->get_related_fields() as $field){
            if(!isset($field['module']) || !in_array($field['module'],$this->emailableModules) || (isset($field['dbType']) && $field['dbType'] == "id")){
                continue;
            }
            $targetOptions[$field['name']] = $field['module'].": ".trim(translate($field['vname'],$bean->module_name),":");
        }

        array_multisort($targetOptions, SORT_ASC, $targetOptions);

        if(!array_key_exists('email_target_type',(array)$params)){
            $params['email_target_type'] = 'Email Address';
        }

        if(!in_array($bean->module_dir,$this->emailableModules)) unset($app_list_strings['aow_email_type_list']['Record Email']);
        if(empty($targetOptions)) unset($app_list_strings['aow_email_type_list']['Related Field']);


        $html = "<table border='0' cellpadding='0' cellspacing='0' width='100%'>";
        $html .= "<tr>";
        $html .= '<td id="name_label" scope="row" valign="top" width="12.5%">'.translate("LBL_EMAIL","AOW_Actions").':<span class="required">*</span></td>';
        $html .= '<td valign="top" width="37.5%">';

        $html .= "\n<select onchange='targetTypeChanged(".$line.")' id='aow_actions_param_email_target_type".$line."' name='aow_actions_param[".$line."][email_target_type]'>".get_select_options_with_id($app_list_strings['aow_email_type_list'],$params['email_target_type'] )."</select>";


        //Related field inputs
        $hideRelated = $params['email_target_type'] != "Related Field" ? "style='display: none;'" : '';
        $html .= "\n<select $hideRelated name='aow_actions_param[".$line."][email_target]' id='aow_actions_param_email_target".$line."' >".get_select_options_with_id($targetOptions,isset($params['email_target'])? $params['email_target'] : '')."</select>";


        //User Input
        $emailUserId = array_key_exists('email_user_id',(array)$params) ? $params['email_user_id'] : '';
        $emailUserName = array_key_exists('email_user_name',(array)$params) ? $params['email_user_name'] : '';

        $hideUser = $params['email_target_type'] != "Specify User" ? "style='display: none;'" : '';
        $html .= <<<EOS

        <span $hideUser id="aow_actions_email_user_span$line">
<input type="text"
        name="aow_actions_param[$line][email_user_name]" class="sqsEnabled" tabindex="1"
        id="aow_actions_param[$line][email_user_name]" size="" value="$emailUserName" title='' autocomplete="off"  	 >
<input type="hidden" name="aow_actions_param[$line][email_user_id]"
	id="aow_actions_param[$line][email_user_id]"
	value="$emailUserId">
<span class="id-ff multiple">
<button type="button"
    name="btn_aow_actions_param[$line][email_user_name]"
    id="btn_aow_actions_param[$line][email_user_name]" tabindex="1"
    title="Select User" class="button firstChild" value="Select User"
onclick="open_popup(
    'Users',
	600,
	400,
	'',
	true,
	false,
	{'call_back_function':'set_return',
	    'form_name':'EditView',
	    'field_to_name_array':{
	                'id':'aow_actions_param[$line][email_user_id]',
	                'user_name':'aow_actions_param[$line][email_user_name]'}},
	'single',
	true
);" ><img src="themes/default/images/id-ff-select.png?v=lSCqV0_gGHDPkVH62imIiQ"></button>
<button type="button"
    name="btn_clr_aow_actions_param[$line][email_user_name]"
    id="btn_clr_aow_actions_param[$line][email_user_name]" tabindex="1" title="Clear User"  class="button lastChild"
onclick="SUGAR.clearRelateField(this.form, 'aow_actions_param[$line][email_user_name]', 'aow_actions_param[$line][email_user_id]');"  value="Clear User" ><img src="themes/default/images/id-ff-clear.png?v=lSCqV0_gGHDPkVH62imIiQ"></button>
</span>
<script type="text/javascript">
SUGAR.util.doWhen(
		"typeof(sqs_objects) != 'undefined' && typeof(sqs_objects['EditView_aow_actions_param[$line]['email_user_name']']) != 'undefined'",
		enableQS
);
</script>
</span>

EOS;

        if(!isset($params['email'])) $params['email'] = '';
        if(!isset($params['email_template'])) $params['email_template'] = '';

        $hidden = "style='visibility: hidden;'";
        if($params['email_template'] != '') $hidden = "";

        //Email input
        $hideEmail = $params['email_target_type'] != "Email Address" ? "style='display: none;'" : '';
        $html .= '<input '.$hideEmail.' name="aow_actions_param['.$line.'][email]" id="aow_actions_param_email'.$line.'" size="30" maxlength="255" value="'.$params['email'].'" type="text">';

        $html .= '</td>';

        $html .= '<td id="name_label" scope="row" valign="top" width="12.5%">'.translate("LBL_EMAIL_TEMPLATE","AOW_Actions").':<span class="required">*</span></td>';
        $html .= "<td valign='top' width='37.5%'>";
        $html .= "<select name='aow_actions_param[".$line."][email_template]' id='aow_actions_param_email_template".$line."' onchange='show_edit_template_link(this,".$line.");' >".get_select_options_with_id($email_templates_arr, $params['email_template'])."</select>";

        $html .= "&nbsp;<a href='javascript:open_email_template_form(".$line.")' >".translate('LBL_CREATE_EMAIL_TEMPLATE','AOW_Actions')."</a>";
        $html .= "&nbsp;<span name='edit_template' id='aow_actions_edit_template_link".$line."' $hidden><a href='javascript:edit_email_template_form(".$line.")' >".translate('LBL_EDIT_EMAIL_TEMPLATE','AOW_Actions')."</a></span>";
        $html .= "</td>";
        $html .= "</tr>";
        $html .= "</table>";

        return $html;

    }

    private function getEmailFromParams(SugarBean $bean, $params){
        if(!array_key_exists('email_target_type',$params)){
            return '';
        }

        switch($params['email_target_type']){
            case 'Email Address':
                return array_key_exists('email', $params) ? $params['email'] : '';
            case 'Specify User':
                $user = new User();
                $user->retrieve($params['email_user_id']);
                return $user->emailAddress->getPrimaryAddress($user);
                break;
            case 'Related Field':
                $emailTarget = $params['email_target'];
                $relatedFields = $bean->get_related_fields();
                $field = $relatedFields[$emailTarget];
                if($field['type'] == 'relate'){
                    $linkedBeans = array();
                    $id = $bean->$field['id_name'];
                    $linkedBeans[] = BeanFactory::getBean($field['module'],$id);
                }else{
                    $linkedBeans = $bean->get_linked_beans($field['link'],$field['module']);
                }
                if($linkedBeans){
                    $linkedBean = $linkedBeans[0];
                    return $linkedBean->emailAddress->getPrimaryAddress($linkedBean);
                }
                break;
            case 'Record Email':
                return $bean->emailAddress->getPrimaryAddress($bean);
                break;
            default:
                return '';
        }
        return "";
    }

    function run_action(SugarBean $bean, $params = array()){
        global $sugar_config;

        include_once('modules/EmailTemplates/EmailTemplate.php');
        $emailTemp = new EmailTemplate();
        $emailTemp->retrieve($params['email_template']);

        $object_arr[$bean->module_dir] = $bean->id;

        $parsedSiteUrl = parse_url($sugar_config['site_url']);
        $host = $parsedSiteUrl['host'];
        if(!isset($parsedSiteUrl['port'])) {
            $parsedSiteUrl['port'] = 80;
        }

        $port		= ($parsedSiteUrl['port'] != 80) ? ":".$parsedSiteUrl['port'] : '';
        $path		= !empty($parsedSiteUrl['path']) ? $parsedSiteUrl['path'] : "";
        $cleanUrl	= "{$parsedSiteUrl['scheme']}://{$host}{$port}{$path}";

        $url =  $cleanUrl."/index.php?module={$bean->module_dir}&action=DetailView&record={$bean->id}";

        $subject = $emailTemp->parse_template($emailTemp->subject, $object_arr);
        $body_html = $emailTemp->parse_template($emailTemp->body_html, $object_arr);
        $body_html = str_replace("\$url",$url,$body_html);
        $body_plain = $emailTemp->parse_template($emailTemp->body, $object_arr);
        $body_plain = str_replace("\$url",$url,$body_plain);
        $email = $this->getEmailFromParams($bean,$params);
        return $this->sendEmail($email, $subject, $body_html, $body_plain, $bean);

    }

    function sendEmail($emailTo, $emailSubject, $emailBody, $altemailBody, SugarBean $relatedBean = null, $attachments = array())
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
        $mail->AddAddress($emailTo);

        //now create email
        if (@$mail->Send()) {
            $emailObj->to_addrs= $emailTo;
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

            return true;
        }
        return false;
    }

}