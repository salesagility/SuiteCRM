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


$dictionary['FieldsMetaData'] = array (
	'table' => 'fields_meta_data',
	'fields' => array (
		'id'=>array('name' =>'id', 'type' =>'varchar', 'len'=>'255', 'reportable'=>false),
		'name'=>array('name' =>'name', 'vname'=>'COLUMN_TITLE_NAME', 'type' =>'varchar', 'len'=>'255'),
		'vname'=>array('name' =>'vname' ,'type' =>'varchar','vname'=>'COLUMN_TITLE_LABEL',  'len'=>'255'),
		'comments'=>array('name' =>'comments' ,'type' =>'varchar','vname'=>'COLUMN_TITLE_LABEL',  'len'=>'255'),
        'help'=>array('name' =>'help' ,'type' =>'varchar','vname'=>'COLUMN_TITLE_LABEL',  'len'=>'255'),
		'custom_module'=>array('name' =>'custom_module',  'type' =>'varchar', 'len'=>'255', ),
		'type'=>array('name' =>'type', 'vname'=>'COLUMN_TITLE_DATA_TYPE',  'type' =>'varchar', 'len'=>'255'),
		'len'=>array('name' =>'len','vname'=>'COLUMN_TITLE_MAX_SIZE', 'type' =>'int', 'len'=>'11', 'required'=>false, 'validation' => array('type' => 'range', 'min' => 1, 'max' => 255),),
		'required'=>array('name' =>'required', 'type' =>'bool', 'default'=>'0'),
		'default_value'=>array('name' =>'default_value', 'type' =>'varchar', 'len'=>'255', ),
		'date_modified'=>array('name' =>'date_modified', 'type' =>'datetime', 'len'=>'255',),		
		'deleted'=>array('name' =>'deleted', 'type' =>'bool', 'default'=>'0', 'reportable'=>false),
		'audited'=>array('name' =>'audited', 'type' =>'bool', 'default'=>'0'),		
		'massupdate'=>array('name' =>'massupdate', 'type' =>'bool', 'default'=>'0'),	
        'duplicate_merge'=>array('name' =>'duplicate_merge', 'type' =>'short', 'default'=>'0'),  
        'reportable' => array('name'=>'reportable', 'type'=>'bool', 'default'=>'1'),
        'importable' => array('name'=>'importable', 'type'=>'varchar', 'len'=>'255'),
		'ext1'=>array('name' =>'ext1', 'type' =>'varchar', 'len'=>'255', 'default'=>''),
		'ext2'=>array('name' =>'ext2', 'type' =>'varchar', 'len'=>'255', 'default'=>''),
		'ext3'=>array('name' =>'ext3', 'type' =>'varchar', 'len'=>'255', 'default'=>''),
		'ext4'=>array('name' =>'ext4', 'type' =>'text'),
	),
	'indices' => array (
		array('name' =>'fields_meta_datapk', 'type' =>'primary', 'fields' => array('id')),
		array('name' =>'idx_meta_id_del', 'type' =>'index', 'fields'=>array('id','deleted')),
		array('name' => 'idx_meta_cm_del', 'type' => 'index', 'fields' => array('custom_module', 'deleted')),
	),
);