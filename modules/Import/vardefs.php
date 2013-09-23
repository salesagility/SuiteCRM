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

$dictionary['ImportMap'] = array (
    'table' => 'import_maps', 
    'comment' => 'Import mapping control table',
    'fields' => array (
        'id' => array (
            'name' => 'id',
            'vname' => 'LBL_ID',
            'type' => 'id',
            'required'=>true,
            'reportable'=>false,
            'comment' => 'Unique identifier',
            ),
        'name' => array (
            'name' => 'name',
            'vname' => 'LBL_NAME',
            'type' => 'varchar',
            'len' => '254',
            'required'=>true,
            'comment' => 'Name of import map',
            ),
        'source' => array (
            'name' => 'source',
            'vname' => 'LBL_SOURCE',
            'type' => 'varchar',
            'len' => '36',
            'required'=>true,
            'comment' => '',
            ),
        'enclosure' => array (
            'name' => 'enclosure',
            'vname' => 'LBL_CUSTOM_ENCLOSURE',
            'type' => 'varchar',
            'len' => '1',
            'required'=>true,
            'comment' => '',
            'default' => ' ',
            ),
        'delimiter' => array (
            'name' => 'delimiter',
            'vname' => 'LBL_CUSTOM_DELIMITER',
            'type' => 'varchar',
            'len' => '1',
            'required'=>true,
            'comment' => '',
            'default' => ',',
            ),
        'module' => array (
            'name' => 'module',
            'vname' => 'LBL_MODULE',
            'type' => 'varchar',
            'len' => '36',
            'required'=>true,
            'comment' => 'Module used for import',
            ),
        'content' => array (
            'name' => 'content',
            'vname' => 'LBL_CONTENT',
            'type' => 'text',
            'comment' => 'Mappings for all columns',
            ),
        'default_values' => array (
            'name' => 'default_values',
            'vname' => 'LBL_CONTENT',
            'type' => 'text',
            'comment' => 'Default Values for all columns',
            ),
        'has_header' => array (
            'name' => 'has_header',
            'vname' => 'LBL_HAS_HEADER',
            'type' => 'bool',
            'default' => '1',
            'required'=>true,
            'comment' => 'Indicator if source file contains a header row',
            ),
        'deleted' => array (
            'name' => 'deleted',
            'vname' => 'LBL_DELETED',
            'type' => 'bool',
            'required'=>false,
            'reportable'=>false,
            'comment' => 'Record deletion indicator',
            ),
        'date_entered' => array (
            'name' => 'date_entered',
            'vname' => 'LBL_DATE_ENTERED',
            'type' => 'datetime',
            'required'=>true,
            'comment' => 'Date record created',
            ),
        'date_modified' => array (
            'name' => 'date_modified',
            'vname' => 'LBL_DATE_MODIFIED',
            'type' => 'datetime',
            'required'=>true,
            'comment' => 'Date record last modified',
            ),
        'assigned_user_id' => array (
            'name' => 'assigned_user_id',
            'rname' => 'user_name',
            'id_name' => 'assigned_user_id',
            'vname' => 'LBL_ASSIGNED_TO',
            'type' => 'assigned_user_name',
            'table' => 'users',
            'isnull' => 'false',
            'dbType' => 'id',
            'reportable'=>false,
            'comment' => 'Assigned-to user',
            ),
        'is_published' => array (
            'name' => 'is_published',
            'vname' => 'LBL_IS_PUBLISHED',
            'type' => 'varchar',
            'len' => '3',
            'required'=>true,
            'default'=>'no',
            'comment' => 'Indicator if mapping is published',
            ),
        ),                                
    'indices' => array (
        array(
            'name' =>'import_mapspk', 
            'type' =>'primary', 
            'fields'=>array('id')
            ),
        array(
            'name' =>'idx_owner_module_name', 
            'type' =>'index', 
            'fields'=>array('assigned_user_id','module','name','deleted')
            ),
        )
    );
                                  
$dictionary['UsersLastImport'] = array ( 
    'table' => 'users_last_import', 
    'comment' => 'Maintains rows last imported by user', 
    'fields' => array (
        'id' => array (
            'name' => 'id',
            'vname' => 'LBL_ID',
            'type' => 'id',
            'required'=>true,
            'reportable'=>false,
            'comment' => 'Unique identifier'
            ),
        'assigned_user_id' => array (
            'name' => 'assigned_user_id',
            'rname' => 'user_name',
            'id_name' => 'assigned_user_id',
            'vname' => 'LBL_ASSIGNED_TO',
            'type' => 'assigned_user_name',
            'table' => 'users',
            'isnull' => 'false',
            'dbType' => 'id',
            'reportable'=>false,
            'comment' => 'User assigned to this record'
            ),
        'import_module' => array (
            'name' => 'import_module',
            'vname' => 'LBL_BEAN_TYPE',
            'type' => 'varchar',
            'len' => '36',
            'comment' => 'Module for which import occurs'
            ),
        'bean_type' => array (
            'name' => 'bean_type',
            'vname' => 'LBL_BEAN_TYPE',
            'type' => 'varchar',
            'len' => '36',
            'comment' => 'Bean type for which import occurs'
            ),
        'bean_id' => array (
            'name' => 'bean_id',
            'vname' => 'LBL_BEAN_ID',
            'type' => 'id',
            'reportable'=>false,
            'comment' => 'ID of item identified by bean_type'
            ),
        'deleted' => array (
            'name' => 'deleted',
            'vname' => 'LBL_DELETED',
            'type' => 'bool',
            'reportable'=>false,
            'required'=>false,
            'comment' => 'Record deletion indicator'
            ),
        ),
    'indices' => array (
        array(
            'name' =>'users_last_importpk', 
            'type' =>'primary', 
            'fields'=>array('id')
            ),
        array(
            'name' =>'idx_user_id', 
            'type' =>'index', 
            'fields'=>array('assigned_user_id')
            )
        )
    );
?>
