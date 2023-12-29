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
$popupMeta = array(
    'moduleMain' => 'FP_Event_Locations',
    'varName' => 'FP_Event_Locations',
    'orderBy' => 'fp_event_locations.name',
    'whereClauses' => array(
        'name' => 'fp_event_locations.name',
        'capacity' => 'fp_event_locations.capacity',
        'address' => 'fp_event_locations.address',
        'address_postalcode' => 'fp_event_locations.address_postalcode',
        'address_city' => 'fp_event_locations.address_city',
        'stic_address_county_c' => 'fp_event_locations_cstm.stic_address_county_c',
        'address_state' => 'fp_event_locations.address_state',
        'address_country' => 'fp_event_locations.address_country',
        'stic_address_region_c' => 'fp_event_locations_cstm.stic_address_region_c',
        'assigned_user_name' => 'fp_event_locations.assigned_user_name',
        'description' => 'fp_event_locations.description',
        'created_by_name' => 'fp_event_locations.created_by_name',
        'date_entered' => 'fp_event_locations.date_entered',
        'modified_by_name' => 'fp_event_locations.modified_by_name',
        'date_modified' => 'fp_event_locations.date_modified',
    ),
    'searchInputs' => array(
        1 => 'name',
        4 => 'capacity',
        5 => 'address',
        6 => 'address_postalcode',
        7 => 'address_city',
        8 => 'stic_address_county_c',
        9 => 'address_state',
        10 => 'address_country',
        11 => 'stic_address_region_c',
        12 => 'assigned_user_name',
        13 => 'description',
        14 => 'created_by_name',
        15 => 'date_entered',
        16 => 'modified_by_name',
        17 => 'date_modified',
    ),
    'searchdefs' => array(
        'name' => array(
            'name' => 'name',
            'width' => '10%',
        ),
        'capacity' => array(
            'type' => 'int',
            'label' => 'LBL_CAPACITY',
            'width' => '10%',
            'name' => 'capacity',
        ),
        'address' => array(
            'type' => 'varchar',
            'label' => 'LBL_ADDRESS',
            'width' => '10%',
            'name' => 'address',
        ),
        'address_postalcode' => array(
            'type' => 'varchar',
            'label' => 'LBL_ADDRESS_POSTALCODE',
            'width' => '10%',
            'name' => 'address_postalcode',
        ),
        'address_city' => array(
            'type' => 'varchar',
            'label' => 'LBL_ADDRESS_CITY',
            'width' => '10%',
            'name' => 'address_city',
        ),
        'stic_address_county_c' => array(
            'type' => 'enum',
            'studio' => 'visible',
            'label' => 'LBL_STIC_ADDRESS_COUNTY',
            'width' => '10%',
            'name' => 'stic_address_county_c',
        ),
        'address_state' => array(
            'type' => 'enum',
            'label' => 'LBL_ADDRESS_STATE',
            'width' => '10%',
            'name' => 'address_state',
        ),
        'address_country' => array(
            'type' => 'varchar',
            'label' => 'LBL_ADDRESS_COUNTRY',
            'width' => '10%',
            'name' => 'address_country',
        ),
        'stic_address_region_c' => array(
            'type' => 'enum',
            'studio' => 'visible',
            'label' => 'LBL_STIC_ADDRESS_REGION',
            'width' => '10%',
            'name' => 'stic_address_region_c',
        ),
        'assigned_user_name' => array(
            'link' => true,
            'type' => 'relate',
            'label' => 'LBL_ASSIGNED_TO_NAME',
            'id' => 'ASSIGNED_USER_ID',
            'width' => '10%',
            'name' => 'assigned_user_name',
        ),
        'description' => array(
            'type' => 'text',
            'label' => 'LBL_DESCRIPTION',
            'sortable' => false,
            'width' => '10%',
            'name' => 'description',
        ),
        'created_by_name' => array(
            'type' => 'relate',
            'link' => true,
            'label' => 'LBL_CREATED',
            'id' => 'CREATED_BY',
            'width' => '10%',
            'name' => 'created_by_name',
        ),
        'date_entered' => array(
            'type' => 'datetime',
            'label' => 'LBL_DATE_ENTERED',
            'width' => '10%',
            'name' => 'date_entered',
        ),
        'modified_by_name' => array(
            'type' => 'relate',
            'link' => true,
            'label' => 'LBL_MODIFIED_NAME',
            'id' => 'MODIFIED_USER_ID',
            'width' => '10%',
            'name' => 'modified_by_name',
        ),
        'date_modified' => array(
            'type' => 'datetime',
            'label' => 'LBL_DATE_MODIFIED',
            'width' => '10%',
            'name' => 'date_modified',
        ),
    ),
    'listviewdefs' => array(
        'NAME' => array(
            'width' => '32%',
            'label' => 'LBL_NAME',
            'default' => true,
            'link' => true,
            'name' => 'name',
        ),
        'CAPACITY' => array(
            'type' => 'int',
            'default' => true,
            'label' => 'LBL_CAPACITY',
            'width' => '10%',
            'name' => 'capacity',
        ),
        'ADDRESS' => array(
            'type' => 'varchar',
            'default' => true,
            'label' => 'LBL_ADDRESS',
            'width' => '10%',
            'name' => 'address',
        ),
        'ADDRESS_POSTALCODE' => array(
            'type' => 'varchar',
            'default' => true,
            'label' => 'LBL_ADDRESS_POSTALCODE',
            'width' => '10%',
            'name' => 'address_postalcode',
        ),
        'ADDRESS_CITY' => array(
            'type' => 'varchar',
            'default' => true,
            'label' => 'LBL_ADDRESS_CITY',
            'width' => '10%',
            'name' => 'address_city',
        ),
        'ADDRESS_STATE' => array(
            'type' => 'enum',
            'default' => true,
            'label' => 'LBL_ADDRESS_STATE',
            'width' => '10%',
            'name' => 'address_state',
        ),
        'ASSIGNED_USER_NAME' => array(
            'width' => '9%',
            'label' => 'LBL_ASSIGNED_TO_NAME',
            'module' => 'Employees',
            'id' => 'ASSIGNED_USER_ID',
            'default' => true,
            'name' => 'assigned_user_name',
        ),
    ),
);
