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

$dictionary['Administration'] = array('table' => 'config', 'comment' => 'System table containing system-wide definitions'
                               ,'fields' => array (
  'category' =>
  array (
    'name' => 'category',
    'vname' => 'LBL_LIST_SYMBOL',
    'type' => 'varchar',
    'len' => '32',
    'comment' => 'Settings are grouped under this category; arbitraily defined based on requirements'
  ),
  'name' =>
  array (
    'name' => 'name',
    'vname' => 'LBL_LIST_NAME',
    'type' => 'varchar',
    'len' => '32',
    'comment' => 'The name given to the setting'
  ),
  'value' =>
  array (
    'name' => 'value',
    'vname' => 'LBL_LIST_RATE',
    'type' => 'text',
    'comment' => 'The value given to the setting'
  ),

), 'indices'=>array( array('name'=>'idx_config_cat', 'type'=>'index',  'fields'=>array('category')),)
                            );

$dictionary['UpgradeHistory'] = array(
    'table'  => 'upgrade_history', 'comment' => 'Tracks Sugar upgrades made over time; used by Upgrade Wizard and Module Loader',
    'fields' => array (
        'id' => array (
                'name'       => 'id',
                'type'       => 'id',
                'required'   => true,
                'reportable' => false,
    		    'comment' => 'Unique identifier'
        ),
        'filename' => array (
                'name' => 'filename',
                'type' => 'varchar',
                'len' => '255',
    		    'comment' => 'Cached filename containing the upgrade scripts and content'
        ),
        'md5sum' => array (
                'name' => 'md5sum',
                'type' => 'varchar',
                'len' => '32',
    		    'comment' => 'The MD5 checksum of the upgrade file'
        ),
        'type' => array (
                'name' => 'type',
                'type' => 'varchar',
                'len' => '30',
    		    'comment' => 'The upgrade type (module, patch, theme, etc)'
        ),
        'status' => array (
                'name' => 'status',
                'type' => 'varchar',
                'len' => '50',
    		    'comment' => 'The status of the upgrade (ex:  "installed")',
        ),
        'version' => array (
                'name' => 'version',
                'type' => 'varchar',
                'len' => '64',
    		    'comment' => 'Version as contained in manifest file'
        ),
		'name' => array (
                'name'  => 'name',
                'type'  => 'varchar',
                'len'   => '255',
        ),
		'description' => array (
                'name'  => 'description',
                'type'  => 'text',
        ),
        'id_name' => array (
                'name' => 'id_name',
                'type' => 'varchar',
                'len' => '255',
    		    'comment' => 'The unique id of the module'
        ),
        'manifest' => array (
                'name' => 'manifest',
                'type' => 'longtext',
    		    'comment' => 'A serialized copy of the manifest file.'
        ),
        'date_entered' => array (
                'name' => 'date_entered',
                'type' => 'datetime',
                'required'=>true,
    		    'comment' => 'Date of upgrade or module load'
        ),
        'enabled' => array(
                                      'name' => 'enabled',
                                      'type' => 'bool',
                                      'len'  => '1',
                                      'default'   => '1',
        ),
    ),

    'indices' => array(
        array('name'=>'upgrade_history_pk',     'type'=>'primary', 'fields'=>array('id')),
        array('name'=>'upgrade_history_md5_uk', 'type'=>'unique',  'fields'=>array('md5sum')),

    ),
);


?>
