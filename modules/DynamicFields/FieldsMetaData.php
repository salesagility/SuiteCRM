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













class FieldsMetaData extends SugarBean {
	// database table columns
	var $id;
	var $name;
	var $vname;
  	var $custom_module;
  	var $type;
  	var $len;
  	var $required;
  	var $default_value;
  	var $deleted;
  	var $ext1;
  	var $ext2;
  	var $ext3;
	var $audited;
    var $duplicate_merge;
    var $reportable;
	var $required_fields =  array("name"=>1, "date_start"=>2, "time_start"=>3,);

	var $table_name = 'fields_meta_data';
	var $object_name = 'FieldsMetaData';
	var $module_dir = 'DynamicFields';
	var $column_fields = array(
		'id',
		'name',
		'vname',
		'custom_module',
		'type',
		'len',
		'required',
		'default_value',
		'deleted',
		'ext1',
		'ext2',
		'ext3',
		'audited',
		'massupdate',
        'duplicate_merge',
        'reportable',
	);

	var $list_fields = array(
		'id',
		'name',
		'vname',
		'type',
		'len',
		'required',
		'default_value',
		'audited',
		'massupdate',
        'duplicate_merge',
        'reportable',
	);

	var $field_name_map;
	var $new_schema = true;

	//////////////////////////////////////////////////////////////////
	// METHODS
	//////////////////////////////////////////////////////////////////

	function FieldsMetaData()
	{
		parent::SugarBean();
		$this->disable_row_level_security = true;
	}
	
	function mark_deleted($id)
	{
		$query = "DELETE FROM $this->table_name WHERE  id='$id'";
		$this->db->query($query, true,"Error deleting record: ");
		$this->mark_relationships_deleted($id);

	}
	
	function get_list_view_data(){
	    $data = parent::get_list_view_data();
	    $data['VNAME'] = translate($this->vname, $this->custom_module);
	    $data['NAMELINK'] = '<input class="checkbox" type="checkbox" name="remove[]" value="' . $this->id . '">&nbsp;&nbsp;<a href="index.php?module=Studio&action=wizard&wizard=EditCustomFieldsWizard&option=EditCustomField&record=' . $this->id . '" >';
	    return $data;
	}


	function get_summary_text()
	{
		return $this->name;
	}
}
?>
