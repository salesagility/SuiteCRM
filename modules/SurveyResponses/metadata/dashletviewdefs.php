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

 global $current_user;

// STIC-Custom - MHP - 20240201 - Override the core metadata files with the custom metadata files 
// https://github.com/SinergiaTIC/SinergiaCRM/pull/105 
// $dashletData['SurveyResponsesDashlet']['searchFields'] = array(
//     'date_entered'     => array('default' => ''),
//     'date_modified'    => array('default' => ''),
//     'assigned_user_id' => array(
//         'type'    => 'assigned_user_name',
//         'default' => $current_user->name
//     )
// );
// $dashletData['SurveyResponsesDashlet']['columns'] = array(
//     'name'               => array(
//         'width'   => '40',
//         'label'   => 'LBL_LIST_NAME',
//         'link'    => true,
//         'default' => true
//     ),
//     'date_entered'       => array(
//         'width'   => '15',
//         'label'   => 'LBL_DATE_ENTERED',
//         'default' => true
//     ),
//     'date_modified'      => array(
//         'width' => '15',
//         'label' => 'LBL_DATE_MODIFIED'
//     ),
//     'created_by'         => array(
//         'width' => '8',
//         'label' => 'LBL_CREATED'
//     ),
//     'assigned_user_name' => array(
//         'width' => '8',
//         'label' => 'LBL_LIST_ASSIGNED_USER'
//     ),
// );

$dashletData['SurveyResponsesDashlet']['searchFields'] = array (
    'name' => 
    array (
      'default' => '',
    ),
    'survey_name' => 
    array (
      'default' => '',
    ),
    'campaign_name' => 
    array (
      'default' => '',
    ),
    'date_entered' => 
    array (
      'default' => '',
    ),
    'date_modified' => 
    array (
      'default' => '',
    ),
    'assigned_user_id' => 
    array (
      'default' => '',
    ),
  );
  $dashletData['SurveyResponsesDashlet']['columns'] = array (
    'name' => 
    array (
      'width' => '32%',
      'label' => 'LBL_LIST_NAME',
      'link' => true,
      'default' => true,
      'name' => 'name',
    ),
    'survey_name' => 
    array (
      'type' => 'relate',
      'link' => true,
      'label' => 'LBL_SURVEYS_SURVEYRESPONSES_FROM_SURVEYS_TITLE',
      'id' => 'SURVEY_ID',
      'width' => '10%',
      'default' => true,
      'name' => 'survey_name',
    ),
    'campaign_name' => 
    array (
      'type' => 'relate',
      'link' => true,
      'label' => 'LBL_SURVEYRESPONSES_CAMPAIGNS_FROM_CAMPAIGNS_TITLE',
      'id' => 'CAMPAIGN_ID',
      'width' => '10%',
      'default' => true,
      'name' => 'campaign_name',
    ),
    'assigned_user_name' => 
    array (
      'width' => '8%',
      'label' => 'LBL_LIST_ASSIGNED_USER',
      'name' => 'assigned_user_name',
      'default' => true,
    ),
    'date_entered' => 
    array (
      'width' => '10%',
      'label' => 'LBL_DATE_ENTERED',
      'default' => true,
      'name' => 'date_entered',
    ),
    'date_modified' => 
    array (
      'width' => '10%',
      'label' => 'LBL_DATE_MODIFIED',
      'name' => 'date_modified',
      'default' => true,
    ),
    'created_by_name' => 
    array (
      'type' => 'relate',
      'link' => true,
      'label' => 'LBL_CREATED',
      'id' => 'CREATED_BY',
      'width' => '10%',
      'default' => false,
      'name' => 'created_by_name',
    ),
    'modified_by_name' => 
    array (
      'type' => 'relate',
      'link' => true,
      'label' => 'LBL_MODIFIED_NAME',
      'id' => 'MODIFIED_USER_ID',
      'width' => '10%',
      'default' => false,
      'name' => 'modified_by_name',
    ),
);  
// END STIC-Custom