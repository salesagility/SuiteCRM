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
