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

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

global $current_user;

$dashletData['stic_GrantsDashlet']['searchFields'] = array(
    'date_entered' => array('default' => ''),
    'date_modified' => array('default' => ''),
    'assigned_user_id' => array(
        'type' => 'assigned_user_name',
        'default' => $current_user->name,
    ),
);
$dashletData['stic_GrantsDashlet']['columns'] = array(
    'name' => array(
        'width' => '10%',
        'label' => 'LBL_NAME',
        'link' => true,
        'default' => true,
    ),
    'type' => array(
        'width' => '10%',
        'label' => 'LBL_TYPE',
        'link' => true,
        'default' => true,
    ),
    'subtype' => array(
        'width' => '10%',
        'label' => 'LBL_SUBTYPE',
        'link' => true,
        'default' => true,
    ),
    'amount' => array(
        'width' => '10%',
        'label' => 'LBL_AMOUNT',
        'link' => true,
        'default' => true,
    ),
    'percentage' => array(
        'width' => '10%',
        'label' => 'LBL_PERCENTAGE',
        'link' => true,
        'default' => true,
    ),
    'start_date' => array(
        'width' => '10%',
        'label' => 'LBL_START_DATE',
        'link' => true,
        'default' => true,
    ),
    'end_date' => array(
        'width' => '10%',
        'label' => 'LBL_END_DATE',
        'link' => true,
        'default' => true,
    ),
    'active' => array(
        'width' => '5%',
        'label' => 'LBL_ACTIVE',
        'link' => true,
        'default' => true,
    ),
    'stic_grants_contacts_name' => array(
        'width' => '10%',
        'label' => 'LBL_STIC_GRANTS_CONTACTS_FROM_CONTACTS_TITLE',
        'link' => true,
        'default' => true,
    ),
    'stic_grants_stic_families_name' => array(
        'width' => '10%',
        'label' => 'LBL_STIC_GRANTS_STIC_FAMILIES_FROM_STIC_FAMILIES_TITLE',
        'link' => true,
        'default' => true,
    ),
    'date_entered' => array(
        'width' => '5%',
        'label' => 'LBL_DATE_ENTERED',
        'default' => true,
    ),
    'date_modified' => array(
        'width' => '5%',
        'label' => 'LBL_DATE_MODIFIED',
    ),
    'created_by' => array(
        'width' => '5%',
        'label' => 'LBL_CREATED',
    ),
    'assigned_user_name' => array(
        'width' => '5%',
        'label' => 'LBL_LIST_ASSIGNED_USER',
    ),
);
