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

$module_name = 'AOS_Products';

// STIC-Custom - MHP - 20240201 - Override the core metadata files with the custom metadata files 
// https://github.com/SinergiaTIC/SinergiaCRM/pull/105
// $searchdefs [$module_name] =
// array(
//   'layout' =>
//   array(
//     'basic_search' =>
//     array(
//       0 => 'name',
//       1 =>
//       array(
//         'name' => 'current_user_only',
//         'label' => 'LBL_CURRENT_USER_FILTER',
//         'type' => 'bool',
//       ),
//         'favorites_only' => array('name' => 'favorites_only','label' => 'LBL_FAVORITES_FILTER','type' => 'bool',),
//     ),
//     'advanced_search' =>
//     array(
//       'name' =>
//       array(
//         'name' => 'name',
//         'default' => true,
//         'width' => '10%',
//       ),
//       'part_number' =>
//       array(
//         'name' => 'part_number',
//         'default' => true,
//         'width' => '10%',
//       ),
//       'cost' =>
//       array(
//         'name' => 'cost',
//         'default' => true,
//         'width' => '10%',
//       ),
//       'price' =>
//       array(
//         'name' => 'price',
//         'default' => true,
//         'width' => '10%',
//       ),
//       'created_by' =>
//       array(
//         'name' => 'created_by',
//         'label' => 'LBL_CREATED',
//         'type' => 'enum',
//         'function' =>
//         array(
//           'name' => 'get_user_array',
//           'params' =>
//           array(
//             0 => false,
//           ),
//         ),
//         'default' => true,
//         'width' => '10%',
//       ),
//     ),
//   ),
//   'templateMeta' =>
//   array(
//     'maxColumns' => '3',
//     'widths' =>
//     array(
//       'label' => '10',
//       'field' => '30',
//     ),
//   ),
// );

$searchdefs[$module_name] =
array(
    'layout' => array(
        'basic_search' => array(
            'name' => array(
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ),
            'part_number' => array(
                'name' => 'part_number',
                'default' => true,
                'width' => '10%',
            ),
            'type' => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_TYPE',
                'width' => '10%',
                'name' => 'type',
            ),
            'aos_product_category_name' => array(
                'type' => 'relate',
                'studio' => 'visible',
                'label' => 'LBL_AOS_PRODUCT_CATEGORYS_NAME',
                'id' => 'AOS_PRODUCT_CATEGORY_ID',
                'link' => true,
                'width' => '10%',
                'default' => true,
                'name' => 'aos_product_category_name',
            ),
            'contact' => array(
                'type' => 'relate',
                'studio' => 'visible',
                'label' => 'LBL_CONTACT',
                'id' => 'CONTACT_ID',
                'link' => true,
                'width' => '10%',
                'default' => true,
                'name' => 'contact',
            ),
            'cost' => array(
                'name' => 'cost',
                'default' => true,
                'width' => '10%',
            ),
            'price' => array(
                'name' => 'price',
                'default' => true,
                'width' => '10%',
            ),
            'assigned_user_name' => array(
                'link' => true,
                'type' => 'relate',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'id' => 'ASSIGNED_USER_ID',
                'width' => '10%',
                'default' => true,
                'name' => 'assigned_user_name',
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
            'maincode' => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_MAINCODE',
                'width' => '10%',
                'name' => 'maincode',
            ),
            'part_number' => array(
                'name' => 'part_number',
                'default' => true,
                'width' => '10%',
            ),
            'type' => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_TYPE',
                'width' => '10%',
                'name' => 'type',
            ),
            'aos_product_category_name' => array(
                'type' => 'relate',
                'studio' => 'visible',
                'label' => 'LBL_AOS_PRODUCT_CATEGORYS_NAME',
                'link' => true,
                'width' => '10%',
                'default' => true,
                'id' => 'AOS_PRODUCT_CATEGORY_ID',
                'name' => 'aos_product_category_name',
            ),
            'contact' => array(
                'type' => 'relate',
                'studio' => 'visible',
                'label' => 'LBL_CONTACT',
                'link' => true,
                'width' => '10%',
                'default' => true,
                'id' => 'CONTACT_ID',
                'name' => 'contact',
            ),
            'currency_id' => array(
                'type' => 'id',
                'studio' => 'visible',
                'label' => 'LBL_CURRENCY',
                'width' => '10%',
                'default' => true,
                'name' => 'currency_id',
            ),
            'cost' => array(
                'name' => 'cost',
                'default' => true,
                'width' => '10%',
            ),
            'price' => array(
                'name' => 'price',
                'default' => true,
                'width' => '10%',
            ),
            'assigned_user_name' => array(
                'link' => true,
                'type' => 'relate',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'width' => '10%',
                'default' => true,
                'id' => 'ASSIGNED_USER_ID',
                'name' => 'assigned_user_name',
            ),
            'description' => array(
                'type' => 'text',
                'label' => 'LBL_DESCRIPTION',
                'sortable' => false,
                'width' => '10%',
                'default' => true,
                'name' => 'description',
            ),
            'url' => array(
                'type' => 'varchar',
                'label' => 'LBL_URL',
                'width' => '10%',
                'default' => true,
                'name' => 'url',
            ),
            'created_by' => array(
                'name' => 'created_by',
                'label' => 'LBL_CREATED',
                'type' => 'enum',
                'function' => array(
                    'name' => 'get_user_array',
                    'params' => array(
                        0 => false,
                    ),
                ),
                'default' => true,
                'width' => '10%',
            ),
            'date_entered' => array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_ENTERED',
                'width' => '10%',
                'default' => true,
                'name' => 'date_entered',
            ),
            'modified_user_id' => array(
                'type' => 'assigned_user_name',
                'label' => 'LBL_MODIFIED',
                'width' => '10%',
                'default' => true,
                'name' => 'modified_user_id',
            ),
            'date_modified' => array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_MODIFIED',
                'width' => '10%',
                'default' => true,
                'name' => 'date_modified',
            ),
            'current_user_only' => array(
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
                'name' => 'current_user_only',
            ),
            'favorites_only' => array(
                'label' => 'LBL_FAVORITES_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
                'name' => 'favorites_only',
            ),
        ),
    ),
    'templateMeta' => array(
        'maxColumns' => '3',
        'widths' => array(
            'label' => '10',
            'field' => '30',
        ),
    ),
);
// STIC-Custom