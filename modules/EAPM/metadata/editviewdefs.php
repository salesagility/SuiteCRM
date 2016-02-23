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
$viewdefs[$module_name]['EditView'] = array(
    'templateMeta' => array('maxColumns' => '2',
                            'widths' => array(
                                            array('label' => '10', 'field' => '30'),
                                            array('label' => '10', 'field' => '30')
                                            ),
                            'form' => array(
                                'hidden'=>array('<input name="assigned_user_id" type="hidden" value="{$fields.assigned_user_id.value}" autocomplete="off">'),
                                'buttons' =>
                                array (
                                    array (
                                        'customCode' => '{if $bean->aclAccess("save")}<input title="{$MOD.LBL_CONNECT_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button primary" onclick="{if $isDuplicate}this.form.return_id.value=\'\'; {/if}this.form.action.value=\'Save\'; if(check_form(\'EditView\'))this.form.submit();else return false;" type="submit" name="button" value="{$MOD.LBL_CONNECT_BUTTON_TITLE}" id="EditViewSave">{/if} '
                                    ),
                                    array (
                                        'customCode' => '<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" id="cancel_button" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="window.location.href=\'{$cancelUrl}\'; return false;" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">',
                                    ),
                                    array (
                                        'customCode' => '{if $bean->aclAccess("delete") && !empty($smarty.request.record)}<input title="{$APP.LBL_DELETE_BUTTON_TITLE}" id="delete_button" accessKey="{$APP.LBL_DELETE_BUTTON_KEY}" class="button" onclick="this.form.return_module.value=\'Users\'; this.form.return_action.value=\'EditView\'; this.form.action.value=\'Delete\'; this.form.return_id.value=\'{$return_id}\'; if (confirm(\'{$APP.NTC_DELETE_CONFIRMATION}\')){ldelim}disableOnUnloadEditView(); return true;{rdelim}else{ldelim}return false;{rdelim};" type="submit" name="Delete" value="{$APP.LBL_DELETE_BUTTON_LABEL}">{/if} ',
                                    ),
                                ),
                                'headerTpl'=>'modules/EAPM/tpls/EditViewHeader.tpl',
                                'footerTpl'=>'modules/EAPM/tpls/EditViewFooter.tpl',),
                                            ),

 'panels' =>array (
  'default' =>
  array (
    array(
        array(
            'name' => 'application',
            'displayParams'=>array('required'=>true)
        ),
        array('name' => 'note', 
              'type'=>'text', 
              'customCode' => '{if $fields.validated.value}{$MOD.LBL_CONNECTED}<div id="eapm_notice_div" style="display: none;"></div>{else}<div id="eapm_notice_div">&nbsp;</div>{/if}',
              'label' => 'LBL_STATUS',
        ),
    ),
    array (
        array('name' => 'name', 'displayParams' => array('required' => true) ),
        array('name'=>'password', 'type'=>'password', 'displayParams' => array('required' => true) ),
    ),
    array (
        array('name' => 'url',
              'displayParams' => array('required' => true),
              'customCode' => '<input type=\'text\' name=\'url\' id=\'url\' size=\'30\' maxlength=\'255\' value=\'{$fields.url.value}\' title=\'\' tabindex=\'104\' ><br>{$MOD.LBL_OMIT_URL}',
            )
    ),
  ),

),

);
?>
