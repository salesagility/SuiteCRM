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
