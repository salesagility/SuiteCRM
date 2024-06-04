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

$dashletData['stic_Time_TrackerDashlet']['searchFields'] = array(
    'name' => array(
        'default' => '',
    ),
    'assigned_user_id' => array(
        'default' => '',
    ),    
    'start_date' => array(
        'default' => '',
    ),
    'end_date' => array(
        'default' => '',
    ),
    'duration' => array(
        'default' => '',
    ),    
    'description' => array(
        'default' => '',
    ),
    'date_entered' => array(
        'default' => '',
    ),   
    'date_modified' => array(
        'default' => '',
    ),
    'created_by_name' => array(
        'default' => '',
    ),
    'modified_by_name' => array(
        'default' => '',
    ),
);
$dashletData['stic_Time_TrackerDashlet']['columns'] = array(
    'name' => array(
        'width' => '40',
        'label' => 'LBL_LIST_NAME',
        'link' => true,
        'default' => true
    ),
    'start_date' => array(
        'type' => 'datetimecombo',
        'label' => 'LBL_START_DATE',
        'width' => '10%',
        'default' => true,
    ),
    'end_date' => array(
        'type' => 'datetimecombo',
        'label' => 'LBL_END_DATE',
        'width' => '10%',
        'default' => true,
    ),       
    'duration' => array(
        'type' => 'int',
        'label' => 'LBL_DURATION',
        'width' => '10%',
        'default' => true,
    ), 
    'assigned_user_name' => array(
        'width' => '8',
        'label' => 'LBL_LIST_ASSIGNED_USER',
        'default' => true        
    ),      
    'date_entered' => array(
        'width' => '15',
        'label' => 'LBL_DATE_ENTERED',
        'default' => false
    ),
    'date_modified' => array(
        'width' => '15',
        'label' => 'LBL_DATE_MODIFIED',
        'default' => false
    ),
    'created_by' => array(
        'width' => '8',
        'label' => 'LBL_CREATED',
        'default' => false        
    ),
);
