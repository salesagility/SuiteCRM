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

$module_name='stic_Job_Applications';
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
			'width' => '20%',
	    ),
		'status' => 
		array (
			'type' => 'enum',
			'studio' => 'visible',
			'vname' => 'LBL_STATUS',
			'width' => '10%',
			'default' => true,
		),
		'stic_job_applications_stic_job_offers_name' => 
		array (
			'type' => 'relate',
			'link' => true,
			'vname' => 'LBL_STIC_JOB_APPLICATIONS_STIC_JOB_OFFERS_FROM_STIC_JOB_OFFERS_TITLE',
			'id' => 'STIC_JOB_APPLICATIONS_STIC_JOB_OFFERSSTIC_JOB_OFFERS_IDA',
			'width' => '10%',
			'default' => true,
			'widget_class' => 'SubPanelDetailViewLink',
			'target_module' => 'stic_Job_Offers',
			'target_record_key' => 'stic_job_applications_stic_job_offersstic_job_offers_ida',
		),
		'stic_job_applications_contacts_name' => 
		array (
			'type' => 'relate',
			'link' => true,
			'vname' => 'LBL_STIC_JOB_APPLICATIONS_CONTACTS_FROM_CONTACTS_TITLE',
			'id' => 'STIC_JOB_APPLICATIONS_CONTACTSCONTACTS_IDA',
			'width' => '10%',
			'default' => true,
			'widget_class' => 'SubPanelDetailViewLink',
			'target_module' => 'Contacts',
			'target_record_key' => 'stic_job_applications_contactscontacts_ida',
		),
		'start_date' => 
		array (
			'type' => 'date',
			'vname' => 'LBL_START_DATE',
			'width' => '10%',
			'default' => true,
		),
		'end_date' => 
		array (
			'type' => 'date',
			'vname' => 'LBL_END_DATE',
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