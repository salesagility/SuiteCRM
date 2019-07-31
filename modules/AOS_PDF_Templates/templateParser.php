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
 * @author SalesAgility Ltd <support@salesagility.com>
 */

use SuiteCRM\Utility\SuiteValidator as SuiteValidator;

class templateParser
{
    public static function parse_template($string, $bean_arr)
    {
        foreach ($bean_arr as $bean_name => $bean_id) {
            $focus = BeanFactory::getBean($bean_name, $bean_id);
            $string = templateParser::parse_template_bean($string, $focus->table_name, $focus);

            foreach ($focus->field_defs as $focus_name => $focus_arr) {
                if ($focus_arr['type'] == 'relate') {
                    if (isset($focus_arr['module']) && $focus_arr['module'] != '' && $focus_arr['module'] != 'EmailAddress') {
                        $idName = $focus_arr['id_name'];
                        $relate_focus = BeanFactory::getBean($focus_arr['module'], $focus->$idName);

                        $string = templateParser::parse_template_bean($string, $focus_arr['name'], $relate_focus);
                    }
                }
            }
        }
        return $string;
    }

    /**
     * @param $string
     * @param $key
     * @param $focus
     * @return mixed
     * @throws Exception
     */
    public function parse_template_bean($string, $key, &$focus)
    {
        global $app_strings, $sugar_config;
        $repl_arr = array();
        $isValidator = new SuiteValidator();

        foreach ($focus->field_defs as $field_def) {
            if (isset($field_def['name']) && $field_def['name'] != '') {
                $fieldName = $field_def['name'];
                if ($field_def['type'] == 'currency') {
                    $params = array(
                        'currency_symbol' => false
                    );

                    $repl_arr[$key . "_" . $fieldName] = currency_format_number(
                        $focus->{$fieldName},
                        $params
                    );
                } elseif (($field_def['type'] == 'radioenum' || $field_def['type'] == 'enum' || $field_def['type'] == 'dynamicenum') && isset($field_def['options'])) {
                    $repl_arr[$key . "_" . $fieldName] = translate(
                        $field_def['options'],
                        $focus->module_dir,
                        $focus->{$fieldName}
                    );
                } elseif ($field_def['type'] == 'multienum' && isset($field_def['options'])) {
                    $mVals = unencodeMultienum($focus->{$fieldName});
                    $translatedVals = array();

                    foreach ($mVals as $mVal) {
                        $translatedVals[] = translate($field_def['options'], $focus->module_dir, $mVal);
                    }

                    $repl_arr[$key . "_" . $fieldName] = implode(", ", $translatedVals);
                } elseif ($field_def['type'] == 'int') {
                    //Fix for Windows Server as it needed to be converted to a string.
                    $repl_arr[$key . "_" . $fieldName] = strval($focus->{$fieldName});
                } elseif ($field_def['type'] == 'bool') {
                    if ($focus->{$fieldName} == "1") {
                        $repl_arr[$key . "_" . $fieldName] = "true";
                    } else {
                        $repl_arr[$key . "_" . $fieldName] = "false";
                    }
                } elseif ($field_def['type'] == 'image') {
                    $secureLink = $sugar_config['site_url'] . '/' . "public/" . $focus->id . '_' . $fieldName;
                    $file_location = $sugar_config['upload_dir'] . '/' . $focus->id . '_' . $fieldName;
                    // create a copy with correct extension by mime type
                    if (!file_exists('public')) {
                        sugar_mkdir('public', 0777);
                    }
                    if (!copy($file_location, "public/{$focus->id}" . '_' . "$fieldName")) {
                        $secureLink = $sugar_config['site_url'] . '/' . $file_location;
                    }

                    if (empty($focus->{$fieldName})) {
                        $repl_arr[$key . "_" . $fieldName] = "";
                    } else {
                        $link = $secureLink;
                        $repl_arr[$key . "_" . $fieldName] = '<img src="' . $link . '" width="' . $field_def['width'] . '" height="' . $field_def['height'] . '"/>';
                    }
                } elseif ($field_def['type'] == 'wysiwyg') {
                    $repl_arr[$key . "_" . $field_def['name']] = html_entity_decode($focus->$field_def['name'],
                        ENT_COMPAT, 'UTF-8');
                    $repl_arr[$key . "_" . $fieldName] = html_entity_decode($focus->{$fieldName},
                        ENT_COMPAT, 'UTF-8');
                } else {
                    $repl_arr[$key . "_" . $fieldName] = $focus->{$fieldName};
                }
            }
        } // end foreach()

        krsort($repl_arr);
        reset($repl_arr);

        foreach ($repl_arr as $name => $value) {
            if (strpos($name, 'product_discount') !== false || strpos($name, 'quotes_discount') !== false) {
                if ($value !== '') {
                    if ($isValidator->isPercentageField($repl_arr['aos_products_quotes_discount'])) {
                        $sep = get_number_seperators();
                        $value = rtrim(
                            rtrim(format_number($value), '0'),
                            $sep[1]
                        ) . $app_strings['LBL_PERCENTAGE_SYMBOL'];
                    }
                } else {
                    $value = '';
                }
            }

            if ($name === 'aos_products_product_image' && !empty($value)) {
                $value = '<img src="' . $value . '" class="img-responsive"/>';
            }

            if ($name === 'aos_products_quotes_product_qty') {
                $sep = get_number_seperators();
                $value = rtrim(rtrim(format_number($value), '0'), $sep[1]);
            }

            if ($isValidator->isPercentageField($name)) {
                $sep = get_number_seperators();
                $value = rtrim(rtrim(format_number($value), '0'), $sep[1]) . $app_strings['LBL_PERCENTAGE_SYMBOL'];
            }

            if (
                $focus->field_defs[$name]['dbType'] == 'datetime' &&
                (strpos($name, 'date') > 0 || strpos($name, 'expiration') > 0)
            ) {
                if ($value != '') {
                    $dt = explode(' ', $value);
                    $value = $dt[0];
                    if (isset($dt[1]) && $dt[1] != '') {
                        if (strpos($dt[1], 'am') > 0 || strpos($dt[1], 'pm') > 0) {
                            $value = $dt[0] . ' ' . $dt[1];
                        }
                    }
                }
            }

            if ($value != '' && is_string($value)) {
                $string = str_replace("\$$name", $value, $string);
            } else {
                if (strpos($name, 'address') > 0) {
                    $string = str_replace("\$$name<br />", '', $string);
                    $string = str_replace("\$$name <br />", '', $string);
                    $string = str_replace("\$$name", '', $string);
                } else {
                    $string = str_replace("\$$name", '&nbsp;', $string);
                }
            }
        }

        return $string;
    }
}
