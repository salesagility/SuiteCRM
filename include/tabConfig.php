<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo, "Supercharged by SuiteCRM" logo and “Nonprofitized by SinergiaCRM” logo. 
 * If the display of the logos is not reasonably feasible for technical reasons, 
 * the Appropriate Legal Notices must display the words "Powered by SugarCRM", 
 * "Supercharged by SuiteCRM" and “Nonprofitized by SinergiaCRM”. 
 */

// STIC-Custom - MHP - 20240201 - Override the core tabConfig with the custom tabConfig
// https://github.com/SinergiaTIC/SinergiaCRM/pull/105
// $GLOBALS['tabStructure'] = array(
//     "LBL_TABGROUP_SALES" => array(
//         'label' => 'LBL_TABGROUP_SALES',
//         'modules' => array(
//             "Home",
//             "Accounts",
//             "Contacts",
//             "Opportunities",
//             "Leads",
//             "Contracts",
//             "Quotes",
//             "Forecasts",
//         )
//     ),
//     "LBL_TABGROUP_MARKETING" => array(
//         'label' => 'LBL_TABGROUP_MARKETING',
//         'modules' => array(
//             "Home",
//             "Accounts",
//             "Contacts",
//             "Leads",
//             "Campaigns",
//             "Prospects",
//             "ProspectLists",
//         )
//     ),
//     "LBL_TABGROUP_SUPPORT" => array(
//         'label' => 'LBL_TABGROUP_SUPPORT',
//         'modules' => array(
//             "Home",
//             "Accounts",
//             "Contacts",
//             "Cases",
//             "Bugs",
//         )
//     ),
//     "LBL_TABGROUP_ACTIVITIES" => array(
//         'label' => 'LBL_TABGROUP_ACTIVITIES',
//         'modules' => array(
//             "Home",
//             "Calendar",
//             "Calls",
//             "Meetings",
//             "Emails",
//             "Tasks",
//             "Notes",
//         )
//     ),
//     "LBL_TABGROUP_COLLABORATION"=>array(
//         'label' => 'LBL_TABGROUP_COLLABORATION',
//         'modules' => array(
//             "Home",
//             "Emails",
//             "Documents",
//             "Project",
//         )
//     ),
// );


$GLOBALS['tabStructure'] = array(
    'LBL_GROUPTAB_MAIN' => array(
        'label' => 'LBL_GROUPTAB_MAIN',
        'modules' => array(
            0 => 'Contacts',
            1 => 'Accounts',
            2 => 'Leads',
            3 => 'stic_Contacts_Relationships',
            4 => 'stic_Accounts_Relationships',
            5 => 'stic_Centers',
        ),
    ),
    'LBL_GROUPTAB_ACTIVITIES' => array(
        'label' => 'LBL_GROUPTAB_ACTIVITIES',
        'modules' => array(
            0 => 'Home',
            1 => 'Calendar',
            2 => 'Calls',
            3 => 'Meetings',
            4 => 'Emails',
            5 => 'Tasks',
            6 => 'Notes',
        ),
    ),
    'LBL_GROUPTAB_ECONOMY' => array(
        'label' => 'LBL_GROUPTAB_ECONOMY',
        'modules' => array(
            0 => 'stic_Payment_Commitments',
            1 => 'stic_Payments',
            2 => 'stic_Remittances',
            3 => 'Opportunities',
        ),
    ),
    'LBL_GROUPTAB_CAMPAIGNS' => array(
        'label' => 'LBL_GROUPTAB_CAMPAIGNS',
        'modules' => array(
            0 => 'Campaigns',
            1 => 'ProspectLists',
            2 => 'Surveys',
        ),
    ),
    'LBL_GROUPTAB_EVENTS' => array(
        'label' => 'LBL_GROUPTAB_EVENTS',
        'modules' => array(
            0 => 'stic_Events',
            1 => 'stic_Registrations',
            2 => 'stic_Sessions',
            3 => 'stic_Attendances',
            4 => 'FP_Event_Locations',
        ),
    ),
    'LBL_GROUPTAB_DIRECTCARE' => array(
        'label' => 'LBL_GROUPTAB_DIRECTCARE',
        'modules' => array(
            0 => 'stic_Assessments',
            1 => 'stic_Goals',
            2 => 'stic_Personal_Environment',
            3 => 'stic_FollowUps',
            4 => 'stic_Grants',
            5 => 'stic_Families',
            6 => 'stic_Medication',
            7 => 'stic_Prescription',
            8 => 'stic_Medication_Log',
            9 => 'stic_Journal',
        ),
    ),
    'LBL_GROUPTAB_LABOURINSERTION' => array(
        'label' => 'LBL_GROUPTAB_LABOURINSERTION',
        'modules' => array(
            0 => 'stic_Job_Offers',
            1 => 'stic_Job_Applications',
            2 => 'stic_Sepe_Actions',
            3 => 'stic_Sepe_Incidents',
            4 => 'stic_Sepe_Files',
            5 => 'stic_Training',
            6 => 'stic_Skills',
            7 => 'stic_Work_Experience',
        ),
    ),
    'LBL_GROUPTAB_BOOKINGS' => array(
        'label' => 'LBL_GROUPTAB_BOOKINGS',
        'modules' => array(
            0 => 'stic_Bookings',
            1 => 'stic_Resources',
            2 => 'stic_Bookings_Calendar',
        ),
    ),
    'LBL_GROUPTAB_SALES' => array(
        'label' => 'LBL_GROUPTAB_SALES',
        'modules' => array(
            0 => 'AOS_Product_Categories',
            1 => 'AOS_Products',
            2 => 'AOS_Quotes',
            3 => 'AOS_Contracts',
            4 => 'AOS_Invoices',
        ),
    ),
    'LBL_GROUPTAB_OTHER' => array(
        'label' => 'LBL_GROUPTAB_OTHER',
        'modules' => array(
            0 => 'Project',
            1 => 'KReports',
            2 => 'Documents',
            3 => 'DHA_PlantillasDocumentos',
            4 => 'AOW_WorkFlow',
            5 => 'AOR_Reports',
            6 => 'AOS_PDF_Templates',
        ),
    ),
);
// END STIC-Custom

if (file_exists('custom/include/tabConfig.php')) {
    require 'custom/include/tabConfig.php';
}
