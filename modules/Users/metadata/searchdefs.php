<?php
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
  // $searchdefs['Users'] = array(
  //                   'templateMeta' => array('maxColumns' => '3', 'maxColumnsBasic' => '4',
  //                           'widths' => array('label' => '10', 'field' => '30'),
  //                          ),
  //                   'layout' => array(
  //                       'basic_search' => array(
  //                           array('name'=>'search_name','label' =>'LBL_NAME', 'type' => 'name'),
  //                           ),
  //                       'advanced_search' => array(
  //                           'first_name',
  //                           'last_name',
  //                           'user_name',
  //                           'status',
  //                           'is_admin',
  //                           'title',
  //                           'is_group',
  //                           'department',
  //                           'phone' =>
  //                             array(
  //                               'name' => 'phone',
  //                               'label' => 'LBL_ANY_PHONE',
  //                               'type' => 'name',
  //                               'default' => true,
  //                               'width' => '10%',
  //                             ),
  //                           'address_street' =>
  //                             array(
  //                               'name' => 'address_street',
  //                               'label' => 'LBL_ANY_ADDRESS',
  //                               'type' => 'name',
  //                               'default' => true,
  //                               'width' => '10%',
  //                             ),
  //                           'email' =>
  //                             array(
  //                               'name' => 'email',
  //                               'label' => 'LBL_ANY_EMAIL',
  //                               'type' => 'name',
  //                               'default' => true,
  //                               'width' => '10%',
  //                             ),
  //                             'address_city' =>
  //                             array(
  //                               'name' => 'address_city',
  //                               'label' => 'LBL_CITY',
  //                               'type' => 'name',
  //                               'default' => true,
  //                               'width' => '10%',
  //                             ),
  //                           'address_state' =>
  //                             array(
  //                               'name' => 'address_state',
  //                               'label' => 'LBL_STATE',
  //                               'type' => 'name',
  //                               'default' => true,
  //                               'width' => '10%',
  //                             ),
  //                             'address_postalcode' =>
  //                             array(
  //                               'name' => 'address_postalcode',
  //                               'label' => 'LBL_POSTAL_CODE',
  //                               'type' => 'name',
  //                               'default' => true,
  //                               'width' => '10%',
  //                             ),
                             
  //                           'address_country' =>
  //                             array(
  //                               'name' => 'address_country',
  //                               'label' => 'LBL_COUNTRY',
  //                               'type' => 'name',
  //                               'default' => true,
  //                               'width' => '10%',
  //                             ),
  //                           ),
  //                   ),
  //              );

  $searchdefs ['Users'] = 
  array (
    'layout' => 
    array (
      'basic_search' => 
      array (
        0 => 
        array (
          'name' => 'search_name',
          'label' => 'LBL_NAME',
          'type' => 'name',
        ),
      ),
      'advanced_search' => 
      array (
        'first_name' => 
        array (
          'name' => 'first_name',
          'default' => true,
          'width' => '10%',
        ),
        'last_name' => 
        array (
          'name' => 'last_name',
          'default' => true,
          'width' => '10%',
        ),
        'user_name' => 
        array (
          'name' => 'user_name',
          'default' => true,
          'width' => '10%',
        ),
        'status' => 
        array (
          'name' => 'status',
          'default' => true,
          'width' => '10%',
        ),
        'is_admin' => 
        array (
          'name' => 'is_admin',
          'default' => true,
          'width' => '10%',
        ),
        'sda_allowed_c' => 
        array (
          'type' => 'bool',
          'default' => true,
          'studio' => 'visible',
          'label' => 'LBL_SDA_ALLOWED',
          'width' => '10%',
          'name' => 'sda_allowed_c',
        ),
        'stic_work_calendar_c' => 
        array (
          'type' => 'bool',
          'default' => true,
          'studio' => 'visible',
          'label' => 'LBL_STIC_WORK_CALENDAR',
          'width' => '10%',
          'name' => 'stic_work_calendar_c',
        ),
        'stic_clock_c' => 
        array (
          'type' => 'bool',
          'default' => true,
          'studio' => 'visible',
          'label' => 'LBL_STIC_CLOCK',
          'width' => '10%',
          'name' => 'stic_clock_c',
        ),        
        'title' => 
        array (
          'name' => 'title',
          'default' => true,
          'width' => '10%',
        ),
        'is_group' => 
        array (
          'name' => 'is_group',
          'default' => true,
          'width' => '10%',
        ),
        'department' => 
        array (
          'name' => 'department',
          'default' => true,
          'width' => '10%',
        ),
        'phone' => 
        array (
          'name' => 'phone',
          'label' => 'LBL_ANY_PHONE',
          'type' => 'name',
          'default' => true,
          'width' => '10%',
        ),
        'address_street' => 
        array (
          'name' => 'address_street',
          'label' => 'LBL_ANY_ADDRESS',
          'type' => 'name',
          'default' => true,
          'width' => '10%',
        ),
        'email' => 
        array (
          'name' => 'email',
          'label' => 'LBL_ANY_EMAIL',
          'type' => 'name',
          'default' => true,
          'width' => '10%',
        ),
        'address_city' => 
        array (
          'name' => 'address_city',
          'label' => 'LBL_CITY',
          'type' => 'name',
          'default' => true,
          'width' => '10%',
        ),
        'address_state' => 
        array (
          'name' => 'address_state',
          'label' => 'LBL_STATE',
          'type' => 'name',
          'default' => true,
          'width' => '10%',
        ),
        'address_postalcode' => 
        array (
          'name' => 'address_postalcode',
          'label' => 'LBL_POSTAL_CODE',
          'type' => 'name',
          'default' => true,
          'width' => '10%',
        ),
        'address_country' => 
        array (
          'name' => 'address_country',
          'label' => 'LBL_COUNTRY',
          'type' => 'name',
          'default' => true,
          'width' => '10%',
        ),
      ),
    ),
    'templateMeta' => 
    array (
      'maxColumns' => '3',
      'maxColumnsBasic' => '4',
      'widths' => 
      array (
        'label' => '10',
        'field' => '30',
      ),
    ),
);
// END STIC-Custom