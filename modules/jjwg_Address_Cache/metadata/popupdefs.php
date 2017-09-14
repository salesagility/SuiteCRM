<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
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

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$popupMeta = array(
    'moduleMain' => 'jjwg_Adress_Cache',
    'varName' => 'jjwg_Adress_Cache',
    'orderBy' => 'jjwg_adress_cache.name',
    'whereClauses' => array(
        'name' => 'jjwg_adress_cache.name',
        'lat' => 'jjwg_adress_cache.lat',
        'lng' => 'jjwg_adress_cache.lng',
        'date_entered' => 'jjwg_adress_cache.date_entered',
        'assigned_user_name' => 'jjwg_adress_cache.assigned_user_name',
    ),
    'searchInputs' => array(
        1 => 'name',
        4 => 'lat',
        5 => 'lng',
        6 => 'date_entered',
        7 => 'assigned_user_name',
    ),
    'searchdefs' => array(
        'name' =>
            array(
                'type' => 'name',
                'label' => 'LBL_NAME',
                'width' => '10%',
                'name' => 'name',
            ),
        'lat' =>
            array(
                'type' => 'decimal',
                'label' => 'LBL_LAT',
                'width' => '10%',
                'name' => 'lat',
            ),
        'lng' =>
            array(
                'type' => 'decimal',
                'label' => 'LBL_LNG',
                'width' => '10%',
                'name' => 'lng',
            ),
        'date_entered' =>
            array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_ENTERED',
                'width' => '10%',
                'name' => 'date_entered',
            ),
        'assigned_user_name' =>
            array(
                'link' => 'assigned_user_link',
                'type' => 'relate',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'width' => '10%',
                'name' => 'assigned_user_name',
            ),
    ),
    'listviewdefs' => array(
        'NAME' =>
            array(
                'type' => 'name',
                'label' => 'LBL_NAME',
                'width' => '10%',
                'default' => true,
            ),
        'LAT' =>
            array(
                'type' => 'decimal',
                'label' => 'LBL_LAT',
                'width' => '10%',
                'default' => true,
            ),
        'LNG' =>
            array(
                'type' => 'decimal',
                'label' => 'LBL_LNG',
                'width' => '10%',
                'default' => true,
            ),
        'DATE_ENTERED' =>
            array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_ENTERED',
                'width' => '10%',
                'default' => true,
            ),
        'ASSIGNED_USER_NAME' =>
            array(
                'link' => 'assigned_user_link',
                'type' => 'relate',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'width' => '10%',
                'default' => true,
            ),
    ),
);
