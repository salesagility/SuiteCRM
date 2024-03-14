<?php
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

$module_name = 'FP_Event_Locations';

// STIC-Custom - MHP - 20240201 - Override the core metadata files with the custom metadata files 
// https://github.com/SinergiaTIC/SinergiaCRM/pull/105 
// $searchdefs[$module_name] = array(
//                     'templateMeta' => array(
//                             'maxColumns' => '3',
//                             'maxColumnsBasic' => '4',
//                             'widths' => array('label' => '10', 'field' => '30'),
//                            ),
//                     'layout' => array(
//                         'basic_search' => array(
//                             'name',
//                             array('name'=>'current_user_only', 'label'=>'LBL_CURRENT_USER_FILTER', 'type'=>'bool'),
//                             ),
//                         'advanced_search' => array(
//                             'name',
//                             array('name' => 'assigned_user_id', 'label' => 'LBL_ASSIGNED_TO', 'type' => 'enum', 'function' => array('name' => 'get_user_array', 'params' => array(false))),
//                         ),
//                     ),
//                );

$searchdefs['FP_Event_Locations'] = array(
    'templateMeta' => array(
        'maxColumns' => '3',
        'maxColumnsBasic' => '4',
        'widths' => array(
            'label' => '10',
            'field' => '30',
        ),
    ),
    'layout' => array(
        'basic_search' => array(
            0 => array(
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ),
            1 => array(
                'type' => 'int',
                'default' => true,
                'label' => 'LBL_CAPACITY',
                'width' => '10%',
                'name' => 'capacity',
            ),
            2 => array(
                'type' => 'varchar',
                'default' => true,
                'label' => 'LBL_ADDRESS',
                'width' => '10%',
                'name' => 'address',
            ),
            3 => array(
                'type' => 'varchar',
                'default' => true,
                'label' => 'LBL_ADDRESS_POSTALCODE',
                'width' => '10%',
                'name' => 'address_postalcode',
            ),
            4 => array(
                'type' => 'varchar',
                'default' => true,
                'label' => 'LBL_ADDRESS_CITY',
                'width' => '10%',
                'name' => 'address_city',
            ),
            5 => array(
                'type' => 'enum',
                'default' => true,
                'label' => 'LBL_ADDRESS_STATE',
                'width' => '10%',
                'name' => 'address_state',
            ),
            6 => array(
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
            7 => array(
                'name' => 'current_user_only',
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
            ),
            8 => array(
                'name' => 'favorites_only',
                'label' => 'LBL_FAVORITES_FILTER',
                'type' => 'bool',
                'width' => '10%',
                'default' => true,
            ),
        ),
        'advanced_search' => array(
            0 => array(
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ),
            1 => array(
                'type' => 'int',
                'default' => true,
                'label' => 'LBL_CAPACITY',
                'width' => '10%',
                'name' => 'capacity',
            ),
            2 => array(
                'type' => 'varchar',
                'default' => true,
                'label' => 'LBL_ADDRESS',
                'width' => '10%',
                'name' => 'address',
            ),
            3 => array(
                'type' => 'varchar',
                'default' => true,
                'label' => 'LBL_ADDRESS_CITY',
                'width' => '10%',
                'name' => 'address_city',
            ),
            4 => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_ADDRESS_COUNTY',
                'width' => '10%',
                'name' => 'stic_address_county_c',
            ),
            5 => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_ADDRESS_REGION',
                'width' => '10%',
                'name' => 'stic_address_region_c',
            ),
            6 => array(
                'type' => 'varchar',
                'default' => true,
                'label' => 'LBL_ADDRESS_POSTALCODE',
                'width' => '10%',
                'name' => 'address_postalcode',
            ),
            7 => array(
                'type' => 'enum',
                'default' => true,
                'label' => 'LBL_ADDRESS_STATE',
                'width' => '10%',
                'name' => 'address_state',
            ),
            8 => array(
                'type' => 'varchar',
                'default' => true,
                'label' => 'LBL_ADDRESS_COUNTRY',
                'width' => '10%',
                'name' => 'address_country',
            ),
            9 => array(
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
            10 => array(
                'type' => 'text',
                'label' => 'LBL_DESCRIPTION',
                'sortable' => false,
                'width' => '10%',
                'default' => true,
                'name' => 'description',
            ),
            11 => array(
                'type' => 'assigned_user_name',
                'label' => 'LBL_CREATED',
                'width' => '10%',
                'default' => true,
                'name' => 'created_by',
            ),
            12 => array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_ENTERED',
                'width' => '10%',
                'default' => true,
                'name' => 'date_entered',
            ),
            13 => array(
                'type' => 'assigned_user_name',
                'label' => 'LBL_MODIFIED',
                'width' => '10%',
                'default' => true,
                'name' => 'modified_user_id',
            ),
            14 => array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_MODIFIED',
                'width' => '10%',
                'default' => true,
                'name' => 'date_modified',
            ),
            15 => array(
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
                'name' => 'current_user_only',
            ),
            16 => array(
                'name' => 'favorites_only',
                'label' => 'LBL_FAVORITES_FILTER',
                'type' => 'bool',
                'width' => '10%',
                'default' => true,
            ),
        ),
    ),
);
// END STIC-Custom