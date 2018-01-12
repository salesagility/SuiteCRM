<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
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
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

/**
 * install email templates
 */
function install_email_templates() {
    $templates = getEmailTemplateDefaults();
    foreach ($templates as $configKey => $templateData) {
        $template = new EmailTemplate();
        foreach ($templateData as $field => $value) {
            $template->$field = $value;
        }
        $template->save();
        $sugar_config['email_templates'][$configKey . "_id"] = $template->id;
    }
    ksort($sugar_config);
    write_array_to_file('sugar_config', $sugar_config, 'config.php');
}

/**
 * return default email templates data
 * 
 * @return string
 */
function getEmailTemplateDefaults() {
    
    $templates['confirmed_opt_in_template'] = array(
        'name' => 'Confirmed Opt In',
        'published' => 'off',
        'description' => 'Email template to send to a contact to confirm they have opted in.',
        'subject' => 'Confirm Opt In',
        'type' => 'system',
        'body' => 'Hi \$user_first_name \$user_last_name, \n Please confirm that you have opted in by selecting the following link: \$sugarurl/index.php?entryPoint=ConfirmOptIn&from=\$contact_email1',
        'body_html' =>
            '<p>Hi $user_first_name $user_last_name,</p>
             <p>
                Please confirm that you have opted in by selecting the following link:
                <a href="$sugarurl/index.php?entryPoint=ConfirmOptIn&from=$contact_email1">Opt In</a>
             </p>'
    );
    
    return $templates;
}