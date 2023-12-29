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
$listViewDefs['AOS_Products'] =
array(
    'NAME' => array(
        'width' => '15%',
        'label' => 'LBL_NAME',
        'default' => true,
        'link' => true,
    ),
    'PART_NUMBER' => array(
        'width' => '10%',
        'label' => 'LBL_PART_NUMBER',
        'default' => true,
    ),
    'TYPE' => array(
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_TYPE',
        'width' => '10%',
    ),
    'AOS_PRODUCT_CATEGORY_NAME' => array(
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_AOS_PRODUCT_CATEGORYS_NAME',
        'id' => 'AOS_PRODUCT_CATEGORY_ID',
        'link' => true,
        'width' => '10%',
        'default' => true,
        'related_fields' => array(
            0 => 'aos_product_category_id',
        ),
    ),
    'CONTACT' => array(
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_CONTACT',
        'id' => 'CONTACT_ID',
        'link' => true,
        'width' => '10%',
        'default' => true,
    ),
    'COST' => array(
        'width' => '10%',
        'label' => 'LBL_COST',
        'currency_format' => true,
        'default' => true,
    ),
    'PRICE' => array(
        'width' => '10%',
        'label' => 'LBL_PRICE',
        'currency_format' => true,
        'default' => true,
    ),
    'ASSIGNED_USER_NAME' => array(
        'link' => true,
        'type' => 'relate',
        'label' => 'LBL_ASSIGNED_TO_NAME',
        'id' => 'ASSIGNED_USER_ID',
        'width' => '10%',
        'default' => true,
    ),
    'MODIFIED_BY_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_MODIFIED_NAME',
        'id' => 'MODIFIED_USER_ID',
        'width' => '10%',
        'default' => false,
    ),
    'URL' => array(
        'type' => 'varchar',
        'label' => 'LBL_URL',
        'width' => '10%',
        'default' => false,
    ),
    'PRICE_USDOLLAR' => array(
        'type' => 'currency',
        'studio' => array(
            'editview' => false,
            'detailview' => false,
            'quickcreate' => false,
        ),
        'label' => 'LBL_PRICE_USDOLLAR',
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
    'COST_USDOLLAR' => array(
        'type' => 'currency',
        'studio' => array(
            'editview' => false,
            'detailview' => false,
            'quickcreate' => false,
        ),
        'label' => 'LBL_COST_USDOLLAR',
        'currency_format' => true,
        'width' => '10%',
        'default' => false,
    ),
    'CATEGORY' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_CATEGORY',
        'width' => '10%',
        'default' => false,
    ),
    'MAINCODE' => array(
        'type' => 'enum',
        'default' => false,
        'studio' => 'visible',
        'label' => 'LBL_MAINCODE',
        'width' => '10%',
    ),
    'DATE_MODIFIED' => array(
        'type' => 'datetime',
        'label' => 'LBL_DATE_MODIFIED',
        'width' => '10%',
        'default' => false,
        'align' => 'center',
    ),
    'DESCRIPTION' => array(
        'type' => 'text',
        'label' => 'LBL_DESCRIPTION',
        'sortable' => false,
        'width' => '10%',
        'default' => false,
    ),
    'CREATED_BY_NAME' => array(
        'width' => '10%',
        'label' => 'LBL_CREATED',
        'default' => false,
        'module' => 'Users',
        'link' => true,
        'id' => 'CREATED_BY',
    ),
    'DATE_ENTERED' => array(
        'width' => '5%',
        'label' => 'LBL_DATE_ENTERED',
        'default' => false,
        'align' => 'center',
    ),
);
