<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
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
 * SugarCRM" logo and "Jubilee Insurance | CRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Jubilee Insurance | CRM".
 ********************************************************************************/





$listViewDefs['Bugs'] = array(
	'BUG_NUMBER' => array(
		'width' => '5', 
		'label' => 'LBL_LIST_NUMBER', 
		'link' => true,
        'default' => true), 
	'NAME' => array(
		'width' => '32', 
		'label' => 'LBL_LIST_SUBJECT', 
		'default' => true,
        'link' => true),
	'STATUS' => array(
		'width' => '10', 
		'label' => 'LBL_LIST_STATUS',
        'default' => true),
    'TYPE' => array(
        'width' => '10', 
        'label' => 'LBL_LIST_TYPE',
        'default' => true), 
    'PRIORITY' => array(
        'width' => '10', 
        'label' => 'LBL_LIST_PRIORITY',
        'default' => true),  
    'RELEASE_NAME' => array(
        'width' => '10', 
        'label' => 'LBL_FOUND_IN_RELEASE',
        'default' => false,
        'related_fields' => array('found_in_release'),
        'module' => 'Releases',
        'id' => 'FOUND_IN_RELEASE',),
    'FIXED_IN_RELEASE_NAME' => array(
        'width' => '10', 
        'label' => 'LBL_LIST_FIXED_IN_RELEASE',
        'default' => true,
        'related_fields' => array('fixed_in_release'),
        'module' => 'Releases',
        'id' => 'FIXED_IN_RELEASE',),  
    'RESOLUTION' => array(
        'width' => '10', 
        'label' => 'LBL_LIST_RESOLUTION',
        'default' => false),          
	'ASSIGNED_USER_NAME' => array(
		'width' => '9', 
		'label' => 'LBL_LIST_ASSIGNED_USER',
		'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => true)
);
