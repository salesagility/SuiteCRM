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

    if(!(ACLController::checkAccess('AOS_Contracts', 'edit', true))){
        ACLController::displayNoAccess();
        die;
    }

	require_once('modules/AOS_Quotes/AOS_Quotes.php');
	require_once('modules/AOS_Contracts/AOS_Contracts.php');
	
	//Setting values in Quotes
	$quote = new AOS_Quotes();
	$quote->retrieve($_REQUEST['record']);

	//Setting Contract Values
	$contract = new AOS_Contracts();
	$contract->name = $quote->name;
	$contract->assigned_user_id = $quote->assigned_user_id;
	$contract->total_contract_value = format_number($quote->total_amount);
	$contract->contract_account_id = $quote->billing_account_id;
    $contract->contact_id = $quote->billing_contact_id;
	$contract->opportunity_id = $quote->opportunity_id;

    $contract->total_amt = $quote->total_amt;
    $contract->subtotal_amount = $quote->subtotal_amount;
    $contract->discount_amount = $quote->discount_amount;
    $contract->tax_amount = $quote->tax_amount;
    $contract->shipping_amount = $quote->shipping_amount;
    $contract->shipping_tax = $quote->shipping_tax;
    $contract->shipping_tax_amt = $quote->shipping_tax_amt;
    $contract->total_amount = $quote->total_amount;
    $contract->currency_id = $quote->currency_id;

    $contract->save();

    $group_id_map = array();

    //Setting Group Line Items
    $sql = "SELECT * FROM aos_line_item_groups WHERE parent_type = 'AOS_Quotes' AND parent_id = '".$quote->id."' AND deleted = 0";

    $result = $this->bean->db->query($sql);
    while ($row = $this->bean->db->fetchByAssoc($result)) {
        $old_id = $row['id'];
        $row['id'] = '';
        $row['parent_id'] = $contract->id;
        $row['parent_type'] = 'AOS_Contracts';
        if($row['total_amt'] != null) $row['total_amt'] = format_number($row['total_amt']);
        if($row['discount_amount'] != null) $row['discount_amount'] = format_number($row['discount_amount']);
        if($row['subtotal_amount'] != null) $row['subtotal_amount'] = format_number($row['subtotal_amount']);
        if($row['tax_amount'] != null) $row['tax_amount'] = format_number($row['tax_amount']);
        if($row['subtotal_tax_amount'] != null) $row['subtotal_tax_amount'] = format_number($row['subtotal_tax_amount']);
        if($row['total_amount'] != null) $row['total_amount'] = format_number($row['total_amount']);
        $group_contract = new AOS_Line_Item_Groups();
        $group_contract->populateFromRow($row);
        $group_contract->save();
        $group_id_map[$old_id] = $group_contract->id;
    }


    //Setting Line Items
    $sql = "SELECT * FROM aos_products_quotes WHERE parent_type = 'AOS_Quotes' AND parent_id = '".$quote->id."' AND deleted = 0";
    $result = $this->bean->db->query($sql);
    while ($row = $this->bean->db->fetchByAssoc($result)) {
        $row['id'] = '';
        $row['parent_id'] = $contract->id;
        $row['parent_type'] = 'AOS_Contracts';
        if($row['product_cost_price'] != null){
            $row['product_cost_price'] = format_number($row['product_cost_price']);
        }
        $row['product_list_price'] = format_number($row['product_list_price']);
        if($row['product_discount'] != null){
            $row['product_discount'] = format_number($row['product_discount']);
            $row['product_discount_amount'] = format_number($row['product_discount_amount']);
        }
        $row['product_unit_price'] = format_number($row['product_unit_price']);
        $row['vat_amt'] = format_number($row['vat_amt']);
        $row['product_total_price'] = format_number($row['product_total_price']);
        $row['product_qty'] = format_number($row['product_qty']);
        $row['group_id'] = $group_id_map[$row['group_id']];

        $prod_contract = new AOS_Products_Quotes();
        $prod_contract->populateFromRow($row);
        $prod_contract->save();
    }

	//Setting contract quote relationship
	require_once('modules/Relationships/Relationship.php');
	$key = Relationship::retrieve_by_modules('AOS_Quotes', 'AOS_Contracts', $GLOBALS['db']);
	if (!empty($key)) {
		$quote->load_relationship($key);
		$quote->$key->add($contract->id);
	} 
	ob_clean();
	header('Location: index.php?module=AOS_Contracts&action=EditView&record='.$contract->id);
?>
