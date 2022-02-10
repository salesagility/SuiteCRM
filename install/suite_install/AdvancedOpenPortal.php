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
 * install aop
 */
function install_aop()
{
    require_once __DIR__ . '/../../modules/EmailTemplates/EmailTemplate.php';
    global $sugar_config;
    $sugar_config['aop']['enable_portal'] = false;
    $sugar_config['aop']['joomla_url'] = '';
    $sugar_config['aop']['distribution_user_id'] = '';
    $sugar_config['aop']['support_from_address'] = '';
    $sugar_config['aop']['support_from_name'] = '';
    $sugar_config['aop'] = array('distribution_method' => 'roundRobin');
    $templates = getTemplates();
    foreach ($templates as $configKey => $templateData) {
        $template = BeanFactory::newBean('EmailTemplates');
        foreach ($templateData as $field => $value) {
            $template->$field = $value;
        }
        $template->save();
        $sugar_config['aop'][$configKey . "_id"] = $template->id;
    }
    ksort($sugar_config);
    write_array_to_file('sugar_config', $sugar_config, 'config.php');

    installAOPHooks();
}

/**
 * installAOPHooks
 */
function installAOPHooks()
{
    require_once __DIR__ . '/../../ModuleInstall/ModuleInstaller.php';

    $hooks = array(
        //Contacts
        array(
            'module' => 'Contacts',
            'hook' => 'after_save',
            'order' => 1,
            'description' => 'Update Portal',
            'file' => 'modules/Contacts/updatePortal.php',
            'class' => 'updatePortal',
            'function' => 'updateUser',
        ),
        // Cases
        array(
            'module' => 'Cases',
            'hook' => 'before_save',
            'order' => 10,
            'description' => 'Save case updates',
            'file' => 'modules/AOP_Case_Updates/CaseUpdatesHook.php',
            'class' => 'CaseUpdatesHook',
            'function' => 'saveUpdate',
        ),
        array(
            'module' => 'Cases',
            'hook' => 'before_save',
            'order' => 11,
            'description' => 'Save case events',
            'file' => 'modules/AOP_Case_Events/CaseEventsHook.php',
            'class' => 'CaseEventsHook',
            'function' => 'saveUpdate',
        ),
        array(
            'module' => 'Cases',
            'hook' => 'before_save',
            'order' => 12,
            'description' => 'Case closure prep',
            'file' => 'modules/AOP_Case_Updates/CaseUpdatesHook.php',
            'class' => 'CaseUpdatesHook',
            'function' => 'closureNotifyPrep',
        ),
        array(
            'module' => 'Cases',
            'hook' => 'after_save',
            'order' => 10,
            'description' => 'Send contact case closure email',
            'file' => 'modules/AOP_Case_Updates/CaseUpdatesHook.php',
            'class' => 'CaseUpdatesHook',
            'function' => 'closureNotify',
        ),
        array(
            'module' => 'Cases',
            'hook' => 'after_relationship_add',
            'order' => 9,
            'description' => 'Assign account',
            'file' => 'modules/AOP_Case_Updates/CaseUpdatesHook.php',
            'class' => 'CaseUpdatesHook',
            'function' => 'assignAccount',
        ),
        array(
            'module' => 'Cases',
            'hook' => 'after_relationship_add',
            'order' => 10,
            'description' => 'Send contact case email',
            'file' => 'modules/AOP_Case_Updates/CaseUpdatesHook.php',
            'class' => 'CaseUpdatesHook',
            'function' => 'creationNotify',
        ),
        array(
            'module' => 'Cases',
            'hook' => 'after_retrieve',
            'order' => 10,
            'description' => 'Filter HTML',
            'file' => 'modules/AOP_Case_Updates/CaseUpdatesHook.php',
            'class' => 'CaseUpdatesHook',
            'function' => 'filterHTML',
        ),
        //Emails
        array(
            'module' => 'Emails',
            'hook' => 'after_save',
            'order' => 10,
            'description' => 'Save email case updates',
            'file' => 'modules/AOP_Case_Updates/CaseUpdatesHook.php',
            'class' => 'CaseUpdatesHook',
            'function' => 'saveEmailUpdate',
        ),
    );

    foreach ($hooks as $hook) {
        check_logic_hook_file(
            $hook['module'],
            $hook['hook'],
            array($hook['order'], $hook['description'], $hook['file'], $hook['class'], $hook['function'])
        );
    }
}

/**
 * @return array
 */
