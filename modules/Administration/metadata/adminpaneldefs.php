<?php
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

global $current_user,$admin_group_header;

//users and security.
$admin_option_defs=array();
$admin_option_defs['Users']['user_management']= array('UserManagement','LBL_MANAGE_USERS_TITLE','LBL_MANAGE_USERS','./index.php?module=Users&action=index', 'user-management');
$admin_option_defs['Users']['roles_management']= array('Roles','LBL_MANAGE_ROLES_TITLE','LBL_MANAGE_ROLES','./index.php?module=ACLRoles&action=index', 'roles');
$admin_option_defs['Administration']['password_management']= array('Password','LBL_MANAGE_PASSWORD_TITLE','LBL_MANAGE_PASSWORD','./index.php?module=Administration&action=PasswordManager', 'password');
$admin_group_header[]= array('LBL_USERS_TITLE','',false,$admin_option_defs, 'LBL_USERS_DESC');
$license_management = false;
    if (!isset($GLOBALS['sugar_config']['hide_admin_licensing']) || !$GLOBALS['sugar_config']['hide_admin_licensing']) {
        $license_management = array('License','LBL_MANAGE_LICENSE_TITLE','LBL_MANAGE_LICENSE','./index.php?module=Administration&action=LicenseSettings');
    }

  // Shared Security Rules
    $admin_option_defs['Administration']['sharedrules_settings'] = array(
        'icon_SugarFeed',
        'LBL_SHAREDRULES_SETTINGS',
        'LBL_SHAREDRULES_SETTINGS_DESC',
        './index.php?module=SharedSecurityRules&action=index',
        'security'
    );
    if (isset($admin_group_header[0])) {
        $admin_option_defs =
            array_merge(
                (array)$admin_option_defs['Administration'],
                (array)$admin_group_header[0][3]['Administration']
            );
    }

    $admin_group_header[0][3]['Administration'] = $admin_option_defs;


//system.
$admin_option_defs=array();
$admin_option_defs['Administration']['configphp_settings']= array('Administration','LBL_CONFIGURE_SETTINGS_TITLE','LBL_CONFIGURE_SETTINGS','./index.php?module=Configurator&action=EditView', 'system-settings');
$admin_option_defs['Administration']['import']= array('Import','LBL_IMPORT_WIZARD','LBL_IMPORT_WIZARD_DESC','./index.php?module=Import&action=step1&import_module=Administration', 'import');
$admin_option_defs['Administration']['locale']= array('Currencies','LBL_MANAGE_LOCALE','LBL_LOCALE','./index.php?module=Administration&action=Locale&view=default', 'locale');

if(!defined('TEMPLATE_URL')){
	$admin_option_defs['Administration']['upgrade_wizard']= array('Upgrade','LBL_UPGRADE_WIZARD_TITLE','LBL_UPGRADE_WIZARD','./index.php?module=UpgradeWizard&action=index', 'upgrade-wizard');
}

$admin_option_defs['Administration']['currencies_management']= array('Currencies','LBL_MANAGE_CURRENCIES','LBL_CURRENCY','./index.php?module=Currencies&action=index', 'currencies');

if (!isset($GLOBALS['sugar_config']['hide_admin_backup']) || !$GLOBALS['sugar_config']['hide_admin_backup'])
{
    $admin_option_defs['Administration']['backup_management']= array('Backups','LBL_BACKUPS_TITLE','LBL_BACKUPS','./index.php?module=Administration&action=Backups', 'backups');
}

$admin_option_defs['Administration']['languages']= array('Currencies','LBL_MANAGE_LANGUAGES','LBL_LANGUAGES','./index.php?module=Administration&action=Languages&view=default', 'languages');

$admin_option_defs['Administration']['repair']= array('Repair','LBL_UPGRADE_TITLE','LBL_UPGRADE','./index.php?module=Administration&action=Upgrade', 'repair');

$admin_option_defs['Administration']['global_search']=array('icon_SearchForm','LBL_GLOBAL_SEARCH_SETTINGS','LBL_GLOBAL_SEARCH_SETTINGS_DESC','./index.php?module=Administration&action=GlobalSearchSettings', 'global-search');

