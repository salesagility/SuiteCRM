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

$module_name = 'stic_Custom_View_Customizations';
$subpanel_layout = array(
    'top_buttons' => array(
        0 => array(
            'widget_class' => 'SubPanelTopCreateButton',
        ),
    ),
    'where' => '',
    'list_fields' => array(
        'customization_order' => array(
            'type' => 'int',
            'vname' => 'LBL_CUSTOMIZATION_ORDER',
            'width' => '5%',
            'default' => true,
            'sortable' => true,
            'sort_order' => 'asc',
            'sort_by' => 'customization_order',
        ),
        'name' => array(
            'type' => 'text',
            'vname' => 'LBL_NAME',
            'default' => true,
        ),
        'status' => array(
            'type' => 'enum',
            'vname' => 'LBL_STATUS',
            'default' => true,
        ),
        'conditions' => array(
            'type' => 'text',
            'vname' => 'LBL_CONDITIONS',
            'width' => '30%',
            'sortable' => false,
            'default' => true,
        ),
        'actions' => array(
            'type' => 'text',
            'vname' => 'LBL_ACTIONS',
            'width' => '30%',
            'sortable' => false,
            'default' => true,
        ),
        'description' => array(
            'type' => 'text',
            'vname' => 'LBL_DESCRIPTION',
            'sortable' => false,
            'default' => true,
        ),
        'date_modified' => array(
            'vname' => 'LBL_DATE_MODIFIED',
            'default' => true,
        ),
        'quickedit_button' => array(
            'vname' => 'LBL_QUICKEDIT_BUTTON',
            'widget_class' => 'SubPanelQuickEditButton',
            'module' => 'stic_Custom_View_Customizations',
            'default' => true,
        ),
        'duplicate_button' => array(
            'vname' => 'LBL_DUPLICATE_BUTTON',
            'widget_class' => 'SubPanelDuplicateButtonstic',
            'module' => 'stic_Custom_View_Customizations',
            'default' => true,
        ),
        'remove_button' => array(
            'vname' => 'LBL_REMOVE',
            'widget_class' => 'SubPanelRemoveButton',
            'module' => 'stic_Custom_View_Customizations',
            'default' => true,
        ),
    ),
);
