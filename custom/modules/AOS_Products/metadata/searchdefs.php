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
$module_name = 'AOS_Products';
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
