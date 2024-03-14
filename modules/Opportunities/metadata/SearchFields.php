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
// $searchFields['Opportunities'] =
//     array(
//         'name' => array( 'query_type'=>'default'),
//         'account_name'=> array('query_type'=>'default','db_field'=>array('accounts.name')),
//         'amount'=> array('query_type'=>'default'),
//         'next_step'=> array('query_type'=>'default'),
//         'probability'=> array('query_type'=>'default'),
//         'lead_source'=> array('query_type'=>'default', 'operator'=>'=', 'options' => 'lead_source_dom', 'template_var' => 'LEAD_SOURCE_OPTIONS'),
//         'opportunity_type'=> array('query_type'=>'default', 'operator'=>'=', 'options' => 'opportunity_type_dom', 'template_var' => 'TYPE_OPTIONS'),
//         'sales_stage'=> array('query_type'=>'default', 'operator'=>'=', 'options' => 'sales_stage_dom', 'template_var' => 'SALES_STAGE_OPTIONS', 'options_add_blank' => true),
//         'current_user_only'=> array('query_type'=>'default','db_field'=>array('assigned_user_id'),'my_items'=>true, 'vname' => 'LBL_CURRENT_USER_FILTER', 'type' => 'bool'),
//         'assigned_user_id'=> array('query_type'=>'default'),
//         'open_only' => array(
//             'query_type'=>'default',
//             'db_field'=>array('sales_stage'),
//             'operator'=>'not in',
//             'closed_values' => array('Closed Won', 'Closed Lost'),
//             'type'=>'bool',
//         ),
//         'favorites_only' => array(
//             'query_type'=>'format',
//             'operator' => 'subquery',
//             'checked_only' => true,
//             'subquery' => "SELECT favorites.parent_id FROM favorites
// 			                    WHERE favorites.deleted = 0
// 			                        and favorites.parent_type = 'Opportunities'
// 			                        and favorites.assigned_user_id = '{1}'",
//             'db_field'=>array('id')),

//         //Range Search Support
//        'range_date_entered' => array('query_type' => 'default', 'enable_range_search' => true, 'is_date_field' => true),
//        'start_range_date_entered' => array('query_type' => 'default',  'enable_range_search' => true, 'is_date_field' => true),
//        'end_range_date_entered' => array('query_type' => 'default', 'enable_range_search' => true, 'is_date_field' => true),
//        'range_date_modified' => array('query_type' => 'default', 'enable_range_search' => true, 'is_date_field' => true),
//        'start_range_date_modified' => array('query_type' => 'default',  'enable_range_search' => true, 'is_date_field' => true),
//        'end_range_date_modified' => array('query_type' => 'default', 'enable_range_search' => true, 'is_date_field' => true),
       
//        'range_date_closed' => array('query_type' => 'default', 'enable_range_search' => true, 'is_date_field' => true),
//        'start_range_date_closed' => array('query_type' => 'default',  'enable_range_search' => true, 'is_date_field' => true),
//        'end_range_date_closed' => array('query_type' => 'default', 'enable_range_search' => true, 'is_date_field' => true),

//        'range_amount' => array('query_type' => 'default', 'enable_range_search' => true),
//        'start_range_amount' => array('query_type' => 'default',  'enable_range_search' => true),
//        'end_range_amount' => array('query_type' => 'default', 'enable_range_search' => true),
//         //Range Search Support
//     );

