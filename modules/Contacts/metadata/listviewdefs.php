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

// STIC-Custom - MHP - 20240201 - Override the core metadata files with the custom metadata files 
// https://github.com/SinergiaTIC/SinergiaCRM/pull/105
// $listViewDefs['Contacts'] = array(
//     'NAME' => array(
//         'width' => '20%',
//         'label' => 'LBL_LIST_NAME',
//         'link' => true,
//         'contextMenu' => array('objectType' => 'sugarPerson',
//                                'metaData' => array('contact_id' => '{$ID}',
//                                                    'module' => 'Contacts',
//                                                    'return_action' => 'ListView',
//                                                    'contact_name' => '{$FULL_NAME}',
//                                                    'parent_id' => '{$ACCOUNT_ID}',
//                                                    'parent_name' => '{$ACCOUNT_NAME}',
//                                                    'return_module' => 'Contacts',
//                                                    'return_action' => 'ListView',
//                                                    'parent_type' => 'Account',
//                                                    'notes_parent_type' => 'Account')
//                               ),
//         'orderBy' => 'name',
//         'default' => true,
//         'related_fields' => array('first_name', 'last_name', 'salutation', 'account_name', 'account_id'),
//         ),
//     'TITLE' => array(
//         'width' => '15%',
//         'label' => 'LBL_LIST_TITLE',
//         'default' => true),
//     'ACCOUNT_NAME' => array(
//         'width' => '34%',
//         'label' => 'LBL_LIST_ACCOUNT_NAME',
//         'module' => 'Accounts',
//         'id' => 'ACCOUNT_ID',
//         'link' => true,
//         'contextMenu' => array('objectType' => 'sugarAccount',
//                                'metaData' => array('return_module' => 'Contacts',
//                                                    'return_action' => 'ListView',
//                                                    'module' => 'Accounts',
//                                                    'return_action' => 'ListView',
//                                                    'parent_id' => '{$ACCOUNT_ID}',
//                                                    'parent_name' => '{$ACCOUNT_NAME}',
//                                                    'account_id' => '{$ACCOUNT_ID}',
//                                                    'account_name' => '{$ACCOUNT_NAME}'),
//                               ),
//         'default' => true,
//         'sortable'=> true,
//         'ACLTag' => 'ACCOUNT',
//         'related_fields' => array('account_id')),
//     'EMAIL1' => array(
//         'width' => '15%',
//         'label' => 'LBL_LIST_EMAIL_ADDRESS',
//         'sortable' => false,
//         'link' => true,
//         'customCode' => '{$EMAIL1_LINK}',
//         'default' => true
//         ),
//     'PHONE_WORK' => array(
//         'width' => '15%',
//         'label' => 'LBL_OFFICE_PHONE',
//         'default' => true),
//     'DEPARTMENT' => array(
//         'width' => '10',
//         'label' => 'LBL_DEPARTMENT'),
//     'DO_NOT_CALL' => array(
//         'width' => '10',
//         'label' => 'LBL_DO_NOT_CALL'),
//     'PHONE_HOME' => array(
//         'width' => '10',
//         'label' => 'LBL_HOME_PHONE'),
//     'PHONE_MOBILE' => array(
//         'width' => '10',
//         'label' => 'LBL_MOBILE_PHONE'),
//     'PHONE_OTHER' => array(
//         'width' => '10',
//         'label' => 'LBL_OTHER_PHONE'),
//     'PHONE_FAX' => array(
//         'width' => '10',
//         'label' => 'LBL_FAX_PHONE'),
//     'EMAIL2' => array(
//         'width' => '15',
//         'label' => 'LBL_LIST_EMAIL_ADDRESS',
//         'sortable' => false,
//         'customCode' => '{$EMAIL2_LINK}{$EMAIL2}</a>'),
//     'EMAIL_OPT_OUT' => array(
//         'width' => '10',
        
