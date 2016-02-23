<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/


    function wrapTD($html, $options){
        return wrapTag("td",$html, $options);
    }

    function wrapTR($html, $options){
        return wrapTag("tr",$html, $options);
    }

    function wrapTable($html, $options){
        return wrapTag("table",$html, $options);
    }

    function wrapB($html){
        return "<b>".$html."</b>";
    }

    function wrapI($html){
        return "<i>".$html."</i>";
    }
    function wrapTag($tag, $html, $options){
        // Wrap the tags defined in the options array (like b, i, font... tags)
        if(!empty($options)){
            foreach($options as $k=>$v){
                if(is_array($v)){
                    $html = wrapTag($k, "$html", $v);
                }
            }
        }
        // wrap the HTML content with the passed tag
        $return = "<$tag ";
        if(!empty($options)){
            foreach($options as $k=>$v){
                if(!is_array($v)){
                    $return .= " $k=".'"'.$v.'"';
                }
            }
        }
        return $return.">".$html."</$tag>";
    }

    /**
     * This function prepare a string to be ready for the PDF printing.
     * @param $string
     * @return string
     */
    function prepare_string($string){
        global $locale;
        $string = html_entity_decode($string, ENT_QUOTES);
        // return $locale->translateCharset($string, 'UTF-8', $locale->getExportCharset());
        return $string;
    }
     /**
     * Copy of format_number() from currency with fix for sugarpdf.
     * @return String formatted currency value
     * @see modules/Currencies/Currency.php
     */
    function format_number_sugarpdf($amount, $round = null, $decimals = null, $params = array()) {
        global $app_strings, $current_user, $sugar_config, $locale;
        static $current_users_currency = null;
        static $last_override_currency = null;
        static $override_currency_id = null;
        static $currency;

        $seps = get_number_seperators();
        $num_grp_sep = $seps[0];
        $dec_sep = $seps[1];

        // cn: bug 8522 - sig digits not honored in pdfs
        if(is_null($decimals)) {
            $decimals = $locale->getPrecision();
        }
        if(is_null($round)) {
            $round = $locale->getPrecision();
        }

        // only create a currency object if we need it
        if((!empty($params['currency_symbol']) && $params['currency_symbol']) ||
          (!empty($params['convert']) && $params['convert']) ||
          (!empty($params['currency_id']))) {
                // if we have an override currency_id
                if(!empty($params['currency_id'])) {
                    if($override_currency_id != $params['currency_id']) {
                        $override_currency_id = $params['currency_id'];
                        $currency = new Currency();
                        $currency->retrieve($override_currency_id);
                        $last_override_currency = $currency;
                    } else {
                        $currency = $last_override_currency;
                    }

                } elseif(!isset($current_users_currency)) { // else use current user's
                    $current_users_currency = new Currency();
                    if($current_user->getPreference('currency')) $current_users_currency->retrieve($current_user->getPreference('currency'));
                    else $current_users_currency->retrieve('-99'); // use default if none set
                    $currency = $current_users_currency;
                }
        }
        if(!empty($params['convert']) && $params['convert']) {
            $amount = $currency->convertFromDollar($amount, 6);
        }

        if(!empty($params['currency_symbol']) && $params['currency_symbol']) {
            if(!empty($params['symbol_override'])) {
                $symbol = $params['symbol_override'];
            }

            // BEGIN SUGARPDF
            /*elseif(!empty($params['type']) && $params['type'] == 'pdf') {
                $symbol = $currency->getPdfCurrencySymbol();
                $symbol_space = false;
            }*/
            elseif(!empty($params['type']) && $params['type'] == 'sugarpdf') {
                $symbol = $currency->symbol;
                $symbol_space = false;
            }
            // END SUGARPDF

            else {
                if(empty($currency->symbol))
                    $symbol = $currency->getDefaultCurrencySymbol();
                else
                    $symbol = $currency->symbol;
                $symbol_space = true;
            }
        } else {
            $symbol = '';
        }

        if(isset($params['charset_convert'])) {
            $symbol = $locale->translateCharset($symbol, 'UTF-8', $locale->getExportCharset());
        }

        if(empty($params['human'])) {
           $amount = number_format(round($amount, $round), $decimals, $dec_sep, $num_grp_sep);
           $amount = format_place_symbol($amount, $symbol,(empty($params['symbol_space']) ? false : true));
        } else {
            // If amount is more greater than a thousand(positive or negative)
            if(strpos($amount, '.') > 0) {
               $checkAmount = strlen(substr($amount, 0, strpos($amount, '.')));
            }

            if($checkAmount >= 1000 || $checkAmount <= -1000) {
                $amount = round(($amount / 1000), 0);
                $amount = $amount . 'k';
                $amount = format_place_symbol($amount, $symbol,(empty($params['symbol_space']) ? false : true));
            } else {
                $amount = format_place_symbol($amount, $symbol,(empty($params['symbol_space']) ? false : true));
            }
        }

        if(!empty($params['percentage']) && $params['percentage']) $amount .= $app_strings['LBL_PERCENTAGE_SYMBOL'];
        return $amount;

    } //end function format_number
?>
