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
$listViewDefs[$module_name] =
array(
    'NAME' => array(
        'width' => '32%',
        'label' => 'LBL_NAME',
        'default' => true,
        'link' => true,
    ),
    'STIC_FOLLOWUPS_CONTACTS_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_FOLLOWUPS_CONTACTS_FROM_CONTACTS_TITLE',
        'id' => 'STIC_FOLLOWUPS_CONTACTSCONTACTS_IDA',
        'width' => '10%',
        'default' => true,
    ),
    'TYPE' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_TYPE',
        'width' => '10%',
        'default' => true,
    ),
    'SUBTYPE' => array(
        'type' => 'dynamicenum',
        'studio' => 'visible',
        'label' => 'LBL_SUBTYPE',
        'width' => '10%',
        'default' => true,
    ),
    'STATUS' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_STATUS',
        'width' => '10%',
        'default' => true,
    ),
    'START_DATE' => array(
        'type' => 'datetimecombo',
        'label' => 'LBL_START_DATE',
        'width' => '10%',
        'default' => true,
    ),
    'DURATION' => array(
        'type' => 'int',
        'label' => 'LBL_DURATION',
        'width' => '10%',
        'default' => true,
    ),
    'ASSIGNED_USER_NAME' => array(
        'width' => '9%',
        'label' => 'LBL_ASSIGNED_TO_NAME',
        'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => true,
    ),
    'STIC_GOALS_STIC_FOLLOWUPS_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_GOALS_STIC_FOLLOWUPS_FROM_STIC_GOALS_TITLE',
        'id' => 'STIC_GOALS_STIC_FOLLOWUPSSTIC_GOALS_IDA',
        'width' => '10%',
        'default' => false,
    ),
    'CREATED_BY_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_CREATED',
        'id' => 'CREATED_BY',
        'width' => '10%',
        'default' => false,
    ),
    'MODIFIED_BY_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_MODIFIED_NAME',
        'id' => 'MODIFIED_USER_ID',
        'width' => '10%',
        'default' => false,
    ),
    'DATE_MODIFIED' => array(
        'type' => 'datetime',
        'label' => 'LBL_DATE_MODIFIED',
        'width' => '10%',
        'default' => false,
    ),
    'DESCRIPTION' => array(
        'type' => 'text',
        'label' => 'LBL_DESCRIPTION',
        'sortable' => false,
        'width' => '10%',
        'default' => false,
    ),
    'CHANNEL' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_CHANNEL',
        'width' => '10%',
        'default' => false,
    ),
    'EXTERNAL_CONTACT' => array(
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_EXTERNAL_CONTACT',
        'id' => 'CONTACT_ID_C',
        'link' => true,
        'width' => '10%',
        'default' => false,
    ),
    'ATTENDEES' => array(
        'type' => 'multienum',
        'studio' => 'visible',
        'label' => 'LBL_ATTENDEES',
        'width' => '10%',
        'default' => false,
    ),
    'COLOR' => array(
        'type' => 'color',
        'studio' => 'visible',
        'label' => 'LBL_COLOR',
        'width' => '10%',
        'default' => false,
    ),
    'EXTERNAL_ACCOUNT' => array(
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_EXTERNAL_ACCOUNT',
        'id' => 'ACCOUNT_ID_C',
        'link' => true,
        'width' => '10%',
        'default' => false,
    ),
    'FOLLOWUP_ORIGIN' => array(
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_FOLLOWUP_ORIGIN',
        'id' => 'STIC_FOLLOWUPS_ID1_C',
        'link' => true,
        'width' => '10%',
        'default' => false,
    ),
    'STIC_FOLLOWUPS_STIC_REGISTRATIONS_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_FOLLOWUPS_STIC_REGISTRATIONS_FROM_STIC_REGISTRATIONS_TITLE',
        'id' => 'STIC_FOLLOWUPS_STIC_REGISTRATIONSSTIC_REGISTRATIONS_IDA',
        'width' => '10%',
        'default' => false,
    ),
    'STIC_FOLLOWUPS_PROJECT_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_FOLLOWUPS_PROJECT_FROM_PROJECT_TITLE',
        'id' => 'STIC_FOLLOWUPS_PROJECTPROJECT_IDA',
        'width' => '10%',
        'default' => false,
    ),
    'PENDING_ACTIONS' => array(
        'type' => 'text',
        'studio' => 'visible',
        'label' => 'LBL_PENDING_ACTIONS',
        'sortable' => false,
        'width' => '10%',
        'default' => false,
    ),
    'DATE_ENTERED' => array(
        'type' => 'datetime',
        'label' => 'LBL_DATE_ENTERED',
        'width' => '10%',
        'default' => false,
    ),
);