//         'label' => 'LBL_EMAIL_OPT_OUT'),
//     'PRIMARY_ADDRESS_STREET' => array(
//         'width' => '10',
//         'label' => 'LBL_PRIMARY_ADDRESS_STREET'),
//     'PRIMARY_ADDRESS_CITY' => array(
//         'width' => '10',
//         'label' => 'LBL_PRIMARY_ADDRESS_CITY'),
//     'PRIMARY_ADDRESS_STATE' => array(
//         'width' => '10',
//         'label' => 'LBL_PRIMARY_ADDRESS_STATE'),
//     'PRIMARY_ADDRESS_POSTALCODE' => array(
//         'width' => '10',
//         'label' => 'LBL_PRIMARY_ADDRESS_POSTALCODE'),
//     'ALT_ADDRESS_COUNTRY' => array(
//         'width' => '10',
//         'label' => 'LBL_ALT_ADDRESS_COUNTRY'),
//     'ALT_ADDRESS_STREET' => array(
//         'width' => '10',
//         'label' => 'LBL_ALT_ADDRESS_STREET'),
//     'ALT_ADDRESS_CITY' => array(
//         'width' => '10',
//         'label' => 'LBL_ALT_ADDRESS_CITY'),
//     'ALT_ADDRESS_STATE' => array(
//         'width' => '10',
//         'label' => 'LBL_ALT_ADDRESS_STATE'),
//     'ALT_ADDRESS_POSTALCODE' => array(
//         'width' => '10',
//         'label' => 'LBL_ALT_ADDRESS_POSTALCODE'),
//     'ALT_ADDRESS_COUNTRY' => array(
//         'width' => '10',
//         'label' => 'LBL_ALT_ADDRESS_COUNTRY'),
//     'CREATED_BY_NAME' => array(
//         'width' => '10',
//         'label' => 'LBL_CREATED'),
//     'ASSIGNED_USER_NAME' => array(
//         'width' => '10',
//         'label' => 'LBL_LIST_ASSIGNED_USER',
//         'module' => 'Employees',
//         'id' => 'ASSIGNED_USER_ID',
//         'default' => true),
//     'MODIFIED_BY_NAME' => array(
//         'width' => '10',
//         'label' => 'LBL_MODIFIED'),
//     'SYNC_CONTACT' => array(
//         'type' => 'bool',
//         'label' => 'LBL_SYNC_CONTACT',
//         'width' => '10%',
//         'default' => false,
//         'sortable' => false,
//         ),
//     'DATE_ENTERED' => array(
//         'width' => '10',
//         'label' => 'LBL_DATE_ENTERED',
//         'default' => true)
// );

