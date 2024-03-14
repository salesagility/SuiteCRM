<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/**
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

global $theme, $mod_strings;

// STIC-Custom - MHP - 20240201 - Override the core metadata files with the custom metadata files 
// https://github.com/SinergiaTIC/SinergiaCRM/pull/105
// $listViewDefs['Campaigns'] = array(
//     'NAME' => array(
//         'width' => '20',
//         'label' => 'LBL_LIST_CAMPAIGN_NAME',
//         'link' => true,
//         'default' => true),
//     'STATUS' => array(
//         'width' => '10',
//         'label' => 'LBL_LIST_STATUS',
//         'default' => true),
//     'CAMPAIGN_TYPE' => array(
//         'width' => '10',
//         'label' => 'LBL_LIST_TYPE',
//         'default' => true),
//     'END_DATE' => array(
//         'width' => '10',
//         'label' => 'LBL_LIST_END_DATE',
//         'default' => true),
//     'DATE_ENTERED' => array(
//         'width' => '10',
//         'label' => 'LBL_DATE_ENTERED',
//         'default' => true),

//     'ASSIGNED_USER_NAME' => array(
//         'width' => '8',
//         'label' => 'LBL_LIST_ASSIGNED_USER',
//         'module' => 'Employees',
//         'id' => 'ASSIGNED_USER_ID',
//         'default' => true),
//     'TRACK_CAMPAIGN' => array(
//         'width' => '0.01',
//         'label' => '&nbsp;',
//         'link' => true,
//         'customCode' => ' <a title="{$TRACK_CAMPAIGN_TITLE}" href="index.php?action=TrackDetailView&module=Campaigns&record={$ID}"><!--not_in_theme!--><span class="suitepicon suitepicon-action-view-status"></span></a> ',
//         'default' => true,
//         'studio' => false,
//         'nowrap' => true,
//         'sortable' => false),
// );

$listViewDefs['Campaigns'] = array (
    'TRACK_CAMPAIGN' => 
    array (
      'width' => '0.01',
      'label' => 'LBL_LIST_STATUS',
      'link' => true,
      'customCode' => ' <a title="{$TRACK_CAMPAIGN_TITLE}" href="index.php?action=TrackDetailView&module=Campaigns&record={$ID}"><!--not_in_theme!--><span class="suitepicon suitepicon-action-view-status"></span></a> ',
      'default' => true,
      'studio' => false,
      'nowrap' => true,
      'sortable' => false,
    ),
    'NAME' => 
    array (
      'width' => '20%',
      'label' => 'LBL_LIST_NAME',
      'link' => true,
      'default' => true,
    ),
    'STATUS' => 
    array (
      'width' => '10%',
      'label' => 'LBL_LIST_STATUS',
      'default' => true,
    ),
    'CAMPAIGN_TYPE' => 
    array (
      'width' => '10%',
      'label' => 'LBL_LIST_TYPE',
      'default' => true,
    ),
    'START_DATE' => 
    array (
      'type' => 'date',
      'label' => 'LBL_CAMPAIGN_START_DATE',
      'width' => '10%',
      'default' => true,
    ),
    'END_DATE' => 
    array (
      'width' => '10%',
      'label' => 'LBL_LIST_END_DATE',
      'default' => true,
    ),
    'FREQUENCY' => 
    array (
      'type' => 'enum',
      'label' => 'LBL_CAMPAIGN_FREQUENCY',
      'width' => '10%',
      'default' => true,
    ),
    'ASSIGNED_USER_NAME' => 
    array (
      'width' => '8%',
      'label' => 'LBL_LIST_ASSIGNED_USER',
      'module' => 'Employees',
      'id' => 'ASSIGNED_USER_ID',
      'default' => true,
    ),
    'SURVEY_NAME' => 
    array (
      'type' => 'relate',
      'link' => true,
      'label' => 'LBL_CAMPAIGN_SURVEYS',
      'id' => 'SURVEY_ID',
      'width' => '10%',
      'default' => false,
    ),
    'CONTENT' => 
    array (
      'type' => 'text',
      'label' => 'LBL_CAMPAIGN_CONTENT',
      'sortable' => false,
      'width' => '10%',
      'default' => false,
    ),
    'OBJECTIVE' => 
    array (
      'type' => 'text',
      'label' => 'LBL_CAMPAIGN_OBJECTIVE',
      'sortable' => false,
      'width' => '10%',
      'default' => false,
    ),
    'EXPECTED_REVENUE' => 
    array (
      'type' => 'currency',
      'label' => 'LBL_CAMPAIGN_EXPECTED_REVENUE',
      'currency_format' => true,
      'width' => '10%',
      'default' => false,
    ),
    'ACTUAL_COST' => 
    array (
      'type' => 'currency',
      'label' => 'LBL_CAMPAIGN_ACTUAL_COST',
      'currency_format' => true,
      'width' => '10%',
      'default' => false,
    ),
    'EXPECTED_COST' => 
    array (
      'type' => 'currency',
      'label' => 'LBL_CAMPAIGN_EXPECTED_COST',
      'currency_format' => true,
      'width' => '10%',
      'default' => false,
    ),
    'DESCRIPTION' => 
    array (
      'type' => 'none',
      'label' => 'description',
      'width' => '10%',
      'default' => false,
    ),
    'BUDGET' => 
    array (
      'type' => 'currency',
      'label' => 'LBL_CAMPAIGN_BUDGET',
      'currency_format' => true,
      'width' => '10%',
      'default' => false,
    ),
    'IMPRESSIONS' => 
    array (
      'type' => 'int',
      'default' => false,
      'label' => 'LBL_CAMPAIGN_IMPRESSIONS',
      'width' => '10%',
    ),
    'TRACKER_TEXT' => 
    array (
      'type' => 'varchar',
      'label' => 'LBL_TRACKER_TEXT',
      'width' => '10%',
      'default' => false,
    ),
    'DATE_ENTERED' => 
    array (
      'width' => '10%',
      'label' => 'LBL_DATE_ENTERED',
      'default' => false,
    ),
    'REFER_URL' => 
    array (
      'type' => 'varchar',
      'default' => false,
      'label' => 'LBL_REFER_URL',
      'width' => '10%',
    ),
    'TRACKER_COUNT' => 
    array (
      'type' => 'int',
      'default' => false,
      'label' => 'LBL_TRACKER_COUNT',
      'width' => '10%',
    ),
    'TRACKER_KEY' => 
    array (
      'type' => 'int',
      'studio' => 
      array (
        'editview' => false,
      ),
      'label' => 'LBL_TRACKER_KEY',
      'width' => '10%',
      'default' => false,
    ),
    'CREATED_BY_NAME' => 
    array (
      'type' => 'relate',
      'link' => true,
      'label' => 'LBL_CREATED',
      'id' => 'CREATED_BY',
      'width' => '10%',
      'default' => false,
    ),
    'MODIFIED_BY_NAME' => 
    array (
      'type' => 'relate',
      'link' => true,
      'label' => 'LBL_MODIFIED_NAME',
      'id' => 'MODIFIED_USER_ID',
      'width' => '10%',
      'default' => false,
    ),
    'DATE_MODIFIED' => 
    array (
      'type' => 'datetime',
      'label' => 'LBL_DATE_MODIFIED',
      'width' => '10%',
      'default' => false,
    ),
);
// END STIC-Custom