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
$popupMeta = array(
    'moduleMain' => 'AOS_Products_Quotes',
    'varName' => 'AOS_Products_Quotes',
    'orderBy' => 'aos_products_quotes.name',
    'whereClauses' => array(
        'name' => 'aos_products_quotes.name',
        'number' => 'aos_products_quotes.number',
        'parent_name' => 'aos_products_quotes.parent_name',
        'group_name' => 'aos_products_quotes.group_name',
        'part_number' => 'aos_products_quotes.part_number',
        'product_total_price' => 'aos_products_quotes.product_total_price',
        'date_modified' => 'aos_products_quotes.date_modified',
        'modified_by_name' => 'aos_products_quotes.modified_by_name',
        'created_by_name' => 'aos_products_quotes.created_by_name',
        'date_entered' => 'aos_products_quotes.date_entered',
    ),
    'searchInputs' => array(
        1 => 'name',
        4 => 'number',
        5 => 'parent_name',
        6 => 'group_name',
        7 => 'part_number',
        8 => 'product_total_price',
        9 => 'date_modified',
        10 => 'modified_by_name',
        11 => 'created_by_name',
        12 => 'date_entered',
    ),
    'searchdefs' => array(
        'name' => array(
            'type' => 'text',
            'link' => true,
            'label' => 'LBL_NAME',
            'sortable' => false,
            'width' => '10%',
            'name' => 'name',
        ),
        'number' => array(
            'type' => 'int',
            'label' => 'LBL_LIST_NUM',
            'width' => '10%',
            'name' => 'number',
        ),
        'parent_name' => array(
            'type' => 'parent',
            'studio' => 'visible',
            'label' => 'LBL_FLEX_RELATE',
            'link' => true,
            'sortable' => false,
            'ACLTag' => 'PARENT',
            'dynamic_module' => 'PARENT_TYPE',
            'id' => 'PARENT_ID',
            'related_fields' => array(
                0 => 'parent_id',
                1 => 'parent_type',
            ),
            'width' => '10%',
            'name' => 'parent_name',
        ),
        'group_name' => array(
            'type' => 'relate',
            'label' => 'LBL_GROUP_NAME',
            'id' => 'GROUP_ID',
            'link' => true,
            'width' => '10%',
            'name' => 'group_name',
        ),
        'part_number' => array(
            'type' => 'varchar',
            'label' => 'LBL_PART_NUMBER',
            'width' => '10%',
            'name' => 'part_number',
        ),
        'product_total_price' => array(
            'type' => 'currency',
            'label' => 'LBL_PRODUCT_TOTAL_PRICE',
            'currency_format' => true,
            'width' => '10%',
            'name' => 'product_total_price',
        ),
        'date_modified' => array(
            'type' => 'datetime',
            'label' => 'LBL_DATE_MODIFIED',
            'width' => '10%',
            'name' => 'date_modified',
        ),
        'modified_by_name' => array(
            'type' => 'relate',
            'link' => true,
            'label' => 'LBL_MODIFIED_NAME',
            'id' => 'MODIFIED_USER_ID',
            'width' => '10%',
            'name' => 'modified_by_name',
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
    ),
    'listviewdefs' => array(
        'NAME' => array(
            'width' => '32%',
            'label' => 'LBL_NAME',
            'default' => true,
            'link' => true,
            'name' => 'name',
        ),
        'PRODUCT_QTY' => array(
            'type' => 'decimal',
            'label' => 'LBL_PRODUCT_QTY',
            'width' => '10%',
            'default' => true,
            'name' => 'product_qty',
        ),
        'GROUP_NAME' => array(
            'type' => 'relate',
            'label' => 'LBL_GROUP_NAME',
            'id' => 'GROUP_ID',
            'link' => true,
            'width' => '10%',
            'default' => true,
            'name' => 'group_name',
        ),
        'PARENT_NAME' => array(
            'type' => 'parent',
            'studio' => 'visible',
            'label' => 'LBL_FLEX_RELATE',
            'link' => true,
            'sortable' => false,
            'ACLTag' => 'PARENT',
            'dynamic_module' => 'PARENT_TYPE',
            'id' => 'PARENT_ID',
            'related_fields' => array(
                0 => 'parent_id',
                1 => 'parent_type',
            ),
            'width' => '10%',
            'default' => true,
            'name' => 'parent_name',
        ),
        'PRODUCT_TOTAL_PRICE' => array(
            'type' => 'currency',
            'label' => 'LBL_PRODUCT_TOTAL_PRICE',
            'currency_format' => true,
            'width' => '10%',
            'default' => true,
            'name' => 'product_total_price',
        ),
        'ASSIGNED_USER_NAME' => array(
            'width' => '9%',
            'label' => 'LBL_ASSIGNED_TO_NAME',
            'default' => true,
            'name' => 'assigned_user_name',
        ),
    ),
);
// END STIC-Custom