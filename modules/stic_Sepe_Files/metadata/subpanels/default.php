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
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$module_name='stic_Sepe_Files';
$subpanel_layout = array(
	'top_buttons' => array(
		array('widget_class' => 'SubPanelTopCreateButton'),
		array('widget_class' => 'SubPanelTopSelectButton', 'popup_module' => $module_name),
	),
	'where' => '',
	'list_fields' => array(
		'name'=>array(
	 		'vname' => 'LBL_NAME',
			'widget_class' => 'SubPanelDetailViewLink',
	 		'width' => '45%',
		),
		'status' => 
		array (
			'type' => 'enum',
			'studio' => 'visible',
			'vname' => 'LBL_STATUS',
			'width' => '10%',
			'default' => true,
		),
		'type' => 
		array (
			'type' => 'enum',
			'studio' => 'visible',
			'vname' => 'LBL_TYPE',
			'width' => '10%',
			'default' => true,
		),
		'reported_month' => 
		array (
			'type' => 'date',
			'vname' => 'LBL_REPORTED_MONTH',
			'width' => '10%',
			'default' => true,
		),
		'agreement' => 
		array (
			'type' => 'enum',
			'studio' => 'visible',
			'vname' => 'LBL_AGREEMENT',
			'width' => '10%',
			'default' => true,
		),
		'assigned_user_name' => 
		array (
			'width' => '9%',
			'vname' => 'LBL_ASSIGNED_TO_NAME',
			'module' => 'Employees',
			'id' => 'ASSIGNED_USER_ID',
			'default' => true,
			'widget_class' => 'SubPanelDetailViewLink',
            'target_module' => 'Users',
            'target_record_key' => 'assigned_user_id',
		),
		'edit_button'=>array(
            'vname' => 'LBL_EDIT_BUTTON',
			'widget_class' => 'SubPanelEditButton',
		 	'module' => $module_name,
	 		'width' => '4%',
		),
		'remove_button'=>array(
            'vname' => 'LBL_REMOVE',
			'widget_class' => 'SubPanelRemoveButton',
		 	'module' => $module_name,
			'width' => '5%',
		),
	),
);

?>