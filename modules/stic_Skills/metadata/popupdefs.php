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
    'moduleMain' => 'stic_Skills',
    'varName' => 'stic_Skills',
    'orderBy' => 'stic_skills.name',
    'whereClauses' => array(
        'name' => 'stic_skills.name',
        'stic_skills_contacts_name' => 'stic_skills.stic_skills_contacts_name',
        'skill' => 'stic_skills.skill',
        'type' => 'stic_skills.type',
        'level' => 'stic_skills.level',
        'assigned_user_id' => 'stic_skills.assigned_user_id',
    ),
    'searchInputs' => array(
        1 => 'name',
        4 => 'stic_skills_contacts_name',
        5 => 'skill',
        6 => 'type',
        7 => 'level',
        8 => 'assigned_user_id',
    ),
    'searchdefs' => array(
        'name' => array(
            'name' => 'name',
            'width' => '10%',
        ),
        'stic_skills_contacts_name' => array(
            'type' => 'relate',
            'link' => true,
            'label' => 'LBL_STIC_SKILLS_CONTACTS_FROM_CONTACTS_TITLE',
            'id' => 'STIC_SKILLS_CONTACTSCONTACTS_IDA',
            'width' => '10%',
            'name' => 'stic_skills_contacts_name',
        ),
        'skill' => array(
            'type' => 'varchar',
            'label' => 'LBL_SKILL',
            'width' => '10%',
            'name' => 'skill',
        ),
        'type' => array(
            'type' => 'enum',
            'studio' => 'visible',
            'label' => 'LBL_TYPE',
            'width' => '10%',
            'name' => 'type',
        ),
        'level' => array(
            'type' => 'enum',
            'studio' => 'visible',
            'label' => 'LBL_LEVEL',
            'width' => '10%',
            'name' => 'level',
        ),
        'assigned_user_id' => array(
            'name' => 'assigned_user_id',
            'label' => 'LBL_ASSIGNED_TO',
            'type' => 'enum',
            'function' => array(
                'name' => 'get_user_array',
                'params' => array(
                    0 => false,
                ),
            ),
            'width' => '10%',
        ),
    ),
);
