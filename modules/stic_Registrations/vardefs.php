<?php
/**
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */

$dictionary['stic_Registrations'] = array(
    'table' => 'stic_registrations',
    'audited' => 1,
    'inline_edit' => 1,
    'duplicate_merge' => 1,
    'fields' => array(
        'status' => array(
            'required' => 1,
            'name' => 'status',
            'vname' => 'LBL_STATUS',
            'type' => 'enum',
            'massupdate' => 1,
            'no_default' => 0,
            'comments' => '',
            'help' => '',
            'importable' => 'required',
            'audited' => 0,
            'reportable' => 1,
            'unified_search' => 0,
            'len' => 100,
            'size' => '20',
            'options' => 'stic_registrations_status_list',
            'studio' => 'visible',
            'dependency' => 0,
            'inline_edit' => 1,
            'default' => '',
            'duplicate_merge' => 'enabled',
            'merge_filter' => 'enabled',
            'dependency' => 0,
        ),
        'registration_date' => array(
            'required' => 1,
            'name' => 'registration_date',
            'vname' => 'LBL_REGISTRATION_DATE',
            'type' => 'datetimecombo',
            'massupdate' => 1,
            'no_default' => 0,
            'comments' => '',
            'help' => '',
            'importable' => 'required',
            'audited' => 0,
            'reportable' => 1,
            'unified_search' => 0,
            'size' => '20',
            'enable_range_search' => 1,
            'options' => 'date_range_search_dom',
            'dbType' => 'datetime',
            'duplicate_merge' => 'enabled',
            'merge_filter' => 'enabled',
        ),
        'not_participating_reason' => array(
            'required' => 0,
            'name' => 'not_participating_reason',
            'vname' => 'LBL_NOT_PARTICIPATING_REASON',
            'type' => 'enum',
            'massupdate' => 1,
            'no_default' => 0,
            'comments' => '',
            'help' => '',
            'importable' => 1,
            'audited' => 0,
            'reportable' => 1,
            'unified_search' => 0,
            'len' => 100,
            'size' => '20',
            'options' => 'stic_registrations_not_participating_reasons_list',
            'studio' => 'visible',
            'dependency' => 0,
            'inline_edit' => 1,
            'default' => '',
            'duplicate_merge' => 'enabled',
            'merge_filter' => 'enabled',
        ),
        'rejection_reason' => array(
            'required' => 0,
            'name' => 'rejection_reason',
            'vname' => 'LBL_REJECTION_REASON',
            'type' => 'enum',
            'massupdate' => 1,
            'no_default' => 0,
            'comments' => '',
            'help' => '',
            'importable' => 1,
            'audited' => 0,
            'reportable' => 1,
            'unified_search' => 0,
            'len' => 100,
            'size' => '20',
            'options' => 'stic_registrations_rejection_reasons_list',
            'studio' => 'visible',
            'dependency' => 0,
            'inline_edit' => 1,
            'default' => '',
            'duplicate_merge' => 'enabled',
            'merge_filter' => 'enabled',
        ),
        'participation_type' => array(
            'required' => 0,
            'name' => 'participation_type',
            'vname' => 'LBL_PARTICIPATION_TYPE',
            'type' => 'enum',
            'massupdate' => 1,
            'no_default' => 0,
            'comments' => '',
            'help' => '',
            'importable' => 1,
            'audited' => 0,
            'reportable' => 1,
            'unified_search' => 0,
            'len' => 100,
            'size' => '20',
            'options' => 'stic_registrations_participation_types_list',
            'studio' => 'visible',
            'dependency' => 0,
            'inline_edit' => 1,
            'default' => '',
            'duplicate_merge' => 'enabled',
            'merge_filter' => 'enabled',
        ),
        'special_needs' => array(
            'required' => 0,
            'name' => 'special_needs',
            'vname' => 'LBL_SPECIAL_NEEDS',
            'type' => 'enum',
            'massupdate' => 1,
            'default' => '',
            'no_default' => 0,
            'comments' => '',
            'help' => '',
            'importable' => 1,
            'audited' => 0,
            'reportable' => 1,
            'unified_search' => 0,
            'len' => 100,
            'size' => '20',
            'options' => 'stic_boolean_list',
            'studio' => 'visible',
            'dependency' => 0,
            'inline_edit' => 1,
            'duplicate_merge' => 'enabled',
            'merge_filter' => 'enabled',
        ),
        'special_needs_description' => array(
            'required' => 0,
            'name' => 'special_needs_description',
            'vname' => 'LBL_SPECIAL_NEEDS_DESCRIPTION',
            'type' => 'varchar',
            'massupdate' => 0,
            'no_default' => 0,
            'comments' => '',
            'help' => '',
            'importable' => 1,
            'audited' => 0,
            'reportable' => 1,
            'unified_search' => 0,
            'len' => '255',
            'size' => '20',
            'duplicate_merge' => 'enabled',
            'merge_filter' => 'enabled',
            'inline_edit' => 1,
        ),
        'attendance_percentage' => array(
            'required' => 0,
            'name' => 'attendance_percentage',
            'vname' => 'LBL_ATTENDANCE_PERCENTAGE',
            'type' => 'decimal',
            'precision' => 2,
            'len' => '10',
            'size' => '10',
            'massupdate' => 0, // autocalc
            'reportable' => 1,
            'audited' => 0,
            'importable' => 1,
            'enable_range_search' => 1,
            'options' => 'numeric_range_search_dom',
            'duplicate_merge' => 'enabled',
            'merge_filter' => 'enabled',
            'inline_edit' => 0,
            'studio' => array(
                'editview' => false,
                'quickcreate' => false,
            ),
        ),
        'attended_hours' => array(
            'name' => 'attended_hours',
            'vname' => 'LBL_ATTENDED_HOURS',
            'type' => 'decimal',
            'precision' => '2',
            'len' => '10',
            'size' => '10',
            'massupdate' => 0, // autocalc
            'required' => 0,
            'reportable' => 1,
            'audited' => 0,
            'importable' => 1,
            'enable_range_search' => 1,
            'options' => 'numeric_range_search_dom',
            'duplicate_merge' => 'enabled',
            'merge_filter' => 'enabled',
            'inline_edit' => 0,
            'studio' => array(
                'editview' => false,
                'quickcreate' => false,
            ),
        ),
        'attendees' => array(
            'required' => 1,
            'name' => 'attendees',
            'vname' => 'LBL_ATTENDEES',
            'type' => 'int',
            'massupdate' => 1,
            'default' => '1',
            'no_default' => 0,
            'comments' => '',
            'help' => '',
            'importable' => 'required',
            'audited' => 0,
            'inline_edit' => 1,
            'reportable' => 1,
            'unified_search' => 0,
            'len' => '255',
            'size' => '20',
            'enable_range_search' => 1,
            'options' => 'numeric_range_search_dom',
            'disable_num_format' => '1',
            'min' => 1,
            'duplicate_merge' => 'enabled',
            'merge_filter' => 'enabled',
            // 'validation' => array('type' => 'range', 'min' => 1, 'max' => 999999),
        ),
        'disabled_weekdays' => array(
            'name' => 'disabled_weekdays',
            'vname' => 'LBL_DISABLED_WEEKDAYS',
            'comments' => '',
            'help' => '',
            'type' => 'multienum',
            'size' => '20',
            'options' => 'stic_weekdays_list',
            'isMultiSelect' => true,
            'required' => 0,
            'audited' => 0,
            'unified_search' => 0,
            'default' => '^^',
            'no_default' => 0,
            'inline_edit' => 1,
            'importable' => 1,
            'massupdate' => 1,
            'reportable' => 1,
            'duplicate_merge' => 'enabled',
            'duplicate_merge_dom_value' => 1,
            'merge_filter' => 'enabled',
            'popupHelp'=> 'LBL_DISABLED_WEEKDAYS_INFO',
        ),
        'session_amount' => array(
            'required' => 0,
            'name' => 'session_amount',
            'vname' => 'LBL_SESSION_AMOUNT',
            'duplicate_merge' => 'enabled',
            'merge_filter' => 'enabled',
            'type' => 'decimal',
            'massupdate' => 1,
            'no_default' => 0,
            'comments' => '',
            'help' => '',
            'importable' => '1',
            'audited' => 0,
            'reportable' => 1,
            'unified_search' => 0,
            'len' => 26,
            'size' => '20',
            'options' => 'numeric_range_search_dom',
            'enable_range_search' => 1,
            'precision' => 2,
            'inline_edit' => 1,
            'popupHelp' => 'LBL_SESSION_AMOUNT_INFO',
        ),
        'stic_registrations_contacts' => array(
            'name' => 'stic_registrations_contacts',
            'type' => 'link',
            'relationship' => 'stic_registrations_contacts',
            'source' => 'non-db',
            'module' => 'Contacts',
            'bean_name' => 'Contact',
            'vname' => 'LBL_STIC_REGISTRATIONS_CONTACTS_FROM_CONTACTS_TITLE',
            'id_name' => 'stic_registrations_contactscontacts_ida',
        ),
        'stic_registrations_contacts_name' => array(
            'name' => 'stic_registrations_contacts_name',
            'type' => 'relate',
            'source' => 'non-db',
            'vname' => 'LBL_STIC_REGISTRATIONS_CONTACTS_FROM_CONTACTS_TITLE',
            'save' => 1,
            'inline_edit' => 1,
            'massupdate' => 0, // unusual
            'id_name' => 'stic_registrations_contactscontacts_ida',
            'link' => 'stic_registrations_contacts',
            'table' => 'contacts',
            'module' => 'Contacts',
            'rname' => 'name',
            'db_concat_fields' => array(
                0 => 'first_name',
                1 => 'last_name',
            ),
        ),
        'stic_registrations_contactscontacts_ida' => array(
            'name' => 'stic_registrations_contactscontacts_ida',
            'type' => 'link',
            'relationship' => 'stic_registrations_contacts',
            'source' => 'non-db',
            'reportable' => 0,
            'side' => 'right',
            'vname' => 'LBL_STIC_REGISTRATIONS_CONTACTS_FROM_STIC_REGISTRATIONS_TITLE',
        ),
        'stic_registrations_accounts' => array(
            'name' => 'stic_registrations_accounts',
            'type' => 'link',
            'relationship' => 'stic_registrations_accounts',
            'source' => 'non-db',
            'module' => 'Accounts',
            'bean_name' => 'Account',
            'vname' => 'LBL_STIC_REGISTRATIONS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
            'id_name' => 'stic_registrations_accountsaccounts_ida',
        ),
        'stic_registrations_accounts_name' => array(
            'name' => 'stic_registrations_accounts_name',
            'type' => 'relate',
            'source' => 'non-db',
            'vname' => 'LBL_STIC_REGISTRATIONS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
            'save' => 1,
            'inline_edit' => 1,
            'massupdate' => 0, // unusual
            'id_name' => 'stic_registrations_accountsaccounts_ida',
            'link' => 'stic_registrations_accounts',
            'table' => 'accounts',
            'module' => 'Accounts',
            'rname' => 'name',
        ),
        'stic_registrations_accountsaccounts_ida' => array(
            'name' => 'stic_registrations_accountsaccounts_ida',
            'type' => 'link',
            'relationship' => 'stic_registrations_accounts',
            'source' => 'non-db',
            'reportable' => 0,
            'side' => 'right',
            'vname' => 'LBL_STIC_REGISTRATIONS_ACCOUNTS_FROM_STIC_REGISTRATIONS_TITLE',
        ),
        'stic_registrations_leads' => array(
            'name' => 'stic_registrations_leads',
            'type' => 'link',
            'relationship' => 'stic_registrations_leads',
            'source' => 'non-db',
            'module' => 'Leads',
            'bean_name' => 'Lead',
            'vname' => 'LBL_STIC_REGISTRATIONS_LEADS_FROM_LEADS_TITLE',
            'id_name' => 'stic_registrations_leadsleads_ida',
        ),
        'stic_registrations_leads_name' => array(
            'name' => 'stic_registrations_leads_name',
            'type' => 'relate',
            'source' => 'non-db',
            'vname' => 'LBL_STIC_REGISTRATIONS_LEADS_FROM_LEADS_TITLE',
            'save' => 1,
            'inline_edit' => 1,
            'massupdate' => 0, // unusual
            'id_name' => 'stic_registrations_leadsleads_ida',
            'link' => 'stic_registrations_leads',
            'table' => 'leads',
            'module' => 'Leads',
            'rname' => 'name',
            'db_concat_fields' => array(
                0 => 'first_name',
                1 => 'last_name',
            ),

        ),
        'stic_registrations_leadsleads_ida' => array(
            'name' => 'stic_registrations_leadsleads_ida',
            'type' => 'link',
            'relationship' => 'stic_registrations_leads',
            'source' => 'non-db',
            'reportable' => 0,
            'side' => 'right',
            'vname' => 'LBL_STIC_REGISTRATIONS_LEADS_FROM_STIC_REGISTRATIONS_TITLE',
        ),
        'stic_registrations_stic_events' => array(
            'name' => 'stic_registrations_stic_events',
            'type' => 'link',
            'relationship' => 'stic_registrations_stic_events',
            'source' => 'non-db',
            'module' => 'stic_Events',
            'bean_name' => 'stic_Events',
            'vname' => 'LBL_STIC_REGISTRATIONS_STIC_EVENTS_FROM_STIC_EVENTS_TITLE',
            'id_name' => 'stic_registrations_stic_eventsstic_events_ida',
        ),
        'stic_registrations_stic_events_name' => array(
            'name' => 'stic_registrations_stic_events_name',
            'type' => 'relate',
            'source' => 'non-db',
            'vname' => 'LBL_STIC_REGISTRATIONS_STIC_EVENTS_FROM_STIC_EVENTS_TITLE',
            'save' => 1,
            'id_name' => 'stic_registrations_stic_eventsstic_events_ida',
            'link' => 'stic_registrations_stic_events',
            'table' => 'stic_events',
            'module' => 'stic_Events',
            'required' => 1,
            'importable' => 'required',
            'rname' => 'name',
            'massupdate' => 1,
            'inline_edit' => 1,
        ),
        'stic_registrations_stic_eventsstic_events_ida' => array(
            'name' => 'stic_registrations_stic_eventsstic_events_ida',
            'type' => 'link',
            'relationship' => 'stic_registrations_stic_events',
            'source' => 'non-db',
            'reportable' => 0,
            'side' => 'right',
            'vname' => 'LBL_STIC_REGISTRATIONS_STIC_EVENTS_FROM_STIC_REGISTRATIONS_TITLE',
        ),
        'stic_payments_stic_registrations' => array(
            'name' => 'stic_payments_stic_registrations',
            'type' => 'link',
            'relationship' => 'stic_payments_stic_registrations',
            'source' => 'non-db',
            'module' => 'stic_Payments',
            'bean_name' => 'stic_Payments',
            'vname' => 'LBL_STIC_PAYMENTS_STIC_REGISTRATIONS_FROM_STIC_PAYMENTS_TITLE',
            'id_name' => 'stic_payments_stic_registrationsstic_payments_ida',
        ),
        'stic_payments_stic_registrations_name' => array(
            'name' => 'stic_payments_stic_registrations_name',
            'type' => 'relate',
            'source' => 'non-db',
            'vname' => 'LBL_STIC_PAYMENTS_STIC_REGISTRATIONS_FROM_STIC_PAYMENTS_TITLE',
            'save' => 1,
            'id_name' => 'stic_payments_stic_registrationsstic_payments_ida',
            'link' => 'stic_payments_stic_registrations',
            'table' => 'stic_payments',
            'module' => 'stic_Payments',
            'rname' => 'name',
            'massupdate' => 0, // unusual
            'inline_edit' => 1,
        ),
        'stic_payments_stic_registrationsstic_payments_ida' => array(
            'name' => 'stic_payments_stic_registrationsstic_payments_ida',
            'type' => 'link',
            'relationship' => 'stic_payments_stic_registrations',
            'source' => 'non-db',
            'reportable' => 0,
            'side' => 'left',
            'vname' => 'LBL_STIC_PAYMENTS_STIC_REGISTRATIONS_FROM_STIC_PAYMENTS_TITLE',
        ),
        'stic_attendances_stic_registrations' => array(
            'name' => 'stic_attendances_stic_registrations',
            'type' => 'link',
            'relationship' => 'stic_attendances_stic_registrations',
            'source' => 'non-db',
            'module' => 'stic_Attendances',
            'bean_name' => 'stic_Attendances',
            'side' => 'right',
            'vname' => 'LBL_STIC_ATTENDANCES_STIC_REGISTRATIONS_FROM_STIC_ATTENDANCES_TITLE',
        ),
        'stic_followups_stic_registrations' => array(
            'name' => 'stic_followups_stic_registrations',
            'type' => 'link',
            'relationship' => 'stic_followups_stic_registrations',
            'source' => 'non-db',
            'module' => 'stic_FollowUps',
            'bean_name' => 'stic_FollowUps',
            'vname' => 'LBL_STIC_FOLLOWUPS_STIC_REGISTRATIONS_FROM_STIC_FOLLOWUPS_TITLE',
        ),
        'stic_goals_stic_registrations' => array(
            'name' => 'stic_goals_stic_registrations',
            'type' => 'link',
            'relationship' => 'stic_goals_stic_registrations',
            'source' => 'non-db',
            'module' => 'stic_Goals',
            'bean_name' => 'stic_Goals',
            'vname' => 'LBL_STIC_GOALS_STIC_REGISTRATIONS_FROM_STIC_GOALS_TITLE',
        ),
        'stic_registrations_activities_calls' => array(
            'name' => 'stic_registrations_activities_calls',
            'type' => 'link',
            'relationship' => 'stic_registrations_activities_calls',
            'source' => 'non-db',
            'module' => 'Calls',
            'bean_name' => 'Call',
            'vname' => 'LBL_STIC_REGISTRATIONS_ACTIVITIES_CALLS_FROM_CALLS_TITLE',
        ),
        'stic_registrations_activities_emails' => array(
            'name' => 'stic_registrations_activities_emails',
            'type' => 'link',
            'relationship' => 'stic_registrations_activities_emails',
            'source' => 'non-db',
            'module' => 'Emails',
            'bean_name' => 'Email',
            'vname' => 'LBL_STIC_REGISTRATIONS_ACTIVITIES_EMAILS_FROM_EMAILS_TITLE',
        ),
        'stic_registrations_activities_meetings' => array(
            'name' => 'stic_registrations_activities_meetings',
            'type' => 'link',
            'relationship' => 'stic_registrations_activities_meetings',
            'source' => 'non-db',
            'module' => 'Meetings',
            'bean_name' => 'Meeting',
            'vname' => 'LBL_STIC_REGISTRATIONS_ACTIVITIES_MEETINGS_FROM_MEETINGS_TITLE',
        ),
        'stic_registrations_activities_notes' => array(
            'name' => 'stic_registrations_activities_notes',
            'type' => 'link',
            'relationship' => 'stic_registrations_activities_notes',
            'source' => 'non-db',
            'module' => 'Notes',
            'bean_name' => 'Note',
            'vname' => 'LBL_STIC_REGISTRATIONS_ACTIVITIES_NOTES_FROM_NOTES_TITLE',
        ),
        'stic_registrations_activities_tasks' => array(
            'name' => 'stic_registrations_activities_tasks',
            'type' => 'link',
            'relationship' => 'stic_registrations_activities_tasks',
            'source' => 'non-db',
            'module' => 'Tasks',
            'bean_name' => 'Task',
            'vname' => 'LBL_STIC_REGISTRATIONS_ACTIVITIES_TASKS_FROM_TASKS_TITLE',
        ),
        'stic_payment_commitments_stic_registrations' => array (
            'name' => 'stic_payment_commitments_stic_registrations',
            'type' => 'link',
            'relationship' => 'stic_payment_commitments_stic_registrations',
            'source' => 'non-db',
            'module' => 'stic_Payment_Commitments',
            'bean_name' => 'stic_Payment_Commitments',
            'vname' => 'LBL_STIC_PAYMENT_COMMITMENTS_STIC_REGISTRATIONS_FROM_STIC_PAYMENT_COMMITMENTS_TITLE',
            'id_name' => 'stic_payme96d2itments_ida',
        ),
        'stic_payment_commitments_stic_registrations_name' => array (
            'name' => 'stic_payment_commitments_stic_registrations_name',
            'type' => 'relate',
            'source' => 'non-db',
            'vname' => 'LBL_STIC_PAYMENT_COMMITMENTS_STIC_REGISTRATIONS_FROM_STIC_PAYMENT_COMMITMENTS_TITLE',
            'save' => true,
            'id_name' => 'stic_payme96d2itments_ida',
            'link' => 'stic_payment_commitments_stic_registrations',
            'table' => 'stic_payment_commitments',
            'module' => 'stic_Payment_Commitments',
            'rname' => 'name',
        ),
        'stic_payme96d2itments_ida' => array (
            'name' => 'stic_payme96d2itments_ida',
            'type' => 'link',
            'relationship' => 'stic_payment_commitments_stic_registrations',
            'source' => 'non-db',
            'reportable' => false,
            'side' => 'right',
            'vname' => 'LBL_STIC_PAYMENT_COMMITMENTS_STIC_REGISTRATIONS_FROM_STIC_REGISTRATIONS_TITLE',
        ),
    ),
    'relationships' => array(
    ),
    'optimistic_locking' => 1,
    'unified_search' => 1,
    'unified_search_default_enabled' => true,
);
if (!class_exists('VardefManager')) {
    require_once 'include/SugarObjects/VardefManager.php';
}
VardefManager::createVardef('stic_Registrations', 'stic_Registrations', array('basic', 'assignable', 'security_groups'));

// Set special values for SuiteCRM base fields
$dictionary['stic_Registrations']['fields']['name']['required'] = '0'; // Name is not required in this module
$dictionary['stic_Registrations']['fields']['name']['importable'] = true; // Name is importable but not required in this module
$dictionary['stic_Registrations']['fields']['description']['rows'] = '2'; // Make textarea fields shorter
