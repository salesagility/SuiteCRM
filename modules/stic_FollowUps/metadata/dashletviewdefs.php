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
$dashletData['stic_FollowUpsDashlet']['searchFields'] = array(
    'name' => array(
        'default' => '',
    ),
    'stic_followups_contacts_name' => array(
        'default' => '',
    ),
    'type' => array(
        'default' => '',
    ),
    'status' => array(
        'default' => '',
    ),
    'stic_followups_project_name' => array(
        'default' => '',
    ),
    'assigned_user_id' => array(
        'default' => '',
    ),
);
$dashletData['stic_FollowUpsDashlet']['columns'] = array(
    'name' => array(
        'width' => '40%',
        'label' => 'LBL_LIST_NAME',
        'link' => true,
        'default' => true,
        'name' => 'name',
    ),
    'stic_followups_contacts_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_FOLLOWUPS_CONTACTS_FROM_CONTACTS_TITLE',
        'id' => 'STIC_FOLLOWUPS_CONTACTSCONTACTS_IDA',
        'width' => '10%',
        'default' => true,
    ),
    'type' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_TYPE',
        'width' => '10%',
        'default' => true,
    ),
    'status' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_STATUS',
        'width' => '10%',
        'default' => true,
    ),
    'start_date' => array(
        'type' => 'datetimecombo',
        'label' => 'LBL_START_DATE',
        'width' => '10%',
        'default' => true,
    ),
    'duration' => array(
        'type' => 'int',
        'label' => 'LBL_DURATION',
        'width' => '10%',
        'default' => true,
    ),
    'stic_goals_stic_followups_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_GOALS_STIC_FOLLOWUPS_FROM_STIC_GOALS_TITLE',
        'id' => 'STIC_GOALS_STIC_FOLLOWUPSSTIC_GOALS_IDA',
        'width' => '10%',
        'default' => false,
    ),
    'stic_followups_stic_registrations_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_FOLLOWUPS_STIC_REGISTRATIONS_FROM_STIC_REGISTRATIONS_TITLE',
        'id' => 'STIC_FOLLOWUPS_STIC_REGISTRATIONSSTIC_REGISTRATIONS_IDA',
        'width' => '10%',
        'default' => false,
    ),
    'stic_followups_project_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_FOLLOWUPS_PROJECT_FROM_PROJECT_TITLE',
        'id' => 'STIC_FOLLOWUPS_PROJECTPROJECT_IDA',
        'width' => '10%',
        'default' => false,
    ),
    'followup_origin' => array(
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_FOLLOWUP_ORIGIN',
        'id' => 'STIC_FOLLOWUPS_ID1_C',
        'link' => true,
        'width' => '10%',
        'default' => false,
    ),
    'external_account' => array(
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_EXTERNAL_ACCOUNT',
        'id' => 'ACCOUNT_ID_C',
        'link' => true,
        'width' => '10%',
        'default' => false,
    ),
    'external_contact' => array(
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_EXTERNAL_CONTACT',
        'id' => 'CONTACT_ID_C',
        'link' => true,
        'width' => '10%',
        'default' => false,
    ),
    'pending_actions' => array(
        'type' => 'text',
        'studio' => 'visible',
        'label' => 'LBL_PENDING_ACTIONS',
        'sortable' => false,
        'width' => '10%',
        'default' => false,
    ),
    'attendees' => array(
        'type' => 'multienum',
        'studio' => 'visible',
        'label' => 'LBL_ATTENDEES',
        'width' => '10%',
        'default' => false,
    ),
    'subtype' => array(
        'type' => 'dynamicenum',
        'studio' => 'visible',
        'label' => 'LBL_SUBTYPE',
        'width' => '10%',
        'default' => false,
    ),
    'channel' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_CHANNEL',
        'width' => '10%',
        'default' => false,
    ),
    'color' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_COLOR',
        'width' => '10%',
        'default' => false,
    ),
    'description' => array(
        'type' => 'text',
        'label' => 'LBL_DESCRIPTION',
        'sortable' => false,
        'width' => '10%',
        'default' => false,
    ),
    'date_modified' => array(
        'width' => '15%',
        'label' => 'LBL_DATE_MODIFIED',
        'name' => 'date_modified',
        'default' => false,
    ),
    'modified_by_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_MODIFIED_NAME',
        'id' => 'MODIFIED_USER_ID',
        'width' => '10%',
        'default' => false,
    ),
    'date_entered' => array(
        'width' => '15%',
        'label' => 'LBL_DATE_ENTERED',
        'default' => false,
        'name' => 'date_entered',
    ),
    'created_by_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_CREATED',
        'id' => 'CREATED_BY',
        'width' => '10%',
        'default' => false,
    ),
    'created_by' => array(
        'width' => '8%',
        'label' => 'LBL_CREATED',
        'name' => 'created_by',
        'default' => false,
    ),
    'assigned_user_name' => array(
        'width' => '8%',
        'label' => 'LBL_LIST_ASSIGNED_USER',
        'name' => 'assigned_user_name',
        'default' => false,
    ),
);
