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

$dictionary['Administration'] = ['table' => 'config', 'comment' => 'System table containing system-wide definitions', 'fields' => [
    'category' => [
        'name' => 'category',
        'vname' => 'LBL_LIST_SYMBOL',
        'type' => 'varchar',
        'len' => '32',
        'comment' => 'Settings are grouped under this category; arbitraily defined based on requirements'
    ],
    'name' => [
        'name' => 'name',
        'vname' => 'LBL_LIST_NAME',
        'type' => 'varchar',
        'len' => '32',
        'comment' => 'The name given to the setting'
    ],
    'value' => [
        'name' => 'value',
        'vname' => 'LBL_LIST_RATE',
        'type' => 'text',
        'comment' => 'The value given to the setting'
    ],
], 'indices' => [['name' => 'idx_config_cat', 'type' => 'index',  'fields' => ['category']]]
];

$dictionary['UpgradeHistory'] = [
    'table' => 'upgrade_history', 'comment' => 'Tracks Sugar upgrades made over time; used by Upgrade Wizard and Module Loader',
    'fields' => [
        'id' => [
            'name' => 'id',
            'type' => 'id',
            'required' => true,
            'reportable' => false,
            'comment' => 'Unique identifier'
        ],
        'filename' => [
            'name' => 'filename',
            'type' => 'varchar',
            'len' => '255',
            'comment' => 'Cached filename containing the upgrade scripts and content'
        ],
        'md5sum' => [
            'name' => 'md5sum',
            'type' => 'varchar',
            'len' => '32',
            'comment' => 'The MD5 checksum of the upgrade file'
        ],
        'type' => [
            'name' => 'type',
            'type' => 'varchar',
            'len' => '30',
            'comment' => 'The upgrade type (module, patch, theme, etc)'
        ],
        'status' => [
            'name' => 'status',
            'type' => 'varchar',
            'len' => '50',
            'comment' => 'The status of the upgrade (ex:  "installed")',
        ],
        'version' => [
            'name' => 'version',
            'type' => 'varchar',
            'len' => '64',
            'comment' => 'Version as contained in manifest file'
        ],
        'name' => [
            'name' => 'name',
            'type' => 'varchar',
            'len' => '255',
        ],
        'description' => [
            'name' => 'description',
            'type' => 'text',
        ],
        'id_name' => [
            'name' => 'id_name',
            'type' => 'varchar',
            'len' => '255',
            'comment' => 'The unique id of the module'
        ],
        'manifest' => [
            'name' => 'manifest',
            'type' => 'longtext',
            'comment' => 'A serialized copy of the manifest file.'
        ],
        'date_entered' => [
            'name' => 'date_entered',
            'type' => 'datetime',
            'required' => true,
            'comment' => 'Date of upgrade or module load'
        ],
        'enabled' => [
            'name' => 'enabled',
            'type' => 'bool',
            'len' => '1',
            'default' => '1',
        ],
    ],

    'indices' => [
        ['name' => 'upgrade_history_pk',     'type' => 'primary', 'fields' => ['id']],
        ['name' => 'upgrade_history_md5_uk', 'type' => 'unique',  'fields' => ['md5sum']],
    ],
];
