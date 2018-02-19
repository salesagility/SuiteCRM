<?php
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2018 Salesagility Ltd.
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

/**
 * THIS CLASS IS FOR DEVELOPERS TO MAKE CUSTOMIZATIONS IN
 */
require_once('modules/OutboundEmailAccounts/OutboundEmailAccounts_sugar.php');
class OutboundEmailAccounts extends OutboundEmailAccounts_sugar
{

	/**
	 * @var string
	 */
	public $mail_smtppass;

	function __construct(){
		parent::__construct();
	}

	public function save($check_notify = false) {
		if(!$this->mail_smtppass && $this->id) {
			$bean = new OutboundEmailAccounts();
			$bean->retrieve($this->id);
			if(!$bean->mail_smtppass) {
				$GLOBALS['log']->warn("Unable to send email via SMTP using an empty password.");
                $GLOBALS['log']->info("Please ensure that the email settings are configured correctly");
				$this->mail_smtppass = null;
			} else {
				$this->mail_smtppass = $bean->mail_smtppass;
			}
		}
		$this->mail_smtppass = $this->mail_smtppass ? blowfishEncode(blowfishGetKey('OutBoundEmail'), $this->mail_smtppass) : null;
		$results = parent::save($check_notify);
		return $results;
	}

	public function retrieve($id = -1, $encode = true, $deleted = true) {
		$results = parent::retrieve($id, $encode, $deleted);
		$this->mail_smtppass = $this->mail_smtppass ? blowfishDecode(blowfishGetKey('OutBoundEmail'), $this->mail_smtppass) : null;
		return $results;
	}

	public static function getPasswordChange() {
		global $mod_strings;
		$html = <<<HTML
<script type="text/javascript">
var passwordToggle = function(elem, sel) {
	$(sel).show();
	$(elem).hide();
}
</script>
<div id="password_toggle" style="display:none;">
	<input type="password" id="mail_smtppass" name="mail_smtppass" />
</div>
<a href="javascript:;" onclick="passwordToggle(this, '#password_toggle');">{$mod_strings['LBL_CHANGE_PASSWORD']}</a>

HTML;
		return $html;
	}

	public static function getEmailProviderChooser($focus, $name, $value, $view) {
		global $app_strings, $mod_strings;
		$ss = new Sugar_Smarty();
		$ss->assign('APP', $app_strings);
		$ss->assign('MOD', $mod_strings);
		$ss->assign('mail_smtptype', $focus->mail_smtptype);
		$html = $ss->fetch('modules/OutboundEmailAccounts/smtpPreselection.tpl');
		return $html;
	}

