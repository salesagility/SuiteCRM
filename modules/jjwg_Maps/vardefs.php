<?php
/*********************************************************************************
 * SugarCRM is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2010 SugarCRM Inc.
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
$dictionary['jjwg_Maps'] = array(
	'table'=>'jjwg_maps',
	'audited'=>true,
	'fields'=>array (
  'distance' => 
  array (
    'required' => true,
    'name' => 'distance',
    'vname' => 'LBL_DISTANCE',
    'type' => 'float',
    'massupdate' => 0,
    'comments' => '',
    'help' => 'Distance',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => true,
    'reportable' => true,
    'len' => '9',
    'size' => '20',
    'precision' => '4',
  ),
  'unit_type' => 
  array (
    'required' => true,
    'name' => 'unit_type',
    'vname' => 'LBL_UNIT_TYPE',
    'type' => 'enum',
    'massupdate' => 0,
    'default' => 'mi',
    'comments' => '',
    'help' => 'Unit Type (mi/km)',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => true,
    'reportable' => true,
    'len' => 100,
    'size' => '20',
    'options' => 'map_unit_type_list',
    'studio' => 'visible',
    'dependency' => false,
  ),
  'module_type' => 
  array (
    'required' => true,
    'name' => 'module_type',
    'vname' => 'LBL_MODULE_TYPE',
    'type' => 'enum',
    'massupdate' => 0,
    'default' => 'Accounts',
    'comments' => '',
    'help' => 'Module Type to Display',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => true,
    'reportable' => true,
    'len' => 100,
    'size' => '20',
    'options' => 'map_module_type_list',
    'studio' => 'visible',
    'dependency' => false,
  ),
  'parent_name' => 
  array (
    'required' => true,
    'source' => 'non-db',
    'name' => 'parent_name',
    'vname' => 'LBL_FLEX_RELATE',
    'type' => 'parent',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => true,
    'reportable' => true,
    'len' => 25,
    'size' => '20',
    'options' => 'map_relate_type_list',
    'studio' => 'visible',
    'type_name' => 'parent_type',
    'id_name' => 'parent_id',
    'parent_type' => 'record_type_display',
  ),
  'parent_type' => 
  array (
    'required' => false,
    'name' => 'parent_type',
    'vname' => 'LBL_PARENT_TYPE',
    'type' => 'parent_type',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => false,
    'reportable' => true,
    'len' => 255,
    'size' => '20',
    'dbType' => 'varchar',
    'studio' => 'hidden',
  ),
  'parent_id' => 
  array (
    'required' => false,
    'name' => 'parent_id',
    'vname' => 'LBL_PARENT_ID',
    'type' => 'id',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => false,
    'reportable' => true,
    'len' => 36,
    'size' => '20',
  ),
// 'lists' => 
//  array (
//    'required' => false,
//    'name' => 'lists',
//    'vname' => 'LBL_LISTS',
//    'type' => 'multienum',
//    'massupdate' => 0,
//    'default' => '^default^',
//    'comments' => '',
//    'help' => 'Target Lists',
//    'importable' => 'false',
//    'duplicate_merge' => 'disabled',
//    'duplicate_merge_dom_value' => 0,
//    'audited' => false,
//    'reportable' => true,
//    'unified_search' => false,
//    'size' => '20',
//    'function' => 'getProspectLists',
//    'studio' => 'visible',
//    'isMultiSelect' => true,
//    ),
),
	'relationships'=>array (
),
	'optimistic_locking'=>true,
);
if (!class_exists('VardefManager')){
        require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('jjwg_Maps','jjwg_Maps', array('basic','assignable'));