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
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/

/*********************************************************************************

 * Description:
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc. All Rights
 * Reserved. Contributor(s): ______________________________________..
 *********************************************************************************/

$dictionary['folders'] = array(
	'table' => 'folders',
	'fields' => array(
		array(
			'name'			=> 'id',
			'type'			=> 'id',
			'required'		=> true,
		),
		array(
			'name'			=> 'name',
			'type'			=> 'varchar',
			'len'			=> 25,
			'required'		=> true,
		),
		array(
			'name'			=> 'folder_type',
			'type'			=> 'varchar',
			'len'			=> 25,
			'default'		=> NULL,
		),
		array(
			'name'			=> 'parent_folder',
			'type'			=> 'id',
			'required'		=> false,
		),
		array(
			'name'			=> 'has_child',
			'type'			=> 'bool',
			'default'		=> '0',
		),
		array(
			'name'			=> 'is_group',
			'type'			=> 'bool',
			'default'		=> '0',
		),
		array(
			'name'			=> 'is_dynamic',
			'type'			=> 'bool',
			'default'		=> '0',
		),
		array(
			'name'			=> 'dynamic_query',
			'type'			=> 'text',
		),
		array(
			'name'			=> 'assign_to_id',
			'type'			=> 'id',
			'required'		=> false,
		),

		array(
			'name'			=> 'created_by',
			'type'			=> 'id',
			'required'		=> true,
		),
		array(
			'name'			=> 'modified_by',
			'type'			=> 'id',
			'required'		=> true,
		),
		array(
			'name'			=> 'deleted',
			'type'			=> 'bool',
			'default'		=> '0',
		),
	),
	'indices' => array(
		array(
			'name'			=> 'folderspk',
			'type'			=> 'primary',
			'fields'		=> array('id')
		),
		array(
			'name'			=> 'idx_parent_folder',
			'type'			=> 'index',
			'fields'		=> array('parent_folder')
		),
	),
);

$dictionary['folders_subscriptions'] = array(
	'table' => 'folders_subscriptions',
	'fields' => array(
		array(
			'name'			=> 'id',
			'type'			=> 'id',
			'required'		=> true,
		),
		array(
			'name'			=> 'folder_id',
			'type'			=> 'id',
			'required'		=> true,
		),
		array(
			'name'			=> 'assigned_user_id',
			'type'			=> 'id',
			'required'		=> true,
		),
	),
	'indices' => array(
		array(
			'name'			=> 'folders_subscriptionspk',
			'type'			=> 'primary',
			'fields'		=> array('id')
		),
		array(
			'name'			=> 'idx_folder_id_assigned_user_id',
			'type'			=> 'index',
			'fields'		=> array('folder_id', 'assigned_user_id')
		),
	),
);

$dictionary['folders_rel'] = array(
	'table' => 'folders_rel',
	'fields' => array(
		array(
			'name'			=> 'id',
			'type'			=> 'id',
			'required'		=> true,
		),
		array(
			'name'			=> 'folder_id',
			'type'			=> 'id',
			'required'		=> true,
		),
		array(
			'name'			=> 'polymorphic_module',
			'type'			=> 'varchar',
			'len'			=> 25,
			'required'		=> true,
		),
		array(
			'name'			=> 'polymorphic_id',
			'type'			=> 'id',
			'required'		=> true,
		),
		array(
			'name'			=> 'deleted',
			'type'			=> 'bool',
			'default'		=> '0',
		),
	),
	'indices' => array(
		array(
			'name'			=> 'folders_relpk',
			'type'			=> 'primary',
			'fields'		=> array('id'),
		),
		array(
			'name'			=> 'idx_poly_module_poly_id',
			'type'			=> 'index',
			'fields'		=> array('polymorphic_module', 'polymorphic_id'),
		),
		array(
		    'name'			=> 'idx_fr_id_deleted_poly',
		    'type'			=> 'index',
		    'fields'		=> array('folder_id','deleted','polymorphic_id'),
		),
	),
);