	public static function getSendTestEmailBtn() {
		global $app_strings, $current_user;
		$APP = $app_strings;
		$CURRENT_USER_EMAIL = $current_user->email1;
		$admin = new Administration();
		$admin->retrieveSettings();
		$adminNotifyFromAddress = $admin->settings['notify_fromaddress'];
		$adminNotifyFromName = $admin->settings['notify_fromname'];
		$html = <<<HTML
			<input type="button" class="button" value="{$APP['LBL_EMAIL_TEST_OUTBOUND_SETTINGS']}" onclick="testOutboundSettings();">
			<script type="text/javascript" src="cache/include/javascript/sugar_grp_yui_widgets.js"></script>
			<script type="text/javascript">

				function overlay(reqtitle, body, type) {
					var config = { };
					config.type = type;
					config.title = reqtitle;
					config.msg = body;
					YAHOO.SUGAR.MessageBox.show(config);
				}

				function hideOverlay() {
					YAHOO.SUGAR.MessageBox.hide();
				}


				var EmailMan = {};

				var testOutboundSettings = function() {
					testOutboundSettingsDialog();
				};

				function testOutboundSettingsDialog() {
					// lazy load dialogue
					if(!EmailMan.testOutboundDialog) {
						EmailMan.testOutboundDialog = new YAHOO.widget.Dialog("testOutboundDialog", {
							modal:true,
							visible:true,
							fixedcenter: false,
							constraintoviewport: false,
							width   : 600,
							shadow  : false
						});
						EmailMan.testOutboundDialog.setHeader("{$APP['LBL_EMAIL_TEST_OUTBOUND_SETTINGS']}");
						YAHOO.util.Dom.removeClass("testOutboundDialog", "yui-hidden");
					} // end lazy load

					EmailMan.testOutboundDialog.render();
					EmailMan.testOutboundDialog.show();
				}
                
                                function showFullSmtpLogDialog(headerText, bodyHtml, dialogType) {

                                     var config = { };
                                     config.type = dialogType;
                                     config.title = headerText;
                                     config.msg = bodyHtml;
                                     config.modal = false;
                                     config.width = 600;
                                     YAHOO.SUGAR.MessageBox.show(config);
                                }
				
				function sendTestEmail() {
					var toAddress = document.getElementById("outboundtest_to_address").value;
					
					if (trim(toAddress) == "") 
					{
						overlay("{$APP['ERR_MISSING_REQUIRED_FIELDS']}", "{$APP['LBL_EMAIL_SETTINGS_FROM_TO_EMAIL_ADDR']}", 'alert');
						//return;
					}
					else if (!isValidEmail(toAddress)) {
						overlay("{$APP['ERR_INVALID_REQUIRED_FIELDS']}", "{$APP['LBL_EMAIL_SETTINGS_FROM_TO_EMAIL_ADDR']}", 'alert');
						return;
					}
					
					//Hide the email address window and show a message notifying the user that the test email is being sent.
					EmailMan.testOutboundDialog.hide();
					overlay("{$APP['LBL_EMAIL_PERFORMING_TASK']}", "{$APP['LBL_EMAIL_ONE_MOMENT']}", 'alert');
                    
					var callbackOutboundTest = {
						success	: function(o) {
							hideOverlay();
							var responseObject = YAHOO.lang.JSON.parse(o.responseText);
							if (responseObject.status)
								overlay("{$APP['LBL_EMAIL_TEST_OUTBOUND_SETTINGS']}", "{$APP['LBL_EMAIL_TEST_NOTIFICATION_SENT']}", 'alert');
       							else {
                                
                                                           var dialogBody = 
                                                            "<div style='padding: 10px'>" +
                                                               "<div class='well'>" + responseObject.errorMessage + "</div>" +
                                                               "<div >" +
                                                                   "<button class='btn btn-primary' type='button' data-toggle='collapse' data-target='#fullSmtpLog' aria-expanded='false' aria-controls='fullSmtpLog'>" + 
                                                                       "{$APP['LBL_EMAIL_TEST_SEE_FULL_SMTP_LOG']}" +
                                                                  "</button>" +
                                                                   "<div class='collapse' id='fullSmtpLog'>" +
                                                                       "<pre style='height: 300px; overflow: scroll;'>" +
                                                                           responseObject.fullSmtpLog + 
                                                                       "</pre>" +
                                                                   "</div>" +
                                                               "</div>" +
                                                           "</div>";
                                                           showFullSmtpLogDialog("{$APP['LBL_EMAIL_TEST_OUTBOUND_SETTINGS']}", dialogBody, 'alert');
                                                        }
						}
					};

					var smtpServer = document.getElementById('mail_smtpserver').value;
					var smtpPort = document.getElementById('mail_smtpport').value;
					var smtpssl  = document.getElementById('mail_smtpssl').value;
					var mailsmtpauthreq = document.getElementById('mail_smtpauth_req');
					var mail_sendtype = 'SMTP'; 
                                                                var adminNotifyFromAddress = document.getElementById('smtp_from_addr').value ? document.getElementById('smtp_from_addr').value :'$adminNotifyFromName';
                                                                var adminNotifyFromName = document.getElementById('smtp_from_name').value ? document.getElementById('smtp_from_name').value : '$adminNotifyFromAddress';
					var postDataString =
						'mail_type=system&' +
						'mail_sendtype=' + mail_sendtype + '&' +
						'mail_smtpserver=' + smtpServer + "&" +
						"mail_smtpport=" + smtpPort + "&mail_smtpssl=" + smtpssl + "&" +
						"mail_smtpauth_req=" + mailsmtpauthreq.checked + "&" +
						"mail_smtpuser=" + trim(document.getElementById('mail_smtpuser').value) + "&" +
						"mail_smtppass=" + trim(document.getElementById('mail_smtppass').value) + "&" +
						"outboundtest_to_address=" + toAddress + '&' +
						'outboundtest_from_address=' + adminNotifyFromAddress + '&' +
						'mail_from_name=' + adminNotifyFromName;
					//YAHOO.util.Connect.asyncRequest("POST", "index.php?action=EmailUIAjax&module=Emails&emailUIAction=testOutbound&to_pdf=true&sugar_body_only=true", callbackOutboundTest, postDataString);
					YAHOO.util.Connect.asyncRequest("POST", "index.php?action=testOutboundEmail&module=EmailMan&to_pdf=true&sugar_body_only=true", callbackOutboundTest, postDataString);
				}

			</script>

			<div id="testOutboundDialog" class="yui-hidden">
				<div id="testOutbound">
					<form>
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="edit view">
						<tr>
							<td scope="row">
								{$APP['LBL_EMAIL_SETTINGS_FROM_TO_EMAIL_ADDR']}
								<span class="required">
								</span>
							</td>
							<td>
								<input type="text" id="outboundtest_to_address" name="outboundtest_to_address" size="35" maxlength="64" value="{$CURRENT_USER_EMAIL}">
							</td>
						</tr>
						<tr>
							<td scope="row" colspan="2">
								<input type="button" class="button" value="   {$APP['LBL_EMAIL_SEND']}   " onclick="javascript:sendTestEmail();">&nbsp;
								<input type="button" class="button" value="   {$APP['LBL_CANCEL_BUTTON_LABEL']}   " onclick="javascript:EmailMan.testOutboundDialog.hide();">&nbsp;
							</td>
						</tr>
					</table>
					</form>
				</div>
			</div>
HTML;
		return $html;
	}
	
}
