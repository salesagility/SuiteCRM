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
$module_name = 'stic_Security_Groups_Rules';
$listViewDefs[$module_name] =
array(
    'NAME' => array(
        'width' => '32%',
        'label' => 'LBL_NAME',
        'default' => false,
        'link' => true,
        'type' => 'readonly',
    ),
    'NAME_LABEL' => array(
        'width' => '32%',
        'label' => 'LBL_NAME_LABEL',
        'default' => true,
        'link' => true,

    ),
    'ACTIVE' => array(
        'type' => 'bool',
        'align' => 'center',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_ACTIVE',
        'width' => '10%',
    ),
    'INHERIT_ASSIGNED' => array(
        'type' => 'bool',
        'align' => 'center',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_INHERIT_ASSIGNED',
        'width' => '10%',
    ),
    'INHERIT_CREATOR' => array(
        'type' => 'bool',
        'align' => 'center',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_INHERIT_CREATOR',
        'width' => '10%',
    ),
    'INHERIT_PARENT' => array(
        'type' => 'bool',
        'align' => 'center',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_INHERIT_PARENT',
        'width' => '10%',
    ),
    'INHERIT_FROM_MODULES' => array(
        'type' => 'multienum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_INHERIT_FROM_MODULES',
        'width' => '10%',
    ),
    'NON_INHERIT_FROM_SECURITY_GROUPS' => array(
        'type' => 'multienum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_NON_INHERIT_FROM_SECURITY_GROUPS',
        'width' => '10%',
    ),
    // 'CREATED_BY_NAME' => array(
    //     'type' => 'relate',
    //     'link' => true,
    //     'label' => 'LBL_CREATED',
    //     'id' => 'CREATED_BY',
    //     'width' => '10%',
    //     'default' => false,
    // ),
    // 'MODIFIED_BY_NAME' => array(
    //     'type' => 'relate',
    //     'link' => true,
    //     'label' => 'LBL_MODIFIED_NAME',
    //     'id' => 'MODIFIED_USER_ID',
    //     'width' => '10%',
    //     'default' => false,
    // ),
    // 'DATE_MODIFIED' => array(
    //     'type' => 'datetime',
    //     'label' => 'LBL_DATE_MODIFIED',
    //     'width' => '10%',
    //     'default' => true,
    // ),
    // 'DATE_ENTERED' => array(
    //     'type' => 'datetime',
    //     'label' => 'LBL_DATE_ENTERED',
    //     'width' => '10%',
    //     'default' => true,
    // ),
);
