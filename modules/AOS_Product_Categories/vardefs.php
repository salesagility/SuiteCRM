<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

$dictionary['AOS_Product_Categories'] = array(
    'table' => 'aos_product_categories',
    'audited' => true,
    'duplicate_merge' => true,
    'fields' => array(
        'is_parent' =>
            array(
                'required' => false,
                'name' => 'is_parent',
                'vname' => 'LBL_IS_PARENT',
                'type' => 'bool',
                'massupdate' => '0',
                'default' => '0',
                'no_default' => false,
                'comments' => '',
                'help' => '',
                'importable' => 'true',
                'duplicate_merge' => 'disabled',
                'duplicate_merge_dom_value' => '0',
                'audited' => false,
                'reportable' => true,
                'unified_search' => false,
                'merge_filter' => 'disabled',
                'id' => 'AOS_Product_Categoriesis_parent',
            ),
        "aos_products" => array(
            'name' => 'aos_products',
            'type' => 'link',
            'source' => 'non-db',
            'relationship' => 'product_categories',
            'side' => 'right',
            'vname' => 'LBL_AOS_PRODUCT_CATEGORIES_AOS_PRODUCTS_FROM_AOS_PRODUCTS_TITLE',
        ),

        "sub_categories" => array(
            'name' => 'sub_categories',
            'type' => 'link',
            'source' => 'non-db',
            'relationship' => 'sub_product_categories',
            'vname' => 'LBL_SUB_CATEGORIES',
            'id_name' => 'parent_category_id',
        ),
        'parent_category' =>
            array(
                'name' => 'parent_category',
                'type' => 'link',
                'relationship' => 'sub_product_categories',
                'module' => 'AOS_Product_Categories',
                'bean_name' => 'AOS_Product_Categories',
                'link_type' => 'one',
                'source' => 'non-db',
                'vname' => 'LBL_PARENT_CATEGORY',
                'side' => 'right',
            ),
        "parent_category_name" => array(
            'name' => 'parent_category_name',
            'type' => 'relate',
            'source' => 'non-db',
            'vname' => 'LBL_PRODUCT_CATEGORYS_NAME',
            'save' => true,
            'id_name' => 'parent_category_id',
            'link' => 'parent_category',
            'table' => 'aos_product_categories',
            'module' => 'AOS_Product_Categories',
            'rname' => 'name',
        ),
        "parent_category_id" => array(
            'name' => 'parent_category_id',
            'type' => 'id',
            'reportable' => false,
            'vname' => 'LBL_PARENT_CATEGORY_ID',
        ),

    ),
    'relationships' => array(
        "sub_product_categories" => array(
            'lhs_module' => 'AOS_Product_Categories',
            'lhs_table' => 'aos_product_categories',
            'lhs_key' => 'id',
            'rhs_module' => 'AOS_Product_Categories',
            'rhs_table' => 'aos_product_categories',
            'rhs_key' => 'parent_category_id',
            'relationship_type' => 'one-to-many',
        ),
        "products" => array(
            'lhs_module' => 'AOS_Product_Categories',
            'lhs_table' => 'aos_product_categories',
            'lhs_key' => 'id',
            'rhs_module' => 'AOS_Product',
            'rhs_table' => 'aos_product',
            'rhs_key' => 'aos_product_category_id',
            'relationship_type' => 'one-to-many',
        ),

    ),
    'optimistic_locking' => true,
    'unified_search' => true,
);
if (!class_exists('VardefManager')) {
    require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('AOS_Product_Categories', 'AOS_Product_Categories', array('basic', 'assignable', 'security_groups'));
