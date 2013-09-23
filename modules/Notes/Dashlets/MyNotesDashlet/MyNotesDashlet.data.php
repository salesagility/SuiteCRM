<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/


global $current_user;

$dashletData['MyNotesDashlet']['searchFields'] = array('date_entered'     => array('default' => ''),
														'assigned_user_id' => array('type'    => 'assigned_user_name',
																					'label'   => 'LBL_ASSIGNED_TO', 
																					'default' => $current_user->name),
																					'name' => array( 'default'=>''),
														);
                                                                                           
$dashletData['MyNotesDashlet']['columns'] = array (
											  'name' => 
											  array (
											    'width' => '40%',
											    'label' => 'LBL_LIST_SUBJECT',
											    'link' => true,
											    'default' => true,
											  ),
											  'contact_name' => 
											  array (
											    'width' => '20%',
											    'label' => 'LBL_LIST_CONTACT',
											    'link' => true,
											    'id' => 'CONTACT_ID',
											    'module' => 'Contacts',
											    'default' => true,
											    'ACLTag' => 'CONTACT',
											    'related_fields' => 
											    array (
											      0 => 'contact_id',
											    ),
											  ),
											  'parent_name' => 
											  array (
											    'width' => '20%',
											    'label' => 'LBL_LIST_RELATED_TO',
											    'dynamic_module' => 'PARENT_TYPE',
											    'id' => 'PARENT_ID',
											    'link' => true,
											    'default' => true,
											    'sortable' => false,
											    'ACLTag' => 'PARENT',
											    'related_fields' => 
											    array (
											      0 => 'parent_id',
											      1 => 'parent_type',
											    ),
											  ),  
											  'filename' => 
											  array (
											    'width' => '20%',
											    'label' => 'LBL_LIST_FILENAME',
											    'default' => true,
											    'type' => 'file',
											    'related_fields' => 
											    array (
											      0 => 'file_url',
											      1 => 'id',
											      2 => 'doc_id',
											      3 => 'doc_type',
											    ),
											    'displayParams' =>
											    array(
											      'module' => 'Notes',
											    ),
											  ),
											  'created_by_name' => 
											  array (
											    'type' => 'relate',
											    'label' => 'LBL_CREATED_BY',
											    'width' => '10%',
											    'default' => true,
											  ),
											  'date_entered' => 
											  array (
											    'type' => 'datetime',
											    'label' => 'LBL_DATE_ENTERED',
											    'width' => '10%',
											    'default' => false,
											  ),
											  'date_modified' => 
											  array (
											    'width' => '20%',
											    'label' => 'LBL_DATE_MODIFIED',
											    'link' => false,
											    'default' => false,
											  ),
											);
											?>
