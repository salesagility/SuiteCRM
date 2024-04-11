<?php

/**
 * We can run this post_install code calling the URL 'https://xxxxx.sinergiacrm.org/SticRunScripts.php?file=SticInstall/scripts/PostInstall.php'
 * It is important that all the code included in this file can be executed in different updates,
 * incorporating new operations, such as making new modules available.
 **/

$GLOBALS['log']->info('Line ' . __LINE__ . ': ' . __METHOD__ . ':  Running STIC PostInstall script');

include_once 'modules/MySettings/TabController.php';

$controller = new TabController();
$currentTabs = $controller->get_system_tabs();

// Set modules available and visible in the main menu
$installedModules = array(
    // Modules must be visible after install

    // Main
    0 => 'Contacts',
    1 => 'Accounts',
    2 => 'Leads',
    3 => 'stic_Accounts_Relationships',
    4 => 'stic_Contacts_Relationships',

    // Activities
    5 => 'Calendar',
    6 => 'Calls',
    7 => 'Meetings',
    8 => 'Emails',
    9 => 'Tasks',
    10 => 'Notes',

    // Economy
    11 => 'stic_Payment_Commitments',
    12 => 'stic_Payments',
    13 => 'stic_Remittances',
    14 => 'Opportunities',

    // Campaigns
    15 => 'Campaigns',
    16 => 'ProspectLists',
    17 => 'Surveys',

    // Events
    18 => 'stic_Events',
    19 => 'stic_Registrations',
    20 => 'stic_Sessions',
    21 => 'stic_Attendances',
    22 => 'FP_Event_Locations',

    // Others
    23 => 'Project',
    24 => 'ProjectTask',
    25 => 'KReports',
    26 => 'Documents',
    27 => 'DHA_PlantillasDocumentos',
    28 => 'AOW_WorkFlow',
    29 => 'AOS_PDF_Templates',

    // Direct Care
    30=>'stic_Assessments',
    31=>'stic_FollowUps',
    32=>'stic_Personal_Environment',
    33=>'stic_Goals',

    // Labour Insertion
    34 => 'stic_Job_Applications',
    35 => 'stic_Job_Offers',
    36 => 'stic_Sepe_Actions',
    37 => 'stic_Sepe_Incidents',
    38 => 'stic_Sepe_Files',

    // Resources and Bookings
    39 => 'stic_Resources',
    40 => 'stic_Bookings',
    41 => 'stic_Bookings_Calendar',

);

foreach ($installedModules as $module) {
    // Add $installedModules if not present
    if (!in_array($module, $currentTabs)) {
        $currentTabs[$module] = $module;
    }
}

// Modules must be hidden in CRM
$hiddenModules = array(
    0 => 'SecurityGroups',
    1 => 'Administration',
    2 => 'EmailTemplates',
    3 => 'Administration',
    4 => 'stic_Web_Forms',
    5 => 'stic_Validation_Actions',
    6 => 'FP_events',
    7 => 'jjwg_Address_Cache',
    8 => 'AOS_Contracts',
    9 => 'jjwg_Areas',
    11 => 'jjwg_Markers',
    12 => 'jjwg_Maps',
    13 => 'AOS_Quotes',
    14 => 'AOS_Products',
    15 => 'AOS_Product_Categories',
    16 => 'AOS_Invoices',
    17 => 'AOK_KnowledgeBase',
    18 => 'AOK_Knowledge_Base_Categories',
    19 => 'Spots',
    20 => 'AOBH_BusinessHours',
    21 => 'ResourceCalendar',
    22 => 'Bugs',
    23 => 'Cases',
    24 => 'Prospects',
    25 => 'AM_ProjectTemplates',
    26 => 'AOR_Scheduled_Reports',
    27 => 'stic_Settings',
    28 => 'AOR_Reports',
    29 => 'stic_Validation_Results',
    30 => 'stic_Custom_Views',
    31 => 'stic_Custom_View_Customizations',
    32 => 'stic_Custom_View_Conditions',
    33 => 'stic_Custom_View_Actions',
);

// Remove $hiddenModules if present
foreach ($hiddenModules as $module) {
    unset($currentTabs[$module]);
}

$controller->set_system_tabs($currentTabs);
$newCurrentTabs = $controller->get_system_tabs();
foreach ($installedModules as $module) {
    if (in_array($module, $newCurrentTabs)) {
        $GLOBALS['log']->info('Line ' . __LINE__ . ': ' . __METHOD__ . ':  Module ' . $module . ' is already available');
    } else {
        $GLOBALS['log']->error('Line ' . __LINE__ . ': ' . __METHOD__ . ':  Module ' . $module . ' is NOT available');

    }
}

// Hidden subpanels (name must be lowercase )
$hiddenSubpanels = array(
    1 => 'administration',
    2 => 'emailtemplates',
    3 => 'administration',
    4 => 'stic_web_forms',
    6 => 'fp_events',
    7 => 'jjwg_address_cache',
    8 => 'aos_contracts',
    9 => 'jjwg_areas',
    11 => 'jjwg_markers',
    12 => 'jjwg_maps',
    13 => 'aos_quotes',
    14 => 'aos_products',
    15 => 'aos_product_categories',
    16 => 'aos_invoices',
    17 => 'aok_knowledgebase',
    18 => 'aok_knowledge_base_categories',
    19 => 'spots',
    20 => 'aobh_businesshours',
    21 => 'resourcecalendar',
    22 => 'bugs',
    23 => 'cases',
    24 => 'prospects',
    25 => 'am_projecttemplates',
    26 => 'aor_scheduled_reports',
    27 => 'aos_products_quotes',
);
$administration = new Administration();
$serialized = base64_encode(serialize($hiddenSubpanels));
$administration->saveSetting('MySettings', 'hide_subpanels', $serialized);

// Repairing and rebuilding
global $current_user;
$current_user = new User();
$current_user->getSystemUser();

// Repairing roles
include 'modules/ACL/install_actions.php';
$GLOBALS['log']->info('Line ' . __LINE__ . ': ' . __METHOD__ . ':  Repairing roles');

// Rebuilding relationships
include 'modules/Administration/RebuildRelationship.php';
$GLOBALS['log']->info('Line ' . __LINE__ . ': ' . __METHOD__ . ':  Rebuilding relationships');

// Repairing indexes
include "modules/Administration/RepairIndex.php";
$GLOBALS['log']->info('Line ' . __LINE__ . ': ' . __METHOD__ . ':  Repairing indexes');