$listViewDefs['Contacts'] = array (
    'NAME' => 
    array (
      'width' => '20%',
      'label' => 'LBL_LIST_NAME',
      'link' => true,
      'contextMenu' => 
      array (
        'objectType' => 'sugarPerson',
        'metaData' => 
        array (
          'contact_id' => '{$ID}',
          'module' => 'Contacts',
          'return_action' => 'ListView',
          'contact_name' => '{$FULL_NAME}',
          'parent_id' => '{$ACCOUNT_ID}',
          'parent_name' => '{$ACCOUNT_NAME}',
          'return_module' => 'Contacts',
          'parent_type' => 'Account',
          'notes_parent_type' => 'Account',
        ),
      ),
      'orderBy' => 'name',
      'default' => true,
      'related_fields' => 
      array (
        0 => 'first_name',
        1 => 'last_name',
        2 => 'salutation',
        3 => 'account_name',
        4 => 'account_id',
      ),
    ),
    'STIC_RELATIONSHIP_TYPE_C' => 
    array (
      'type' => 'multienum',
      'default' => true,
      'studio' => 'visible',
      'label' => 'LBL_STIC_RELATIONSHIP_TYPE',
      'width' => '10%',
    ),
    'ACCOUNT_NAME' => 
    array (
      'width' => '34%',
      'label' => 'LBL_LIST_ACCOUNT_NAME',
      'module' => 'Accounts',
      'id' => 'ACCOUNT_ID',
      'link' => true,
      'contextMenu' => 
      array (
        'objectType' => 'sugarAccount',
        'metaData' => 
        array (
          'return_module' => 'Contacts',
          'return_action' => 'ListView',
          'module' => 'Accounts',
          'parent_id' => '{$ACCOUNT_ID}',
          'parent_name' => '{$ACCOUNT_NAME}',
          'account_id' => '{$ACCOUNT_ID}',
          'account_name' => '{$ACCOUNT_NAME}',
        ),
      ),
      'default' => true,
      'sortable' => true,
      'ACLTag' => 'ACCOUNT',
      'related_fields' => 
      array (
        0 => 'account_id',
      ),
    ),
    'PHONE_MOBILE' => 
    array (
      'width' => '10%',
      'label' => 'LBL_MOBILE_PHONE',
      'default' => true,
    ),
    'PHONE_HOME' => 
    array (
      'width' => '10%',
      'label' => 'LBL_HOME_PHONE',
      'default' => true,
    ),
    'EMAIL1' => 
    array (
      'width' => '15%',
      'label' => 'LBL_LIST_EMAIL_ADDRESS',
      'sortable' => false,
      'link' => true,
      'customCode' => '{$EMAIL1_LINK}',
      'default' => true,
    ),
    'ASSIGNED_USER_NAME' => 
    array (
      'width' => '10%',
      'label' => 'LBL_LIST_ASSIGNED_USER',
      'module' => 'Employees',
      'id' => 'ASSIGNED_USER_ID',
      'default' => true,
    ),
    'FIRST_NAME' => 
    array (
      'type' => 'varchar',
      'label' => 'LBL_FIRST_NAME',
      'width' => '10%',
      'default' => false,
    ),
    'LAST_NAME' => 
    array (
      'type' => 'varchar',
      'label' => 'LBL_LAST_NAME',
      'width' => '10%',
      'default' => false,
    ),
    'STIC_IDENTIFICATION_TYPE_C' => 
    array (
      'type' => 'enum',
      'default' => false,
      'studio' => 'visible',
      'label' => 'LBL_STIC_IDENTIFICATION_TYPE',
      'width' => '10%',
    ),
    'STIC_IDENTIFICATION_NUMBER_C' => 
    array (
      'type' => 'varchar',
      'default' => false,
      'studio' => 'visible',
      'label' => 'LBL_STIC_IDENTIFICATION_NUMBER',
      'width' => '10%',
    ),
    'EMAIL2' => 
    array (
      'width' => '15%',
      'label' => 'LBL_LIST_EMAIL_ADDRESS',
      'sortable' => false,
      'customCode' => '{$EMAIL2_LINK}{$EMAIL2}</a>',
      'default' => false,
    ),
    'PHONE_OTHER' => 
    array (
      'width' => '10%',
      'label' => 'LBL_OTHER_PHONE',
      'default' => false,
    ),
    'STIC_GENDER_C' => 
    array (
      'type' => 'enum',
      'default' => false,
      'studio' => 'visible',
      'label' => 'LBL_STIC_GENDER',
      'width' => '10%',
    ),
    'STIC_LANGUAGE_C' => 
    array (
      'type' => 'enum',
      'default' => false,
      'studio' => 'visible',
      'label' => 'LBL_STIC_LANGUAGE',
      'width' => '10%',
    ),
    'BIRTHDATE' => 
    array (
      'type' => 'date',
      'label' => 'LBL_BIRTHDATE',
      'width' => '10%',
      'default' => false,
    ),
    'STIC_AGE_C' => 
    array (
      'type' => 'int',
      'default' => false,
      'studio' => 
      array (
        'editview' => false,
        'quickcreate' => false,
      ),
      'label' => 'LBL_STIC_AGE',
      'width' => '10%',
    ),
    'PHONE_WORK' => 
    array (
      'width' => '15%',
      'label' => 'LBL_OFFICE_PHONE',
      'default' => false,
    ),
    'STIC_ACQUISITION_CHANNEL_C' => 
    array (
      'type' => 'enum',
      'default' => false,
      'studio' => 'visible',
      'label' => 'LBL_STIC_ACQUISITION_CHANNEL',
      'width' => '10%',
    ),
    'STIC_PREFERRED_CONTACT_CHANNEL_C' => 
    array (
      'type' => 'enum',
      'default' => false,
      'studio' => 'visible',
      'label' => 'LBL_STIC_PREFERRED_CONTACT_CHANNEL',
      'width' => '10%',
    ),
    'STIC_REFERRAL_AGENT_C' => 
    array (
      'type' => 'enum',
      'default' => false,
      'studio' => 'visible',
      'label' => 'LBL_STIC_REFERRAL_AGENT',
      'width' => '10%',
    ),
    'STIC_EMPLOYMENT_STATUS_C' => 
    array (
      'type' => 'enum',
      'default' => false,
      'studio' => 'visible',
      'label' => 'LBL_STIC_EMPLOYMENT_STATUS',
      'width' => '10%',
    ),
    'STIC_PROFESSIONAL_SECTOR_C' => 
    array (
      'type' => 'varchar',
      'default' => false,
      'studio' => 'visible',
      'label' => 'LBL_STIC_PROFESSIONAL_SECTOR',
      'width' => '10%',
    ),
    'STIC_PROFESSIONAL_SECTOR_OTHER_C' => 
    array (
      'type' => 'varchar',
      'default' => false,
      'studio' => 'visible',
      'label' => 'LBL_STIC_PROFESSIONAL_SECTOR_OTHER',
      'width' => '10%',
    ),
    'TITLE' => 
    array (
      'width' => '15%',
      'label' => 'LBL_LIST_TITLE',
      'default' => false,
    ),
    'DEPARTMENT' => 
    array (
      'width' => '10%',
      'label' => 'LBL_DEPARTMENT',
      'default' => false,
    ),
    'STIC_DO_NOT_SEND_POSTAL_MAIL_C' => 
    array (
      'type' => 'bool',
      'default' => false,
      'studio' => 'visible',
      'label' => 'LBL_STIC_DO_NOT_SEND_POSTAL_MAIL',
      'width' => '10%',
    ),
    'STIC_PRIMARY_ADDRESS_TYPE_C' => 
    array (
      'type' => 'enum',
      'default' => false,
      'studio' => 'visible',
      'label' => 'LBL_STIC_PRIMARY_ADDRESS_TYPE',
      'width' => '10%',
    ),
    'PRIMARY_ADDRESS_STREET' => 
    array (
      'width' => '10%',
      'label' => 'LBL_PRIMARY_ADDRESS_STREET',
      'default' => false,
    ),
    'PRIMARY_ADDRESS_POSTALCODE' => 
    array (
      'width' => '10%',
      'label' => 'LBL_PRIMARY_ADDRESS_POSTALCODE',
      'default' => false,
    ),
    'PRIMARY_ADDRESS_CITY' => 
    array (
      'width' => '10%',
      'label' => 'LBL_PRIMARY_ADDRESS_CITY',
      'default' => false,
    ),
    'STIC_PRIMARY_ADDRESS_COUNTY_C' => 
    array (
      'type' => 'enum',
      'default' => false,
      'studio' => 'visible',
      'label' => 'LBL_STIC_PRIMARY_ADDRESS_COUNTY',
      'width' => '10%',
    ),
    'STIC_PRIMARY_ADDRESS_REGION_C' => 
    array (
      'type' => 'enum',
      'default' => false,
      'studio' => 'visible',
      'label' => 'LBL_STIC_PRIMARY_ADDRESS_REGION',
      'width' => '10%',
    ),
    'PRIMARY_ADDRESS_STATE' => 
    array (
      'width' => '10%',
      'label' => 'LBL_PRIMARY_ADDRESS_STATE',
      'default' => false,
    ),
    'PRIMARY_ADDRESS_COUNTRY' => 
    array (
      'type' => 'varchar',
      'label' => 'LBL_PRIMARY_ADDRESS_COUNTRY',
      'width' => '10%',
      'default' => false,
    ),
    'ALT_ADDRESS_STREET' => 
    array (
      'width' => '10%',
      'label' => 'LBL_ALT_ADDRESS_STREET',
      'default' => false,
    ),
    'ALT_ADDRESS_POSTALCODE' => 
    array (
      'width' => '10%',
      'label' => 'LBL_ALT_ADDRESS_POSTALCODE',
      'default' => false,
    ),
    'ALT_ADDRESS_CITY' => 
    array (
      'width' => '10%',
      'label' => 'LBL_ALT_ADDRESS_CITY',
      'default' => false,
    ),
    'STIC_ALT_ADDRESS_COUNTY_C' => 
    array (
      'type' => 'enum',
      'default' => false,
      'studio' => 'visible',
      'label' => 'LBL_STIC_ALT_ADDRESS_COUNTY',
      'width' => '10%',
    ),
    'ALT_ADDRESS_STATE' => 
    array (
      'width' => '10%',
      'label' => 'LBL_ALT_ADDRESS_STATE',
      'default' => false,
    ),
    'STIC_ALT_ADDRESS_REGION_C' => 
    array (
      'type' => 'enum',
      'default' => false,
      'studio' => 'visible',
      'label' => 'LBL_STIC_ALT_ADDRESS_REGION',
      'width' => '10%',
    ),
    'ALT_ADDRESS_COUNTRY' => 
    array (
      'width' => '10%',
      'label' => 'LBL_ALT_ADDRESS_COUNTRY',
      'default' => false,
    ),
    'STIC_ALT_ADDRESS_TYPE_C' => 
    array (
      'type' => 'enum',
      'default' => false,
      'studio' => 'visible',
      'label' => 'LBL_STIC_ALT_ADDRESS_TYPE',
      'width' => '10%',
    ),
    'STIC_TOTAL_ANNUAL_DONATIONS_C' => 
    array (
      'type' => 'currency',
      'default' => false,
      'studio' => 
      array (
        'editview' => false,
        'quickcreate' => false,
      ),
      'label' => 'LBL_STIC_TOTAL_ANNUAL_DONATIONS',
      'currency_format' => true,
      'width' => '10%',
    ),
    'STIC_182_EXCLUDED_C' => 
    array (
      'type' => 'bool',
      'default' => false,
      'studio' => 'visible',
      'label' => 'LBL_STIC_182_EXCLUDED',
      'width' => '10%',
    ),
    'STIC_182_ERROR_C' => 
    array (
      'type' => 'bool',
      'default' => false,
      'studio' => 
      array (
        'editview' => false,
        'quickcreate' => false,
      ),
      'label' => 'LBL_STIC_182_ERROR',
      'width' => '10%',
    ),
    'DO_NOT_CALL' => 
    array (
      'width' => '10%',
      'label' => 'LBL_DO_NOT_CALL',
      'default' => false,
    ),
    'STIC_POSTAL_MAIL_RETURN_REASON_C' => 
    array (
      'type' => 'enum',
      'default' => false,
      'studio' => 'visible',
      'label' => 'LBL_STIC_POSTAL_MAIL_RETURN_REASON',
      'width' => '10%',
    ),
    'CAMPAIGN_NAME' => 
    array (
      'type' => 'relate',
      'link' => true,
      'label' => 'LBL_CAMPAIGN',
      'id' => 'CAMPAIGN_ID',
      'width' => '10%',
      'default' => false,
    ),
    'JJWG_MAPS_ADDRESS_C' => 
    array (
      'type' => 'varchar',
      'default' => false,
      'label' => 'LBL_JJWG_MAPS_ADDRESS',
      'width' => '10%',
    ),
    'JJWG_MAPS_LNG_C' => 
    array (
      'type' => 'float',
      'default' => false,
      'label' => 'LBL_JJWG_MAPS_LNG',
      'width' => '10%',
    ),
    'JJWG_MAPS_LAT_C' => 
    array (
      'type' => 'float',
      'default' => false,
      'label' => 'LBL_JJWG_MAPS_LAT',
      'width' => '10%',
    ),
    'JJWG_MAPS_GEOCODE_STATUS_C' => 
    array (
      'type' => 'varchar',
      'default' => false,
      'label' => 'LBL_JJWG_MAPS_GEOCODE_STATUS',
      'width' => '10%',
    ),
    'LAWFUL_BASIS_SOURCE' => 
    array (
      'type' => 'enum',
      'label' => 'LBL_LAWFUL_BASIS_SOURCE',
      'width' => '10%',
      'default' => false,
    ),
    'DATE_REVIEWED' => 
    array (
      'type' => 'date',
      'label' => 'LBL_DATE_REVIEWED',
      'width' => '10%',
      'default' => false,
    ),
    'LAWFUL_BASIS' => 
    array (
      'type' => 'multienum',
      'label' => 'LBL_LAWFUL_BASIS',
      'width' => '10%',
      'default' => false,
    ),
    'DESCRIPTION' => 
    array (
      'type' => 'text',
      'label' => 'LBL_DESCRIPTION',
      'sortable' => false,
      'width' => '10%',
      'default' => false,
    ),
    'CREATED_BY_NAME' => 
    array (
      'width' => '10%',
      'label' => 'LBL_CREATED',
      'default' => false,
    ),
    'DATE_ENTERED' => 
    array (
      'width' => '10%',
      'label' => 'LBL_DATE_ENTERED',
      'default' => false,
    ),
    'MODIFIED_BY_NAME' => 
    array (
      'width' => '10%',
      'label' => 'LBL_MODIFIED',
      'default' => false,
    ),
    'DATE_MODIFIED' => 
    array (
      'type' => 'datetime',
      'label' => 'LBL_DATE_MODIFIED',
      'width' => '10%',
      'default' => false,
    ),
);  
// END STIC-Custom 