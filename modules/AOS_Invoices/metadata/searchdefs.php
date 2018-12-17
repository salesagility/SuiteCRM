<?php
/**
 * Products, Quotations & Invoices modules.
 * Extensions to SugarCRM
 * @package Advanced OpenSales for SugarCRM
 * @subpackage Products
 * @copyright SalesAgility Ltd http://www.salesagility.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * @author SalesAgility Ltd <support@salesagility.com>
 */

/*
 * Created on Aug 2, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 $module_name = 'AOS_Invoices';
 $_module_name = 'aos_invoices';
  $searchdefs[$module_name] = array(
                    'templateMeta' => array(
                            'maxColumns' => '3',
                            'widths' => array('label' => '10', 'field' => '30'),
                           ),
                    'layout' => array(
                                'basic_search' =>
                        array(
                          'name' =>
                          array(
                            'name' => 'name',
                            'default' => true,
                            'width' => '10%',
                          ),
                          'current_user_only' =>
                          array(
                            'name' => 'current_user_only',
                            'label' => 'LBL_CURRENT_USER_FILTER',
                            'type' => 'bool',
                            'default' => true,
                            'width' => '10%',
                          ),

                            'favorites_only' =>  array('name' => 'favorites_only','label' => 'LBL_FAVORITES_FILTER','type' => 'bool',),
                          
                        ),
                        'advanced_search' => array(
                            'name',
                            'billing_contact',
                            'billing_account',
                            'number',
                            'total_amount',
                            'due_date',
                            'status',
                            array('name' => 'assigned_user_id', 'type' => 'enum', 'label' => 'LBL_ASSIGNED_TO', 'function' => array('name' => 'get_user_array', 'params' => array(false))),
                            
                            
                        ),
                    ),
               );
