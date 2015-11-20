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
 
class aowTemplateParser{
		function parse_template_bean($string, $key, &$focus) {
		global $app_strings;
			$repl_arr = array();
			
			foreach($focus->field_defs as $field_def) {
                if($field_def['type'] == 'currency'){
                    $repl_arr[$key."_".$field_def['name']] = currency_format_number($focus->$field_def['name'],$params = array('currency_symbol' => false));
                }
				else if($field_def['type'] == 'enum' && isset($field_def['options'])) {
                    $repl_arr[$key."_".$field_def['name']] = translate($field_def['options'],$focus->module_dir,$focus->$field_def['name']);
				}
                else if($field_def['type'] == 'multienum' && isset($field_def['options'])) {
					$repl_arr[$key."_".$field_def['name']] = implode(', ', unencodeMultienum($focus->$field_def['name']));
				}
                else {
					$repl_arr[$key."_".$field_def['name']] = $focus->$field_def['name'];
				}
			} // end foreach()
	
			krsort($repl_arr);
			reset($repl_arr);
	
			foreach ($repl_arr as $name=>$value) {
				if (strpos($name,'product_discount')>0){
					if($value != '' && $value != '0.00')
					{
						if($repl_arr['aos_products_quotes_discount'] == 'Percentage')
						{
							$sep = get_number_seperators();
							$value=rtrim(rtrim(format_number($value), '0'),$sep[1]);//.$app_strings['LBL_PERCENTAGE_SYMBOL'];
						}
						else
						{
							$value=currency_format_number($value,$params = array('currency_symbol' => false));
						}
					}
					else
					{
						$value='';
					}
				}
				if ($name === 'aos_products_product_image'){
				$value = '<img src="'.$value.'"width="50" height="50"/>';
				}
				if ($name === 'aos_products_quotes_product_qty'){
					$sep = get_number_seperators();
					$value=rtrim(rtrim(format_number($value), '0'),$sep[1]);
				}
				if ($name === 'aos_products_quotes_vat'||strpos($name,'pct')>0 || strpos($name,'percent')>0 || strpos($name,'percentage')>0){
					$sep = get_number_seperators();
					$value=rtrim(rtrim(format_number($value), '0'),$sep[1]).$app_strings['LBL_PERCENTAGE_SYMBOL'];
				}
				if (strpos($name,'date')>0 || strpos($name,'expiration')>0){
					if($value != ''){
					$dt = explode(' ',$value);
					$value = $dt[0];
					}
				}
				if($value != '' && is_string($value)) {
					$string = str_replace("\$$name", $value, $string);
				} else if(strpos($name,'address')>0) {
					$string = str_replace("\$$name<br />", '', $string);
					$string = str_replace("\$$name <br />", '', $string);
					$string = str_replace("\$$name", '', $string);
				} else {
					$string = str_replace("\$$name", '&nbsp;', $string);
				}

				
			}
	
			return $string;
		}
		static function parse_template($string, &$bean_arr) {
			global $beanFiles, $beanList;

            $person = array();
	
			foreach($bean_arr as $bean_name => $bean_id) {
			
				require_once($beanFiles[$beanList[$bean_name]]);
	
				$focus = new $beanList[$bean_name];
				$focus->retrieve($bean_id);
				
				$string = aowTemplateParser::parse_template_bean($string, strtolower($beanList[$bean_name]), $focus);

                if($focus instanceof Person){
                    $person[] = $focus;
                }
				
			}

            if(!empty($person)){
                $focus = $person[0];
            } else {
                $focus = new Contact();
            }
            $string = aowTemplateParser::parse_template_bean($string, 'contact', $focus);

			return $string;
		}
	}
?>
