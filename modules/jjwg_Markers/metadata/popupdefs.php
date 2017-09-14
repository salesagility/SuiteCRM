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
    'moduleMain' => 'jjwg_Markers',
    'varName' => 'jjwg_Markers',
    'orderBy' => 'jjwg_markers.name',
    'whereClauses' => array(
        'name' => 'jjwg_markers.name',
        'city' => 'jjwg_markers.city',
        'state' => 'jjwg_markers.state',
        'country' => 'jjwg_markers.country',
        'marker_image' => 'jjwg_markers.marker_image',
        'assigned_user_name' => 'jjwg_markers.assigned_user_name',
        'date_entered' => 'jjwg_markers.date_entered',
    ),
    'searchInputs' => array(
        1 => 'name',
        4 => 'city',
        5 => 'state',
        6 => 'country',
        7 => 'marker_image',
        8 => 'assigned_user_name',
        9 => 'date_entered',
    ),
    'searchdefs' => array(
        'name' =>
            array(
                'type' => 'name',
                'label' => 'LBL_NAME',
                'width' => '10%',
                'name' => 'name',
            ),
        'city' =>
            array(
                'type' => 'varchar',
                'label' => 'LBL_CITY',
                'width' => '10%',
                'name' => 'city',
            ),
        'state' =>
            array(
                'type' => 'varchar',
                'label' => 'LBL_STATE',
                'width' => '10%',
                'name' => 'state',
            ),
        'country' =>
            array(
                'type' => 'varchar',
                'label' => 'LBL_COUNTRY',
                'width' => '10%',
                'name' => 'country',
            ),
        'marker_image' =>
            array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_MARKER_IMAGE',
                'sortable' => false,
                'width' => '10%',
                'name' => 'marker_image',
            ),
        'assigned_user_name' =>
            array(
                'link' => 'assigned_user_link',
                'type' => 'relate',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'width' => '10%',
                'name' => 'assigned_user_name',
            ),
        'date_entered' =>
            array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_ENTERED',
                'width' => '10%',
                'name' => 'date_entered',
            ),
    ),
    'listviewdefs' => array(
        'NAME' =>
            array(
                'type' => 'name',
                'label' => 'LBL_NAME',
                'width' => '10%',
                'default' => true,
                'name' => 'name',
            ),
        'CITY' =>
            array(
                'type' => 'varchar',
                'label' => 'LBL_CITY',
                'width' => '10%',
                'default' => true,
                'name' => 'city',
            ),
        'STATE' =>
            array(
                'type' => 'varchar',
                'label' => 'LBL_STATE',
                'width' => '10%',
                'default' => true,
                'name' => 'state',
            ),
        'COUNTRY' =>
            array(
                'type' => 'varchar',
                'label' => 'LBL_COUNTRY',
                'width' => '10%',
                'default' => true,
                'name' => 'country',
            ),
        'MARKER_IMAGE' =>
            array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_MARKER_IMAGE',
                'sortable' => false,
                'width' => '10%',
            ),
        'ASSIGNED_USER_NAME' =>
            array(
                'link' => 'assigned_user_link',
                'type' => 'relate',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'width' => '10%',
                'default' => true,
                'name' => 'assigned_user_name',
            ),
    ),
);
