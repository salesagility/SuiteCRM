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

require_once('modules/AOS_Products_Quotes/AOS_Products_Quotes_sugar.php');
class AOS_Products_Quotes extends AOS_Products_Quotes_sugar {

    function AOS_Products_Quotes(){
        parent::AOS_Products_Quotes_sugar();
    }

    function save_lines($post_data, $parent, $groups = array(), $key = ''){

        $line_count = isset($post_data[$key.'name']) ? count($post_data[$key.'name']) : 0;
        $j = 0;
        for ($i = 0; $i < $line_count; ++$i) {

            if($post_data[$key.'deleted'][$i] == 1){
                $this->mark_deleted($post_data[$key.'id'][$i]);
            } else {
                $product_quote = new AOS_Products_Quotes();
                foreach($this->field_defs as $field_def) {
                    if(isset($post_data[$key.$field_def['name']][$i])){
                        $product_quote->$field_def['name'] = $post_data[$key.$field_def['name']][$i];
                    }
                }
                if(isset($post_data[$key.'group_number'][$i])){
                    $product_quote->group_id = $groups[$post_data[$key.'group_number'][$i]];
                }
                if(trim($product_quote->product_id) != '' && trim($product_quote->name) != '' && trim($product_quote->product_unit_price) != ''){
                    $product_quote->number = ++$j;
                    $product_quote->assigned_user_id = $parent->assigned_user_id;
                    $product_quote->parent_id = $parent->id;
                    $product_quote->currency_id = $parent->currency_id;
                    $product_quote->parent_type = $parent->object_name;
                    $product_quote->save();
                    $_POST[$key.'id'][$i] = $product_quote->id;
                }
            }
        }
    }

    function mark_lines_deleted($parent){

        require_once('modules/Relationships/Relationship.php');
        //$key = Relationship::retrieve_by_modules($parent->object_name, $this->object_name, $this->db);
        //if (!empty($key)) {
        $product_quotes = $parent->get_linked_beans('aos_products_quotes', $this->object_name);
        foreach($product_quotes as $product_quote){
            $product_quote->mark_deleted($product_quote->id);
        }
        //}
    }

    function save($check_notify = FALSE){
        require_once('modules/AOS_Products_Quotes/AOS_Utils.php');
        perform_aos_save($this);
        parent::save($check_notify);
    }
}
?>