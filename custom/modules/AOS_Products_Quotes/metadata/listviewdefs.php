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
$module_name = 'AOS_Products_Quotes';
$listViewDefs[$module_name] =
array(
    'NAME' => array(
        'width' => '32%',
        'label' => 'LBL_NAME',
        'default' => true,
        'link' => true,
    ),
    'PRODUCT_QTY' => array(
        'type' => 'decimal',
        'label' => 'LBL_PRODUCT_QTY',
        'width' => '10%',
        'default' => true,
    ),
    'GROUP_NAME' => array(
        'type' => 'relate',
        'label' => 'LBL_GROUP_NAME',
        'id' => 'GROUP_ID',
        'link' => true,
        'width' => '10%',
        'default' => true,
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
    ),
    'PRODUCT_TOTAL_PRICE' => array(
        'type' => 'currency',
        'label' => 'LBL_PRODUCT_TOTAL_PRICE',
        'currency_format' => true,
        'width' => '10%',
        'default' => true,
    ),
    'ASSIGNED_USER_NAME' => array(
        'width' => '9%',
        'label' => 'LBL_ASSIGNED_TO_NAME',
        'default' => true,
    ),
    'NUMBER' => array(
        'type' => 'int',
        'label' => 'LBL_LIST_NUM',
        'width' => '10%',
        'default' => false,
    ),
    'PART_NUMBER' => array(
        'type' => 'varchar',
        'default' => false,
        'label' => 'LBL_PART_NUMBER',
        'width' => '10%',
    ),
    'PRODUCT_COST_PRICE' => array(
        'width' => '10%',
        'label' => 'LBL_PRODUCT_COST_PRICE',
        'default' => false,
    ),
    'PRODUCT_LIST_PRICE' => array(
        'type' => 'currency',
        'label' => 'LBL_PRODUCT_LIST_PRICE',
        'currency_format' => true,
        'width' => '10%',
        'default' => false,
    ),
    'PRODUCT_UNIT_PRICE' => array(
        'type' => 'currency',
        'label' => 'LBL_PRODUCT_UNIT_PRICE',
        'currency_format' => true,
        'width' => '10%',
        'default' => false,
    ),
    'DISCOUNT' => array(
        'type' => 'enum',
        'default' => false,
        'studio' => 'visible',
        'label' => 'LBL_DISCOUNT',
        'width' => '10%',
    ),
    'PRODUCT_DISCOUNT_AMOUNT' => array(
        'type' => 'currency',
        'label' => 'LBL_PRODUCT_DISCOUNT_AMOUNT',
        'currency_format' => true,
        'width' => '10%',
        'default' => false,
    ),
    'PRODUCT_DISCOUNT' => array(
        'type' => 'currency',
        'label' => 'LBL_PRODUCT_DISCOUNT',
        'currency_format' => true,
        'width' => '10%',
        'default' => false,
    ),
    'VAT' => array(
        'type' => 'enum',
        'default' => false,
        'studio' => 'visible',
        'label' => 'LBL_VAT',
        'width' => '10%',
    ),
    'VAT_AMT' => array(
        'type' => 'currency',
        'label' => 'LBL_VAT_AMT',
        'currency_format' => true,
        'width' => '10%',
        'default' => false,
    ),
    'CURRENCY_ID' => array(
        'type' => 'id',
        'studio' => 'visible',
        'label' => 'LBL_CURRENCY',
        'width' => '10%',
        'default' => false,
    ),
    'ITEM_DESCRIPTION' => array(
        'type' => 'text',
        'label' => 'LBL_PRODUCT_DESCRIPTION',
        'sortable' => false,
        'width' => '10%',
        'default' => false,
    ),
    'DESCRIPTION' => array(
        'type' => 'text',
        'label' => 'LBL_DESCRIPTION',
        'sortable' => false,
        'width' => '10%',
        'default' => false,
    ),
    'CREATED_BY_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_CREATED',
        'id' => 'CREATED_BY',
        'width' => '10%',
        'default' => false,
    ),
    'DATE_ENTERED' => array(
        'type' => 'datetime',
        'label' => 'LBL_DATE_ENTERED',
        'width' => '10%',
        'default' => false,
        'align' => 'center',
    ),
    'MODIFIED_BY_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_MODIFIED_NAME',
        'id' => 'MODIFIED_USER_ID',
        'width' => '10%',
        'default' => false,
    ),
    'DATE_MODIFIED' => array(
        'type' => 'datetime',
        'label' => 'LBL_DATE_MODIFIED',
        'width' => '10%',
        'default' => false,
        'align' => 'center',
    ),
);
