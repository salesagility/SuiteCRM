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

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$module_name = 'stic_Assessments';
$listViewDefs[$module_name] =
array(
    'NAME' => array(
        'width' => '32%',
        'label' => 'LBL_NAME',
        'default' => true,
        'link' => true,
    ),
    'STIC_ASSESSMENTS_CONTACTS_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_ASSESSMENTS_CONTACTS_FROM_CONTACTS_TITLE',
        'id' => 'STIC_ASSESSMENTS_CONTACTSCONTACTS_IDA',
        'width' => '10%',
        'default' => true,
    ),
    'STATUS' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_STATUS',
        'width' => '10%',
        'default' => true,
    ),
    'MOMENT' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_MOMENT',
        'width' => '10%',
        'default' => true,
    ),
    'SCOPE' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_SCOPE',
        'width' => '10%',
        'default' => false,
    ),
    'ASSESSMENT_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_ASSESSMENT_DATE',
        'width' => '10%',
        'default' => true,
    ),
    'NEXT_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_NEXT_DATE',
        'width' => '10%',
        'default' => true,
    ),
    'AREAS' => array(
        'type' => 'multienum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_AREAS',
        'width' => '10%',
    ),
    'ASSIGNED_USER_NAME' => array(
        'width' => '9%',
        'label' => 'LBL_ASSIGNED_TO_NAME',
        'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => true,
    ),
    'DATE_MODIFIED' => array(
        'type' => 'datetime',
        'label' => 'LBL_DATE_MODIFIED',
        'width' => '10%',
        'default' => false,
    ),
    'DERIVATION' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_DERIVATION',
        'width' => '10%',
        'default' => false,
    ),
    'WORKING_WITH' => array(
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_WORKING_WITH',
        'id' => 'ACCOUNT_ID_C',
        'link' => true,
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
    'RECOMMENDATIONS' => array(
        'type' => 'multienum',
        'default' => false,
        'studio' => 'visible',
        'label' => 'LBL_RECOMMENDATIONS',
        'width' => '10%',
    ),
    'CONCLUSIONS' => array(
        'type' => 'text',
        'studio' => 'visible',
        'label' => 'LBL_CONCLUSIONS',
        'sortable' => false,
        'width' => '10%',
        'default' => false,
    ),
    'MODIFIED_BY_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_MODIFIED_NAME',
        'id' => 'MODIFIED_USER_ID',
        'width' => '10%',
        'default' => false,
    ),
    'DESCRIPTION' => array(
        'type' => 'text',
        'studio' => 'visible',
        'label' => 'LBL_DESCRIPTION',
        'sortable' => false,
        'width' => '10%',
        'default' => false,
    ),
    'DATE_ENTERED' => array(
        'type' => 'datetime',
        'label' => 'LBL_DATE_ENTERED',
        'width' => '10%',
        'default' => false,
    ),
);
