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
$module_name = 'stic_Job_Offers';
$listViewDefs[$module_name] =
array(
    'NAME' => array(
        'width' => '32%',
        'label' => 'LBL_NAME',
        'default' => true,
        'link' => true,
    ),
    'OFFER_CODE' => array(
        'type' => 'varchar',
        'label' => 'LBL_OFFER_CODE',
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
    'TYPE' => array(
        'type' => 'multienum',
        'studio' => 'visible',
        'label' => 'LBL_TYPE',
        'width' => '10%',
        'default' => true,
    ),
    'STIC_JOB_OFFERS_ACCOUNTS_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_JOB_OFFERS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
        'id' => 'STIC_JOB_OFFERS_ACCOUNTSACCOUNTS_IDA',
        'width' => '10%',
        'default' => true,
    ),
    'PROFESSIONAL_PROFILE' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_PROFESSIONAL_PROFILE',
        'width' => '10%',
        'default' => true,
    ),
    'PROCESS_END_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_PROCESS_END_DATE',
        'width' => '10%',
        'default' => true,
    ),
    'ASSIGNED_USER_NAME' => array(
        'width' => '9%',
        'label' => 'LBL_ASSIGNED_TO_NAME',
        'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => true,
    ),
    'PROCESS_START_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_PROCESS_START_DATE',
        'width' => '10%',
        'default' => false,
    ),
    'OFFERED_POSITIONS' => array(
        'type' => 'int',
        'label' => 'LBL_OFFERED_POSITIONS',
        'width' => '10%',
        'default' => false,
    ),
    'APPLICATIONS_START_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_APPLICATIONS_START_DATE',
        'width' => '10%',
        'default' => false,
    ),
    'APPLICATIONS_END_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_APPLICATIONS_END_DATE',
        'width' => '10%',
        'default' => false,
    ),
    'OFFER_ORIGIN' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_OFFER_ORIGIN',
        'width' => '10%',
        'default' => false,
    ),
    'INTERLOCUTOR' => array(
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_INTERLOCUTOR',
        'id' => 'CONTACT_ID_C',
        'link' => true,
        'width' => '10%',
        'default' => false,
    ),
    'CONTRACT_DURATION_DETAILS' => array(
        'type' => 'text',
        'studio' => 'visible',
        'label' => 'LBL_CONTRACT_DURATION_DETAILS',
        'sortable' => false,
        'width' => '10%',
        'default' => false,
    ),
    'HOURS_PER_WEEK' => array(
        'type' => 'decimal',
        'label' => 'LBL_HOURS_PER_WEEK',
        'width' => '10%',
        'default' => false,
    ),
    'CONTRACT_DESCRIPTION' => array(
        'type' => 'text',
        'studio' => 'visible',
        'label' => 'LBL_CONTRACT_DESCRIPTION',
        'sortable' => false,
        'width' => '10%',
        'default' => false,
    ),
    'RETRIBUTION' => array(
        'type' => 'decimal',
        'label' => 'LBL_RETRIBUTION',
        'width' => '10%',
        'default' => false,
    ),
    'RETRIBUTION_CONDITIONS' => array(
        'type' => 'text',
        'studio' => 'visible',
        'label' => 'LBL_RETRIBUTION_CONDITIONS',
        'sortable' => false,
        'width' => '10%',
        'default' => false,
    ),
    'JOB_REQUIREMENTS' => array(
        'type' => 'text',
        'studio' => 'visible',
        'label' => 'LBL_JOB_REQUIREMENTS',
        'sortable' => false,
        'width' => '10%',
        'default' => false,
    ),
    'SEPE_CONTRACT_TYPE' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_SEPE_CONTRACT_TYPE',
        'width' => '10%',
        'default' => false,
    ),
    'SEPE_ACTIVATION_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_SEPE_ACTIVATION_DATE',
        'width' => '10%',
        'default' => false,
    ),
    'SEPE_COVERED_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_SEPE_COVERED_DATE',
        'width' => '10%',
        'default' => false,
    ),
    'INC_ID' => array(
        'type' => 'varchar',
        'label' => 'LBL_INC_ID',
        'width' => '10%',
        'default' => false,
    ),
    'INC_INCORPORA_RECORD' => array(
        'type' => 'bool',
        'label' => 'LBL_INC_INCORPORA_RECORD',
        'width' => '10%',
        'default' => false,
    ),
    'INC_STATUS' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_INC_STATUS',
        'width' => '10%',
        'default' => false,
    ),
    'INC_CHECKIN_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_INC_CHECKIN_DATE',
        'width' => '10%',
        'default' => false,
    ),
    'INC_OFFER_ORIGIN' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_INC_OFFER_ORIGIN',
        'width' => '10%',
        'default' => false,
    ),
    'INC_REGISTER_START_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_INC_REGISTER_START_DATE',
        'width' => '10%',
        'default' => false,
    ),
    'INC_REGISTER_END_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_INC_REGISTER_END_DATE',
        'width' => '10%',
        'default' => false,
    ),
    'INC_CONTRACT_START_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_INC_CONTRACT_START_DATE',
        'width' => '10%',
        'default' => false,
    ),
    'INC_COLLECTIVE_REQUIREMENTS' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_INC_COLLECTIVE_REQUIREMENTS',
        'width' => '10%',
        'default' => false,
    ),
    'INC_CONTRACT_TYPE' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_INC_CONTRACT_TYPE',
        'width' => '10%',
        'default' => false,
    ),
    'INC_CONTRACT_DURATION' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_INC_CONTRACT_DURATION',
        'width' => '10%',
        'default' => false,
    ),
    'INC_REMUNERATION' => array(
        'type' => 'float',
        'label' => 'LBL_INC_REMUNERATION',
        'width' => '10%',
        'default' => false,
    ),
    'INC_TASKS_RESPONSABILITIES' => array(
        'type' => 'text',
        'studio' => 'visible',
        'label' => 'LBL_INC_TASKS_RESPONSABILITIES',
        'sortable' => false,
        'width' => '10%',
        'default' => false,
    ),
    'INC_WORKING_DAY' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_INC_WORKING_DAY',
        'width' => '10%',
        'default' => false,
    ),
    'INC_CNO_N1' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_INC_CNO_N1',
        'width' => '10%',
        'default' => false,
    ),
    'INC_CNO_N2' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_INC_CNO_N2',
        'width' => '10%',
        'default' => false,
    ),
    'INC_CNO_N3' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_INC_CNO_N3',
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
    'INC_TOWN' => array(
        'type' => 'varchar',
        'studio' => array(
            'no_duplicate' => true,
            'editview' => false,
            'quickcreate' => false,
        ),
        'label' => 'LBL_INC_TOWN',
        'width' => '10%',
        'default' => false,
    ),
    'INC_MUNICIPALITY' => array(
        'type' => 'varchar',
        'studio' => array(
            'no_duplicate' => true,
            'editview' => false,
            'quickcreate' => false,
        ),
        'label' => 'LBL_INC_MUNICIPALITY',
        'width' => '10%',
        'default' => false,
    ),
    'INC_STATE' => array(
        'type' => 'varchar',
        'studio' => array(
            'no_duplicate' => true,
            'editview' => false,
            'quickcreate' => false,
        ),
        'label' => 'LBL_INC_STATE',
        'width' => '10%',
        'default' => false,
    ),
    'INC_COUNTRY' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_INC_COUNTRY',
        'width' => '10%',
        'default' => false,
    ),
    'INC_LOCATION' => array(
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_INC_LOCATION',
        'id' => 'STIC_INCORPORA_LOCATIONS_ID',
        'link' => true,
        'width' => '10%',
        'default' => false,
    ),
    'INC_REFERENCE_GROUP' => array(
        'type' => 'enum',
        'studio' => array(
            'no_duplicate' => true,
            'editview' => false,
            'quickcreate' => false,
        ),
        'label' => 'LBL_INC_REFERENCE_GROUP',
        'width' => '10%',
        'default' => false,
    ),
    'INC_REFERENCE_ENTITY' => array(
        'type' => 'enum',
        'studio' => array(
            'no_duplicate' => true,
            'editview' => false,
            'quickcreate' => false,
        ),
        'label' => 'LBL_INC_REFERENCE_ENTITY',
        'width' => '10%',
        'default' => false,
    ),
    'INC_REFERENCE_OFFICER' => array(
        'type' => 'int',
        'studio' => array(
            'no_duplicate' => true,
            'editview' => false,
            'quickcreate' => false,
        ),
        'label' => 'LBL_INC_REFERENCE_OFFICER',
        'width' => '10%',
        'default' => false,
    ),
    'INC_SYNCHRONIZATION_ERRORS' => array(
        'type' => 'bool',
        'studio' => array(
            'no_duplicate' => true,
            'editview' => false,
            'quickcreate' => false,
        ),
        'label' => 'LBL_INC_SYNCHRONIZATION_ERRORS',
        'width' => '10%',
        'default' => false,
    ),
    'INC_SYNCHRONIZATION_LOG' => array(
        'type' => 'text',
        'studio' => array(
            'no_duplicate' => true,
            'editview' => false,
            'quickcreate' => false,
        ),
        'label' => 'LBL_INC_SYNCHRONIZATION_LOG',
        'sortable' => false,
        'width' => '10%',
        'default' => false,
    ),
    'INC_SYNCHRONIZATION_DATE' => array(
        'type' => 'datetimecombo',
        'studio' => array(
            'no_duplicate' => true,
            'editview' => false,
            'quickcreate' => false,
        ),
        'label' => 'LBL_INC_SYNCHRONIZATION_DATE',
        'width' => '10%',
        'default' => false,
    ),
    'INC_OBSERVATIONS' => array(
        'type' => 'text',
        'studio' => 'visible',
        'label' => 'LBL_INC_OBSERVATIONS',
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
    'DATE_MODIFIED' => array(
        'type' => 'datetime',
        'label' => 'LBL_DATE_MODIFIED',
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
    'CREATED_BY_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_CREATED',
        'id' => 'CREATED_BY',
        'width' => '10%',
        'default' => false,
    ),
);
