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

$module_name = 'EAPM';
$viewdefs[$module_name]['DetailView'] = array(
'templateMeta' => array('maxColumns' => '2',
                        'widths' => array(
                                        array('label' => '10', 'field' => '30'),
                                        array('label' => '10', 'field' => '30')
                                        ),
                            'form' => array(
                                'buttons' =>
                                array (
                                  0 => 'EDIT',
                                  array('customCode'=>'<input title="{$MOD.LBL_REAUTHENTICATE_LABEL}" class="button" onclick="window.open(\'index.php?module=EAPM&action=Reauthenticate&record={$fields.id.value}&closeWhenDone=1&refreshParentWindow=1\',\'EAPM\');" type="button" name="Reauthenticate" id="Reauthenticate" value="{$MOD.LBL_REAUTHENTICATE_LABEL}">',
                                      //Bug#51778: The custom code will be replaced with sugar_html. customCode will be deplicated.
                                      'sugar_html' => array(
                                          'type' => 'button',
                                          'value' => '{$MOD.LBL_REAUTHENTICATE_LABEL}',
                                          'htmlOptions' => array(
                                              'title' => '{$MOD.LBL_REAUTHENTICATE_LABEL}',
                                              'class' => 'button',
                                              'onclick' => 'window.open(\'index.php?module=EAPM&action=Reauthenticate&record={$fields.id.value}&closeWhenDone=1&refreshParentWindow=1\',\'EAPM\');',
                                              'name' => 'Reauthenticate',
                                              'id' => 'Reauthenticate',
                                          ),
                                      ),
                                  ),
                                  array ('customCode' => '{if $bean->aclAccess("delete")}<input title="{$APP.LBL_DELETE_BUTTON_TITLE}" accessKey="{$APP.LBL_DELETE_BUTTON_KEY}" class="button" onclick="this.form.return_module.value=\'Users\'; this.form.return_action.value=\'EditView\'; this.form.return_id.value=\'{$return_id}\'; this.form.action.value=\'Delete\'; return confirm(\'{$APP.NTC_DELETE_CONFIRMATION}\');" type="submit" name="Delete" value="{$APP.LBL_DELETE_BUTTON_LABEL}">{/if}',
                                      //Bug#51778: The custom code will be replaced with sugar_html. customCode will be deplicated.
                                      'sugar_html' => array(
                                          'type' => 'submit',
                                          'value' => '{$APP.LBL_DELETE_BUTTON_LABEL}',
                                          'htmlOptions' => array(
                                              'title' => '{$APP.LBL_DELETE_BUTTON_TITLE}',
                                              'accessKey' => '{$APP.LBL_DELETE_BUTTON_KEY}',
                                              'class' => 'button',
                                              'onclick' => 'this.form.return_module.value=\'Users\'; this.form.return_action.value=\'EditView\'; this.form.return_id.value=\'{$return_id}\'; this.form.action.value=\'Delete\'; return confirm(\'{$APP.NTC_DELETE_CONFIRMATION}\');',
                                              'name' => 'Delete',
                                          ),
                                          'template' => '{if $bean->aclAccess("delete")}[CONTENT]{/if}',
                                      ),

                                  ),
                                  ),
                                'footerTpl'=>'modules/EAPM/tpls/DetailViewFooter.tpl',),
                        ),

'panels' =>array (
    array('application', 'validated'),
    array('name',        'url'),

  array (
	array (
      'name' => 'date_entered',
      'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
      'label' => 'LBL_DATE_ENTERED',
    ),
    array (
      'name' => 'date_modified',
      'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
      'label' => 'LBL_DATE_MODIFIED',
    ),
  ),

)
);
