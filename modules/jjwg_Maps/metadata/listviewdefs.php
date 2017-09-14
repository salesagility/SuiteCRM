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

$module_name = 'jjwg_Maps';

$listViewDefs[$module_name] =
    array(
        'MAP_ACTION' =>
            array(
                'type' => 'url',
                'label' => 'LBL_MAP_DISPLAY',
                'width' => '10%',
                'sortable' => false,
                'link' => true,
                'default' => true,
                'related_fields' =>
                    array(
                        0 => 'parent_type',
                        1 => 'module_type',
                        2 => 'id',
                    ),
                'customCode' => '<a href="index.php?module=' . $module_name . '&action=map_display' .
                    '&relate_module={$PARENT_TYPE}&display_module={$MODULE_TYPE}&record={$ID}" >' . $GLOBALS['app_strings']['LBL_MAP'] . ' {$MODULE_TYPE}</a>',
            ),
        'NAME' =>
            array(
                'width' => '25%',
                'label' => 'LBL_NAME',
                'default' => true,
                'link' => true,
            ),
        'PARENT_NAME' =>
            array(
                'type' => 'parent',
                'studio' => 'visible',
                'label' => 'LBL_FLEX_RELATE',
                'link' => true,
                'sortable' => false,
                'ACLTag' => 'PARENT',
                'dynamic_module' => 'PARENT_TYPE',
                'id' => 'PARENT_ID',
                'related_fields' =>
                    array(
                        0 => 'parent_id',
                        1 => 'parent_type',
                    ),
                'width' => '25%',
                'default' => true,
            ),
        'MODULE_TYPE' =>
            array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_MODULE_TYPE',
                'sortable' => false,
                'width' => '10%',
            ),
        'DISTANCE' =>
            array(
                'type' => 'float',
                'label' => 'LBL_DISTANCE',
                'width' => '10%',
                'default' => true,
            ),
        'UNIT_TYPE' =>
            array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_UNIT_TYPE',
                'sortable' => false,
                'width' => '10%',
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
                'width' => '9%',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'default' => true,
            ),
        'DESCRIPTION' =>
            array(
                'type' => 'text',
                'label' => 'LBL_DESCRIPTION',
                'sortable' => false,
                'width' => '10%',
                'default' => false,
            ),
        'CREATED_BY_NAME' =>
            array(
                'type' => 'relate',
                'link' => 'created_by_link',
                'label' => 'LBL_CREATED',
                'width' => '10%',
                'default' => false,
            ),
        'DATE_MODIFIED' =>
            array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_MODIFIED',
                'width' => '10%',
                'default' => false,
            ),
    );
