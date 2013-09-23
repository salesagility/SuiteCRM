<?php
if(!defined('sugarEntry'))define('sugarEntry', true);
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


require_once('service/v3_1/registry.php');

class registry_v4 extends registry_v3_1 {

	/**
	 * This method registers all the functions on the service class
	 *
	 */
	protected function registerFunction()
	{
		$GLOBALS['log']->info('Begin: registry->registerFunction');
		parent::registerFunction();

		$this->serviceClass->registerFunction(
		    'search_by_module',
	        array('session'=>'xsd:string','search_string'=>'xsd:string', 'modules'=>'tns:select_fields', 'offset'=>'xsd:int', 'max_results'=>'xsd:int','assigned_user_id' => 'xsd:string', 'select_fields'=>'tns:select_fields', 'unified_search_only'=>'xsd:boolean', 'favorites'=>'xsd:boolean'),
	        array('return'=>'tns:return_search_result'));

	}

	/**
	 * This method registers all the complex types
	 *
	 */
	protected function registerTypes()
	{
	    parent::registerTypes();

	    $this->serviceClass->registerType(
		   	 'return_search_result',
		   	 'complexType',
		   	 'struct',
		   	 'all',
		  	  '',
			array(
				'entry_list' => array('name' =>'entry_list', 'type'=>'tns:search_link_list'),
			)
		);

		$this->serviceClass->registerType(
		    'search_link_list',
			'complexType',
		   	 'array',
		   	 '',
		  	  'SOAP-ENC:Array',
			array(),
		    array(
		        array('ref'=>'SOAP-ENC:arrayType', 'wsdl:arrayType'=>'tns:search_link_name_value[]')
		    ),
			'tns:search_link_name_value'
		);

		$this->serviceClass->registerType(
		    'search_link_name_value',
			'complexType',
		   	 'struct',
		   	 'all',
		  	  '',
				array(
		        	'name'=>array('name'=>'name', 'type'=>'xsd:string'),
					'records'=>array('name'=>'records', 'type'=>'tns:search_link_array_list'),
				)
		);

		$this->serviceClass->registerType(
		    'search_link_array_list',
			'complexType',
		   	 'array',
		   	 '',
		  	  'SOAP-ENC:Array',
			array(),
		    array(
		        array('ref'=>'SOAP-ENC:arrayType', 'wsdl:arrayType'=>'tns:link_value[]')
		    ),
			'tns:link_value'
		);

		$this->serviceClass->registerType(
		    'module_list_entry',
			'complexType',
		   	 'struct',
		   	 'all',
		  	  '',
				array(
					'module_key'=>array('name'=>'module_key', 'type'=>'xsd:string'),
					'module_label'=>array('name'=>'module_label', 'type'=>'xsd:string'),
					'favorite_enabled'=>array('name'=>'favorite_enabled', 'type'=>'xsd:boolean'),
					'acls'=>array('name'=>'acls', 'type'=>'tns:acl_list'),
				)
		);

		$this->serviceClass->registerType(
		    'new_module_fields',
			'complexType',
		   	 'struct',
		   	 'all',
		  	  '',
				array(
		        	'module_name'=>array('name'=>'module_name', 'type'=>'xsd:string'),
		        	'table_name'=>array('name'=>'table_name', 'type'=>'xsd:string'),
					'module_fields'=>array('name'=>'module_fields', 'type'=>'tns:field_list'),
					'link_fields'=>array('name'=>'link_fields', 'type'=>'tns:link_field_list'),
				)
		);
	}
}