<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
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
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */


/**
 * Core email_address table
 */
$dictionary['email_addresses'] = array(
    'table'        => 'email_addresses',
    'audited' => true,
    'fields'    => array(
        'id' => array(
            'name'            => 'id',
            'type'            => 'id',
            'vname'         => 'LBL_EMAIL_ADDRESS_ID',
            'required'        => true,
        ),
        'email_address' =>array(
            'name'            => 'email_address',
            'type'            => 'varchar',
            'vname'         => 'LBL_EMAIL_ADDRESS',
            'length'        => 100,
            'required'        => true,
        ),
        'email_address_caps' => array(
            'name'            => 'email_address_caps',
            'type'            => 'varchar',
            'vname'         => 'LBL_EMAIL_ADDRESS_CAPS',
            'length'        => 100,
            'required'        => true,
                        'reportable'            => false,
        ),
        'invalid_email' => array(
            'name'            => 'invalid_email',
            'type'            => 'bool',
            'default'        => 0,
            'vname'         => 'LBL_INVALID_EMAIL',
        ),
        'opt_out' => array(
            'name'            => 'opt_out',
            'type'            => 'bool',
            'default'        => 0,
            'vname'         => 'LBL_OPT_OUT',
            'audited' => true,
        ),
        
        'confirm_opt_in' => array(
            'name'            => 'confirm_opt_in',
            'type'            => 'enum',
            'length' => 255,
            'default'        => 'not-opt-in',
            'options' => 'email_settings_opt_in_dom',
            'vname'         => 'LBL_CONFIRM_OPT_IN',
            'audited' => true,
        ),

        'confirm_opt_in_date' => array(
            'name' => 'confirm_opt_in_date',
            'type' => 'datetime',
            'vname' => 'LBL_CONFIRM_OPT_IN_DATE',
        ),

        'confirm_opt_in_sent_date' => array(
            'name' => 'confirm_opt_in_sent_date',
            'type' => 'datetime',
            'vname' => 'LBL_CONFIRM_OPT_IN_SENT_DATE',
        ),
        
        'confirm_opt_in_fail_date' => array(
            'name' => 'confirm_opt_in_fail_date',
            'type' => 'datetime',
            'vname' => 'LBL_CONFIRM_OPT_IN_FAIL_DATE',
        ),
        
        'confirm_opt_in_token' => [
            'name' => 'confirm_opt_in_token',
            'type' => 'varchar',
            'len' => 255,
            'vname' => 'LBL_CONFIRM_OPT_IN_TOKEN',
        ],
        
        'date_created' => array(
            'name'            => 'date_created',
            'type'            => 'datetime',
            'vname'         => 'LBL_DATE_CREATE',
        ),
        'date_modified' => array(
            'name'            => 'date_modified',
            'type'            => 'datetime',
            'vname'         => 'LBL_DATE_MODIFIED',
        ),
        'deleted' => array(
            'name'            => 'deleted',
            'type'            => 'bool',
            'default'        => 0,
            'vname'         => 'LBL_DELETED',
        ),
    ),
    'indices' => array(
        array(
            'name'            => 'email_addressespk',
            'type'            => 'primary',
            'fields'        => array('id')
        ),
        array(
            'name'            => 'idx_ea_caps_opt_out_invalid',
            'type'            => 'index',
            'fields'        => array('email_address_caps','opt_out','invalid_email')
        ),
        array(
            'name'            => 'idx_ea_opt_out_invalid',
            'type'            => 'index',
            'fields'        => array('email_address', 'opt_out', 'invalid_email')
        ),
    ),
);

// hack for installer
if (file_exists("cache/modules/EmailAddresses/EmailAddressvardefs.php")) {
    include("cache/modules/EmailAddresses/EmailAddressvardefs.php");
} else {
    $dictionary['EmailAddress'] = $dictionary['email_addresses'];
}

/**
 * Relationship table linking email addresses to an instance of a Sugar Email object
 */
$dictionary['emails_email_addr_rel'] = array(
    'table' => 'emails_email_addr_rel',
    'comment' => 'Normalization of multi-address fields such as To:, CC:, BCC',
    'fields' => array(
        'id' => array(
            'name'            => 'id',
            'type'            => 'id',
            'required'        => true,
            'comment'        => 'GUID',
        ),
        'email_id' => array(
            'name'            => 'email_id',
            'type'            => 'id',
            'required'        => true,
            'comment'        => 'Foriegn key to emails table NOT unique',
        ),
        'address_type' => array(
            'name'            => 'address_type',
            'type'            => 'varchar',
            'len'            => 4,
            'required'        => true,
            'comment'        => 'Type of entry, TO, CC, or BCC',
        ),
        'email_address_id' => array(
            'name'            => 'email_address_id',
            'type'            => 'id',
            'required'        => true,
            'comment'        => 'Foriegn key to emails table NOT unique',
        ),
        'deleted' => array(
            'name'            => 'deleted',
            'type'            => 'bool',
            'default'        => 0,
        ),
    ),
    'indices' => array(
        array(
            'name'        => 'emails_email_addr_relpk',
            'type'        => 'primary',
            'fields'    => array('id'),
        ),
        array(
            'name'        => 'idx_eearl_email_id',
            'type'        => 'index',
            'fields'    => array('email_id', 'address_type'),
        ),
        array(
            'name'        => 'idx_eearl_address_id',
            'type'        => 'index',
            'fields'    => array('email_address_id'),
        ),
    ),
);

/**
 * Relationship table linking email addresses to various SugarBeans or type Person
 */
$dictionary['email_addr_bean_rel'] = array(
    'table' => 'email_addr_bean_rel',
    'fields' => array(
        array(
            'name'            => 'id',
            'type'            => 'id',
            'required'        => true,
        ),
        array(
            'name'            => 'email_address_id',
            'type'            => 'id',
            'required'        => true,
        ),
        array(
            'name'            => 'bean_id',
            'type'            => 'id',
            'required'        => true,
        ),
        array(
            'name'            => 'bean_module',
            'type'            => 'varchar',
            'len'            => 100,
            'required'        => true,
        ),
        array(
            'name'            => 'primary_address',
            'type'            => 'bool',
            'default'        => '0',
        ),
        array(
            'name'            => 'reply_to_address',
            'type'            => 'bool',
            'default'        => '0',
        ),
        array(
            'name'            => 'date_created',
            'type'            => 'datetime'
        ),
        array(
            'name'            => 'date_modified',
            'type'            => 'datetime'
        ),
        array(
            'name'            => 'deleted',
            'type'            => 'bool',
            'default'        => 0,
        ),
    ),
    'indices' => array(
        array(
            'name'            => 'email_addresses_relpk',
            'type'            => 'primary',
            'fields'        => array('id')
        ),
        array(
            'name'            => 'idx_email_address_id',
            'type'            => 'index',
            'fields'        => array('email_address_id')
        ),
        array(
            'name'            => 'idx_bean_id',
            'type'            => 'index',
            'fields'        => array('bean_id', 'bean_module'),
        ),
    ),
    'relationships' => array(
        //Defined in Person/Company template vardefs
    ),
);
