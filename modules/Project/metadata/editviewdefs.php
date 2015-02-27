<?php
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
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
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
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
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/




$viewdefs ['Project'] =
array (
  'EditView' => 
  array (
    'templateMeta' => 
    array (
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
      'form' => 
      array (
        'hidden' => '<input type="hidden" name="is_template" value="{$is_template}" />',
        'buttons' => 
        array (
          0 => 'SAVE',
          1 => 
          array (
            'customCode' => '{if !empty($smarty.request.return_action) && $smarty.request.return_action == "ProjectTemplatesDetailView" && (!empty($fields.id.value) || !empty($smarty.request.return_id)) }<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="this.form.action.value=\'ProjectTemplatesDetailView\'; this.form.module.value=\'{$smarty.request.return_module}\'; this.form.record.value=\'{$smarty.request.return_id}\';" type="submit" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" id="CANCEL{$place}"> {elseif !empty($smarty.request.return_action) && $smarty.request.return_action == "DetailView" && (!empty($fields.id.value) || !empty($smarty.request.return_id)) }<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="this.form.action.value=\'DetailView\'; this.form.module.value=\'{$smarty.request.return_module}\'; this.form.record.value=\'{$smarty.request.return_id}\';" type="submit" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" id="CANCEL{$place}"> {elseif $is_template}<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="this.form.action.value=\'ProjectTemplatesListView\'; this.form.module.value=\'{$smarty.request.return_module}\'; this.form.record.value=\'{$smarty.request.return_id}\';" type="submit" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" id="CANCEL{$place}"> {else}<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="this.form.action.value=\'index\'; this.form.module.value=\'{$smarty.request.return_module}\'; this.form.record.value=\'{$smarty.request.return_id}\';" type="submit" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" id="CANCEL{$place}"> {/if}',
          ),
        ),
      ),
      'useTabs' => false,
      'tabDefs' => 
      array (
        'LBL_PROJECT_INFORMATION' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_PANEL_ASSIGNMENT' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' => 
    array (
      'lbl_project_information' => 
      array (
        0 => 
        array (
          0 => 'name',
          1 => 'status',
        ),
        1 => 
        array (
          0 => 'estimated_start_date',
          1 => 'priority',
        ),
        2 => 
        array (
          0 => 'estimated_end_date',
          1 => '',
        ),
        3 => 
        array (
          0 => 'description',
        ),
      ),
      'LBL_PANEL_ASSIGNMENT' => 
      array (
        0 => 
        array (
          0 => 'assigned_user_name',
          1 => 
          array (
            'name' => 'am_projecttemplates_project_1_name',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'date_entered',
            'comment' => 'Date record created',
            'label' => 'LBL_DATE_ENTERED',
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
?>
