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

// STIC-Custom - MHP - 20240201 - Override the core metadata files with the custom metadata files 
// https://github.com/SinergiaTIC/SinergiaCRM/pull/105
// $popupMeta = array(
//     'moduleMain' => 'AOS_Products',
//     'varName' => 'AOS_Products',
//     'orderBy' => 'aos_products.name',
//     'whereClauses' => array(
//   'name' => 'aos_products.name',
//   'part_number' => 'aos_products.part_number',
//   'cost' => 'aos_products.cost',
//   'price' => 'aos_products.price',
//   'created_by' => 'aos_products.created_by',
// ),
//     'searchInputs' => array(
//   1 => 'name',
//   4 => 'part_number',
//   5 => 'cost',
//   6 => 'price',
//   7 => 'created_by',
// ),
//     'searchdefs' => array(
//   'name' =>
//   array(
//     'name' => 'name',
//     'width' => '10%',
//   ),
//   'part_number' =>
//   array(
//     'name' => 'part_number',
//     'width' => '10%',
//   ),
//   'cost' =>
//   array(
//     'name' => 'cost',
//     'width' => '10%',
//   ),
//   'price' =>
//   array(
//     'name' => 'price',
//     'width' => '10%',
//   ),
//   'created_by' =>
//   array(
//     'name' => 'created_by',
//     'label' => 'LBL_CREATED',
//     'type' => 'enum',
//     'function' =>
//     array(
//       'name' => 'get_user_array',
//       'params' =>
//       array(
//         0 => false,
//       ),
//     ),
//     'width' => '10%',
//   ),
// ),
//     'listviewdefs' => array(
//   'NAME' =>
//   array(
//     'width' => '25%',
//     'label' => 'LBL_NAME',
//     'default' => true,
//     'link' => true,
//     'name' => 'name',
//   ),
//   'PART_NUMBER' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_PART_NUMBER',
//     'default' => true,
//     'name' => 'part_number',
//   ),
//   'COST' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_COST',
//     'default' => true,
//     'name' => 'cost',
//   ),
//   'PRICE' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_PRICE',
//     'default' => true,
//     'name' => 'price',
//   ),
//   'CURRENCY_ID' =>
//   array(
//     'type' => 'id',
//     'studio' => 'visible',
//     'label' => 'LBL_CURRENCY',
//     'width' => '10%',
//     'default' => false,
//     'name' => 'currency_id',
//   ),
// ),
// );

$popupMeta = array(
  'moduleMain' => 'AOS_Products',
  'varName' => 'AOS_Products',
  'orderBy' => 'aos_products.name',
  'whereClauses' => array(
      'name' => 'aos_products.name',
      'part_number' => 'aos_products.part_number',
      'cost' => 'aos_products.cost',
      'price' => 'aos_products.price',
      'created_by' => 'aos_products.created_by',
      'maincode' => 'aos_products.maincode',
      'type' => 'aos_products.type',
      'category' => 'aos_products.category',
      'assigned_user_name' => 'aos_products.assigned_user_name',
  ),
  'searchInputs' => array(
      1 => 'name',
      4 => 'part_number',
      5 => 'cost',
      6 => 'price',
      7 => 'created_by',
      8 => 'maincode',
      9 => 'type',
      10 => 'category',
      11 => 'assigned_user_name',
  ),
  'searchdefs' => array(
      'name' => array(
          'name' => 'name',
          'width' => '10%',
      ),
      'maincode' => array(
          'type' => 'enum',
          'studio' => 'visible',
          'label' => 'LBL_MAINCODE',
          'width' => '10%',
          'name' => 'maincode',
      ),
      'part_number' => array(
          'name' => 'part_number',
          'width' => '10%',
      ),
      'type' => array(
          'type' => 'enum',
          'studio' => 'visible',
          'label' => 'LBL_TYPE',
          'width' => '10%',
          'name' => 'type',
      ),
      'category' => array(
          'type' => 'enum',
          'studio' => 'visible',
          'label' => 'LBL_CATEGORY',
          'width' => '10%',
          'name' => 'category',
      ),
      'cost' => array(
          'name' => 'cost',
          'width' => '10%',
      ),
      'price' => array(
          'name' => 'price',
          'width' => '10%',
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
          'width' => '10%',
      ),
      'assigned_user_name' => array(
          'link' => true,
          'type' => 'relate',
          'label' => 'LBL_ASSIGNED_TO_NAME',
          'id' => 'ASSIGNED_USER_ID',
          'width' => '10%',
          'name' => 'assigned_user_name',
      ),
  ),
  'listviewdefs' => array(
      'NAME' => array(
          'width' => '25%',
          'label' => 'LBL_NAME',
          'default' => true,
          'link' => true,
          'name' => 'name',
      ),
      'MAINCODE' => array(
          'type' => 'enum',
          'default' => true,
          'studio' => 'visible',
          'label' => 'LBL_MAINCODE',
          'width' => '10%',
      ),
      'PART_NUMBER' => array(
          'width' => '10%',
          'label' => 'LBL_PART_NUMBER',
          'default' => true,
          'name' => 'part_number',
      ),
      'TYPE' => array(
          'type' => 'enum',
          'default' => true,
          'studio' => 'visible',
          'label' => 'LBL_TYPE',
          'width' => '10%',
      ),
      'CATEGORY' => array(
          'type' => 'enum',
          'studio' => 'visible',
          'label' => 'LBL_CATEGORY',
          'width' => '10%',
          'default' => true,
      ),
      'COST' => array(
          'width' => '10%',
          'label' => 'LBL_COST',
          'default' => true,
          'name' => 'cost',
      ),
      'PRICE' => array(
          'width' => '10%',
          'label' => 'LBL_PRICE',
          'default' => true,
          'name' => 'price',
      ),
      'ASSIGNED_USER_NAME' => array(
          'link' => true,
          'type' => 'relate',
          'label' => 'LBL_ASSIGNED_TO_NAME',
          'id' => 'ASSIGNED_USER_ID',
          'width' => '10%',
          'default' => true,
      ),
  ),
);
// STIC-Custom