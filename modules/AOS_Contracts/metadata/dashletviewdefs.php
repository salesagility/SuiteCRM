<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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
 * @author Salesagility Ltd <support@salesagility.com>
 */




global $current_user;

$dashletData['AOS_ContractsDashlet']['searchFields'] = 
array(
'status' => 
	array(
		'default' => ''
		),
'end_date' => 
	array(
		'default' => ''
		),
'assigned_user_id' => 
	array(
		'type' => 'assigned_user_name', 
		'default' => $current_user->name
		)
	);
	
$dashletData['AOS_ContractsDashlet']['columns'] =  
array(   
'name' => 
	array(
		'width'   => '25', 
		'label'   => 'LBL_LIST_NAME',
		'link'    => true,
		'default' => true
		),     
'status' =>   
	array(
		'width'   => '12', 
		'label'   => 'LBL_STATUS',
		'default' => true
		), 
'total_contract_value'=> 
	array(
		'width'   => '12', 
		'label'   => 'LBL_TOTAL_CONTRACT_VALUE',
		'currency_format' => true,
		'default' => true
		),
'start_date' => 
	array(
		'width'   => '12', 
		'label'   => 'LBL_START_DATE'
		),
'end_date' =>
	array(
		'width'   => '12', 
		'label'   => 'LBL_END_DATE',
		'default' => true
		),
'renewal_reminder_date'=>
	array(
		'width'   => '15', 
		'label'   => 'LBL_RENEWAL_REMINDER_DATE'
		),   
'assigned_user_name' =>
	array(
		'width'   => '12', 
		'label'   => 'LBL_ASSIGNED_TO_NAME'
		),
'created_by' => 
	array(
		'width'   => '8', 
		'label'   => 'LBL_CREATED'
		),        
'date_entered' => 
	array(
		'width'   => '15', 
		'label'   => 'LBL_DATE_ENTERED'
		),
'date_modified' => 
	array(
		'width'   => '15', 
		'label'   => 'LBL_DATE_MODIFIED'
		),
	);
