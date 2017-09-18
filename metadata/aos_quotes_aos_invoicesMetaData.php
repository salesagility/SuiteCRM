<?php
/**
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2016 SalesAgility Ltd.
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
 */
$dictionary['aos_quotes_aos_invoices'] = array(
    'true_relationship_type' => 'many-to-many',
    'relationships' => array(
            'aos_quotes_aos_invoices' => array(
                    'lhs_module' => 'AOS_Quotes',
                    'lhs_table' => 'aos_quotes',
                    'lhs_key' => 'id',
                    'rhs_module' => 'AOS_Invoices',
                    'rhs_table' => 'aos_invoices',
                    'rhs_key' => 'id',
                    'relationship_type' => 'many-to-many',
                    'join_table' => 'aos_quotes_aos_invoices_c',
                    'join_key_lhs' => 'aos_quotes77d9_quotes_ida',
                    'join_key_rhs' => 'aos_quotes6b83nvoices_idb',
                ),
        ),
    'table' => 'aos_quotes_aos_invoices_c',
    'fields' => array(
            0 => array(
                    'name' => 'id',
                    'type' => 'varchar',
                    'len' => 36,
                ),
            1 => array(
                    'name' => 'date_modified',
                    'type' => 'datetime',
                ),
            2 => array(
                    'name' => 'deleted',
                    'type' => 'bool',
                    'len' => '1',
                    'default' => '0',
                    'required' => true,
                ),
            3 => array(
                    'name' => 'aos_quotes77d9_quotes_ida',
                    'type' => 'varchar',
                    'len' => 36,
                ),
            4 => array(
                    'name' => 'aos_quotes6b83nvoices_idb',
                    'type' => 'varchar',
                    'len' => 36,
                ),
        ),
    'indices' => array(
            0 => array(
                    'name' => 'aos_quotes_aos_invoicesspk',
                    'type' => 'primary',
                    'fields' => array(
                            0 => 'id',
                        ),
                ),
            1 => array(
                    'name' => 'aos_quotes_aos_invoices_alt',
                    'type' => 'alternate_key',
                    'fields' => array(
                            0 => 'aos_quotes77d9_quotes_ida',
                            1 => 'aos_quotes6b83nvoices_idb',
                        ),
                ),
        ),
);
