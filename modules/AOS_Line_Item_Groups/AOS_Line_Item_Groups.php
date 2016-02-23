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

require_once('modules/AOS_Line_Item_Groups/AOS_Line_Item_Groups_sugar.php');
class AOS_Line_Item_Groups extends AOS_Line_Item_Groups_sugar {
	
	function AOS_Line_Item_Groups(){
		parent::AOS_Line_Item_Groups_sugar();
	}
	
	function save_groups($post_data, $parent, $key = ''){
	
		$groups = array();
        $group_count = isset($post_data[$key.'group_number']) ? count($post_data[$key.'group_number']) : 0;
        $j = 0;
		for ($i = 0; $i < $group_count; ++$i) {
		
			if($post_data[$key.'deleted'][$i] == 1){
				$this->mark_deleted($post_data[$key.'id'][$i]);
			} else {
				$product_quote_group = new AOS_Line_Item_Groups();
				foreach($this->field_defs as $field_def) {
					if(isset($post_data[$key.$field_def['name']][$i])){
						$product_quote_group->$field_def['name'] = $post_data[$key.$field_def['name']][$i];
					}
				}
                $product_quote_group->number = ++$j;
                $product_quote_group->assigned_user_id = $parent->assigned_user_id;
                $product_quote_group->currency_id = $parent->currency_id;
                $product_quote_group->parent_id = $parent->id;
                $product_quote_group->parent_type = $parent->object_name;
				$product_quote_group->save();
                $post_data[$key.'id'][$i] = $product_quote_group->id;

                if(isset($post_data[$key.'group_number'][$i])){
                    $groups[$post_data[$key.'group_number'][$i]] = $product_quote_group->id;
                }

			}
		}

        require_once('modules/AOS_Products_Quotes/AOS_Products_Quotes.php');
        $productQuote = new AOS_Products_Quotes();
        $productQuote->save_lines($post_data, $parent, $groups, 'product_');
        $productQuote->save_lines($post_data, $parent, $groups, 'service_');
	}

    function save($check_notify = FALSE){
        require_once('modules/AOS_Products_Quotes/AOS_Utils.php');
        perform_aos_save($this);
        parent::save($check_notify);
    }
}
?>
