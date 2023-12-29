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
$dashletData['stic_Personal_EnvironmentDashlet']['searchFields'] = array(
    'name' => array(
        'default' => '',
    ),
    'relationship_type' => array(
        'default' => '',
    ),
    'stic_personal_environment_contacts_name' => array(
        'default' => '',
    ),
    'stic_personal_environment_contacts_1_name' => array(
        'default' => '',
    ),
    'stic_personal_environment_accounts_name' => array(
        'default' => '',
    ),

    'assigned_user_id' => array(
        'default' => '',
    ),
);
$dashletData['stic_Personal_EnvironmentDashlet']['columns'] = array(
    'name' => array(
        'width' => '40%',
        'label' => 'LBL_LIST_NAME',
        'link' => true,
        'default' => true,
        'name' => 'name',
    ),
    'stic_personal_environment_contacts_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_PERSONAL_ENVIRONMENT_CONTACTS_FROM_CONTACTS_TITLE',
        'id' => 'STIC_PERSONAL_ENVIRONMENT_CONTACTSCONTACTS_IDA',
        'width' => '10%',
        'default' => true,
    ),
    'stic_personal_environment_contacts_1_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_PERSONAL_ENVIRONMENT_CONTACTS_1_FROM_CONTACTS_TITLE',
        'id' => 'STIC_PERSONAL_ENVIRONMENT_CONTACTS_1CONTACTS_IDA',
        'width' => '10%',
        'default' => true,
    ),
    'stic_personal_environment_accounts_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_PERSONAL_ENVIRONMENT_ACCOUNTS_FROM_ACCOUNTS_TITLE',
        'id' => 'STIC_PERSONAL_ENVIRONMENT_ACCOUNTSACCOUNTS_IDA',
        'width' => '10%',
        'default' => true,
    ),
    'relationship_type' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_RELATIONSHIP_TYPE',
        'width' => '10%',
        'default' => true,
    ),
    'reference_contact' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_REFERENCE_CONTACT',
        'width' => '10%',
        'default' => true,
    ),
    'date_modified' => array(
        'width' => '15%',
        'label' => 'LBL_DATE_MODIFIED',
        'name' => 'date_modified',
        'default' => false,
    ),
    'created_by' => array(
        'width' => '8%',
        'label' => 'LBL_CREATED',
        'name' => 'created_by',
        'default' => false,
    ),
    'date_entered' => array(
        'width' => '15%',
        'label' => 'LBL_DATE_ENTERED',
        'default' => false,
        'name' => 'date_entered',
    ),
    'assigned_user_name' => array(
        'width' => '8%',
        'label' => 'LBL_LIST_ASSIGNED_USER',
        'name' => 'assigned_user_name',
        'default' => false,
    ),
);
