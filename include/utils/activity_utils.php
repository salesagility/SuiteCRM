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


function build_related_list_by_user_id($bean, $user_id,$where) {
    $bean_id_name = strtolower($bean->object_name).'_id';

    if(isset($bean->rel_users_table) && !empty($bean->rel_users_table)) {
        $select = "SELECT {$bean->table_name}.* from {$bean->rel_users_table},{$bean->table_name} ";

        $auto_where = ' WHERE ';
        if (!empty($where)) {
            $auto_where .= $where . ' AND ';
        }

        $auto_where .= " {$bean->rel_users_table}.{$bean_id_name}={$bean->table_name}.id AND {$bean->rel_users_table}.user_id='{$user_id}' AND {$bean->table_name}.deleted=0 AND {$bean->rel_users_table}.deleted=0";


        $query = $select . $auto_where;

        $result = $bean->db->query($query, true);

        $list = array();

        while ($row = $bean->db->fetchByAssoc($result)) {
            $row = $bean->convertRow($row);
            $bean->fetched_row = $row;
            $bean->fromArray($row);
//        foreach($bean->column_fields as $field) {
//            if(isset($row[$field])) {
//                $bean->$field = $row[$field];
//            } else {
//                $bean->$field = '';
//            }
//        }

            $bean->processed_dates_times = array();
            $bean->check_date_relationships_load();
            $bean->fill_in_additional_detail_fields();

            /**
             * PHP  5+ always treats objects as passed by reference
             * Need to clone it if we're using 5.0+
             * clone() not supported by 4.x
             */
            if (version_compare(phpversion(), "5.0", ">=")) {
                $newBean = clone($bean);
            } else {
                $newBean = $bean;
            }
            $list[] = $newBean;
        }

        return $list;
    }else{
        $select = "SELECT {$bean->table_name}.* from {$bean->table_name} ";

        $auto_where = ' WHERE ';
        if (!empty($where)) {
            $auto_where .= $where . ' AND ';
        }

        $auto_where .= " {$bean->table_name}.assigned_user_id='{$user_id}' AND {$bean->table_name}.deleted=0 ";


        $query = $select . $auto_where;

        $result = $bean->db->query($query, true);

        $list = array();

        while ($row = $bean->db->fetchByAssoc($result)) {
            $row = $bean->convertRow($row);
            $bean->fetched_row = $row;
            $bean->fromArray($row);
//        foreach($bean->column_fields as $field) {
//            if(isset($row[$field])) {
//                $bean->$field = $row[$field];
//            } else {
//                $bean->$field = '';
//            }
//        }

            $bean->processed_dates_times = array();
            $bean->check_date_relationships_load();
            $bean->fill_in_additional_detail_fields();

            /**
             * PHP  5+ always treats objects as passed by reference
             * Need to clone it if we're using 5.0+
             * clone() not supported by 4.x
             */
            if (version_compare(phpversion(), "5.0", ">=")) {
                $newBean = clone($bean);
            } else {
                $newBean = $bean;
            }
            $list[] = $newBean;
        }

        return $list;
    }
}
?>
