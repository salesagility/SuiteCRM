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
$dashletData['stic_AssessmentsDashlet']['searchFields'] = array(
    'name' => array(
        'default' => '',
    ),
    'stic_assessments_contacts_name' => array(
        'default' => '',
    ),
    'status' => array(
        'default' => '',
    ),
    'assessment_date' => array(
        'default' => '',
    ),
    'moment' => array(
        'default' => '',
    ),
    'scope' => array(
        'default' => '',
    ),
    'areas' => array(
        'default' => '',
    ),

);
$dashletData['stic_AssessmentsDashlet']['columns'] = array(
    'name' => array(
        'width' => '40%',
        'label' => 'LBL_LIST_NAME',
        'link' => true,
        'default' => true,
        'name' => 'name',
    ),
    'stic_assessments_contacts_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_ASSESSMENTS_CONTACTS_FROM_CONTACTS_TITLE',
        'id' => 'STIC_ASSESSMENTS_CONTACTSCONTACTS_IDA',
        'width' => '10%',
        'default' => true,
        'name' => 'stic_assessments_contacts_name',
    ),
    'status' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_STATUS',
        'width' => '10%',
        'default' => true,
        'name' => 'status',
    ),
    'moment' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_MOMENT',
        'width' => '10%',
        'default' => true,
        'name' => 'moment',
    ),
    'assessment_date' => array(
        'type' => 'date',
        'label' => 'LBL_ASSESSMENT_DATE',
        'width' => '10%',
        'default' => true,
        'name' => 'assess_date',
    ),
    'next_date' => array(
        'type' => 'date',
        'label' => 'LBL_NEXT_DATE',
        'width' => '10%',
        'default' => true,
        'name' => 'next_date',
    ),
    'scope' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_SCOPE',
        'width' => '10%',
        'default' => false,
        'name' => 'scope',
    ),
    'date_modified' => array(
        'width' => '15%',
        'label' => 'LBL_DATE_MODIFIED',
        'name' => 'date_modified',
        'default' => false,
    ),
    'created_by' => array(
        'width' => '8%',
        'label' => 'LBL_CREATED',
        'name' => 'created_by',
        'default' => false,
    ),
    'date_entered' => array(
        'width' => '15%',
        'label' => 'LBL_DATE_ENTERED',
        'default' => false,
        'name' => 'date_entered',
    ),
    'description' => array(
        'type' => 'text',
        'label' => 'LBL_DESCRIPTION',
        'sortable' => false,
        'width' => '10%',
        'default' => false,
        'name' => 'description',
    ),
    'conclusions' => array(
        'type' => 'text',
        'studio' => 'visible',
        'label' => 'LBL_CONCLUSIONS',
        'sortable' => false,
        'width' => '10%',
        'default' => false,
        'name' => 'conclusions',
    ),
    'recommendations' => array(
        'type' => 'multienum',
        'default' => false,
        'studio' => 'visible',
        'label' => 'LBL_RECOMMENDATIONS',
        'width' => '10%',
        'name' => 'recommendations',
    ),
    'working_with' => array(
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_WORKING_WITH',
        'id' => 'ACCOUNT_ID_C',
        'link' => true,
        'width' => '10%',
        'default' => false,
        'name' => 'coord_work',
    ),
    'areas' => array(
        'type' => 'multienum',
        'default' => false,
        'studio' => 'visible',
        'label' => 'LBL_AREAS',
        'width' => '10%',
        'name' => 'ambits',
    ),
    'derivation' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_DERIVATION',
        'width' => '10%',
        'default' => false,
        'name' => 'derivation',
    ),
    'assigned_user_name' => array(
        'width' => '8%',
        'label' => 'LBL_LIST_ASSIGNED_USER',
        'name' => 'assigned_user_name',
        'default' => false,
    ),
);
