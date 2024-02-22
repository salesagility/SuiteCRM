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
    'moduleMain' => 'stic_Journal',
    'varName' => 'stic_Journal',
    'orderBy' => 'stic_journal.name',
    'whereClauses' => array(
        'name' => 'stic_journal.name',
        'type' => 'stic_journal.type',
        'journal_date' => 'stic_journal.journal_date',
        'turn' => 'stic_journal.turn',
        'stic_journal_stic_centers_name' => 'stic_journal.stic_journal_stic_centers_name',
        'assigned_user_name' => 'stic_journal.assigned_user_name',
        'current_user_only' => 'stic_journal.current_user_only',
    ),
    'searchInputs' => array(
        1 => 'name',
        4 => 'type',
        5 => 'journal_date',
        6 => 'turn',
        7 => 'stic_journal_stic_centers_name',
        22 => 'assigned_user_name',
        24 => 'current_user_only',
    ),
    'searchdefs' => array(
        'name' => array(
            'name' => 'name',
            'width' => '10%',
        ),
        'type' => array(
            'type' => 'enum',
            'studio' => 'visible',
            'label' => 'LBL_TYPE',
            'width' => '10%',
            'name' => 'type',
        ),
        'journal_date' => array(
            'type' => 'datetimecombo',
            'label' => 'LBL_JOURNAL_DATE',
            'width' => '10%',
            'name' => 'journal_date',
        ),
        'turn' => array(
            'type' => 'enum',
            'studio' => 'visible',
            'label' => 'LBL_TURN',
            'width' => '10%',
            'name' => 'turn',
        ),
        'stic_journal_stic_centers_name' => array(
            'type' => 'relate',
            'link' => true,
            'label' => 'LBL_STIC_JOURNAL_STIC_CENTERS_FROM_STIC_CENTERS_TITLE',
            'width' => '10%',
            'id' => 'STIC_JOURNAL_STIC_CENTERSSTIC_CENTERS_IDA',
            'name' => 'stic_journal_stic_centers_name',
        ),
        'assigned_user_name' => array(
            'link' => true,
            'type' => 'relate',
            'label' => 'LBL_ASSIGNED_TO_NAME',
            'id' => 'ASSIGNED_USER_ID',
            'width' => '10%',
            'name' => 'assigned_user_name',
        ),
        'current_user_only' => array(
            'label' => 'LBL_CURRENT_USER_FILTER',
            'type' => 'bool',
            'width' => '10%',
            'name' => 'current_user_only',
        ),
    ),
);