function getTemplates()
{
    $templates = array();
    $templates['case_closure_email_template'] = array(
        'name' => 'Case Closure',
        'published' => 'off',
        'description' => 'Template for informing a contact that their case has been closed.',
        'subject' => '$acase_name [CASE:$acase_case_number] closed',
        'type' => 'system',
        'body' => 'Hi $contact_first_name $contact_last_name,

					   Your case $acase_name (# $acase_case_number) has been closed on $acase_date_entered
					   Status:				$acase_status
					   Reference:			$acase_case_number
					   Resolution:			$acase_resolution',
        'body_html' => '<p> Hi $contact_first_name $contact_last_name,</p>
					    <p>Your case $acase_name (# $acase_case_number) has been closed on $acase_date_entered</p>
					    <table border="0"><tbody>
					    <tr><td>Status</td><td>$acase_status</td></tr>
					    <tr><td>Reference</td><td>$acase_case_number</td></tr>
					    <tr><td>Resolution</td><td>$acase_resolution</td></tr>
					    </tbody></table>'
    );

    $templates['joomla_account_creation_email_template'] = array(
        'name' => 'Joomla Account Creation',
        'published' => 'off',
        'description' => 'Template used when informing a contact that they\'ve been given an account on the joomla portal.',
        'subject' => 'Support Portal Account Created',
        'type' => 'system',
        'body' => 'Hi $contact_name,
					   An account has been created for you at $portal_address.
					   You may login using this email address and the password $joomla_pass',
        'body_html' => '<p>Hi $contact_name,</p>
					    <p>An account has been created for you at <a href="$portal_address">$portal_address</a>.</p>
					    <p>You may login using this email address and the password $joomla_pass</p>'
    );

    $templates['case_creation_email_template'] = array(
        'name' => 'Case Creation',
        'published' => 'off',
        'description' => 'Template to send to a contact when a case is received from them.',
        'subject' => '$acase_name [CASE:$acase_case_number]',
        'type' => 'system',
        'body' => 'Hi $contact_first_name $contact_last_name,

					   We\'ve received your case $acase_name (# $acase_case_number) on $acase_date_entered
					   Status:		$acase_status
					   Reference:	$acase_case_number
					   Description:	$acase_description',
        'body_html' => '<p> Hi $contact_first_name $contact_last_name,</p>
					    <p>We\'ve received your case $acase_name (# $acase_case_number) on $acase_date_entered</p>
					    <table border="0"><tbody>
					    <tr><td>Status</td><td>$acase_status</td></tr>
					    <tr><td>Reference</td><td>$acase_case_number</td></tr>
					    <tr><td>Description</td><td>$acase_description</td></tr>
					    </tbody></table>'
    );

    $templates['contact_email_template'] = array(
        'name' => 'Contact Case Update',
        'published' => 'off',
        'description' => 'Template to send to a contact when their case is updated.',
        'subject' => '$acase_name update [CASE:$acase_case_number]',
        'type' => 'system',
        'body' => 'Hi $user_first_name $user_last_name,

					   You\'ve had an update to your case $acase_name (# $acase_case_number) on $aop_case_updates_date_entered:
					       $contact_first_name $contact_last_name, said:
					               $aop_case_updates_description',
        'body_html' => '<p>Hi $contact_first_name $contact_last_name,</p>
					    <p> </p>
					    <p>You\'ve had an update to your case $acase_name (# $acase_case_number) on $aop_case_updates_date_entered:</p>
					    <p><strong>$user_first_name $user_last_name said:</strong></p>
					    <p style="padding-left:30px;">$aop_case_updates_description</p>'
    );

    $templates['user_email_template'] = array(
        'name' => 'User Case Update',
        'published' => 'off',
        'description' => 'Email template to send to a SuiteCRM user when their case is updated.',
        'subject' => '$acase_name (# $acase_case_number) update',
        'type' => 'system',
        'body' => 'Hi $user_first_name $user_last_name,

					   You\'ve had an update to your case $acase_name (# $acase_case_number) on $aop_case_updates_date_entered:
					       $contact_first_name $contact_last_name, said:
					               $aop_case_updates_description
                        You may review this Case at:
                            $sugarurl/index.php?module=Cases&action=DetailView&record=$acase_id;',
        'body_html' => '<p>Hi $user_first_name $user_last_name,</p>
					     <p> </p>
					     <p>You\'ve had an update to your case $acase_name (# $acase_case_number) on $aop_case_updates_date_entered:</p>
					     <p><strong>$contact_first_name $contact_last_name, said:</strong></p>
					     <p style="padding-left:30px;">$aop_case_updates_description</p>
					     <p>You may review this Case at: $sugarurl/index.php?module=Cases&action=DetailView&record=$acase_id;</p>'
    );

    return $templates;
}
