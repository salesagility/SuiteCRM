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




global $current_user;

$dashletData['MyAccountsDashlet']['searchFields'] = array('date_entered'     => array('default' => ''),
                                                          'account_type'    => array('default' => ''),
 														  'industry'    => array('default' => ''),
														  'billing_address_country' => array('default'=>''),
                                                          'assigned_user_id' => array('type'    => 'assigned_user_name', 
                                                                                      'default' => $current_user->name,
																					  'label' => 'LBL_ASSIGNED_TO'));
$dashletData['MyAccountsDashlet']['columns'] =  array('name' => array('width'   => '40', 
                                                                      'label'   => 'LBL_LIST_ACCOUNT_NAME',
                                                                      'link'    => true,
                                                                      'default' => true),
                                                      'website' => array('width' => '8',
                                                                         'label' => 'LBL_WEBSITE',
																		 'default' => true), 
                                                      'phone_office' => array('width'   => '15', 
                                                                              'label'   => 'LBL_LIST_PHONE',
                                                                              'default' => true),
                                                      'phone_fax' => array('width' => '8',
                                                                          'label' => 'LBL_PHONE_FAX'),
                                                      'phone_alternate' => array('width' => '8',
                                                                                 'label' => 'LBL_OTHER_PHONE'),
                                                      'billing_address_city' => array('width' => '8',
                                                                                      'label' => 'LBL_BILLING_ADDRESS_CITY'),
                                                      'billing_address_street' => array('width' => '8',
                                                                                        'label' => 'LBL_BILLING_ADDRESS_STREET'),
                                                      'billing_address_state' => array('width' => '8',
                                                                                       'label' => 'LBL_BILLING_ADDRESS_STATE'),
                                                      'billing_address_postalcode' => array('width' => '8',
                                                                                            'label' => 'LBL_BILLING_ADDRESS_POSTALCODE'),
                                                      'billing_address_country' => array('width' => '8',
                                                                                         'label' => 'LBL_BILLING_ADDRESS_COUNTRY',
																					     'default' => true),
                                                      'shipping_address_city' => array('width' => '8',
                                                                                       'label' => 'LBL_SHIPPING_ADDRESS_CITY'),
                                                      'shipping_address_street' => array('width' => '8',
                                                                                        'label' => 'LBL_SHIPPING_ADDRESS_STREET'),
                                                      'shipping_address_state' => array('width' => '8',
                                                                                        'label' => 'LBL_SHIPPING_ADDRESS_STATE'),
                                                      'shipping_address_postalcode' => array('width' => '8',
                                                                                             'label' => 'LBL_SHIPPING_ADDRESS_POSTALCODE'),
                                                      'shipping_address_country' => array('width' => '8',
                                                                                          'label' => 'LBL_SHIPPING_ADDRESS_COUNTRY'),
                                                      'email1' => array('width' => '8',
                                                                        'label' => 'LBL_EMAIL_ADDRESS_PRIMARY'),
                                                      'parent_name' => array('width'    => '15',
                                                                              'label'    => 'LBL_MEMBER_OF',
                                                                              'sortable' => false),
                                                      'date_entered' => array('width'   => '15', 
                                                                              'label'   => 'LBL_DATE_ENTERED'),
                                                      'date_modified' => array('width'   => '15', 
                                                                              'label'   => 'LBL_DATE_MODIFIED'),    
                                                      'created_by' => array('width'   => '8', 
                                                                            'label'   => 'LBL_CREATED'),
                                                      'assigned_user_name' => array('width'   => '8', 
                                                                                     'label'   => 'LBL_LIST_ASSIGNED_USER'),
                                               );
?>
