<?php
/**
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */
// Extension of class ListViewSmarty to allow MassUpdate of field types not allowed by default by SugarCRM

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

class sticAccountsDuplicateQueries{

    /**
     * getDuplicateQuery
     *
     * This function returns the SQL String used for initial duplicate Leads check
     *
     * @see checkForDuplicates (method), ContactFormBase.php, LeadFormBase.php, ProspectFormBase.php
     * @param $bean sugarbean
     * @param $prefix String value of prefix that may be present in $_POST variables
     * @return SQL String of the query that should be used for the initial duplicate lookup check
     */
    public static function getDuplicateQuery($bean, $prefix='') {
        if(file_exists("custom/modules/Accounts/customAccountsDuplicateQueries.php")) {
            require_once("custom/modules/Accounts/customAccountsDuplicateQueries.php");
            if(method_exists("customAccountsDuplicateQueries", "getDuplicateQuery")) {
                return customAccountsDuplicateQueries::getDuplicateQuery($bean, $prefix);
            }
        }

        $dbManager = DBManagerFactory::getInstance();

        $query = 'SELECT accounts.id, accounts.name, accounts.website, accounts.billing_address_city, accounts_cstm.stic_identification_number_c '.
                 'FROM accounts '.
                 'INNER JOIN accounts_cstm ON accounts.id=accounts_cstm.id_c';

        $query .= ' WHERE accounts.deleted = 0 ';

        $tempWhere = "";
        $name = (isset($_POST[$prefix.'name']) && !empty($_POST[$prefix.'name'])) ? $_POST[$prefix . 'name'] : '';

        if (!empty($name)) {
            $name = $dbManager->quote($name);
            $tempWhere = "name LIKE '".$name."%'";
        }

        $shippingAddressCity = (isset($_POST[$prefix.'shipping_address_city']) && !empty($_POST[$prefix.'shipping_address_city'])) ? $_POST[$prefix.'shipping_address_city'] : '';
        $billingAddressCity = (isset($_POST[$prefix.'billing_address_city']) && !empty($_POST[$prefix.'billing_address_city'])) ? $_POST[$prefix.'billing_address_city'] : '';
        if (!empty($billingAddressCity)) {
            $billingAddressCity = $dbManager->quote($billingAddressCity);
        }
        if (!empty($shippingAddressCity)) {
            $shippingAddressCity = $dbManager->quote($shippingAddressCity);
        }

        if (!empty($billingAddressCity) || !empty($shippingAddressCity)) {
            if(!empty($tempWhere)) {
                $tempWhere .= " AND ";
            }

            if (!empty($billingAddressCity) && !empty($shippingAddressCity)) {
                $tempWhere .= "(billing_address_city LIKE '".$billingAddressCity."%' OR shipping_address_city LIKE '".$shippingAddressCity."%')";
            } else if(!empty($billingAddressCity)) {
                $tempWhere .= "billing_address_city LIKE '".$billingAddressCity."%'";
            } else if (!empty($shippingAddressCity)) {
                $tempWhere .= "shipping_address_city LIKE '".$shippingAddressCity."%'";
            }
        }
        $stic_identification_number_c = (isset($_POST[$prefix.'stic_identification_number_c']) && !empty($_POST[$prefix.'stic_identification_number_c'])) ? $_POST[$prefix.'stic_identification_number_c'] : '';
        if (!empty($stic_identification_number_c)) {
            if(!empty($tempWhere)) {
                $tempWhere = "(".$tempWhere.") OR ";
            }
            $stic_identification_number_c = $dbManager->quote($stic_identification_number_c);
            $tempWhere .= " accounts_cstm.stic_identification_number_c = '". $stic_identification_number_c ."'";
        }
        if(!empty($tempWhere)) {
            $query .= ' AND ('. $tempWhere . ' ) ';
        }

        return $query;
    }

    public static function getShowDuplicateQuery() {
        if(file_exists("custom/modules/Accounts/customAccountsDuplicateQueries.php")) {
            require_once("custom/modules/Accounts/customAccountsDuplicateQueries.php");
            if(method_exists("customAccountsDuplicateQueries", "getShowDuplicateQuery")) {
                return customAccountsDuplicateQueries::getShowDuplicateQuery();
            }
        }

        $query = 'SELECT accounts.id, accounts.name, accounts_cstm.stic_identification_number_c, accounts.website, accounts.billing_address_city '.
                 'FROM accounts '.
                 'INNER JOIN accounts_cstm ON accounts.id=accounts_cstm.id_c '.
                 'WHERE accounts.deleted=0 ';
        return $query;
    }
}