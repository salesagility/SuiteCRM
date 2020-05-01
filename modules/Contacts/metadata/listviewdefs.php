<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/*
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

$listViewDefs['Contacts'] = [
    'NAME' => [
        'width' => '20%',
        'label' => 'LBL_LIST_NAME',
        'link' => true,
        'contextMenu' => ['objectType' => 'sugarPerson',
            'metaData' => ['contact_id' => '{$ID}',
                'module' => 'Contacts',
                'return_action' => 'ListView',
                'contact_name' => '{$FULL_NAME}',
                'parent_id' => '{$ACCOUNT_ID}',
                'parent_name' => '{$ACCOUNT_NAME}',
                'return_module' => 'Contacts',
                'return_action' => 'ListView',
                'parent_type' => 'Account',
                'notes_parent_type' => 'Account']
        ],
        'orderBy' => 'name',
        'default' => true,
        'related_fields' => ['first_name', 'last_name', 'salutation', 'account_name', 'account_id'],
    ],
    'TITLE' => [
        'width' => '15%',
        'label' => 'LBL_LIST_TITLE',
        'default' => true],
    'ACCOUNT_NAME' => [
        'width' => '34%',
        'label' => 'LBL_LIST_ACCOUNT_NAME',
        'module' => 'Accounts',
        'id' => 'ACCOUNT_ID',
        'link' => true,
        'contextMenu' => ['objectType' => 'sugarAccount',
            'metaData' => ['return_module' => 'Contacts',
                'return_action' => 'ListView',
                'module' => 'Accounts',
                'return_action' => 'ListView',
                'parent_id' => '{$ACCOUNT_ID}',
                'parent_name' => '{$ACCOUNT_NAME}',
                'account_id' => '{$ACCOUNT_ID}',
                'account_name' => '{$ACCOUNT_NAME}'],
        ],
        'default' => true,
        'sortable' => true,
        'ACLTag' => 'ACCOUNT',
        'related_fields' => ['account_id']],
    'EMAIL1' => [
        'width' => '15%',
        'label' => 'LBL_LIST_EMAIL_ADDRESS',
        'sortable' => false,
        'link' => true,
        'customCode' => '{$EMAIL1_LINK}',
        'default' => true
    ],
    'PHONE_WORK' => [
        'width' => '15%',
        'label' => 'LBL_OFFICE_PHONE',
        'default' => true],
    'DEPARTMENT' => [
        'width' => '10',
        'label' => 'LBL_DEPARTMENT'],
    'DO_NOT_CALL' => [
        'width' => '10',
        'label' => 'LBL_DO_NOT_CALL'],
    'PHONE_HOME' => [
        'width' => '10',
        'label' => 'LBL_HOME_PHONE'],
    'PHONE_MOBILE' => [
        'width' => '10',
        'label' => 'LBL_MOBILE_PHONE'],
    'PHONE_OTHER' => [
        'width' => '10',
        'label' => 'LBL_OTHER_PHONE'],
    'PHONE_FAX' => [
        'width' => '10',
        'label' => 'LBL_FAX_PHONE'],
    'EMAIL2' => [
        'width' => '15',
        'label' => 'LBL_LIST_EMAIL_ADDRESS',
        'sortable' => false,
        'customCode' => '{$EMAIL2_LINK}{$EMAIL2}</a>'],
    'EMAIL_OPT_OUT' => [
        'width' => '10',
        'label' => 'LBL_EMAIL_OPT_OUT'],
    'PRIMARY_ADDRESS_STREET' => [
        'width' => '10',
        'label' => 'LBL_PRIMARY_ADDRESS_STREET'],
    'PRIMARY_ADDRESS_CITY' => [
        'width' => '10',
        'label' => 'LBL_PRIMARY_ADDRESS_CITY'],
    'PRIMARY_ADDRESS_STATE' => [
        'width' => '10',
        'label' => 'LBL_PRIMARY_ADDRESS_STATE'],
    'PRIMARY_ADDRESS_POSTALCODE' => [
        'width' => '10',
        'label' => 'LBL_PRIMARY_ADDRESS_POSTALCODE'],
    'ALT_ADDRESS_COUNTRY' => [
        'width' => '10',
        'label' => 'LBL_ALT_ADDRESS_COUNTRY'],
    'ALT_ADDRESS_STREET' => [
        'width' => '10',
        'label' => 'LBL_ALT_ADDRESS_STREET'],
    'ALT_ADDRESS_CITY' => [
        'width' => '10',
        'label' => 'LBL_ALT_ADDRESS_CITY'],
    'ALT_ADDRESS_STATE' => [
        'width' => '10',
        'label' => 'LBL_ALT_ADDRESS_STATE'],
    'ALT_ADDRESS_POSTALCODE' => [
        'width' => '10',
        'label' => 'LBL_ALT_ADDRESS_POSTALCODE'],
    'ALT_ADDRESS_COUNTRY' => [
        'width' => '10',
        'label' => 'LBL_ALT_ADDRESS_COUNTRY'],
    'CREATED_BY_NAME' => [
        'width' => '10',
        'label' => 'LBL_CREATED'],
    'ASSIGNED_USER_NAME' => [
        'width' => '10',
        'label' => 'LBL_LIST_ASSIGNED_USER',
        'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => true],
    'MODIFIED_BY_NAME' => [
        'width' => '10',
        'label' => 'LBL_MODIFIED'],
    'SYNC_CONTACT' => [
        'type' => 'bool',
        'label' => 'LBL_SYNC_CONTACT',
        'width' => '10%',
        'default' => false,
        'sortable' => false,
    ],
    'DATE_ENTERED' => [
        'width' => '10',
        'label' => 'LBL_DATE_ENTERED',
        'default' => true]
];
