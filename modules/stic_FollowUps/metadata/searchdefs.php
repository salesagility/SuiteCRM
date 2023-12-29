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
$module_name = 'stic_FollowUps';
$searchdefs[$module_name] =
array(
    'layout' => array(
        'basic_search' => array(
            'name' => array(
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ),
            'stic_followups_contacts_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_FOLLOWUPS_CONTACTS_FROM_CONTACTS_TITLE',
                'id' => 'STIC_FOLLOWUPS_CONTACTSCONTACTS_IDA',
                'width' => '10%',
                'default' => true,
                'name' => 'stic_followups_contacts_name',
            ),
            'type' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_TYPE',
                'width' => '10%',
                'default' => true,
                'name' => 'type',
            ),
            'subtype' => array(
                'type' => 'dynamicenum',
                'studio' => 'visible',
                'label' => 'LBL_SUBTYPE',
                'width' => '10%',
                'default' => true,
                'name' => 'subtype',
            ),
            'status' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_STATUS',
                'width' => '10%',
                'default' => true,
                'name' => 'status',
            ),
            'start_date' => array(
                'type' => 'datetimecombo',
                'label' => 'LBL_START_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'start_date',
            ),
            'duration' => array(
                'type' => 'int',
                'label' => 'LBL_DURATION',
                'width' => '10%',
                'default' => true,
                'name' => 'duration',
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
                'width' => '10%',
                'default' => true,
            ),
            'current_user_only' => array(
                'name' => 'current_user_only',
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
            ),
            'favorites_only' => array(
                'name' => 'favorites_only',
                'label' => 'LBL_FAVORITES_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
            ),
        ),
        'advanced_search' => array(
            'name' => array(
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ),
            'stic_followups_contacts_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_FOLLOWUPS_CONTACTS_FROM_CONTACTS_TITLE',
                'id' => 'STIC_FOLLOWUPS_CONTACTSCONTACTS_IDA',
                'width' => '10%',
                'default' => true,
                'name' => 'stic_followups_contacts_name',
            ),
            'type' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_TYPE',
                'width' => '10%',
                'default' => true,
                'name' => 'type',
            ),
            'subtype' => array(
                'type' => 'dynamicenum',
                'studio' => 'visible',
                'label' => 'LBL_SUBTYPE',
                'width' => '10%',
                'default' => true,
                'name' => 'subtype',
            ),
            'status' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_STATUS',
                'width' => '10%',
                'default' => true,
                'name' => 'status',
            ),
            'start_date' => array(
                'type' => 'datetimecombo',
                'label' => 'LBL_START_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'start_date',
            ),
            'duration' => array(
                'type' => 'int',
                'label' => 'LBL_DURATION',
                'width' => '10%',
                'default' => true,
                'name' => 'duration',
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
                'width' => '10%',
                'default' => true,
            ),
            'stic_goals_stic_followups_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_GOALS_STIC_FOLLOWUPS_FROM_STIC_GOALS_TITLE',
                'id' => 'STIC_GOALS_STIC_FOLLOWUPSSTIC_GOALS_IDA',
                'width' => '10%',
                'default' => true,
                'name' => 'stic_goals_stic_followups_name',
            ),
            'stic_followups_stic_registrations_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_FOLLOWUPS_STIC_REGISTRATIONS_FROM_STIC_REGISTRATIONS_TITLE',
                'id' => 'STIC_FOLLOWUPS_STIC_REGISTRATIONSSTIC_REGISTRATIONS_IDA',
                'width' => '10%',
                'default' => true,
                'name' => 'stic_followups_stic_registrations_name',
            ),
            'channel' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_CHANNEL',
                'width' => '10%',
                'default' => true,
                'name' => 'channel',
            ),
            'attendees' => array(
                'type' => 'multienum',
                'studio' => 'visible',
                'label' => 'LBL_ATTENDEES',
                'width' => '10%',
                'default' => true,
                'name' => 'attendees',
            ),
            'pending_actions' => array(
                'type' => 'text',
                'studio' => 'visible',
                'label' => 'LBL_PENDING_ACTIONS',
                'sortable' => false,
                'width' => '10%',
                'default' => true,
                'name' => 'pending_actions',
            ),
            'stic_followups_project_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_FOLLOWUPS_PROJECT_FROM_PROJECT_TITLE',
                'id' => 'STIC_FOLLOWUPS_PROJECTPROJECT_IDA',
                'width' => '10%',
                'default' => true,
                'name' => 'stic_followups_project_name',
            ),
            'external_contact' => array(
                'type' => 'relate',
                'studio' => 'visible',
                'label' => 'LBL_EXTERNAL_CONTACT',
                'id' => 'CONTACT_ID_C',
                'link' => true,
                'width' => '10%',
                'default' => true,
                'name' => 'external_contact',
            ),
            'external_account' => array(
                'type' => 'relate',
                'studio' => 'visible',
                'label' => 'LBL_EXTERNAL_ACCOUNT',
                'id' => 'ACCOUNT_ID_C',
                'link' => true,
                'width' => '10%',
                'default' => true,
                'name' => 'external_account',
            ),
            'followup_origin' => array(
                'type' => 'relate',
                'studio' => 'visible',
                'label' => 'LBL_FOLLOWUP_ORIGIN',
                'id' => 'STIC_FOLLOWUPS_ID1_C',
                'link' => true,
                'width' => '10%',
                'default' => true,
                'name' => 'followup_origin',
            ),
            'color' => array(
                'type' => 'color',
                'label' => 'LBL_COLOR',
                'sortable' => false,
                'width' => '10%',
                'default' => true,
                'name' => 'color',
            ),
            'description' => array(
                'type' => 'text',
                'label' => 'LBL_DESCRIPTION',
                'sortable' => false,
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
                'name' => 'current_user_only',
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
            ),
            'favorites_only' => array(
                'name' => 'favorites_only',
                'label' => 'LBL_FAVORITES_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
            ),
        ),
    ),
    'templateMeta' => array(
        'maxColumns' => '3',
        'maxColumnsBasic' => '4',
        'widths' => array(
            'label' => '10',
            'field' => '30',
        ),
    ),
);

?>
