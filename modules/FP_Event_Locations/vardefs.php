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

$dictionary['FP_Event_Locations'] = array(
    'table' => 'fp_event_locations',
    'audited' => true,
    'duplicate_merge' => true,
    'fields' => array(
        'fp_event_locations_fp_events_1' =>
            array(
                'name' => 'fp_event_locations_fp_events_1',
                'type' => 'link',
                'relationship' => 'fp_event_locations_fp_events_1',
                'source' => 'non-db',
                'side' => 'right',
                'vname' => 'LBL_FP_EVENT_LOCATIONS_FP_EVENTS_1_FROM_FP_EVENTS_TITLE',
            ),
        'address' =>
            array(
                'required' => true,
                'name' => 'address',
                'vname' => 'LBL_ADDRESS',
                'type' => 'varchar',
                'massupdate' => '0',
                'default' => '',
                'no_default' => false,
                'comments' => '',
                'help' => 'Location address',
                'importable' => 'true',
                'duplicate_merge' => 'disabled',
                'duplicate_merge_dom_value' => '0',
                'audited' => false,
                'reportable' => true,
                'unified_search' => false,
                'merge_filter' => 'disabled',
                'len' => '255',
                'size' => '20',
            ),
        'address_city' =>
            array(
                'required' => true,
                'name' => 'address_city',
                'vname' => 'LBL_ADDRESS_CITY',
                'type' => 'varchar',
                'massupdate' => '0',
                'default' => null,
                'no_default' => false,
                'comments' => '',
                'help' => '',
                'importable' => 'true',
                'duplicate_merge' => 'disabled',
                'duplicate_merge_dom_value' => '0',
                'audited' => false,
                'reportable' => true,
                'unified_search' => false,
                'merge_filter' => 'disabled',
                'len' => '100',
                'size' => '20',
            ),
        'address_country' =>
            array(
                'required' => false,
                'name' => 'address_country',
                'vname' => 'LBL_ADDRESS_COUNTRY',
                'type' => 'varchar',
                'massupdate' => '0',
                'default' => null,
                'no_default' => false,
                'comments' => '',
                'help' => '',
                'importable' => 'true',
                'duplicate_merge' => 'disabled',
                'duplicate_merge_dom_value' => '0',
                'audited' => false,
                'reportable' => true,
                'unified_search' => false,
                'merge_filter' => 'disabled',
                'len' => '100',
                'size' => '20',
            ),
        'address_postalcode' =>
            array(
                'required' => true,
                'name' => 'address_postalcode',
                'vname' => 'LBL_ADDRESS_POSTALCODE',
                'type' => 'varchar',
                'massupdate' => '0',
                'default' => null,
                'no_default' => false,
                'comments' => '',
                'help' => '',
                'importable' => 'true',
                'duplicate_merge' => 'disabled',
                'duplicate_merge_dom_value' => '0',
                'audited' => false,
                'reportable' => true,
                'unified_search' => false,
                'merge_filter' => 'disabled',
                'len' => '20',
                'size' => '20',
            ),
        'address_state' =>
            array(
                'required' => false,
                'name' => 'address_state',
                'vname' => 'LBL_ADDRESS_STATE',
                'type' => 'varchar',
                'massupdate' => '0',
                'default' => null,
                'no_default' => false,
                'comments' => '',
                'help' => '',
                'importable' => 'true',
                'duplicate_merge' => 'disabled',
                'duplicate_merge_dom_value' => '0',
                'audited' => false,
                'reportable' => true,
                'unified_search' => false,
                'merge_filter' => 'disabled',
                'len' => '100',
                'size' => '20',
            ),
        'capacity' =>
            array(
                'required' => false,
                'name' => 'capacity',
                'vname' => 'LBL_CAPACITY',
                'type' => 'varchar',
                'massupdate' => '0',
                'default' => '',
                'no_default' => false,
                'comments' => 'The maximum amount of people the location can cater for.',
                'help' => 'The capacity of the event location',
                'importable' => 'true',
                'duplicate_merge' => 'disabled',
                'duplicate_merge_dom_value' => '0',
                'audited' => false,
                'reportable' => true,
                'unified_search' => false,
                'merge_filter' => 'disabled',
                'len' => '255',
                'size' => '20',
            ),
        'fp_event_locations_fp_events_1' => array(
            'name' => 'fp_event_locations_fp_events_1',
            'type' => 'link',
            'relationship' => 'fp_event_locations_fp_events_1',
            'source' => 'non-db',
            'side' => 'right',
            'vname' => 'LBL_FP_EVENT_LOCATIONS_FP_EVENTS_1_FROM_FP_EVENTS_TITLE',
        ),
    ),
    'relationships' =>
        array(
            'fp_event_locations_modified_user' =>
                array(
                    'lhs_module' => 'Users',
                    'lhs_table' => 'users',
                    'lhs_key' => 'id',
                    'rhs_module' => 'FP_Event_Locations',
                    'rhs_table' => 'fp_event_locations',
                    'rhs_key' => 'modified_user_id',
                    'relationship_type' => 'one-to-many',
                ),
            'fp_event_locations_created_by' =>
                array(
                    'lhs_module' => 'Users',
                    'lhs_table' => 'users',
                    'lhs_key' => 'id',
                    'rhs_module' => 'FP_Event_Locations',
                    'rhs_table' => 'fp_event_locations',
                    'rhs_key' => 'created_by',
                    'relationship_type' => 'one-to-many',
                ),
            'fp_event_locations_assigned_user' =>
                array(
                    'lhs_module' => 'Users',
                    'lhs_table' => 'users',
                    'lhs_key' => 'id',
                    'rhs_module' => 'FP_Event_Locations',
                    'rhs_table' => 'fp_event_locations',
                    'rhs_key' => 'assigned_user_id',
                    'relationship_type' => 'one-to-many',
                ),
            'optimistic_locking' => true,
            'unified_search' => true,
        ),
);

if (!class_exists('VardefManager')) {
    require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('FP_Event_Locations', 'FP_Event_Locations', array('basic', 'assignable', 'security_groups'));
