<?php
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

/*
 * Created on May 29, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
  $searchdefs['Accounts'] = array(
					  'templateMeta' => array(
							'maxColumns' => '3', 
  							'maxColumnsBasic' => '4', 
                            'widths' => array('label' => '10', 'field' => '30'),                 
                           ),
					  'layout' => 
					  array (
					    'basic_search' => 
					    array (
					      'name' => 
					      array (
					        'name' => 'name',
					        'default' => true,
					        'width' => '10%',
					      ),
					      'current_user_only' => 
					      array (
					        'name' => 'current_user_only',
					        'label' => 'LBL_CURRENT_USER_FILTER',
					        'type' => 'bool',
					        'default' => true,
					        'width' => '10%',
					      ),
					      
					    ),
					    'advanced_search' => 
					    array (
					      'name' => 
					      array (
					        'name' => 'name',
					        'default' => true,
					        'width' => '10%',
					      ),
					      'website' => 
					      array (
					        'name' => 'website',
					        'default' => true,
					        'width' => '10%',
					      ),
					      'phone' => 
					      array (
					        'name' => 'phone',
					        'label' => 'LBL_ANY_PHONE',
					        'type' => 'name',
					        'default' => true,
					        'width' => '10%',
					      ),
					      'email' => 
					      array (
					        'name' => 'email',
					        'label' => 'LBL_ANY_EMAIL',
					        'type' => 'name',
					        'default' => true,
					        'width' => '10%',
					      ),
					      'address_street' => 
					      array (
					        'name' => 'address_street',
					        'label' => 'LBL_ANY_ADDRESS',
					        'type' => 'name',
					        'default' => true,
					        'width' => '10%',
					      ),
					      'address_city' => 
					      array (
					        'name' => 'address_city',
					        'label' => 'LBL_CITY',
					        'type' => 'name',
					        'default' => true,
					        'width' => '10%',
					      ),
					      'address_state' => 
					      array (
					        'name' => 'address_state',
					        'label' => 'LBL_STATE',
					        'type' => 'name',
					        'default' => true,
					        'width' => '10%',
					      ),
					      'address_postalcode' => 
					      array (
					        'name' => 'address_postalcode',
					        'label' => 'LBL_POSTAL_CODE',
					        'type' => 'name',
					        'default' => true,
					        'width' => '10%',
					      ),
					      'billing_address_country' => 
					      array (
					        'name' => 'billing_address_country',
					        'label' => 'LBL_COUNTRY',
					        'type' => 'name',
					        'options' => 'countries_dom',
					        'default' => true,
					        'width' => '10%',
					      ),
					      'account_type' => 
					      array (
					        'name' => 'account_type',
					        'default' => true,
					        'width' => '10%',
					      ),
					      'industry' => 
					      array (
					        'name' => 'industry',
					        'default' => true,
					        'width' => '10%',
					      ),
					      'assigned_user_id' => 
					      array (
					        'name' => 'assigned_user_id',
					        'type' => 'enum',
					        'label' => 'LBL_ASSIGNED_TO',
					        'function' => 
					        array (
					          'name' => 'get_user_array',
					          'params' => 
					          array (
					            0 => false,
					          ),
					        ),
					        'default' => true,
					        'width' => '10%',
					      ),
					      
					    ),
					  ),
);
?>