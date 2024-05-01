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

    if (!(ACLController::checkAccess('UT_OrderSupplier', 'edit', true))) {
        ACLController::displayNoAccess();
        die;
    }

    require_once('modules/AOS_Invoices/AOS_Invoices.php');
    require_once('modules/AOS_Products_Quotes/AOS_Products_Quotes.php');

    global $timedate;
    //Setting values in Quotes
    $invoice = BeanFactory::newBean('AOS_Invoices');
    $invoice->retrieve($_REQUEST['record']);
    $invoice->invoice_status = 'Invoiced';
    $invoice->total_amt = format_number($invoice->total_amt);
    $invoice->discount_amount = format_number($invoice->discount_amount);
    $invoice->subtotal_amount = format_number($invoice->subtotal_amount);
    $invoice->tax_amount = format_number($invoice->tax_amount);
    if ($invoice->shipping_amount != null) {
        $invoice->shipping_amount = format_number($invoice->shipping_amount);
    }
    $invoice->total_amount = format_number($invoice->total_amount);
   // $invoice->save();
      

    //Setting Invoice Values
    $ordertosupplier = BeanFactory::newBean('UT_OrderSupplier');
    $rawRow = $invoice->fetched_row;
    $rawRow['id'] = '';
    $rawRow['template_ddown_c'] = ' ';
    $rawRow['quote_number'] = $rawRow['number'];
    $rawRow['number'] = '';
    $dt = explode(' ', $rawRow['date_entered']);
    $rawRow['quote_date'] = $dt[0];
    $rawRow['invoice_date'] = date('Y-m-d');
    $rawRow['total_amt'] = format_number($rawRow['total_amt']);
    $rawRow['discount_amount'] = format_number($rawRow['discount_amount']);
    $rawRow['subtotal_amount'] = format_number($rawRow['subtotal_amount']);
    $rawRow['tax_amount'] = format_number($rawRow['tax_amount']);
    $rawRow['overall_discount_amount'] = format_number($rawRow['overall_discount_amount']);
    $rawRow['other_charges_amount'] = format_number($rawRow['other_charges_amount']);
    $rawRow['date_entered'] = '';
    $rawRow['date_modified'] = '';
    if ($rawRow['shipping_amount'] != null) {
        $rawRow['shipping_amount'] = format_number($rawRow['shipping_amount']);
    }
    $rawRow['total_amount'] = format_number($rawRow['total_amount']);
    
    
    $_REQUEST['parent_id'] = $invoice->id;
    $_REQUEST['parent_type'] = 'AOS_Invoices';
    $ordertosupplier->populateFromRow($rawRow);
    
    $ordertosupplier->process_save_dates =false;
    $ordertosupplier->save();

    //Setting invoice quote relationship
    require_once('modules/Relationships/Relationship.php');
    $key = Relationship::retrieve_by_modules('AOS_Invoices', 'UT_OrderSupplier', $GLOBALS['db']);
    
    if (!empty($key)) {
        $invoice->load_relationship($key);
        $invoice->$key->add($ordertosupplier->id);
    }

    //Setting Group Line Items
    $sql = "SELECT * FROM aos_line_item_groups WHERE parent_type = 'AOS_Invoices' AND parent_id = '".$invoice->id."' AND deleted = 0";
    $result = $this->bean->db->query($sql);
    $invoiceToInvoiceGroupIds = array();
    
    $parentTotalAmt = 0;
    $parentDiscountAmount = 0;
    $parentSubtotalAmount = 0;
    $parentTaxAmount = 0;
    $parentTotalAmount = 0;
    while ($row = $this->bean->db->fetchByAssoc($result)) {
        $invoiceGroupId = $row['id'];
        $oGroup = BeanFactory::getBean("AOS_Line_Item_Groups",$invoiceGroupId);    
        $product_quotes = $oGroup->get_linked_beans('aos_products_quotes', "AOS_Products_Quotes");
        $groupTotalAmt = 0;
        $groupDiscountAmount = 0;
        $groupSubtotalAmount = 0;
        $groupTaxAmount = 0;
        $groupTotalAmount = 0;
        if(!empty($oGroup->id)) {
            foreach ($product_quotes as $product_quote) {
                if ($product_quote->product_cost_price != null) {
                    $product_quote->product_list_price = $product_quote->product_cost_price;
                }
                if(!empty($product_quote->product_discount)) {
                    if($product_quote->discount === "Percentage") {
                        $product_quote->product_unit_price = ($product_quote->product_list_price - (($product_quote->product_list_price * $product_quote->product_discount)/100));
                        $product_quote->product_discount_amount = -(($product_quote->product_list_price * $product_quote->product_discount)/100);
                    }
                    else if($product_quote->discount === "Amount") {
                        $product_quote->product_unit_price = ($product_quote->product_list_price - $product_quote->product_discount);
                        $product_quote->product_discount_amount = -($product_quote->product_discount);
                    }
                }
                else {
                    $product_quote->product_unit_price = $product_quote->product_list_price;
                }
                $product_quote->product_total_price = ($product_quote->product_qty * $product_quote->product_unit_price);
                $product_quote->vat_amt = ($product_quote->product_qty * (($product_quote->product_unit_price * $product_quote->field_defs['vat']['default'])/100));
                
                $groupTotalAmt += $product_quote->product_total_price;
                $groupDiscountAmount += abs($product_quote->product_discount_amount);
                $groupSubtotalAmount += $product_quote->product_total_price;
                $groupTaxAmount += $product_quote->vat_amt;
                $groupTotalAmount += ($product_quote->product_total_price + $product_quote->vat_amt);
            }
        }
        $row['id'] = '';
        $row['parent_id'] = $ordertosupplier->id;
        $row['parent_type'] = 'UT_OrderSupplier';
        
        if ($row['total_amt'] != null) {
            $row['total_amt'] = format_number($groupTotalAmt);
        }
        if ($row['discount_amount'] != null) {
            $row['discount_amount'] = format_number($groupDiscountAmount);
        }
        if ($row['subtotal_amount'] != null) {
            $row['subtotal_amount'] = format_number($groupSubtotalAmount);
        }
        if ($row['tax_amount'] != null) {
            $row['tax_amount'] = format_number($groupTaxAmount);
        }
        if ($row['subtotal_tax_amount'] != null) {
            $row['subtotal_tax_amount'] = format_number($row['subtotal_tax_amount']);
        }
        if ($row['total_amount'] != null) {
            $row['total_amount'] = format_number($groupTotalAmount);
        }
        //Update group total 
        $parentTotalAmt = $parentTotalAmt + $groupTotalAmt;
        $parentDiscountAmount = $parentDiscountAmount + abs($groupDiscountAmount);
        $parentSubtotalAmount = $parentSubtotalAmount + $groupSubtotalAmount;
        $parentTaxAmount = $parentTaxAmount + $groupTaxAmount;
        $parentTotalAmount = $parentTotalAmount+ $groupTotalAmount;
        
        $group_invoice = BeanFactory::newBean('AOS_Line_Item_Groups');
        $group_invoice->populateFromRow($row);
        $group_invoice->save();
        $invoiceToInvoiceGroupIds[$invoiceGroupId] = $group_invoice->id;
    }

    //Setting Line Items
    $sql = "SELECT * FROM aos_products_quotes WHERE parent_type = 'AOS_Invoices' AND parent_id = '".$invoice->id."' AND deleted = 0";
    $result = $this->bean->db->query($sql);
    while ($row = $this->bean->db->fetchByAssoc($result)) {
        $row['id'] = '';
        $row['parent_id'] = $ordertosupplier->id;
        $row['parent_type'] = 'UT_OrderSupplier';
        $row['group_id'] = $invoiceToInvoiceGroupIds[$row['group_id']];
       
        if ($row['product_cost_price'] != null) {
            //$row['product_cost_price'] = format_number($row['product_cost_price']);
            $row['product_list_price'] = format_number($row['product_cost_price']);
        }
        else
            $row['product_list_price'] = format_number($row['product_list_price']);
            
        //Set unit price    
        if(!empty($row['product_discount'])) {
            if($row['product_discount'] === "Percentage") {
                $row['product_unit_price'] = ($row['product_list_price'] - (($row['product_list_price']  * $row['product_discount'])/100));
                $row['product_discount_amount'] = -(($row['product_list_price']  * $row['product_discount'])/100);
            }
            else if($row['product_discount'] === "Amount") {
                $row['product_unit_price']  = ($row['product_list_price'] - $row['product_discount']);
                $row['product_discount_amount'] = -($row['product_discount']);
            }
            else {
                $row['product_unit_price'] = $row['product_list_price'];
            }
        }
        else {
            $row['product_unit_price'] = $row['product_list_price'];
        }
        if ($row['product_discount'] != null) {
            $row['product_discount'] = format_number($row['product_discount']);
            $row['product_discount_amount'] = format_number($row['product_discount_amount']);
        }
        $row['product_unit_price'] = ($row['product_unit_price']);

        $row['vat_amt'] = ($row['vat_amt']);
        $row['product_total_price'] = ($row['product_total_price']);
        $row['product_qty'] = ($row['product_qty']);
        
        $prod_invoice = BeanFactory::newBean('AOS_Products_Quotes');
        $prod_invoice->populateFromRow($row);
        $prod_invoice->save();
        $qty = 1; 
        if(!empty($prod_invoice->product_qty))
            $qty = $prod_invoice->product_qty;

        $prod_invoice->product_total_price = ($qty * $prod_invoice->product_unit_price);
        $prod_invoice->vat_amt = ($qty * (($prod_invoice->product_unit_price * $prod_invoice->field_defs['vat']['default'])/100));
                        
        $parentTotalAmt += $prod_invoice->product_total_price;
        $parentDiscountAmount += abs($prod_invoice->product_discount_amount);
        $parentSubtotalAmount += $prod_invoice->product_total_price;
        $parentTaxAmount += $prod_invoice->vat_amt;
        $parentTotalAmount += ($prod_invoice->product_total_price + $prod_invoice->vat_amt);
    }
    //Update Final Total
    $ordertosupplier->total_amt = $parentTotalAmt;
    $ordertosupplier->discount_amount = $parentDiscountAmount;    
    $ordertosupplier->subtotal_amount = $parentSubtotalAmount - $ordertosupplier->overall_discount_amount;
    $ordertosupplier->tax_amount = $parentTaxAmount;
    $ordertosupplier->total_amount = $parentTotalAmount + $rawRow['other_charges_amount'];
    $ordertosupplier->save();
    ob_clean();
    header('Location: index.php?module=UT_OrderSupplier&action=EditView&record='.$ordertosupplier->id);