$searchFields['Opportunities'] = array (
    'name' => 
    array (
      'query_type' => 'default',
    ),
    'account_name' => 
    array (
      'query_type' => 'default',
      'db_field' => 
      array (
        0 => 'accounts.name',
      ),
    ),
    'amount' => 
    array (
      'query_type' => 'default',
    ),
    'next_step' => 
    array (
      'query_type' => 'default',
    ),
    'probability' => 
    array (
      'query_type' => 'default',
    ),
    'lead_source' => 
    array (
      'query_type' => 'default',
      'operator' => '=',
      'options' => 'lead_source_dom',
      'template_var' => 'LEAD_SOURCE_OPTIONS',
    ),
    'opportunity_type' => 
    array (
      'query_type' => 'default',
      'operator' => '=',
      'options' => 'opportunity_type_dom',
      'template_var' => 'TYPE_OPTIONS',
    ),
    'sales_stage' => 
    array (
      'query_type' => 'default',
      'operator' => '=',
      'options' => 'sales_stage_dom',
      'template_var' => 'SALES_STAGE_OPTIONS',
      'options_add_blank' => true,
    ),
    'current_user_only' => 
    array (
      'query_type' => 'default',
      'db_field' => 
      array (
        0 => 'assigned_user_id',
      ),
      'my_items' => true,
      'vname' => 'LBL_CURRENT_USER_FILTER',
      'type' => 'bool',
    ),
    'assigned_user_id' => 
    array (
      'query_type' => 'default',
    ),
    'open_only' => 
    array (
      'query_type' => 'default',
      'db_field' => 
      array (
        0 => 'sales_stage',
      ),
      'operator' => 'not in',
      'closed_values' => 
      array (
        0 => 'Closed Won',
        1 => 'Closed Lost',
      ),
      'type' => 'bool',
    ),
    'favorites_only' => 
    array (
      'query_type' => 'format',
      'operator' => 'subquery',
      'checked_only' => true,
      'subquery' => 'SELECT favorites.parent_id FROM favorites
                                  WHERE favorites.deleted = 0
                                      and favorites.parent_type = \'Opportunities\'
                                      and favorites.assigned_user_id = \'{1}\'',
      'db_field' => 
      array (
        0 => 'id',
      ),
    ),
    'range_date_entered' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'start_range_date_entered' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'end_range_date_entered' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'range_date_modified' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'start_range_date_modified' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'end_range_date_modified' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'range_date_closed' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'start_range_date_closed' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'end_range_date_closed' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'range_amount' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
    ),
    'start_range_amount' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
    ),
    'end_range_amount' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
    ),
    'date_closed' => 
    array (
      'query_type' => 'default',
    ),
    'stic_range_amount_awarded_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
    ),
    'stic_start_range_amount_awarded_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
    ),
    'stic_end_range_amount_awarded_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
    ),
    'stic_range_amount_charged_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
    ),
    'stic_start_range_amount_charged_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
    ),
    'stic_end_range_amount_charged_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
    ),
    'stic_range_advance_date_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'stic_start_range_advance_date_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'stic_end_range_advance_date_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'stic_range_justification_date_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'stic_start_range_justification_date_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'stic_end_range_justification_date_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'stic_range_paymentn_date_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'stic_start_range_paymentn_date_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'stic_end_range_paymentn_date_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'stic_range_presentation_date_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'stic_start_range_presentation_date_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'stic_end_range_presentation_date_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'stic_range_resolution_date_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'stic_start_range_resolution_date_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'stic_end_range_resolution_date_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'range_stic_presentation_date_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'start_range_stic_presentation_date_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'end_range_stic_presentation_date_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'range_stic_amount_received_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
    ),
    'start_range_stic_amount_received_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
    ),
    'end_range_stic_amount_received_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
    ),
    'range_stic_resolution_date_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'start_range_stic_resolution_date_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'end_range_stic_resolution_date_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'range_stic_advance_date_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'start_range_stic_advance_date_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'end_range_stic_advance_date_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'range_stic_justification_date_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'start_range_stic_justification_date_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'end_range_stic_justification_date_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'range_stic_amount_awarded_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
    ),
    'start_range_stic_amount_awarded_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
    ),
    'end_range_stic_amount_awarded_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
    ),
    'range_stic_payment_date_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'start_range_stic_payment_date_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'end_range_stic_payment_date_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
);
// END STIC-Custom