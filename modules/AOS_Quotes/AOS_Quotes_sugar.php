<?php
/**
 * Advanced OpenSales, Advanced, robust set of sales modules.
 * @package Advanced OpenSales for SugarCRM
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
 * @author SalesAgility <info@salesagility.com>
 */

class AOS_Quotes_sugar extends Basic {
	var $new_schema = true;
	var $module_dir = 'AOS_Quotes';
	var $object_name = 'AOS_Quotes';
	var $table_name = 'aos_quotes';
	var $importable = true;
	var $lineItems = true;

	var $disable_row_level_security = true ; // to ensure that modules created and deployed under CE will continue to function under team security if the instance is upgraded to PRO

		var $id;
		var $name;
		var $date_entered;
		var $date_modified;
		var $modified_user_id;
		var $modified_by_name;
		var $created_by;
		var $created_by_name;
		var $description;
		var $deleted;
		var $created_by_link;
		var $modified_user_link;
		var $assigned_user_id;
		var $assigned_user_name;
		var $assigned_user_link;
		var $aos_quotes_type;
		var $industry;
		var $annual_revenue;
		var $phone_fax;
		var $billing_address_street;
		var $billing_address_city;
		var $billing_address_state;
		var $billing_address_postalcode;
		var $billing_address_country;
		var $rating;
		var $phone_office;
		var $phone_alternate;
		var $website;
		var $ownership;
		var $employees;
		var $ticker_symbol;
		var $shipping_address_street;
		var $shipping_address_city;
		var $shipping_address_state;
		var $shipping_address_postalcode;
		var $shipping_address_country;
		var $email1;
		var $email_addresses_primary;
		var $approval_issue;
		var $billing_account_id;
		var $billing_account;
		var $billing_contact_id;
		var $billing_contact;
		var $expiration;
		var $number;
		var $opportunity_id;
		var $opportunity;
		var $shipping_account_id;
		var $shipping_account;
		var $template_ddown_c;
		var $shipping_contact_id;
		var $shipping_contact;
		var $subtotal_amount;
		var $tax_amount;
		var $shipping_amount;
		var $total_amount;
		var $stage;
		var $term;
		var $terms_c;
		var $approval_status;
		var $invoice_status;
	




	function AOS_Quotes_sugar(){	
		parent::Basic();
	}
	
	function bean_implements($interface){
		switch($interface){
			case 'ACL': return true;
		}
		return false;
}
		
}
?>
