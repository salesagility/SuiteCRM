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

// STIC-Custom - MHP - 20240201 - Override the core metadata files with the custom metadata files 
// https://github.com/SinergiaTIC/SinergiaCRM/pull/105
// $popupMeta = array(
//     'moduleMain' => 'Campaign',
//     'varName' => 'CAMPAIGN',
//     'orderBy' => 'name',
//     'whereClauses' =>
//         array('name' => 'campaigns.name'),
//     'searchInputs' =>
//         array('name'),
//     'listviewdefs' => array(
//         'NAME' => array(
//             'width' => '20',
//             'label' => 'LBL_LIST_CAMPAIGN_NAME',
//             'link' => true,
//             'default' => true),
//          'CAMPAIGN_TYPE' => array(
//             'width' => '10',
//             'label' => 'LBL_LIST_TYPE',
//             'default' => true),
//         'STATUS' => array(
//             'width' => '10',
//             'label' => 'LBL_LIST_STATUS',
//             'default' => true),
//         'START_DATE' => array(
//             'width' => '10',
//             'label' => 'LBL_LIST_START_DATE',
//             'default' => true),
//         'END_DATE' => array(
//             'width' => '10',
//             'label' => 'LBL_LIST_END_DATE',
//             'default' => true),
//     ),
//     'searchdefs'   => array(
//         'name',
//         'campaign_type',
//         'status',
//         'start_date',
//         'end_date'
//     )
// );

$popupMeta = array(
    'moduleMain' => 'Campaign',
    'varName' => 'CAMPAIGN',
    'orderBy' => 'name',
    'whereClauses' => array(
        'name' => 'campaigns.name',
        'campaign_type' => 'campaigns.campaign_type',
        'status' => 'campaigns.status',
        'start_date' => 'campaigns.start_date',
        'end_date' => 'campaigns.end_date',
    ),
    'searchInputs' => array(
        0 => 'name',
        1 => 'campaign_type',
        2 => 'status',
        3 => 'start_date',
        4 => 'end_date',
    ),
    'searchdefs' => array(
        'name' => array(
            'name' => 'name',
            'default' => true,
            'width' => '10%',
        ),
        'status' => array(
            'name' => 'status',
            'default' => true,
            'width' => '10%',
        ),
        'campaign_type' => array(
            'name' => 'campaign_type',
            'default' => true,
            'width' => '10%',
        ),
        'start_date' => array(
            'name' => 'start_date',
            'type' => 'date',
            'displayParams' => array(
                'showFormats' => true,
            ),
            'default' => true,
            'width' => '10%',
        ),
        'end_date' => array(
            'name' => 'end_date',
            'type' => 'date',
            'displayParams' => array(
                'showFormats' => true,
            ),
            'default' => true,
            'width' => '10%',
        ),
        'assigned_user_id' => array(
            'name' => 'assigned_user_id',
            'label' => 'LBL_ASSIGNED_TO',
            'type' => 'enum',
            'function' => array(
                'name' => 'get_user_array',
                'params' => array(
                    0 => false,
                ),
            ),
            'default' => true,
            'width' => '10%',
        ),
        'survey_name' => array(
            'type' => 'relate',
            'link' => true,
            'label' => 'LBL_CAMPAIGN_SURVEYS',
            'id' => 'SURVEY_ID',
            'width' => '10%',
            'default' => true,
            'name' => 'survey_name',
        ),
        'frequency' => array(
            'type' => 'enum',
            'label' => 'LBL_CAMPAIGN_FREQUENCY',
            'width' => '10%',
            'default' => true,
            'name' => 'frequency',
        ),
        'actual_cost' => array(
            'type' => 'currency',
            'label' => 'LBL_CAMPAIGN_ACTUAL_COST',
            'currency_format' => true,
            'width' => '10%',
            'default' => true,
            'name' => 'actual_cost',
        ),
        'expected_cost' => array(
            'type' => 'currency',
            'label' => 'LBL_CAMPAIGN_EXPECTED_COST',
            'currency_format' => true,
            'width' => '10%',
            'default' => true,
            'name' => 'expected_cost',
        ),
        'budget' => array(
            'type' => 'currency',
            'label' => 'LBL_CAMPAIGN_BUDGET',
            'currency_format' => true,
            'width' => '10%',
            'default' => true,
            'name' => 'budget',
        ),
        'expected_revenue' => array(
            'type' => 'currency',
            'label' => 'LBL_CAMPAIGN_EXPECTED_REVENUE',
            'currency_format' => true,
            'width' => '10%',
            'default' => true,
            'name' => 'expected_revenue',
        ),
        'objective' => array(
            'type' => 'text',
            'label' => 'LBL_CAMPAIGN_OBJECTIVE',
            'sortable' => false,
            'width' => '10%',
            'default' => true,
            'name' => 'objective',
        ),
        'content' => array(
            'type' => 'text',
            'label' => 'LBL_CAMPAIGN_CONTENT',
            'sortable' => false,
            'width' => '10%',
            'default' => true,
            'name' => 'content',
        ),
        'description' => array(
            'type' => 'none',
            'label' => 'description',
            'width' => '10%',
            'default' => true,
            'name' => 'description',
        ),
        'date_entered' => array(
            'type' => 'datetime',
            'label' => 'LBL_DATE_ENTERED',
            'width' => '10%',
            'default' => true,
            'name' => 'date_entered',
        ),
        'date_modified' => array(
            'type' => 'datetime',
            'label' => 'LBL_DATE_MODIFIED',
            'width' => '10%',
            'default' => true,
            'name' => 'date_modified',
        ),
        'created_by' => array(
            'type' => 'assigned_user_name',
            'label' => 'LBL_CREATED',
            'width' => '10%',
            'default' => true,
            'name' => 'created_by',
        ),
        'modified_user_id' => array(
            'type' => 'assigned_user_name',
            'label' => 'LBL_MODIFIED',
            'width' => '10%',
            'default' => true,
            'name' => 'modified_user_id',
        ),
        'current_user_only' => array(
            'label' => 'LBL_CURRENT_USER_FILTER',
            'type' => 'bool',
            'default' => true,
            'width' => '10%',
            'name' => 'current_user_only',
        ),

    ),
    'listviewdefs' => array(
        'NAME' => array(
            'width' => '20%',
            'label' => 'LBL_LIST_CAMPAIGN_NAME',
            'link' => true,
            'default' => true,
            'name' => 'name',
        ),
        'STATUS' => array(
            'width' => '10%',
            'label' => 'LBL_LIST_STATUS',
            'default' => true,
            'name' => 'status',
        ),
        'CAMPAIGN_TYPE' => array(
            'width' => '10%',
            'label' => 'LBL_LIST_TYPE',
            'default' => true,
            'name' => 'campaign_type',
        ),
        'START_DATE' => array(
            'width' => '10%',
            'label' => 'LBL_LIST_START_DATE',
            'default' => true,
            'name' => 'start_date',
        ),
        'END_DATE' => array(
            'width' => '10%',
            'label' => 'LBL_LIST_END_DATE',
            'default' => true,
            'name' => 'end_date',
        ),
        'ASSIGNED_USER_NAME' => array(
            'link' => true,
            'type' => 'relate',
            'label' => 'LBL_ASSIGNED_TO_NAME',
            'id' => 'ASSIGNED_USER_ID',
            'width' => '10%',
            'default' => true,
        ),
    ),
);
// END STIC-Custom