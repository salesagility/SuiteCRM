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

$dashletData['jjwg_AreasDashlet']['searchFields'] = array(
    'name' =>
        array(
            'default' => '',
        ),
    'city' =>
        array(
            'default' => '',
        ),
    'state' =>
        array(
            'default' => '',
        ),
    'country' =>
        array(
            'default' => '',
        ),
    'assigned_user_name' =>
        array(
            'default' => '',
        ),
    'date_entered' =>
        array(
            'default' => '',
        ),
);
$dashletData['jjwg_AreasDashlet']['columns'] = array(
    'name' =>
        array(
            'width' => '40%',
            'label' => 'LBL_LIST_NAME',
            'link' => true,
            'default' => true,
            'name' => 'name',
        ),
    'city' =>
        array(
            'type' => 'varchar',
            'label' => 'LBL_CITY',
            'width' => '10%',
            'default' => true,
            'name' => 'city',
        ),
    'state' =>
        array(
            'type' => 'varchar',
            'label' => 'LBL_STATE',
            'width' => '10%',
            'default' => true,
            'name' => 'state',
        ),
    'country' =>
        array(
            'type' => 'varchar',
            'label' => 'LBL_COUNTRY',
            'width' => '10%',
            'default' => true,
            'name' => 'country',
        ),
    'assigned_user_name' =>
        array(
            'width' => '8%',
            'label' => 'LBL_LIST_ASSIGNED_USER',
            'name' => 'assigned_user_name',
            'default' => true,
        ),
    'modified_by_name' =>
        array(
            'type' => 'relate',
            'link' => 'modified_user_link',
            'label' => 'LBL_MODIFIED_NAME',
            'width' => '10%',
            'default' => false,
            'name' => 'modified_by_name',
        ),
    'created_by_name' =>
        array(
            'type' => 'relate',
            'link' => 'created_by_link',
            'label' => 'LBL_CREATED',
            'width' => '10%',
            'default' => false,
            'name' => 'created_by_name',
        ),
    'coordinates' =>
        array(
            'type' => 'text',
            'studio' => 'visible',
            'label' => 'LBL_COORDINATES',
            'sortable' => false,
            'width' => '10%',
            'default' => false,
            'name' => 'coordinates',
        ),
    'description' =>
        array(
            'type' => 'text',
            'label' => 'LBL_DESCRIPTION',
            'sortable' => false,
            'width' => '10%',
            'default' => false,
            'name' => 'description',
        ),
    'date_entered' =>
        array(
            'width' => '15%',
            'label' => 'LBL_DATE_ENTERED',
            'default' => false,
            'name' => 'date_entered',
        ),
    'date_modified' =>
        array(
            'width' => '15%',
            'label' => 'LBL_DATE_MODIFIED',
            'name' => 'date_modified',
            'default' => false,
        ),
    'created_by' =>
        array(
            'width' => '8%',
            'label' => 'LBL_CREATED',
            'name' => 'created_by',
            'default' => false,
        ),
);
