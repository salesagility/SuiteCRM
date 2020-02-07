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

$viewdefs ['Tasks'] =
array(
  'QuickCreate' =>
  array(
    'templateMeta' =>
    array(
      'form' =>
      array(
        'hidden' =>
        array(
           '<input type="hidden" name="isSaveAndNew" value="false">',
        ),
        'buttons' =>
        array(
           'SAVE',
           'CANCEL',
           
          array(
            'customCode' => '{if $fields.status.value != "Completed"}<input title="{$APP.LBL_CLOSE_AND_CREATE_BUTTON_TITLE}" class="button" onclick="document.getElementById(\'status\').value=\'Completed\'; this.form.action.value=\'Save\'; this.form.return_module.value=\'Tasks\'; this.form.isDuplicate.value=true; this.form.isSaveAndNew.value=true; this.form.return_action.value=\'EditView\'; this.form.return_id.value=\'{$fields.id.value}\'; return check_form(\'EditView\');" type="submit" name="button" value="{$APP.LBL_CLOSE_AND_CREATE_BUTTON_LABEL}">{/if}',
          ),
        ),
      ),
      'maxColumns' => '2',
      'widths' =>
      array(
         
        array(
          'label' => '10',
          'field' => '30',
        ),
         
        array(
          'label' => '10',
          'field' => '30',
        ),
      ),
      'useTabs' => false,
    ),
    'panels' =>
    array(
      'default' =>
      array(
         
        array(
           
          array(
            'name' => 'name',
            'displayParams' =>
            array(
              'required' => true,
            ),
          ),
           
          array(
            'name' => 'status',
            'displayParams' =>
            array(
              'required' => true,
            ),
          ),
        ),
         
        array(
           
          array(
            'name' => 'date_start',
            'type' => 'datetimecombo',
            'displayParams' =>
            array(
              'showNoneCheckbox' => true,
              'showFormats' => true,
            ),
          ),
           
          array(
            'name' => 'parent_name',
            'label' => 'LBL_LIST_RELATED_TO',
          ),
        ),
         
        array(
           
          array(
            'name' => 'date_due',
            'type' => 'datetimecombo',
            'displayParams' =>
            array(
              'showNoneCheckbox' => true,
              'showFormats' => true,
            ),
          ),
           
          array(
            'name' => 'contact_name',
            'label' => 'LBL_CONTACT_NAME',
          ),
        ),
         
        array(
           
          array(
            'name' => 'priority',
            'displayParams' =>
            array(
              'required' => true,
            ),
          ),
        ),
         array(
          array(
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO_NAME',
          ),
        ),
        array(
           
          array(
            'name' => 'description',
            'displayParams' =>
            array(
              'rows' => 8,
              'cols' => 60,
            ),
          ),
        ),
      ),
    ),
  ),
);