if (!isset($GLOBALS['sugar_config']['hide_admin_diagnostics']) || !$GLOBALS['sugar_config']['hide_admin_diagnostics'])
{
    $admin_option_defs['Administration']['diagnostic']= array('Diagnostic','LBL_DIAGNOSTIC_TITLE','LBL_DIAGNOSTIC_DESC','./index.php?module=Administration&action=Diagnostic', 'diagnostic');
}

// Connector Integration
$admin_option_defs['Administration']['connector_settings']=array('icon_Connectors','LBL_CONNECTOR_SETTINGS','LBL_CONNECTOR_SETTINGS_DESC','./index.php?module=Connectors&action=ConnectorSettings', 'connectors');


// Theme Enable/Disable
$admin_option_defs['Administration']['theme_settings']=array('icon_AdminThemes','LBL_THEME_SETTINGS','LBL_THEME_SETTINGS_DESC','./index.php?module=Administration&action=ThemeSettings', 'themes');

$admin_option_defs['Administration']['scheduler'] = array('Schedulers','LBL_SUGAR_SCHEDULER_TITLE','LBL_SUGAR_SCHEDULER','./index.php?module=Schedulers&action=index', 'scheduler');

$admin_option_defs['Administration']['feed_settings']=array('icon_SugarFeed','LBL_SUGARFEED_SETTINGS','LBL_SUGARFEED_SETTINGS_DESC','./index.php?module=SugarFeed&action=AdminSettings', 'activity-streams');





require_once 'include/SugarOAuthServer.php';
if(SugarOAuthServer::enabled()) {
    $admin_option_defs['Administration']['oauth_keys']= array('Password','LBL_OAUTH_TITLE','LBL_OAUTH','./index.php?module=OAuthKeys&action=index');
}
$admin_option_defs['Administration']['oauth2_clients']= array('Password','LBL_OAUTH2_CLIENTS_TITLE','LBL_OAUTH2_CLIENTS','./index.php?module=OAuth2Clients&action=index');

$admin_group_header[]= array('LBL_ADMINISTRATION_HOME_TITLE','',false,$admin_option_defs, 'LBL_ADMINISTRATION_HOME_DESC');


//email manager.
$admin_option_defs=array();
$admin_option_defs['Emails']['mass_Email_config']= array('EmailMan','LBL_MASS_EMAIL_CONFIG_TITLE','LBL_MASS_EMAIL_CONFIG_DESC','./index.php?module=EmailMan&action=config', 'email-settings');

$admin_option_defs['Campaigns']['campaignconfig']= array('EmailCampaigns','LBL_CAMPAIGN_CONFIG_TITLE','LBL_CAMPAIGN_CONFIG_DESC','./index.php?module=EmailMan&action=campaignconfig', 'campaign-email-settings');

$admin_option_defs['Emails']['mailboxes']= array('EmailInbound','LBL_MANAGE_MAILBOX','LBL_MAILBOX_DESC','./index.php?module=InboundEmail&action=index', 'inbound-email');
$admin_option_defs['Emails']['mailboxes_outbound']= array('EmailOutbound','LBL_MANAGE_MAILBOX_OUTBOUND','LBL_MAILBOX_OUTBOUND_DESC','./index.php?module=OutboundEmailAccounts&action=index', 'outbound-email');
$admin_option_defs['Campaigns']['mass_Email']= array('EmailQueue','LBL_MASS_EMAIL_MANAGER_TITLE','LBL_MASS_EMAIL_MANAGER_DESC','./index.php?module=EmailMan&action=index', 'email-queue');


$admin_group_header[]= array('LBL_EMAIL_TITLE','',false,$admin_option_defs, 'LBL_EMAIL_DESC');




