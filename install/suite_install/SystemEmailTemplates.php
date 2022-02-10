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
 * Install System Email Templates
 */
function installSystemEmailTemplates()
{
    require_once __DIR__ . '/../../modules/EmailTemplates/EmailTemplate.php';
    global $sugar_config;

    $templates = getSystemEmailTemplates();
    foreach ($templates as $configKey => $templateData) {
        if (
            isset($sugar_config['system_email_templates'])
            && isset($sugar_config['system_email_templates'][$configKey . "_id"])
            && !empty($sugar_config['system_email_templates'][$configKey . "_id"])
        ) {
            continue;
        }

        $template = BeanFactory::newBean('EmailTemplates');
        foreach ($templateData as $field => $value) {
            $template->$field = $value;
        }
        $template->save();
        $sugar_config['system_email_templates'][$configKey . "_id"] = $template->id;
    }

    ksort($sugar_config);
    write_array_to_file('sugar_config', $sugar_config, 'config.php');
}

/**
 * upgrade System Email Templates
 */
function upgradeSystemEmailTemplates()
{
    installSystemEmailTemplates();
}

function setSystemEmailTemplatesDefaultConfig()
{
    global $sugar_config;


    // set confirm_opt_in_template
    if (
        isset($sugar_config['system_email_templates'])
        && isset($sugar_config['system_email_templates']['confirm_opt_in_template' . "_id"])
        && isset($sugar_config['email_enable_confirm_opt_in'])
    ) {
        $sugar_config['email_confirm_opt_in_email_template_id'] =
            $sugar_config['system_email_templates']['confirm_opt_in_template' . "_id"];
    }

    ksort($sugar_config);
    write_array_to_file('sugar_config', $sugar_config, 'config.php');
}


/**
 * @return array
 */
function getSystemEmailTemplates()
{
    $templates = array();
    $templates['confirm_opt_in_template'] = array(
        'name' => 'Confirmed Opt In',
        'published' => 'off',
        'description' => 'Email template to send to a contact to confirm they have opted in.',
        'subject' => 'Confirm Opt In',
        'type' => 'system',
        'body' => 'Hi $contact_first_name $contact_last_name, \n Please confirm that you have opted in by selecting the following link: $sugarurl/index.php?entryPoint=ConfirmOptIn&from=$emailaddress_email_address',
        'body_html' =>
            '<p>Hi $contact_first_name $contact_last_name,</p>
             <p>
                Please confirm that you have opted in by selecting the following link:
                <a href="$sugarurl/index.php?entryPoint=ConfirmOptIn&from=$emailaddress_confirm_opt_in_token">Opt In</a>
             </p>'
    );

    return $templates;
}
