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

class sticContactsDuplicateQueries{

    /**
     * getDuplicateQuery
     *
     * This function returns the SQL String used for initial duplicate Contacts check
     *
     * @see checkForDuplicates (method), ContactFormBase.php, LeadFormBase.php, ProspectFormBase.php
     * @param $bean sugarbean
     * @param $prefix String value of prefix that may be present in $_POST variables
     * @return SQL String of the query that should be used for the initial duplicate lookup check
     */
    public static function getDuplicateQuery($bean, $prefix='') {
        if(file_exists("custom/modules/Contacts/customContactsDuplicateQueries.php")) {
            require_once("custom/modules/Contacts/customContactsDuplicateQueries.php");
            if(method_exists("customContactsDuplicateQueries", "getDuplicateQuery")) {
                return customContactsDuplicateQueries::getDuplicateQuery($bean, $prefix);
            }
        }
        $dbManager = DBManagerFactory::getInstance();

        $query = 'SELECT contacts.id, contacts.first_name, contacts.last_name, contacts.title, contacts_cstm.stic_identification_number_c '. 
                 'FROM contacts '.
                 'INNER JOIN contacts_cstm ON contacts.id=contacts_cstm.id_c';

        // Bug #46427 : Records from other Teams shown on Potential Duplicate Contacts screen during Lead Conversion
        // add team security

        $query .= ' WHERE contacts.deleted = 0 AND (';
        if (isset($_POST[$prefix.'first_name']) && strlen($_POST[$prefix.'first_name']) != 0 && isset($_POST[$prefix.'last_name']) && strlen($_POST[$prefix.'last_name']) != 0) {
            $firstName = $dbManager->quote($_POST[$prefix.'first_name' ?? '']);
            $lastName = $dbManager->quote($_POST[$prefix.'last_name' ?? '']);
            $query .= " (contacts.first_name LIKE '". $firstName . "%' AND contacts.last_name LIKE '". $lastName ."%')";
        } else {
            $lastName = $dbManager->quote($_POST[$prefix.'last_name' ?? '']);
            $query .= " contacts.last_name LIKE '". $lastName ."%'";
        }
        if(isset($_POST[$prefix.'stic_identification_number_c']) && strlen($_POST[$prefix.'stic_identification_number_c']) != 0) {
            $query .= " OR ";
            $stic_identification_number_c = $dbManager->quote($_POST[$prefix.'stic_identification_number_c' ?? '']);
            $query .= " contacts_cstm.stic_identification_number_c = '". $stic_identification_number_c ."'";
        }
        $query .= ")";


        if (!empty($_POST[$prefix.'record'])) {
            $record = $dbManager->quote($_POST[$prefix.'record' ?? '']);
            $query .= " AND  contacts.id != '". $record ."'";
        }
        return $query;
    }

    public static function getShowDuplicateQuery() {
        if(file_exists("custom/modules/Contacts/customContactsDuplicateQueries.php")) {
            require_once("custom/modules/Contacts/customContactsDuplicateQueries.php");
            if(method_exists("customContactsDuplicateQueries", "getShowDuplicateQuery")) {
                return customContactsDuplicateQueries::getShowDuplicateQuery();
            }
        }

        $query = 'SELECT contacts.id, contacts.first_name, contacts.last_name, contacts_cstm.stic_identification_number_c, contacts.title, accounts.name, contacts.primary_address_city '. 
                 'FROM contacts '.
                 'INNER JOIN contacts_cstm ON contacts.id=contacts_cstm.id_c '.
                 'LEFT JOIN accounts_contacts ON contacts.id=accounts_contacts.contact_id AND accounts_contacts.deleted = 0 '.
                 'LEFT JOIN accounts ON accounts_contacts.account_id=accounts.id AND accounts_contacts.deleted=0 AND accounts.deleted=0 '.
                 'WHERE contacts.deleted=0 ';
        return $query;
    }
}