//studio.
$admin_option_defs=array();
$admin_option_defs['studio']['studio']= array('Studio','LBL_STUDIO','LBL_STUDIO_DESC','./index.php?module=ModuleBuilder&action=index&type=studio', 'studio');
if(isset($GLOBALS['beanFiles']['iFrame'])) {
	$admin_option_defs['Administration']['portal']= array('iFrames','LBL_IFRAME','DESC_IFRAME','./index.php?module=iFrames&action=index');
}
$admin_option_defs['Administration']['rename_tabs']= array('RenameTabs','LBL_RENAME_TABS','LBL_CHANGE_NAME_MODULES',"./index.php?action=wizard&module=Studio&wizard=StudioWizard&option=RenameTabs", 'rename-modules');
$admin_option_defs['Administration']['moduleBuilder']= array('ModuleBuilder','LBL_MODULEBUILDER','LBL_MODULEBUILDER_DESC','./index.php?module=ModuleBuilder&action=index&type=mb', 'module-builder');
$admin_option_defs['Administration']['history_contacts_emails'] = array('ConfigureTabs', 'LBL_HISTORY_CONTACTS_EMAILS', 'LBL_HISTORY_CONTACTS_EMAILS_DESC', './index.php?module=Configurator&action=historyContactsEmails', 'history-subpanel');
$admin_option_defs['Administration']['configure_tabs']= array('ConfigureTabs','LBL_CONFIGURE_TABS_AND_SUBPANELS','LBL_CONFIGURE_TABS_AND_SUBPANELS_DESC','./index.php?module=Administration&action=ConfigureTabs', 'display-modules-and-subpanels');
$admin_option_defs['Administration']['module_loader'] = array('ModuleLoader','LBL_MODULE_LOADER_TITLE','LBL_MODULE_LOADER','./index.php?module=Administration&action=UpgradeWizard&view=module', 'module-loader');


$admin_option_defs['Administration']['configure_group_tabs']= array('ConfigureTabs','LBL_CONFIGURE_GROUP_TABS','LBL_CONFIGURE_GROUP_TABS_DESC','./index.php?action=wizard&module=Studio&wizard=StudioWizard&option=ConfigureGroupTabs', 'configure-module-menu-filters');

$admin_option_defs['any']['dropdowneditor']= array('Dropdown','LBL_DROPDOWN_EDITOR','DESC_DROPDOWN_EDITOR','./index.php?module=ModuleBuilder&action=index&type=dropdowns', 'dropdown-editor');


//$admin_option_defs['migrate_custom_fields']= array('MigrateFields','LBL_EXTERNAL_DEV_TITLE','LBL_EXTERNAL_DEV_DESC','./index.php?module=Administration&action=Development');


$admin_group_header[]= array('LBL_STUDIO_TITLE','',false,$admin_option_defs, 'LBL_TOOLS_DESC');

$admin_option_defs=array();

$admin_option_defs['jjwg_Maps']['config'] = array(
    'Administration',
    'LBL_JJWG_MAPS_ADMIN_CONFIG_TITLE',
    'LBL_JJWG_MAPS_ADMIN_CONFIG_DESC',
    './index.php?module=jjwg_Maps&action=config',
    'google-maps-settings'
);
$admin_option_defs['jjwg_Maps']['geocoded_counts'] = array(
    'Geocoded_Counts',
    'LBL_JJWG_MAPS_ADMIN_GEOCODED_COUNTS_TITLE',
    'LBL_JJWG_MAPS_ADMIN_GEOCODED_COUNTS_DESC',
    './index.php?module=jjwg_Maps&action=geocoded_counts',
    'geocoded-counts'
);
$admin_option_defs['jjwg_Maps']['geocoding_test'] = array(
    'GeocodingTests',
    'LBL_JJWG_MAPS_ADMIN_GEOCODING_TEST_TITLE',
    'LBL_JJWG_MAPS_ADMIN_GEOCODING_TEST_DESC',
    './index.php?module=jjwg_Maps&action=geocoding_test',
    'geocoding-test'
);
$admin_option_defs['jjwg_Maps']['geocode_addresses'] = array(
    'GeocodeAddresses',
    'LBL_JJWG_MAPS_ADMIN_GEOCODE_ADDRESSES_TITLE',
    'LBL_JJWG_MAPS_ADMIN_GEOCODE_ADDRESSES_DESC',
    './index.php?module=jjwg_Maps&action=geocode_addresses',
    'geocode-addresses'
);
$admin_option_defs['jjwg_Maps']['address_cache'] = array(
    'Address_Cache',
    'LBL_JJWG_MAPS_ADMIN_ADDRESS_CACHE_TITLE',
    'LBL_JJWG_MAPS_ADMIN_ADDRESS_CACHE_DESC',
    './index.php?module=jjwg_Address_Cache&action=index',
    'address-cache'
);


$admin_group_header[] = array(
    'LBL_JJWG_MAPS_ADMIN_HEADER',
    '',
    false,
    $admin_option_defs,
    'LBL_JJWG_MAPS_ADMIN_DESC'
);


