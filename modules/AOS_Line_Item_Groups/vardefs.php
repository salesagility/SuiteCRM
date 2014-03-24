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
 * @author Salesagility Ltd <support@salesagility.com>
 */

$dictionary['AOS_Line_Item_Groups'] = array(
	'table'=>'aos_line_item_groups',
	'audited'=>true,
	'fields'=>array (
  'total_amt' => 
  array (
    'required' => false,
    'name' => 'total_amt',
    'vname' => 'LBL_TOTAL_AMT',
    'type' => 'currency',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => 1,
    'reportable' => true,
    'len' => '26,6',
  ),
  'total_amt_usdollar' =>
    array (
        'name' => 'total_amt_usdollar',
        'vname' => 'LBL_TOTAL_AMT_USDOLLAR',
        'type' => 'currency',
        'group'=>'total_amt',
        'disable_num_format' => true,
        'duplicate_merge'=>'0',
        'audited'=>true,
        'comment' => '',
        'studio' => array(
            'editview'=>false,
            'detailview'=>false,
            'quickcreate'=>false,
        ),
        'len' => '26,6',
    ),
   'name' =>
    array (
        'name' => 'name',
        'vname' => 'LBL_NAME',
        'type' => 'name',
        'dbType' => 'varchar',
        'len' => 255,
        'unified_search' => true,
        'required' => false,
  ),
  'discount_amount' => 
  array (
    'required' => false,
    'name' => 'discount_amount',
    'vname' => 'LBL_DISCOUNT_AMOUNT',
    'type' => 'currency',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => 1,
    'reportable' => true,
    'len' => '26,6',
  ),
  'discount_amount_usdollar' =>
    array (
        'name' => 'discount_amount_usdollar',
        'vname' => 'LBL_DISCOUNT_AMOUNT_USDOLLAR',
        'type' => 'currency',
        'group'=>'discount_amount',
        'disable_num_format' => true,
        'duplicate_merge'=>'0',
        'audited'=>true,
        'comment' => '',
        'studio' => array(
            'editview'=>false,
            'detailview'=>false,
            'quickcreate'=>false,
        ),
        'len' => '26,6',
    ),
  'subtotal_amount' => 
  array (
    'required' => false,
    'name' => 'subtotal_amount',
    'vname' => 'LBL_SUBTOTAL_AMOUNT',
    'type' => 'currency',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => 1,
    'reportable' => true,
    'len' => '26,6',
  ),
  'subtotal_amount_usdollar' =>
    array (
        'name' => 'subtotal_amount_usdollar',
        'vname' => 'LBL_SUBTOTAL_AMOUNT_USDOLLAR',
        'type' => 'currency',
        'group'=>'subtotal_amount',
        'disable_num_format' => true,
        'duplicate_merge'=>'0',
        'audited'=>true,
        'comment' => '',
        'studio' => array(
            'editview'=>false,
            'detailview'=>false,
            'quickcreate'=>false,
        ),
        'len' => '26,6',
    ),
  'tax_amount' => 
  array (
    'required' => false,
    'name' => 'tax_amount',
    'vname' => 'LBL_TAX_AMOUNT',
    'type' => 'currency',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => 1,
    'reportable' => true,
    'len' => '26,6',
  ),
  'tax_amount_usdollar' =>
    array (
        'name' => 'tax_amount_usdollar',
        'vname' => 'LBL_TAX_AMOUNT_USDOLLAR',
        'type' => 'currency',
        'group'=>'tax_amount',
        'disable_num_format' => true,
        'duplicate_merge'=>'0',
        'audited'=>true,
        'comment' => '',
        'studio' => array(
            'editview'=>false,
            'detailview'=>false,
            'quickcreate'=>false,
        ),
        'len' => '26,6',
    ),
  'subtotal_tax_amount' => 
  array (
    'required' => false,
    'name' => 'subtotal_tax_amount',
    'vname' => 'LBL_SUBTOTAL_TAX_AMOUNT',
    'type' => 'currency',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => 1,
    'reportable' => true,
    'len' => '26,6',
  ),
  'subtotal_tax_amount_usdollar' =>
    array (
        'name' => 'subtotal_tax_amount_usdollar',
        'vname' => 'LBL_SUBTOTAL_TAX_AMOUNT_USDOLLAR',
        'type' => 'currency',
        'group'=>'subtotal_tax_amount',
        'disable_num_format' => true,
        'duplicate_merge'=>'0',
        'audited'=>true,
        'comment' => '',
        'studio' => array(
            'editview'=>false,
            'detailview'=>false,
            'quickcreate'=>false,
        ),
        'len' => '26,6',
    ),
  'total_amount' =>
  array (
    'required' => false,
    'name' => 'total_amount',
    'vname' => 'LBL_GROUP_TOTAL',
    'type' => 'currency',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'len' => '26,6',
    'enable_range_search' => true,
    'options' => 'numeric_range_search_dom',
  ),
  'total_amount_usdollar' =>
    array (
        'name' => 'total_amount_usdollar',
        'vname' => 'LBL_GROUP_TOTAL_USDOLLAR',
        'type' => 'currency',
        'group'=>'amount',
        'disable_num_format' => true,
        'duplicate_merge'=>'0',
        'audited'=>true,
        'comment' => '',
        'studio' => array(
            'editview'=>false,
            'detailview'=>false,
            'quickcreate'=>false,
        ),
        'len' => '26,6',
    ),
  'parent_name' => 
  array (
    'required' => false,
    'source' => 'non-db',
    'name' => 'parent_name',
    'vname' => 'LBL_FLEX_RELATE',
    'type' => 'parent',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'false',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => 1,
    'reportable' => 0,
    'len' => 25,
    'options' => 'product_quote_parent_type_dom',
    'studio' => 'visible',
    'type_name' => 'parent_type',
    'id_name' => 'parent_id',
    'parent_type' => 'record_type_display',
  ),
  'parent_type' => 
  array (
    'required' => false,
    'name' => 'parent_type',
    'vname' => 'LBL_PARENT_TYPE',
    'type' => 'parent_type',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'false',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
    'len' => 100,
    'dbType' => 'varchar',
    'studio' => 'hidden',
  ),
  'parent_id' => 
  array (
    'required' => false,
    'name' => 'parent_id',
    'vname' => 'LBL_PARENT_ID',
    'type' => 'id',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'false',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
    'len' => 36,
  ),
    'number' =>
    array (
        'required' => false,
        'name' => 'number',
        'vname' => 'LBL_LIST_NUM',
        'type' => 'int',
        'massupdate' => 0,
        'comments' => '',
        'help' => '',
        'importable' => 'true',
        'duplicate_merge' => 'disabled',
        'duplicate_merge_dom_value' => '0',
        'audited' => 0,
        'reportable' => true,
        'len' => '11',
        'disable_num_format' => '',
    ),
  'currency_id' =>
    array (
        'required' => false,
        'name' => 'currency_id',
        'vname' => 'LBL_CURRENCY',
        'type' => 'id',
        'massupdate' => 0,
        'comments' => '',
        'help' => '',
        'importable' => 'true',
        'duplicate_merge' => 'disabled',
        'duplicate_merge_dom_value' => 0,
        'audited' => false,
        'reportable' => false,
        'len' => 36,
        'size' => '20',
        'studio' => 'visible',
        'function' =>
            array (
                'name' => 'getCurrencyDropDown',
                'returns' => 'html',
            ),
    ),
  'aos_products_quotes' =>
  array (
  'name' => 'aos_products_quotes',
    'type' => 'link',
    'relationship' => 'groups_aos_product_quotes',
    'module'=>'AOS_Products_Quotes',
    'bean_name'=>'AOS_Products_Quotes',
    'source'=>'non-db',
 ),
 
),
'relationships'=>array (
	'groups_aos_product_quotes' =>
	array (
	'lhs_module'=> 'AOS_Products_Quotes_Groups', 
	'lhs_table'=> 'aos_products_quotes_groups', 
	'lhs_key' => 'id',
	'rhs_module'=> 'AOS_Products_Quotes', 
	'rhs_table'=> 'aos_products_quotes', 
	'rhs_key' => 'group_id',
	'relationship_type'=>'one-to-many',
	),
),
	'optimistic_lock'=>true,
);
require_once('include/SugarObjects/VardefManager.php');
VardefManager::createVardef('AOS_Line_Item_Groups','AOS_Line_Item_Groups', array('basic','assignable'));
