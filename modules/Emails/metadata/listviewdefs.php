<?php
/**
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
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
$viewdefs['Emails']['ListView'] = [
    'templateMeta' => [
        'form' => [
            'buttons' => [
                [
                    'customCode' => '<a class="btn" data-action="emails-show-compose-modal" title="{$MOD.LBL_COMPOSEEMAIL}"><span class="glyphicon glyphicon-envelope"></span></a>'
                ],
                [
                    'customCode' => '<a class="btn" data-action="emails-configure" title="{$MOD.LBL_EMAILSETTINGS}"><span class="glyphicon glyphicon-cog"></span></a>'
                ],
                [
                    'customCode' => '<a class="btn" data-action="emails-check-new-email" title="{$MOD.LBL_BUTTON_CHECK_TITLE}"><span class="glyphicon glyphicon-refresh"></span></a>'
                ],
                [
                    'customCode' => '<a class="btn" data-action="emails-show-folders-modal" title="{$MOD.LBL_SELECT_FOLDER}"><span class="glyphicon glyphicon-folder-open"></span></a>'
                ],
            ],
            'actions' => [
                [
                    'customCode' => '<a href="javascript:void(0)" class="parent-dropdown-handler" id="delete_listview_top" onclick="return false;"><label class="selected-actions-label hidden-mobile">{$APP.LBL_BULK_ACTION_BUTTON_LABEL_MOBILE}<span class=\'suitepicon suitepicon-action-caret\'></span></label><label class="selected-actions-label hidden-desktop">{$APP.LBL_BULK_ACTION_BUTTON_LABEL}</label></a>',
                ],
                [
                    'customCode' => '<a data-action="emails-import-multiple" title="{$MOD.LBL_IMPORT}">{$MOD.LBL_IMPORT}</a>'
                ],
                [
                    'customCode' => '<a data-action="emails-delete-multiple" title="{$MOD.LBL_BUTTON_DELETE_IMAP}">{$MOD.LBL_BUTTON_DELETE_IMAP}</a>'
                ],
                [
                    'customCode' => '<a data-action="emails-mark" data-for="unread" title="{$MOD.LBL_MARK_UNREAD}">{$MOD.LBL_MARK_UNREAD}</a>',
                ],
                [
                    'customCode' => '<a data-action="emails-mark" data-for="read" title="{$MOD.LBL_MARK_READ}">{$MOD.LBL_MARK_READ}</a>',
                ],
                [
                    'customCode' => '<a data-action="emails-mark" data-for="flagged" title="{$MOD.LBL_MARK_FLAGGED}">{$MOD.LBL_MARK_FLAGGED}</a>',
                ],
                [
                    'customCode' => '<a data-action="emails-mark" data-for="unflagged" title="{$MOD.LBL_MARK_UNFLAGGED}">{$MOD.LBL_MARK_UNFLAGGED}</a>',
                ],
            ],
            'headerTpl' => 'modules/Emails/include/ListView/ListViewHeader.tpl',
        ],
        'includes' => [
            [
                'file' => 'include/javascript/jstree/dist/jstree.js',
            ],
            [
                'file' => 'modules/Emails/include/ListView/ComposeViewModal.js',
            ],
            [
                'file' => 'modules/Emails/include/ListView/SettingsView.js',
            ],
            [
                'file' => 'modules/Emails/include/ListView/CheckNewEmails.js',
            ],
            [
                'file' => 'modules/Emails/include/ListView/FoldersViewModal.js',
            ],
            [
                'file' => 'modules/Emails/include/ListView/ListViewHeader.js',
            ],
            [
                'file' => 'modules/Emails/include/DetailView/ImportView.js',
            ],
            [
                'file' => 'modules/Emails/include/ListView/ImportEmailAction.js',
            ],
            [
                'file' => 'modules/Emails/include/ListView/MarkEmails.js',
            ],
            [
                'file' => 'modules/Emails/include/ListView/DeleteEmailAction.js',
            ],
        ],
        'options' => [
            'hide_edit_link' => true
        ]
    ]
];

$listViewDefs['Emails'] = [
    'FROM_ADDR_NAME' => [
        'width' => '32',
        'label' => 'LBL_LIST_FROM_ADDR',
        'default' => true,
    ],
    'INDICATOR' => [
        'width' => '32',
        'label' => 'LBL_INDICATOR',
        'default' => true,
        'sortable' => false,
        'hide_header_label' => true,
    ],
    'SUBJECT' => [
        // Uses function field
        'width' => '32',
        'label' => 'LBL_LIST_SUBJECT',
        'default' => true,
        'link' => false,
        'customCode' => ''
    ],
    'HAS_ATTACHMENT' => [
        'width' => '32',
        'label' => 'LBL_HAS_ATTACHMENT_INDICATOR',
        'default' => false,
        'sortable' => false,
        'hide_header_label' => true,
    ],
    'ASSIGNED_USER_NAME' => [
        'width' => '9',
        'label' => 'LBL_ASSIGNED_TO_NAME',
        'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => false
    ],
    'DATE_ENTERED' => [
        'width' => '32',
        'label' => 'LBL_DATE_ENTERED',
        'default' => true,
    ],
    'DATE_SENT_RECEIVED' => [
        'width' => '32',
        'label' => 'LBL_LIST_DATE_SENT_RECEIVED',
        'default' => true,
    ],
    'TO_ADDRS_NAMES' => [
        'width' => '32',
        'label' => 'LBL_LIST_TO_ADDR',
        'default' => false,
    ],
    'CATEGORY_ID' => [
        'width' => '10%',
        'label' => 'LBL_LIST_CATEGORY',
        'default' => true,
    ],
];
