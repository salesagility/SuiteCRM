<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
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

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

function install_aos() {

    require_once('modules/Administration/Administration.php');

	global $sugar_config;

	$sugar_config['aos']['version'] = '5.3.3';
    if(!isset($sugar_config['aos']['contracts']['renewalReminderPeriod'])) {
        $sugar_config['aos']['contracts']['renewalReminderPeriod'] = '14';
    }
    if(!isset($sugar_config['aos']['lineItems']['totalTax'])) {
        $sugar_config['aos']['lineItems']['totalTax'] = false;
    }
    if(!isset($sugar_config['aos']['lineItems']['enableGroups'])) {
        $sugar_config['aos']['lineItems']['enableGroups'] = true;
    }
    if(!isset($sugar_config['aos']['invoices']['initialNumber'])) {
        $sugar_config['aos']['invoices']['initialNumber'] = '1';
    }
    if(!isset($sugar_config['aos']['quotes']['initialNumber'])) {
        $sugar_config['aos']['quotes']['initialNumber'] = '1';
    }
	
	ksort($sugar_config);
	write_array_to_file('sugar_config', $sugar_config, 'config.php');
		
}

function upgrade_aos(){
    global $sugar_config, $db;
    if(!isset($sugar_config['aos']['version']) || $sugar_config['aos']['version'] < 5.2){
        $db->query("UPDATE  aos_pdf_templates SET type = 'AOS_Quotes' WHERE type = 'Quotes'");
        $db->query("UPDATE  aos_pdf_templates SET type = 'AOS_Invoices' WHERE type = 'Invoices'");

        require_once('include/utils/file_utils.php');

        $old_files = array(
            'custom/Extension/modules/Accounts/Ext/Layoutdefs/Account.php',
            'custom/Extension/modules/Accounts/Ext/Vardefs/Account.php',
            'custom/Extension/modules/Contacts/Ext/Layoutdefs/Contact.php',
            'custom/Extension/modules/Contacts/Ext/Vardefs/Contact.php',
            'custom/Extension/modules/Opportunities/Ext/Layoutdefs/Opportunity.php',
            'custom/Extension/modules/Opportunities/Ext/Vardefs/Opportunity.php',
            'custom/Extension/modules/Project/Ext/Layoutdefs/Project.php',
            'custom/Extension/modules/Project/Ext/Vardefs/Project.php',
            'modules/AOS_Quotes/js/Quote.js',
        );

        foreach($old_files as $old_file){
            if( file_exists($old_file)){
                create_custom_directory('bak_aos/'.$old_file);
                sugar_rename($old_file, 'custom/bak_aos/'.$old_file);
            }
        }

    }
}
?>
