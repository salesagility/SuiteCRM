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
$module_name = 'stic_Group_Opportunities';
$subpanel_layout = array(
    'top_buttons' => array(
        0 => array(
            'widget_class' => 'SubPanelTopCreateButton',
        ),
        1 => array(
            'widget_class' => 'SubPanelTopSelectButton',
            'popup_module' => 'stic_Group_Opportunities',
        ),
    ),
    'where' => '',
    'list_fields' => array(
        'name' => array(
            'vname' => 'LBL_NAME',
            'widget_class' => 'SubPanelDetailViewLink',
            'width' => '45%',
            'default' => true,
        ),
        'status' => array(
            'type' => 'enum',
            'studio' => 'visible',
            'vname' => 'LBL_STATUS',
            'width' => '10%',
            'default' => true,
        ),
        'stic_group_opportunities_opportunities_name' => array(
            'module' => 'Opportunities',
            'target_record_key' => 'stic_group_opportunities_opportunitiesopportunities_ida',
            'target_module' => 'Opportunities',
            'widget_class' => 'SubPanelDetailViewLink',
            'vname' => 'LBL_STIC_GROUP_OPPORTUNITIES_OPPORTUNITIES_NAME',
            'width' => '20%',
            'default' => true,
        ),
        'amount_requested' => array(
            'type' => 'currency',
            'vname' => 'LBL_AMOUNT_REQUESTED',
            'currency_format' => true,
            'width' => '10%',
            'default' => true,
        ),
        'validation_date' => array(
            'type' => 'date',
            'vname' => 'LBL_VALIDATION_DATE',
            'width' => '10%',
            'default' => true,
        ),
        'resolution_date' => array(
            'type' => 'date',
            'vname' => 'LBL_RESOLUTION_DATE',
            'width' => '10%',
            'default' => true,
        ),
        'date_modified' => array(
            'vname' => 'LBL_DATE_MODIFIED',
            'width' => '45%',
            'default' => true,
        ),
        'quickedit_button' => array(
            'vname' => 'LBL_QUICKEDIT_BUTTON',
            'widget_class' => 'SubPanelQuickEditButton',
            'module' => 'stic_Group_Opportunities',
            'width' => '5%',
            'default' => true,
        ),
        'remove_button' => array(
            'vname' => 'LBL_REMOVE',
            'widget_class' => 'SubPanelRemoveButton',
            'module' => 'stic_Group_Opportunities',
            'width' => '5%',
            'default' => true,
        ),
    ),
);
