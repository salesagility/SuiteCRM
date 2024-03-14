<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/**
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo, "Supercharged by SuiteCRM" logo and “Nonprofitized by SinergiaCRM” logo. 
 * If the display of the logos is not reasonably feasible for technical reasons, 
 * the Appropriate Legal Notices must display the words "Powered by SugarCRM", 
 * "Supercharged by SuiteCRM" and “Nonprofitized by SinergiaCRM”. 
 */

global $mod_strings;

// STIC-Custom - MHP - 20240201 - Override the core metadata files with the custom metadata files 
// https://github.com/SinergiaTIC/SinergiaCRM/pull/105
// $popupMeta = array(
//     'moduleMain' => 'Contact',
//     'varName' => 'CONTACT',
//     'orderBy' => 'contacts.first_name, contacts.last_name',
//     'whereClauses' =>
//         array('first_name' => 'contacts.first_name',
//                 'last_name' => 'contacts.last_name',
//                 'account_name' => 'accounts.name',
//                 'account_id' => 'accounts.id'),
//     'searchInputs' =>
//         array('first_name', 'last_name', 'account_name', 'email'),
//     'create' =>
//         array('formBase' => 'ContactFormBase.php',
//                 'formBaseClass' => 'ContactFormBase',
//                 'getFormBodyParams' => array('','','ContactSave'),
//                 'createButton' => 'LNK_NEW_CONTACT'
//               ),
//     'listviewdefs' => array(
//         'NAME' => array(
//             'width' => '20%',
//             'label' => 'LBL_LIST_NAME',
//             'link' => true,
//             'default' => true,
//             'related_fields' => array('first_name', 'last_name', 'salutation', 'account_name', 'account_id')),
//         'ACCOUNT_NAME' => array(
//             'width' => '25',
//             'label' => 'LBL_LIST_ACCOUNT_NAME',
//             'module' => 'Accounts',
//             'id' => 'ACCOUNT_ID',
//             'default' => true,
//             'sortable'=> true,
//             'ACLTag' => 'ACCOUNT',
//             'related_fields' => array('account_id')),
//         'TITLE' => array(
//             'width' => '15%',
//             'label' => 'LBL_LIST_TITLE',
//             'default' => true),
//         'LEAD_SOURCE' => array(
//             'width' => '15%',
//             'label' => 'LBL_LEAD_SOURCE',
//             'default' => true),
//         ),
//     'searchdefs'   => array(
//         'first_name',
//         'last_name',
//         array('name' => 'account_name', 'type' => 'varchar',),
//         'title',
//         'lead_source',
//         'email',
//         array('name' => 'campaign_name', 'displayParams' => array('hideButtons'=>'true', 'size'=>30, 'class'=>'sqsEnabled sqsNoAutofill')),
//         array('name' => 'assigned_user_id', 'type' => 'enum', 'label' => 'LBL_ASSIGNED_TO', 'function' => array('name' => 'get_user_array', 'params' => array(false))),
//       )
//     );

$popupMeta = array(
    'moduleMain' => 'Contact',
    'varName' => 'CONTACT',
    'orderBy' => 'contacts.first_name, contacts.last_name',
    'whereClauses' => array(
        'account_name' => 'accounts.name',
        'name' => 'contacts.name',
        'stic_relationship_type_c' => 'contacts_cstm.stic_relationship_type_c',
        'phone_mobile' => 'contacts.phone_mobile',
        'phone_home' => 'contacts.phone_home',
        'email' => 'contacts.email',
        'assigned_user_id' => 'contacts.assigned_user_id',
    ),
    'searchInputs' => array(
        2 => 'account_name',
        3 => 'email',
        4 => 'name',
        5 => 'stic_relationship_type_c',
        6 => 'phone_mobile',
        7 => 'phone_home',
        8 => 'assigned_user_id',
    ),
    'searchdefs' => array(
        'name' => array(
            'type' => 'name',
            'link' => true,
            'label' => 'LBL_NAME',
            'width' => '10%',
            'name' => 'name',
        ),
        'stic_relationship_type_c' => array(
            'type' => 'multienum',
            'studio' => 'visible',
            'label' => 'LBL_STIC_RELATIONSHIP_TYPE',
            'width' => '10%',
            'name' => 'stic_relationship_type_c',
        ),
        'account_name' => array(
            'name' => 'account_name',
            'type' => 'varchar',
            'width' => '10%',
        ),
        'phone_mobile' => array(
            'type' => 'phone',
            'label' => 'LBL_MOBILE_PHONE',
            'width' => '10%',
            'name' => 'phone_mobile',
        ),
        'phone_home' => array(
            'type' => 'phone',
            'label' => 'LBL_HOME_PHONE',
            'width' => '10%',
            'name' => 'phone_home',
        ),
        'email' => array(
            'name' => 'email',
            'width' => '10%',
        ),
        'assigned_user_id' => array(
            'name' => 'assigned_user_id',
            'type' => 'enum',
            'label' => 'LBL_ASSIGNED_TO',
            'function' => array(
                'name' => 'get_user_array',
                'params' => array(
                    0 => false,
                ),
            ),
            'width' => '10%',
        ),
    ),
    'listviewdefs' => array(
        'NAME' => array(
            'width' => '20%',
            'label' => 'LBL_LIST_NAME',
            'link' => true,
            'default' => true,
            'related_fields' => array(
                0 => 'first_name',
                1 => 'last_name',
                2 => 'salutation',
                3 => 'account_name',
                4 => 'account_id',
            ),
            'name' => 'name',
        ),
        'STIC_RELATIONSHIP_TYPE_C' => array(
            'type' => 'multienum',
            'default' => true,
            'studio' => 'visible',
            'label' => 'LBL_STIC_RELATIONSHIP_TYPE',
            'width' => '10%',
            'name' => 'stic_relationship_type_c',
        ),
        'ACCOUNT_NAME' => array(
            'width' => '25%',
            'label' => 'LBL_LIST_ACCOUNT_NAME',
            'module' => 'Accounts',
            'id' => 'ACCOUNT_ID',
            'default' => true,
            'sortable' => true,
            'ACLTag' => 'ACCOUNT',
            'related_fields' => array(
                0 => 'account_id',
            ),
            'name' => 'account_name',
        ),
        'PHONE_MOBILE' => array(
            'type' => 'phone',
            'label' => 'LBL_MOBILE_PHONE',
            'width' => '10%',
            'default' => true,
        ),
        'PHONE_HOME' => array(
            'type' => 'phone',
            'label' => 'LBL_HOME_PHONE',
            'width' => '10%',
            'default' => true,
        ),
        'EMAIL1' => array(
            'type' => 'varchar',
            'studio' => array(
                'editview' => true,
                'editField' => true,
                'searchview' => false,
                'popupsearch' => false,
            ),
            'label' => 'LBL_EMAIL_ADDRESS',
            'width' => '10%',
            'default' => true,
        ),
        'ASSIGNED_USER_NAME' => array(
            'link' => true,
            'type' => 'relate',
            'label' => 'LBL_ASSIGNED_TO_NAME',
            'id' => 'ASSIGNED_USER_ID',
            'width' => '10%',
            'default' => true,
        ),
    ),
);
// END STIC-Custom 