<?php
/**
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

$viewdefs ['Meetings'] =
array(
  'DetailView' =>
  array(
    'templateMeta' =>
    array(
        'includes' => array(
            array('file' => 'modules/Reminders/Reminders.js'),
        ),
      'form' =>
      array(
        'buttons' =>
        array(
          0 => 'EDIT',
          1 => 'DUPLICATE',
          2 => 'DELETE',
          3 =>
          array(
            'customCode' => '{if $fields.status.value != "Held" && $bean->aclAccess("edit")} <input type="hidden" name="isSaveAndNew" value="false">  <input type="hidden" name="status" value="">  <input type="hidden" name="isSaveFromDetailView" value="true">  <input title="{$APP.LBL_CLOSE_AND_CREATE_BUTTON_TITLE}"   class="button"  onclick="this.form.status.value=\'Held\'; this.form.action.value=\'Save\';this.form.return_module.value=\'Meetings\';this.form.isDuplicate.value=true;this.form.isSaveAndNew.value=true;this.form.return_action.value=\'EditView\'; this.form.isDuplicate.value=true;this.form.return_id.value=\'{$fields.id.value}\';" id="close_create_button" name="button"  value="{$APP.LBL_CLOSE_AND_CREATE_BUTTON_TITLE}"  type="submit">{/if}',
              //Bug#51778: The custom code will be replaced with sugar_html. customCode will be deplicated.
              'sugar_html' => array(
                  'type' => 'submit',
                  'value' => '{$APP.LBL_CLOSE_AND_CREATE_BUTTON_TITLE}',
                  'htmlOptions' => array(
                      'title' => '{$APP.LBL_CLOSE_AND_CREATE_BUTTON_TITLE}',
                      'name' => '{$APP.LBL_CLOSE_AND_CREATE_BUTTON_TITLE}',
                      'class' => 'button',
                      'id' => 'close_create_button',
                      'onclick' => 'this.form.isSaveFromDetailView.value=true; this.form.status.value=\'Held\'; this.form.action.value=\'Save\';this.form.return_module.value=\'Meetings\';this.form.isDuplicate.value=true;this.form.isSaveAndNew.value=true;this.form.return_action.value=\'EditView\'; this.form.isDuplicate.value=true;this.form.return_id.value=\'{$fields.id.value}\';',

                  ),
                  'template' => '{if $fields.status.value != "Held" && $bean->aclAccess("edit")}[CONTENT]{/if}',
              ),
          ),
          4 =>
          array(
            'customCode' => '{if $fields.status.value != "Held" && $bean->aclAccess("edit")} <input type="hidden" name="isSave" value="false">  <input title="{$APP.LBL_CLOSE_BUTTON_TITLE}"  accesskey="{$APP.LBL_CLOSE_BUTTON_KEY}"  class="button"  onclick="this.form.status.value=\'Held\'; this.form.action.value=\'Save\';this.form.return_module.value=\'Meetings\';this.form.isSave.value=true;this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$fields.id.value}\'"  id="close_button" name="button1"  value="{$APP.LBL_CLOSE_BUTTON_TITLE}"  type="submit">{/if}',
              //Bug#51778: The custom code will be replaced with sugar_html. customCode will be deplicated.
              'sugar_html' => array(
                  'type' => 'submit',
                  'value' => '{$APP.LBL_CLOSE_BUTTON_TITLE}',
                  'htmlOptions' => array(
                      'title' => '{$APP.LBL_CLOSE_BUTTON_TITLE}',
                      'accesskey' => '{$APP.LBL_CLOSE_BUTTON_KEY}',
                      'class' => 'button',
                      'onclick' => 'this.form.status.value=\'Held\'; this.form.action.value=\'Save\';this.form.return_module.value=\'Meetings\';this.form.isSave.value=true;this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$fields.id.value}\';',
                      'name' => '{$APP.LBL_CLOSE_BUTTON_TITLE}',
                      'id' => 'close_button',
                  ),
                  'template' => '{if $fields.status.value != "Held" && $bean->aclAccess("edit")}[CONTENT]{/if}',
              ),
          ),
        ),
        'hidden' => array(
            '<input type="hidden" name="isSaveAndNew">',
            '<input type="hidden" name="status">',
            '<input type="hidden" name="isSaveFromDetailView">',
            '<input type="hidden" name="isSave">',
        ),
        'headerTpl' => 'modules/Meetings/tpls/detailHeader.tpl',
      ),
      'maxColumns' => '2',
      'widths' =>
      array(
        0 =>
        array(
          'label' => '10',
          'field' => '30',
        ),
        1 =>
        array(
          'label' => '10',
          'field' => '30',
        ),
      ),
      'useTabs' => false,
    ),
    'panels' =>
    array(
      'lbl_meeting_information' =>
      array(
        array(
          array(
            'name' => 'name',
            'label' => 'LBL_SUBJECT',
          ),
          'status',
        ),
        array(
          array(
            'name' => 'date_start',
            'label' => 'LBL_DATE_TIME',
          ),
        ),
        array(
          array(
            'name' => 'duration',
            'customCode' => '{$fields.duration_hours.value}{$MOD.LBL_HOURS_ABBREV} {$fields.duration_minutes.value}{$MOD.LBL_MINSS_ABBREV} ',
            'label' => 'LBL_DURATION',
          ),
          array(
            'name' => 'parent_name',
            'customLabel' => '{sugar_translate label=\'LBL_MODULE_NAME\' module=$fields.parent_type.value}',
          ),
        ),
        array(
//          array(
//            'name' => 'reminder_time',
//            'customCode' => '{include file="modules/Meetings/tpls/reminders.tpl"}',
//            'label' => 'LBL_REMINDER',
//            ),
          array(
            'name' => 'reminders',
            'label' => 'LBL_REMINDERS',
            ),
          'location',
        ),
        array(
          'description',
        ),
      ),
      'LBL_PANEL_ASSIGNMENT' =>
      array(
        array(
          array(
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO',
          ),
          array(
            'name' => 'date_modified',
            'label' => 'LBL_DATE_MODIFIED',
            'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
          ),

        ),
        array(
          array(
            'name' => 'date_entered',
            'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
          ),
        ),
      ),
    ),
  ),
);
