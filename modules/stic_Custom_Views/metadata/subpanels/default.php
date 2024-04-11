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

$module_name = 'stic_Custom_Views';
$subpanel_layout = array(
    'top_buttons' => array(
        0 => array(
            'widget_class' => 'SubPanelTopCreateButton',
        ),
        1 => array(
            'widget_class' => 'SubPanelTopSelectButton',
            'popup_module' => 'stic_Custom_Views',
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
        'view_module' => array(
            'type' => 'enum',
            'studio' => 'visible',
            'vname' => 'LBL_VIEW_MODULE',
            'width' => '10%',
            'default' => true,
        ),
        'user_type' => array(
            'type' => 'enum',
            'default' => true,
            'studio' => 'visible',
            'vname' => 'LBL_USER_TYPE',
            'width' => '10%',
        ),
        'roles' => array(
            'type' => 'multienum',
            'studio' => 'visible',
            'vname' => 'LBL_ROLES',
            'width' => '10%',
            'default' => true,
        ),
        'security_groups' => array(
            'type' => 'multienum',
            'studio' => 'visible',
            'vname' => 'LBL_SECURITY_GROUPS',
            'width' => '10%',
            'default' => true,
        ),
        'roles_exclude' => array(
            'type' => 'multienum',
            'studio' => 'visible',
            'vname' => 'LBL_ROLES_EXCLUDE',
            'width' => '10%',
            'default' => true,
        ),
        'security_groups_exclude' => array(
            'type' => 'multienum',
            'studio' => 'visible',
            'vname' => 'LBL_SECURITY_GROUPS_EXCLUDE',
            'width' => '10%',
            'default' => true,
        ),
        'date_modified' => array(
            'vname' => 'LBL_DATE_MODIFIED',
            'width' => '10%',
            'default' => true,
        ),
        'edit_button' => array(
            'vname' => 'LBL_EDIT_BUTTON',
            'widget_class' => 'SubPanelEditButton',
            'module' => 'stic_Custom_Views',
            'width' => '4%',
            'default' => true,
        ),
        'remove_button' => array(
            'vname' => 'LBL_REMOVE',
            'widget_class' => 'SubPanelRemoveButton',
            'module' => 'stic_Custom_Views',
            'width' => '5%',
            'default' => true,
        ),
    ),
);
