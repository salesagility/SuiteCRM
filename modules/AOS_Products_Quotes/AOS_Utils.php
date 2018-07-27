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
 * @author Salesagility Ltd <info@salesagility.com>
 */

function perform_aos_save($focus){

    foreach($focus->field_defs as $field){

        $fieldName = $field['name'];
        $fieldNameDollar = $field['name'].'_usdollar';

        if(isset($focus->field_defs[$fieldNameDollar])){

            $focus->$fieldNameDollar = '';
            if(!number_empty($focus->field_defs[$field['name']])){
                $currency = new Currency();
                
                $currencyId = null;
                if (isset($focus->currency_id)) {
                    $currencyId = $focus->currency_id;
                } else {
                    LoggerManager::getLogger()->warn('Undefined currency ID: ' . get_class($focus) . '::$currency_id');
                }
                
                $currency->retrieve($currencyId);
                
                $fieldValue = null;
                if (isset($focus->$fieldName)) {
                    $fieldValue = $focus->$fieldName;
                } else {
                    LoggerManager::getLogger('Undefined field: ' . get_class($focus) . '::$' . $fieldName);
                }

                $amountToConvert = $fieldValue;
                if (!amountToConvertIsDatabaseValue($focus, $fieldName)) {
                    
                    $amountToConvert = null;
                    $fieldName = null;
                    if (isset($focus->$fieldName)) {
                        $fieldName = $focus->$fieldName;
                        $amountToConvert = unformat_number($fieldName);
                    } else {
                        LoggerManager::getLogger()->error('Filedname is not defined for class ' . get_class($focus));
                    }
                    
                }

                $focus->$fieldNameDollar = $currency->convertToDollar($amountToConvert);
            }

        }

    }
}

function amountToConvertIsDatabaseValue($focus, $fieldName)
{
    if (isset($focus->fetched_row)
        && isset($focus->fetched_row[$fieldName])
        && $focus->fetched_row[$fieldName] == $focus->$fieldName) {
        return true;
    }
    return false;
}
