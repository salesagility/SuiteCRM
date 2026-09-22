<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/**
 * SuiteCRM is a customer relationship management program developed by SuiteCRM Ltd.
 * Copyright (C) 2026 SuiteCRM Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUITECRM, SUITECRM DISCLAIMS THE
 * WARRANTY OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License
 * version 3, these Appropriate Legal Notices must retain the display of the
 * "Supercharged by SuiteCRM" logo. If the display of the logos is not reasonably
 * feasible for technical reasons, the Appropriate Legal Notices must display
 * the words "Supercharged by SuiteCRM".
 */
$subpanel_layout['list_fields'] = array(
    'document_name' => array(
        'name' => 'document_name',
        'vname' => 'LBL_LIST_DOCUMENT_NAME',
        'widget_class' => 'SubPanelDetailViewLink',
        'module' => 'Documents',
        'width' => '30%',
        'default' => true,
    ),
    'filename' => array(
        'name' => 'filename',
        'vname' => 'LBL_LIST_FILENAME',
        'width' => '30%',
        'default' => true,
    ),
    'status_id' => array(
        'name' => 'status_id',
        'vname' => 'LBL_LIST_STATUS',
        'width' => '15%',
        'default' => true,
    ),
    'category_id' => array(
        'name' => 'category_id',
        'vname' => 'LBL_LIST_CATEGORY',
        'width' => '15%',
        'default' => true,
    ),
    'edit_button' => array(
        'vname' => 'LBL_EDIT_BUTTON',
        'widget_class' => 'SubPanelEditButton',
        'module' => 'Documents',
        'width' => '5%',
        'default' => true,
    ),
    'remove_button' => array(
        'vname' => 'LBL_REMOVE',
        'widget_class' => 'SubPanelRemoveButton',
        'module' => 'Documents',
        'width' => '5%',
        'default' => true,
    ),
);