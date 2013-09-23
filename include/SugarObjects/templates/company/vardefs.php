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

$vardefs= array (  
'fields' => array (
   'name' => 
  array (
    'name' => 'name',
    'type' => 'name',
    'dbType' => 'varchar',
    'vname' => 'LBL_NAME',
    'len' => 150,
    'comment' => 'Name of the Company',
    'unified_search' => true,
    'full_text_search' => array('boost' => 3),
    'audited' => true,
	'required'=>true,
    'importable' => 'required',
    'merge_filter' => 'selected',  //field will be enabled for merge and will be a part of the default search criteria..other valid values for this property are enabled and disabled, default value is disabled.
                            //property value is case insensitive.
  ),
   
   strtolower($object_name).'_type' => 
  array (
    'name' => strtolower($object_name).'_type',
    'vname' => 'LBL_TYPE',
    'type' => 'enum',
    'options' => strtolower($object_name).'_type_dom',
    'len'=>50,
    'comment' => 'The Company is of this type',
  ),  
'industry' => 
  array (
    'name' => 'industry',
    'vname' => 'LBL_INDUSTRY',
    'type' => 'enum',
    'options' => 'industry_dom',
    'len'=>50,
    'comment' => 'The company belongs in this industry',
    'merge_filter' => 'enabled',
  ),
    'annual_revenue' => 
  array (
    'name' => 'annual_revenue',
    'vname' => 'LBL_ANNUAL_REVENUE',
    'type' => 'varchar',
    'len' => 100,
    'comment' => 'Annual revenue for this company',
    'merge_filter' => 'enabled',
  ),
  'phone_fax' => 
  array (
    'name' => 'phone_fax',
    'vname' => 'LBL_FAX',
    'type' => 'phone',
    'dbType' => 'varchar',
    'len' => 100,
    'unified_search' => true,
    'full_text_search' => array('boost' => 1),
    'comment' => 'The fax phone number of this company',
  ), 
  
  'billing_address_street' => 
  array (
    'name' => 'billing_address_street',
    'vname' => 'LBL_BILLING_ADDRESS_STREET',
    'type' => 'varchar',
    'len' => '150',
    'comment' => 'The street address used for billing address',
    'group'=>'billing_address',
    'merge_filter' => 'enabled',
  ),
  'billing_address_street_2' => 
  array (
    'name' => 'billing_address_street_2',
    'vname' => 'LBL_BILLING_ADDRESS_STREET_2',
    'type' => 'varchar',
    'len' => '150',
    'source'=>'non-db',
  ),
  'billing_address_street_3' => 
  array (
    'name' => 'billing_address_street_3',
    'vname' => 'LBL_BILLING_ADDRESS_STREET_3',
    'type' => 'varchar',
    'len' => '150',
    'source'=>'non-db',
  ),
  'billing_address_street_4' => 
  array (
    'name' => 'billing_address_street_4',
    'vname' => 'LBL_BILLING_ADDRESS_STREET_4',
    'type' => 'varchar',
    'len' => '150',
    'source'=>'non-db',
  ),
  'billing_address_city' => 
  array (
    'name' => 'billing_address_city',
    'vname' => 'LBL_BILLING_ADDRESS_CITY',
    'type' => 'varchar',
    'len' => '100',
    'comment' => 'The city used for billing address',
    'group'=>'billing_address',
    'merge_filter' => 'enabled',
  ),
  'billing_address_state' => 
  array (
    'name' => 'billing_address_state',
    'vname' => 'LBL_BILLING_ADDRESS_STATE',
    'type' => 'varchar',
    'len' => '100',
    'group'=>'billing_address',
    'comment' => 'The state used for billing address',
    'merge_filter' => 'enabled',
  ),
  'billing_address_postalcode' => 
  array (
    'name' => 'billing_address_postalcode',
    'vname' => 'LBL_BILLING_ADDRESS_POSTALCODE',
    'type' => 'varchar',
    'len' => '20',
    'group'=>'billing_address',
    'comment' => 'The postal code used for billing address',
    'merge_filter' => 'enabled',
    
  ),
  'billing_address_country' => 
  array (
    'name' => 'billing_address_country',
    'vname' => 'LBL_BILLING_ADDRESS_COUNTRY',
    'type' => 'varchar',
    'group'=>'billing_address',
    'comment' => 'The country used for the billing address',
    'merge_filter' => 'enabled',
  ),
   'rating' => 
  array (
    'name' => 'rating',
    'vname' => 'LBL_RATING',
    'type' => 'varchar',
    'len' => 100,
    'comment' => 'An arbitrary rating for this company for use in comparisons with others',
  ),
    'phone_office' => 
  array (
    'name' => 'phone_office',
    'vname' => 'LBL_PHONE_OFFICE',
    'type' => 'phone',
    'dbType' => 'varchar',
    'len' => 100,
    'audited'=>true,
    'unified_search' => true,  
    'full_text_search' => array('boost' => 1),
    'comment' => 'The office phone number',
    'merge_filter' => 'enabled',
  ),
    'phone_alternate' => 
  array (
    'name' => 'phone_alternate',
    'vname' => 'LBL_PHONE_ALT',
    'type' => 'phone',
    'group'=>'phone_office',
    'dbType' => 'varchar',
    'len' => 100,
    'unified_search' => true,
    'full_text_search' => array('boost' => 1),
    'comment' => 'An alternate phone number',
    'merge_filter' => 'enabled',
  ),
   'website' => 
  array (
    'name' => 'website',
    'vname' => 'LBL_WEBSITE',
    'type' => 'url',
    'dbType' => 'varchar',
    'len' => 255,
    'comment' => 'URL of website for the company',
  ),
   'ownership' => 
  array (
    'name' => 'ownership',
    'vname' => 'LBL_OWNERSHIP',
    'type' => 'varchar',
    'len' => 100,
    'comment' => '',
  ),
   'employees' => 
  array (
    'name' => 'employees',
    'vname' => 'LBL_EMPLOYEES',
    'type' => 'varchar',
    'len' => 10,
    'comment' => 'Number of employees, varchar to accomodate for both number (100) or range (50-100)',
  ),
  'ticker_symbol' => 
  array (
    'name' => 'ticker_symbol',
    'vname' => 'LBL_TICKER_SYMBOL',
    'type' => 'varchar',
    'len' => 10,
    'comment' => 'The stock trading (ticker) symbol for the company',
    'merge_filter' => 'enabled',
  ),
  'shipping_address_street' => 
  array (
    'name' => 'shipping_address_street',
    'vname' => 'LBL_SHIPPING_ADDRESS_STREET',
    'type' => 'varchar',
    'len' => 150,
    'group'=>'shipping_address',
    'comment' => 'The street address used for for shipping purposes',
    'merge_filter' => 'enabled',
  ),
  'shipping_address_street_2' => 
  array (
    'name' => 'shipping_address_street_2',
    'vname' => 'LBL_SHIPPING_ADDRESS_STREET_2',
    'type' => 'varchar',
    'len' => 150,
    'source'=>'non-db',
  ),
  'shipping_address_street_3' => 
  array (
    'name' => 'shipping_address_street_3',
    'vname' => 'LBL_SHIPPING_ADDRESS_STREET_3',
    'type' => 'varchar',
    'len' => 150,
    'source'=>'non-db',
  ),
  'shipping_address_street_4' => 
  array (
    'name' => 'shipping_address_street_4',
    'vname' => 'LBL_SHIPPING_ADDRESS_STREET_4',
    'type' => 'varchar',
    'len' => 150,
    'source'=>'non-db',
  ),    
  'shipping_address_city' => 
  array (
    'name' => 'shipping_address_city',
    'vname' => 'LBL_SHIPPING_ADDRESS_CITY',
    'type' => 'varchar',
    'len' => 100,
    'group'=>'shipping_address',
    'comment' => 'The city used for the shipping address',
    'merge_filter' => 'enabled',
  ),
  'shipping_address_state' => 
  array (
    'name' => 'shipping_address_state',
    'vname' => 'LBL_SHIPPING_ADDRESS_STATE',
    'type' => 'varchar',
    'len' => 100,
    'group'=>'shipping_address',
    'comment' => 'The state used for the shipping address',
    'merge_filter' => 'enabled',
  ),
  'shipping_address_postalcode' => 
  array (
    'name' => 'shipping_address_postalcode',
    'vname' => 'LBL_SHIPPING_ADDRESS_POSTALCODE',
    'type' => 'varchar',
    'len' => 20,
    'group'=>'shipping_address',
    'comment' => 'The zip code used for the shipping address',
    'merge_filter' => 'enabled',
  ),
  'shipping_address_country' => 
  array (
    'name' => 'shipping_address_country',
    'vname' => 'LBL_SHIPPING_ADDRESS_COUNTRY',
    'type' => 'varchar',
    'group'=>'shipping_address',
    'comment' => 'The country used for the shipping address',
    'merge_filter' => 'enabled',
  ),
  
  
'email1' => array(
	'name'		=> 'email1',
	'vname'		=> 'LBL_EMAIL',
	'group'=>'email1',
	'type'		=> 'varchar',
	'function'	=> array(
	'name'		=> 'getEmailAddressWidget',
	   'returns'	=> 'html'
    ),
	'source'	=> 'non-db',
    'studio' => array('editField' => true, 'searchview' => false),
    'full_text_search' => array('boost' => 3, 'analyzer' => 'whitespace'), //bug 54567
), 
  
  'email_addresses_primary' => 
  array (
    'name' => 'email_addresses_primary',
    'type' => 'link',
    'relationship' => strtolower($object_name).'_email_addresses_primary',
    'source' => 'non-db',
    'vname' => 'LBL_EMAIL_ADDRESS_PRIMARY',
    'duplicate_merge' => 'disabled',
  ),  
  
  'email_addresses' =>
    array (
        'name' => 'email_addresses',
        'type' => 'link',
        'relationship' => strtolower($object_name).'_email_addresses',
        'source' => 'non-db',
        'vname' => 'LBL_EMAIL_ADDRESSES',
        'reportable'=>false,
        'unified_search' => true,
        'rel_fields' => array('primary_address' => array('type'=>'bool')),
    ),
    // Used for non-primary mail import
    'email_addresses_non_primary'=>
    array(
        'name' => 'email_addresses_non_primary',
        'type' => 'email',
        'source' => 'non-db',
        'vname' =>'LBL_EMAIL_NON_PRIMARY',
        'studio' => false,
        'reportable'=>false,
        'massupdate' => false,
    ),
),
'relationships'=>array(
    strtolower($module).'_email_addresses' => 
    array(
        'lhs_module'=> $module, 'lhs_table'=> strtolower($module), 'lhs_key' => 'id',
        'rhs_module'=> 'EmailAddresses', 'rhs_table'=> 'email_addresses', 'rhs_key' => 'id',
        'relationship_type'=>'many-to-many',
        'join_table'=> 'email_addr_bean_rel', 'join_key_lhs'=>'bean_id', 'join_key_rhs'=>'email_address_id', 
        'relationship_role_column'=>'bean_module',
        'relationship_role_column_value'=>$module
    ),
    strtolower($module).'_email_addresses_primary' => 
    array('lhs_module'=> $module, 'lhs_table'=> strtolower($module), 'lhs_key' => 'id',
        'rhs_module'=> 'EmailAddresses', 'rhs_table'=> 'email_addresses', 'rhs_key' => 'id',
        'relationship_type'=>'many-to-many',
        'join_table'=> 'email_addr_bean_rel', 'join_key_lhs'=>'bean_id', 'join_key_rhs'=>'email_address_id', 
        'relationship_role_column'=>'primary_address', 
        'relationship_role_column_value'=>'1'
    ),
)
);
