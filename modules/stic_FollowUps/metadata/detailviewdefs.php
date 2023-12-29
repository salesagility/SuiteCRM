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
$module_name = 'stic_FollowUps';
$viewdefs[$module_name] =
array(
    'DetailView' => array(
        'templateMeta' => array(
            'form' => array(
                'buttons' => array(
                    0 => 'EDIT',
                    1 => 'DUPLICATE',
                    2 => 'DELETE',
                    3 => 'FIND_DUPLICATES',
                ),
            ),
            'maxColumns' => '2',
            'widths' => array(
                0 => array(
                    'label' => '10',
                    'field' => '30',
                ),
                1 => array(
                    'label' => '10',
                    'field' => '30',
                ),
            ),
            'useTabs' => true,
            'tabDefs' => array(
                'DEFAULT' => array(
                    'newTab' => true,
                    'panelDefault' => 'expanded',
                ),
                'LBL_PANEL_RECORD_DETAILS' => array(
                    'newTab' => true,
                    'panelDefault' => 'expanded',
                ),
            ),
            'syncDetailEditViews' => true,
        ),
        'panels' => array(
            'default' => array(
                0 => array(
                    0 => 'name',
                    1 => 'assigned_user_name',
                ),
                1 => array(
                    0 => array(
                        'name' => 'stic_followups_contacts_name',
                    ),
                    1 => array(
                        'name' => 'status',
                        'studio' => 'visible',
                        'label' => 'LBL_STATUS',
                    ),
                ),
                2 => array(
                    0 => array(
                        'name' => 'start_date',
                        'label' => 'LBL_START_DATE',
                    ),
                    1 => array(
                        'name' => 'duration',
                        'label' => 'LBL_DURATION',
                    ),
                ),
                3 => array(
                    0 => array(
                        'name' => 'type',
                        'studio' => 'visible',
                        'label' => 'LBL_TYPE',
                    ),
                    1 => array(
                        'name' => 'subtype',
                        'studio' => 'visible',
                        'label' => 'LBL_SUBTYPE',
                    ),
                ),
                4 => array(
                    0 => array(
                        'name' => 'channel',
                        'studio' => 'visible',
                        'label' => 'LBL_CHANNEL',
                    ),
                    1 => array(
                        'name' => 'followup_origin',
                        'studio' => 'visible',
                        'label' => 'LBL_FOLLOWUP_ORIGIN',
                    ),
                ),
                5 => array(
                    0 => array(
                        'name' => 'attendees',
                        'studio' => 'visible',
                        'label' => 'LBL_ATTENDEES',
                    ),
                    1 => array(
                        'name' => 'color',
                        'label' => 'LBL_COLOR',
                    ),
                ),
                6 => array(
                    0 => array(
                        'name' => 'external_contact',
                        'studio' => 'visible',
                        'label' => 'LBL_EXTERNAL_CONTACT',
                    ),
                    1 => array(
                        'name' => 'external_account',
                        'studio' => 'visible',
                        'label' => 'LBL_EXTERNAL_ACCOUNT',
                    ),
                ),
                7 => array(
                    0 => array(
                        'name' => 'stic_followups_project_name',
                    ),
                    1 => array(
                        'name' => 'stic_followups_stic_registrations_name',
                    ),
                ),
                8 => array(
                    0 => array(
                        'name' => 'pending_actions',
                        'studio' => 'visible',
                        'label' => 'LBL_PENDING_ACTIONS',
                    ),
                    1 => array(
                        'name' => 'description',
                        'comment' => 'Full text of the note',
                        'studio' => 'visible',
                        'label' => 'LBL_DESCRIPTION',
                    ),
                ),
            ),
            'lbl_panel_record_details' => array(
                0 => array(
                    0 => array(
                        'name' => 'created_by_name',
                        'label' => 'LBL_CREATED',
                        
                    ),
                    1 => array(
                        'name' => 'date_entered',
                        'comment' => 'Date record created',
                        'label' => 'LBL_DATE_ENTERED',
                        'customCode' => '{$fields.date_entered.value}',
                    ),
                ),
                1 => array(
                    0 => array(
                        'name' => 'modified_by_name',
                        'label' => 'LBL_MODIFIED_NAME',
                    ),
                    1 => array(
                        'name' => 'date_modified',
                        'comment' => 'Date record last modified',
                        'label' => 'LBL_DATE_MODIFIED',
                        'customCode' => '{$fields.date_modified.value}',
                    ),
                ),
            ),
        ),
    ),
);

?>
