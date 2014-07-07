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


global $mod_strings;

$popupMeta = array(
	'moduleMain' => 'Account',
	'varName' => 'ACCOUNT',
	'orderBy' => 'name',
	'whereClauses' => array(
		'name' => 'accounts.name',
		'billing_address_city' => 'accounts.billing_address_city',
		'phone_office' => 'accounts.phone_office'
	),
	'searchInputs' => array('name', 'billing_address_city', 'phone_office'),
	'create' => array(
		'formBase' => 'AccountFormBase.php',
		'formBaseClass' => 'AccountFormBase',
		'getFormBodyParams' => array('','','AccountSave'),
		'createButton' => 'LNK_NEW_ACCOUNT'
	),
	'listviewdefs' => array(
		'NAME' => array(
			'width' => '40', 
			'label' => 'LBL_LIST_ACCOUNT_NAME', 
			'link' => true,	
			'default' => true,								        
		),
	    'BILLING_ADDRESS_STREET' => array(
			'width' => '10', 
			'label' => 'LBL_BILLING_ADDRESS_STREET',
			'default' => false,										        
		),		
		'BILLING_ADDRESS_CITY' => array(
			'width' => '10', 
			'label' => 'LBL_LIST_CITY',
			'default' => true,										        
		),
		'BILLING_ADDRESS_STATE' => array(
        	'width' => '7', 
        	'label' => 'LBL_STATE',
        	'default' => true,									        	
		),
        'BILLING_ADDRESS_COUNTRY' => array(
	        'width' => '10', 
	        'label' => 'LBL_COUNTRY',
	        'default' => true,
		),
	    'BILLING_ADDRESS_POSTALCODE' => array(
			'width' => '10', 
			'label' => 'LBL_BILLING_ADDRESS_POSTALCODE',
			'default' => false,										        
		),	
	    'SHIPPING_ADDRESS_STREET' => array(
			'width' => '10', 
			'label' => 'LBL_SHIPPING_ADDRESS_STREET',
			'default' => false,										        
		),		
		'SHIPPING_ADDRESS_CITY' => array(
			'width' => '10', 
			'label' => 'LBL_LIST_CITY',
			'default' => false,										        
		),
		'SHIPPING_ADDRESS_STATE' => array(
        	'width' => '7', 
        	'label' => 'LBL_STATE',
        	'default' => false,									        	
		),
        'SHIPPING_ADDRESS_COUNTRY' => array(
	        'width' => '10', 
	        'label' => 'LBL_COUNTRY',
	        'default' => false,
		),
	    'SHIPPING_ADDRESS_POSTALCODE' => array(
			'width' => '10', 
			'label' => 'LBL_SHIPPING_ADDRESS_POSTALCODE',
			'default' => false,										        
		),			
		'ASSIGNED_USER_NAME' => array(
	        'width' => '2', 
	        'label' => 'LBL_LIST_ASSIGNED_USER',
	        'default' => true,
		),
	    'PHONE_OFFICE' => array(
		    'width' => '10', 
			'label' => 'LBL_LIST_PHONE',
		    'default' => false
		),		
	),
	'searchdefs'   => array(
	 	'name', 
		'billing_address_city', 
		'billing_address_state',
		'billing_address_country',
		'email',
		array(
			'name' => 'assigned_user_id', 
			'label'=>'LBL_ASSIGNED_TO', 
			'type' => 'enum', 
			'function' => array('name' => 'get_user_array', 'params' => array(false))
		),
	)
);
?>
