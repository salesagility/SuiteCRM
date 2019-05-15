<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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




global $current_user;

$dashletData['AOS_QuotesDashlet']['searchFields'] =
array(
'date_entered' =>
    array(
        'default' => ''
        ),
'billing_account' =>
    array(
        'default' => ''
        ),
'assigned_user_id' =>
    array(
        'type' => 'assigned_user_name',
        'default' => $current_user->name
        )
    );
$dashletData['AOS_QuotesDashlet']['columns'] =
array(
'number'=>
    array(
        'width' => '5',
        'label'   => 'LBL_LIST_NUM',
        'default' => true
        ),
'name' =>
    array(
        'width'   => '20',
        'label'   => 'LBL_LIST_NAME',
        'link'    => true,
        'default' => true
        ),
        
'billing_account' =>
    array(
        'width' => '20',
        'label'   => 'LBL_BILLING_ACCOUNT'
        ),
'billing_contact' =>
    array(
        'width' => '15',
        'label'   => 'LBL_BILLING_CONTACT'
        ),
'opportunity' =>
    array(
        'width' => '25',
        'label'   => 'LBL_OPPORTUNITY'
        ),
'stage' =>
    array(
        'width'   => '15',
        'label'   => 'LBL_STAGE',
        'default' => true
        ),
'total_amount' =>
    array(
        'width'   => '15',
        'label'   => 'LBL_GRAND_TOTAL',
        'currency_format' => true,
        'default' => true
        ),
'expiration' =>
    array(
        'width' => '15',
        'label'   => 'LBL_EXPIRATION',
        'default' => true
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
'created_by' =>
    array(
        'width'   => '8',
        'label'   => 'LBL_CREATED'
        ),
'assigned_user_name' =>
    array(
        'width'   => '8',
        'label'   => 'LBL_LIST_ASSIGNED_USER'
        ),
    );
