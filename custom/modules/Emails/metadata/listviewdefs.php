<?php
/**
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */
$listViewDefs ['Emails'] = 
array (
  'INDICATOR' => 
  array (
    'width' => '32%',
    'label' => 'LBL_INDICATOR',
    'default' => true,
    'sortable' => false,
    'hide_header_label' => true,
  ),
  'NAME' => 
  array (
    'type' => 'name',
    'link' => true,
    'label' => 'LBL_SUBJECT',
    'width' => '10%',
    'default' => true,
  ),
  'FROM_ADDR_NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_LIST_FROM_ADDR',
    'default' => true,
  ),
  'DATE_SENT_RECEIVED' => 
  array (
    'width' => '32%',
    'label' => 'LBL_LIST_DATE_SENT_RECEIVED',
    'default' => true,
  ),
  'CATEGORY_ID' => 
  array (
    'width' => '10%',
    'label' => 'LBL_LIST_CATEGORY',
    'default' => true,
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '9%',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => true,
  ),
  'STATUS' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_STATUS',
    'width' => '10%',
    'default' => false,
  ),
  'HAS_ATTACHMENT' => 
  array (
    'width' => '32%',
    'label' => 'LBL_HAS_ATTACHMENT_INDICATOR',
    'default' => false,
    'sortable' => false,
    'hide_header_label' => true,
  ),
  'TO_ADDRS_NAMES' => 
  array (
    'width' => '32%',
    'label' => 'LBL_LIST_TO_ADDR',
    'default' => false,
  ),
  'DESCRIPTION' => 
  array (
    'type' => 'text',
    'label' => 'description',
    'sortable' => false,
    'width' => '10%',
    'default' => false,
  ),
  'LAST_SYNCED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_LAST_SYNCED',
    'width' => '10%',
    'default' => false,
  ),
  'REPLY_TO_ADDR' => 
  array (
    'type' => 'varchar',
    'label' => 'reply_to_addr',
    'width' => '10%',
    'default' => false,
  ),
  'CC_ADDRS_NAMES' => 
  array (
    'type' => 'varchar',
    'label' => 'cc_addrs_names',
    'width' => '10%',
    'default' => false,
  ),
  'BCC_ADDRS_NAMES' => 
  array (
    'type' => 'varchar',
    'label' => 'bcc_addrs_names',
    'width' => '10%',
    'default' => false,
  ),
  'IMAP_KEYWORDS' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_IMAP_KEYWORDS',
    'width' => '10%',
    'default' => false,
  ),
  'TYPE' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_LIST_TYPE',
    'width' => '10%',
    'default' => false,
  ),
  'EMAILS_EMAIL_TEMPLATES_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_EMAIL_TEMPLATE',
    'id' => 'EMAILS_EMAIL_TEMPLATES_IDB',
    'width' => '10%',
    'default' => false,
  ),
  'IS_IMPORTED' => 
  array (
    'type' => 'varchar',
    'label' => 'is_imported',
    'width' => '10%',
    'default' => false,
  ),
  'IS_ONLY_PLAIN_TEXT' => 
  array (
    'type' => 'bool',
    'default' => false,
    'label' => 'is_only_plain_text',
    'width' => '10%',
  ),
  'CREATED_BY_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_CREATED',
    'id' => 'CREATED_BY',
    'width' => '10%',
    'default' => false,
  ),
  'DATE_ENTERED' => 
  array (
    'width' => '32%',
    'label' => 'LBL_DATE_ENTERED',
    'default' => false,
  ),
  'MODIFIED_BY_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_MODIFIED_NAME',
    'id' => 'MODIFIED_USER_ID',
    'width' => '10%',
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
$viewdefs['Emails']['ListView']['templateMeta'] = array (
  'form' => 
  array (
    'buttons' => 
    array (
      0 => 
      array (
        'customCode' => '<a class="btn" data-action="emails-show-compose-modal" title="{$MOD.LBL_COMPOSEEMAIL}"><span class="glyphicon glyphicon-envelope"></span></a>',
      ),
      1 => 
      array (
        'customCode' => '<a class="btn" data-action="emails-configure" title="{$MOD.LBL_EMAILSETTINGS}"><span class="glyphicon glyphicon-cog"></span></a>',
      ),
      2 => 
      array (
        'customCode' => '<a class="btn" data-action="emails-check-new-email" title="{$MOD.LBL_BUTTON_CHECK_TITLE}"><span class="glyphicon glyphicon-refresh"></span></a>',
      ),
      3 => 
      array (
        'customCode' => '<a class="btn" data-action="emails-show-folders-modal" title="{$MOD.LBL_SELECT_FOLDER}"><span class="glyphicon glyphicon-folder-open"></span></a>',
      ),
    ),
    'actions' => 
    array (
      0 => 
      array (
        'customCode' => '<a href="javascript:void(0)" class="parent-dropdown-handler" id="delete_listview_top" onclick="return false;"><label class="selected-actions-label hidden-mobile">{$APP.LBL_BULK_ACTION_BUTTON_LABEL_MOBILE}<span class=\'suitepicon suitepicon-action-caret\'></span></label><label class="selected-actions-label hidden-desktop">{$APP.LBL_BULK_ACTION_BUTTON_LABEL}</label></a>',
      ),
      1 => 
      array (
        'customCode' => '<a data-action="emails-import-multiple" title="{$MOD.LBL_IMPORT}">{$MOD.LBL_IMPORT}</a>',
      ),
      2 => 
      array (
        'customCode' => '<a data-action="emails-delete-multiple" title="{$MOD.LBL_BUTTON_DELETE_IMAP}">{$MOD.LBL_BUTTON_DELETE_IMAP}</a>',
      ),
      3 => 
      array (
        'customCode' => '<a data-action="emails-mark" data-for="unread" title="{$MOD.LBL_MARK_UNREAD}">{$MOD.LBL_MARK_UNREAD}</a>',
      ),
      4 => 
      array (
        'customCode' => '<a data-action="emails-mark" data-for="read" title="{$MOD.LBL_MARK_READ}">{$MOD.LBL_MARK_READ}</a>',
      ),
      5 => 
      array (
        'customCode' => '<a data-action="emails-mark" data-for="flagged" title="{$MOD.LBL_MARK_FLAGGED}">{$MOD.LBL_MARK_FLAGGED}</a>',
      ),
      6 => 
      array (
        'customCode' => '<a data-action="emails-mark" data-for="unflagged" title="{$MOD.LBL_MARK_UNFLAGGED}">{$MOD.LBL_MARK_UNFLAGGED}</a>',
      ),
    ),
    'headerTpl' => 'modules/Emails/include/ListView/ListViewHeader.tpl',
  ),
  'includes' => 
  array (
    0 => 
    array (
      'file' => 'include/javascript/jstree/dist/jstree.js',
    ),
    1 => 
    array (
      'file' => 'modules/Emails/include/ListView/ComposeViewModal.js',
    ),
    2 => 
    array (
      'file' => 'modules/Emails/include/ListView/SettingsView.js',
    ),
    3 => 
    array (
      'file' => 'modules/Emails/include/ListView/CheckNewEmails.js',
    ),
    4 => 
    array (
      'file' => 'modules/Emails/include/ListView/FoldersViewModal.js',
    ),
    5 => 
    array (
      'file' => 'modules/Emails/include/ListView/ListViewHeader.js',
    ),
    6 => 
    array (
      'file' => 'modules/Emails/include/DetailView/ImportView.js',
    ),
    7 => 
    array (
      'file' => 'modules/Emails/include/ListView/ImportEmailAction.js',
    ),
    8 => 
    array (
      'file' => 'modules/Emails/include/ListView/MarkEmails.js',
    ),
    9 => 
    array (
      'file' => 'modules/Emails/include/ListView/DeleteEmailAction.js',
    ),
  ),
  'options' => 
  array (
    'hide_edit_link' => true,
  ),
);
?>