$admin_option_defs = array();
$admin_option_defs['Administration']['securitygroup_management'] = array('SecuritySuiteGroupManagement', 'LBL_MANAGE_SECURITYGROUPS_TITLE', 'LBL_MANAGE_SECURITYGROUPS', './index.php?module=SecurityGroups&action=index', 'security');
$admin_option_defs['Administration']['securitygroup_config'] = array('SecurityGroupsManagement', 'LBL_CONFIG_SECURITYGROUPS_TITLE', 'LBL_CONFIG_SECURITYGROUPS', './index.php?module=SecurityGroups&action=config', 'security-suite-group-management');

$admin_option_defs['Administration'] = array_merge((array)$admin_group_header[0][3]['Administration'], (array)$admin_option_defs['Administration']);


$admin_group_header[0] = array('LBL_USERS_TITLE', '', false, array_merge((array)$admin_group_header[0][3], (array)$admin_option_defs), 'LBL_USERS_DESC');


$admin_option_defs=array();
$admin_option_defs['Administration']['aos'] = array(
    'AOS',
    'LBL_AOS_SETTINGS',
    'LBL_CHANGE_SETTINGS',
    './index.php?module=Administration&action=AOSAdmin',
    'aos-settings'
);

$admin_option_defs['Administration']['aod'] = array(
    'AOD',
    'LBL_AOD_SETTINGS',
    'LBL_CHANGE_SETTINGS_AOD',
    './index.php?module=Administration&action=AODAdmin',
    'aod-settings'
);
$admin_option_defs['Administration']['aop'] = array(
    'AOP',
    'LBL_AOP_SETTINGS',
    'LBL_CHANGE_SETTINGS_AOP',
    './index.php?module=Administration&action=AOPAdmin',
    'aop-settings'
);

$admin_option_defs['Administration']['business_hours'] = array(
    'AOBH_BusinessHours',
    'LBL_BUSINESS_HOURS',
    'LBL_AOP_BUSINESS_HOURS_DESC',
    './index.php?module=Administration&action=BusinessHours',
    'aobh-businesshours'
);

$admin_group_header['sagility'] = array(
    'LBL_SALESAGILITY_ADMIN',
    '',
    false,
    $admin_option_defs,
    ''
);

//bugs.
$admin_option_defs=array();
$admin_option_defs['Bugs']['bug_tracker']= array('Releases','LBL_MANAGE_RELEASES','LBL_RELEASE','./index.php?module=Releases&action=index', 'releases');
$admin_group_header[]= array('LBL_BUG_TITLE','',false,$admin_option_defs, 'LBL_BUG_DESC');


if(file_exists('custom/modules/Administration/Ext/Administration/administration.ext.php')){
	include('custom/modules/Administration/Ext/Administration/administration.ext.php');
}

//For users with MLA access we need to find which entries need to be shown.
//lets process the $admin_group_header and apply all the access control rules.
$access = $current_user->getDeveloperModules();
foreach ($admin_group_header as $key=>$values) {
	$module_index = array_keys($values[3]);  //get the actual links..
	foreach ($module_index as $mod_key=>$mod_val) {
		if (is_admin($current_user) ||
			in_array($mod_val, $access) ||
		    $mod_val=='studio'||
		    ($mod_val=='Forecasts' && in_array('ForecastSchedule', $access)) ||
		    ($mod_val =='any')
		   ) {
		   	    if(!is_admin($current_user)&& isset($values[3]['Administration'])){
                    unset($values[3]['Administration']);
                }
                if(displayStudioForCurrentUser() == false) {
                    unset($values[3]['studio']);
                }

                if(displayWorkflowForCurrentUser() == false) {
                    unset($values[3]['any']['workflow_management']);
                }

                // Need this check because Quotes and Products share the header group
                if(!in_array('Quotes', $access)&& isset($values[3]['Quotes'])){
                    unset($values[3]['Quotes']);
                }
                if(!in_array('Products', $access)&& isset($values[3]['Products'])){
                    unset($values[3]['Products']);
                }

                // Need this check because Emails and Campaigns share the header group
                if(!in_array('Campaigns', $access)&& isset($values[3]['Campaigns'])){
                    unset($values[3]['Campaigns']);
                }

                //////////////////

        } else {
        	//hide the link
        	unset($admin_group_header[$key][3][$mod_val]);
        }

	}
}
