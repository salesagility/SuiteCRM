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

require('config.php');
global $sugar_config;
global $timedate;
global $mod_strings;

//Sent when the admin generate a new password
$EmailTemp = new EmailTemplate();
$EmailTemp->name = $mod_strings['advanced_password_new_account_email']['name'];
$EmailTemp->description = $mod_strings['advanced_password_new_account_email']['description'];
$EmailTemp->subject = $mod_strings['advanced_password_new_account_email']['subject'];
$EmailTemp->body = $mod_strings['advanced_password_new_account_email']['txt_body'];
$EmailTemp->body_html = $mod_strings['advanced_password_new_account_email']['body'];
$EmailTemp->deleted = 0;
$EmailTemp->published = 'off';
$EmailTemp->text_only = 0;
$id =$EmailTemp->save();
$sugar_config['passwordsetting']['generatepasswordtmpl'] = $id;

//User generate a link to set a new password
$EmailTemp = new EmailTemplate();
$EmailTemp->name = $mod_strings['advanced_password_forgot_password_email']['name'];
$EmailTemp->description = $mod_strings['advanced_password_forgot_password_email']['description'];
$EmailTemp->subject = $mod_strings['advanced_password_forgot_password_email']['subject'];
$EmailTemp->body = $mod_strings['advanced_password_forgot_password_email']['txt_body'];
$EmailTemp->body_html = $mod_strings['advanced_password_forgot_password_email']['body'];
$EmailTemp->deleted = 0;
$EmailTemp->published = 'off';
$EmailTemp->text_only = 0;
$id =$EmailTemp->save();
$sugar_config['passwordsetting']['lostpasswordtmpl'] = $id;

// set all other default settings
$sugar_config['passwordsetting']['forgotpasswordON'] = true;
$sugar_config['passwordsetting']['SystemGeneratedPasswordON'] = true;
$sugar_config['passwordsetting']['systexpirationtime'] = 7;
$sugar_config['passwordsetting']['systexpiration'] = 1;
$sugar_config['passwordsetting']['linkexpiration'] = true;
$sugar_config['passwordsetting']['linkexpirationtime'] = 24;
$sugar_config['passwordsetting']['linkexpirationtype'] = 60;
$sugar_config['passwordsetting']['minpwdlength'] = 6;
$sugar_config['passwordsetting']['oneupper'] = false;
$sugar_config['passwordsetting']['onelower'] = false;
$sugar_config['passwordsetting']['onenumber'] = false;

write_array_to_file( "sugar_config", $sugar_config, "config.php");
