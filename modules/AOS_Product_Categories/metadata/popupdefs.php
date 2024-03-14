<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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

$module_name = 'AOS_Product_Categories';
$object_name = 'AOS_Product_Categories';
$_module_name = 'aos_product_categories';

// STIC-Custom - MHP - 20240201 - Override the core metadata files with the custom metadata files 
// https://github.com/SinergiaTIC/SinergiaCRM/pull/105
// $popupMeta = array('moduleMain' => $module_name,
//                         'varName' => $object_name,
//                         'orderBy' => $_module_name.'.name',
//                         'whereClauses' =>
//                             array('name' => $_module_name . '.name',
//                                 ),
//                             'searchInputs'=> array($_module_name. '_number', 'name', 'priority','status'),           
//                         );

$popupMeta = array(
    'moduleMain' => 'AOS_Product_Categories',
    'varName' => 'AOS_Product_Categories',
    'orderBy' => 'aos_product_categories.name',
    'whereClauses' => array(
        'name' => 'aos_product_categories.name',
    ),
    'searchInputs' => array(
        0 => 'aos_product_categories_number',
        1 => 'name',
        2 => 'priority',
        3 => 'status',
    ),
    'listviewdefs' => array(
        'NAME' => array(
            'width' => '32%',
            'label' => 'LBL_NAME',
            'default' => true,
            'link' => true,
            'name' => 'name',
        ),
        'IS_PARENT' => array(
            'type' => 'bool',
            'default' => true,
            'label' => 'LBL_IS_PARENT',
            'width' => '10%',
            'name' => 'is_parent',
        ),
        'PARENT_CATEGORY_NAME' => array(
            'type' => 'relate',
            'link' => true,
            'label' => 'LBL_PRODUCT_CATEGORYS_NAME',
            'id' => 'PARENT_CATEGORY_ID',
            'width' => '10%',
            'default' => true,
            'name' => 'parent_category_name',
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
// END STIC-Custom