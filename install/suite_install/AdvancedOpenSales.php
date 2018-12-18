<?php
function install_aos() {

    require_once('modules/Administration/Administration.php');

	global $sugar_config;

	$sugar_config['aos']['version'] = '5.3.3';
    if(!isset($sugar_config['aos']['contracts']['renewalReminderPeriod'])) $sugar_config['aos']['contracts']['renewalReminderPeriod'] = '14';
    if(!isset($sugar_config['aos']['lineItems']['totalTax'])) $sugar_config['aos']['lineItems']['totalTax'] = false;
    if(!isset($sugar_config['aos']['lineItems']['enableGroups'])) $sugar_config['aos']['lineItems']['enableGroups'] = true;
    if(!isset($sugar_config['aos']['invoices']['initialNumber'])) $sugar_config['aos']['invoices']['initialNumber'] = '1';
    if(!isset($sugar_config['aos']['quotes']['initialNumber'])) $sugar_config['aos']['quotes']['initialNumber'] = '1';
	
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
