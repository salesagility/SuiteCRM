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


// this is a list of what values are expected for a given custom field type
// will eventually be moved to the SugarFields classes
$custom_field_meta = array(
	'address' => array(
		'default',
		'duplicate_merge',
		'help',
		'label',
		'label_value',
		'len',
		'name',
		'reportable'
	),
	'bool' => array(
		'duplicate_merge',
		'help',
		'label',
		'label_value',
		'name',
		'reportable'
	),
	'currency' => array(
		'duplicate_merge',
		'help',
		'label',
		'label_value',
		'name',
		'reportable'
	),
	'date' => array(
		'audited',
		'default_value',
		'duplicate_merge',
		'help',
		'label',
		'label_value',
		'massupdate',
		'name',
		'reportable',
		'required'
	),
	'enum' => array(
		'audited',
		'default',
		'duplicate_merge',
		'help',
		'label',
		'label_value',
		'massupdate',
		'name',
		'options',
		'reportable',
		'required'
	),
	'float' => array(
		'audited',
		'default',
		'duplicate_merge',
		'help',
		'label',
		'label_value',
		'len',
		'name',
		'precision',
		'reportable',
		'required'
	),
	'html' => array(
		'audited',
		'duplicate_merge',
		'ext4',
		'help',
		'label',
		'label_value',
		'name',
		'reportable',
		'required'
	),
	'int' => array(
		'audited',
		'default',
		'duplicate_merge',
		'help',
		'label',
		'label_value',
		'len',
		'max',
		'min',
		'name',
		'reportable',
		'required'
	),
	'multienum' => array(
		'audited',
		'default',
		'duplicate_merge',
		'help',
		'label',
		'label_value',
		'massupdate',
		'name',
		'options',
		'reportable',
		'required'
	),
	'phone' => array(
		'audited',
		'default',
		'duplicate_merge',
		'help',
		'label',
		'label_value',
		'len',
		'name',
		'reportable',
		'required'
	),
	'radioenum' => array(
		'audited',
		'default',
		'duplicate_merge',
		'help',
		'label',
		'label_value',
		'massupdate',
		'name',
		'options',
		'reportable',
		'required'
	),
	'relate' => array(
		'audited',
		'duplicate_merge',
		'ext2',
		'help',
		'label',
		'label_value',
		'name',
		'reportable',
		'required'
	),
	'text' => array(
		'audited',
		'default',
		'duplicate_merge',
		'help',
		'label',
		'label_value',
		'name',
		'reportable',
		'required'
	),
	'varchar' => array(
		'audited',
		'default',
		'duplicate_merge',
		'help',
		'label',
		'label_value',
		'len',
		'name',
		'reportable',
		'required'
	)
);

// create or update an existing custom field
$server->register(
	'set_custom_field',
	array(
		'session' => 'xsd:string',
		'module_name' => 'xsd:string',
		'type' => 'xsd:string',
		'properties' => 'tns:name_value_list',
		'add_to_layout' => 'xsd:int',
	),
	array(
		'return' => 'tns:error_value'
	),
	$NAMESPACE
);

function set_custom_field($session, $module_name, $type, $properties, $add_to_layout) {
	global $current_user;
	global $beanList, $beanFiles;
	global $custom_field_meta;

	$error = new SoapError();

	$request_arr = array(
		'action' => 'SaveField',
		'is_update' => 'true',
		'module' => 'ModuleBuilder',
		'view_module' => $module_name,
		'view_package' => 'studio'
	);

	// ERROR CHECKING
	if(!validate_authenticated($session)) {
		$error->set_error('invalid_login');
		return $error->get_soap_array();
	}

	if (!is_admin($current_user)) {
		$error->set_error('no_admin');
		return $error->get_soap_array();
	}

	if(empty($beanList[$module_name])){
		$error->set_error('no_module');
		return $error->get_soap_array();
	}

	if (empty($custom_field_meta[$type])) {
		$error->set_error('custom_field_type_not_supported');
		return $error->get_soap_array();
	}

	$new_properties = array();
	foreach($properties as $value) {
		$new_properties[$value['name']] = $value['value'];
	}

	foreach ($custom_field_meta[$type] as $property) {
		if (!isset($new_properties[$property])) {
			$error->set_error('custom_field_property_not_supplied');
			return $error->get_soap_array();
		}

		$request_arr[$property] = $new_properties[$property];
	}

	// $request_arr should now contain all the necessary information to create a custom field
	// merge $request_arr with $_POST/$_REQUEST, where the action_saveField() method expects them
	$_REQUEST = array_merge($_REQUEST, $request_arr);
	$_POST = array_merge($_POST, $request_arr);

	require_once('include/MVC/Controller/SugarController.php');
	require_once('modules/ModuleBuilder/controller.php');
	require_once('modules/ModuleBuilder/parsers/ParserFactory.php');

	$mbc = new ModuleBuilderController();
	$mbc->setup();
	$mbc->action_SaveField();

	// add the field to the given module's EditView and DetailView layouts
	if ($add_to_layout == 1) {
		$layout_properties = array(
			'name' => $new_properties['name'],
			'label' => $new_properties['label']
		);

		if (isset($new_properties['customCode'])) {
			$layout_properties['customCode'] = $new_properties['customCode'];
		}
		if (isset($new_properties['customLabel'])) {
			$layout_properties['customLabel'] = $new_properties['customLabel'];
		}

		// add the field to the DetailView
		$parser = ParserFactory::getParser('layoutview', FALSE);
		$parser->init($module_name, 'DetailView', FALSE);

		$parser->_addField($layout_properties);
		$parser->writeWorkingFile();
		$parser->handleSave();

		unset($parser);

		// add the field to the EditView
		$parser = ParserFactory::getParser('layoutview', FALSE);
		$parser->init($module_name, 'EditView', FALSE);

		$parser->_addField($layout_properties);
		$parser->writeWorkingFile();
		$parser->handleSave();
	}

	return $error->get_soap_array();
}
?>