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
$module_name = 'Emails';
$viewdefs [$module_name] = 
array (
  'DetailView' => 
  array (
    'templateMeta' => 
    array (
      'form' => 
      array (
        'buttons' => 
        array (
          0 => 'EDIT',
          1 => 'DUPLICATE',
          2 => 'DELETE',
          3 => 
          array (
            'customCode' => '<input type=button onclick="window.location.href=\'index.php?module=Emails&action=DeleteFromImap&folder=INBOX.TestInbox&folder=inbound&inbound_email_record={$bean->inbound_email_record}&uid={$bean->uid}&msgno={$bean->msgNo}&record={$bean->id}\';" value="{$MOD.LBL_BUTTON_DELETE_IMAP}">',
          ),
          4 => 'FIND_DUPLICATES',
          5 => 
          array (
            'customCode' => '<input type=button onclick="window.location.href=\'index.php?module=Emails&action=ReplyTo&return_module=Emails&return_action=index&folder=INBOX.TestInbox&folder=inbound&inbound_email_record={$bean->inbound_email_record}&uid={$bean->uid}&msgno={$bean->msgno}&record={$bean->id}\';" value="{$MOD.LBL_BUTTON_REPLY_TITLE}">',
          ),
          6 => 
          array (
            'customCode' => '<input type=button onclick="window.location.href=\'index.php?module=Emails&action=ReplyToAll&return_module=Emails&return_action=index&folder=INBOX.TestInbox&folder=inbound&inbound_email_record={$bean->inbound_email_record}&uid={$bean->uid}&msgno={$bean->msgno}&record={$bean->id}\';" value="{$MOD.LBL_BUTTON_REPLY_ALL}">',
          ),
          7 => 
          array (
            'customCode' => '<input type=button onclick="window.location.href=\'index.php?module=Emails&action=Forward&return_module=Emails&return_action=index&folder=INBOX.TestInbox&folder=inbound&inbound_email_record={$bean->inbound_email_record}&uid={$bean->uid}&msgno={$bean->msgno}&record={$bean->id}\';" value="{$MOD.LBL_BUTTON_FORWARD}">',
          ),
          8 => 
          array (
            'customCode' => '<input type=button onclick="openQuickCreateModal(\'Bugs\',\'&name={$bean->name}\',\'{$bean->from_addr_name}\');" value="{$MOD.LBL_CREATE} {$APP.LBL_EMAIL_QC_BUGS}"><input type="hidden" id="parentEmailId" name="parentEmailId" value="{$bean->id}">',
          ),
          9 => 
          array (
            'customCode' => '<input type=button onclick="openQuickCreateModal(\'Cases\',\'&name={$bean->name}\',\'{$bean->from_addr_name}\');" value="{$MOD.LBL_CREATE} {$APP.LBL_EMAIL_QC_CASES}"><input type="hidden" id="parentEmailId" name="parentEmailId" value="{$bean->id}">',
          ),
          10 => 
          array (
            'customCode' => '<input type=button onclick="openQuickCreateModal(\'Contacts\',\'&last_name={$bean->name}\',\'{$bean->from_addr_name}\');" value="{$MOD.LBL_CREATE} {$APP.LBL_EMAIL_QC_CONTACTS}"><input type="hidden" id="parentEmailId" name="parentEmailId" value="{$bean->id}">',
          ),
          11 => 
          array (
            'customCode' => '<input type=button onclick="openQuickCreateModal(\'Leads\',\'&last_name={$bean->name}\',\'{$bean->from_addr_name}\');" value="{$MOD.LBL_CREATE} {$APP.LBL_EMAIL_QC_LEADS}"><input type="hidden" id="parentEmailId" name="parentEmailId" value="{$bean->id}">',
          ),
          12 => 
          array (
            'customCode' => '<input type=button onclick="openQuickCreateModal(\'Opportunities\',\'&name={$bean->name}\',\'{$bean->from_addr_name}\');" value="{$MOD.LBL_CREATE} {$APP.LBL_EMAIL_QC_OPPORTUNITIES}"><input type="hidden" id="parentEmailId" name="parentEmailId" value="{$bean->id}">',
          ),
        ),
      ),
      'includes' => 
      array (
        0 => 
        array (
          'file' => 'modules/Emails/include/DetailView/quickCreateModal.js',
        ),
      ),
      'maxColumns' => '2',
      'widths' => 
      array (
        0 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
        1 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
      'useTabs' => true,
      'tabDefs' => 
      array (
        'LBL_EMAIL_INFORMATION' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
        'LBL_STIC_PANEL_RECORD_DETAILS' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' => 
    array (
      'LBL_EMAIL_INFORMATION' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'opt_in',
            'label' => 'LBL_OPT_IN',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'from_addr_name',
            'label' => 'LBL_FROM',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'to_addrs_names',
            'label' => 'LBL_TO',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'cc_addrs_names',
            'label' => 'LBL_CC',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'bcc_addrs_names',
            'label' => 'LBL_BCC',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'name',
            'label' => 'LBL_SUBJECT',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'description_html',
            'label' => 'LBL_BODY',
          ),
        ),
        7 => 
        array (
          0 => 'date_sent_received',
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO_NAME',
          ),
          1 => 'parent_name',
        ),
        9 => 
        array (
          0 => 'category_id',
          1 => '',
        ),
      ),
      'lbl_stic_panel_record_details' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'created_by_name',
            'label' => 'LBL_CREATED',
          ),
          1 => 
          array (
            'name' => 'date_entered',
            'customCode' => '{$fields.date_entered.value}',
            'label' => 'LBL_DATE_ENTERED',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'modified_by_name',
            'label' => 'LBL_MODIFIED_NAME',
          ),
          1 => 
          array (
            'name' => 'date_modified',
            'comment' => 'Date record last modified',
            'label' => 'LBL_DATE_MODIFIED',
          ),
        ),
      ),
    ),
  ),
);
;
?>
