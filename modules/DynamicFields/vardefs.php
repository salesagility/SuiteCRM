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

$dictionary['FieldsMetaData'] = [
    'table' => 'fields_meta_data',
    'fields' => [
        'id' => ['name' => 'id', 'type' => 'varchar', 'len' => '255', 'reportable' => false],
        'name' => ['name' => 'name', 'vname' => 'COLUMN_TITLE_NAME', 'type' => 'varchar', 'len' => '255'],
        'vname' => ['name' => 'vname', 'type' => 'varchar', 'vname' => 'COLUMN_TITLE_LABEL',  'len' => '255'],
        'comments' => ['name' => 'comments', 'type' => 'varchar', 'vname' => 'COLUMN_TITLE_LABEL',  'len' => '255'],
        'help' => ['name' => 'help', 'type' => 'varchar', 'vname' => 'COLUMN_TITLE_LABEL',  'len' => '255'],
        'custom_module' => ['name' => 'custom_module',  'type' => 'varchar', 'len' => '255'],
        'type' => ['name' => 'type', 'vname' => 'COLUMN_TITLE_DATA_TYPE',  'type' => 'varchar', 'len' => '255'],
        'len' => ['name' => 'len', 'vname' => 'COLUMN_TITLE_MAX_SIZE', 'type' => 'int', 'len' => '11', 'required' => false, 'validation' => ['type' => 'range', 'min' => 1, 'max' => 255]],
        'required' => ['name' => 'required', 'type' => 'bool', 'default' => '0'],
        'default_value' => ['name' => 'default_value', 'type' => 'varchar', 'len' => '255'],
        'date_modified' => ['name' => 'date_modified', 'type' => 'datetime', 'len' => '255'],
        'deleted' => ['name' => 'deleted', 'type' => 'bool', 'default' => '0', 'reportable' => false],
        'audited' => ['name' => 'audited', 'type' => 'bool', 'default' => '0'],
        'massupdate' => ['name' => 'massupdate', 'type' => 'bool', 'default' => '0'],
        'duplicate_merge' => ['name' => 'duplicate_merge', 'type' => 'short', 'default' => '0'],
        'reportable' => ['name' => 'reportable', 'type' => 'bool', 'default' => '1'],
        'importable' => ['name' => 'importable', 'type' => 'varchar', 'len' => '255'],
        'ext1' => ['name' => 'ext1', 'type' => 'varchar', 'len' => '255', 'default' => ''],
        'ext2' => ['name' => 'ext2', 'type' => 'varchar', 'len' => '255', 'default' => ''],
        'ext3' => ['name' => 'ext3', 'type' => 'varchar', 'len' => '255', 'default' => ''],
        'ext4' => ['name' => 'ext4', 'type' => 'text'],
    ],
    'indices' => [
        ['name' => 'fields_meta_datapk', 'type' => 'primary', 'fields' => ['id']],
        ['name' => 'idx_meta_id_del', 'type' => 'index', 'fields' => ['id', 'deleted']],
        ['name' => 'idx_meta_cm_del', 'type' => 'index', 'fields' => ['custom_module', 'deleted']],
    ],
];
