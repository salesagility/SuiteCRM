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

$viewdefs['Employees']['DetailView'] = array(
'templateMeta' => array('form' => array('buttons'=>array(
    array('customCode'=>'{if $DISPLAY_EDIT}<input title="{$APP.LBL_EDIT_BUTTON_TITLE}" accessKey="{$APP.LBL_EDIT_BUTTON_KEY}" class="button" onclick="this.form.return_module.value=\'{$module}\'; this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$id}\'; this.form.action.value=\'EditView\'" type="submit" name="Edit" id="edit_button" value="{$APP.LBL_EDIT_BUTTON_LABEL}">{/if}',
        //Bug#51778: The custom code will be replaced with sugar_html. customCode will be deplicated.
        'sugar_html' => array(
            'type' => 'submit',
            'value' => '{$APP.LBL_EDIT_BUTTON_LABEL}',
            'htmlOptions' => array(
                'title' => '{$APP.LBL_EDIT_BUTTON_TITLE}',
                'accessKey' => '{$APP.LBL_EDIT_BUTTON_KEY}',
                'class' => 'button',
                'onclick' => 'this.form.return_module.value=\'{$module}\'; this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$id}\'; this.form.action.value=\'EditView\';',
                'id' => 'edit_button',
                'name' => 'Edit'
            ),
            'template' => '{if $DISPLAY_EDIT}[CONTENT]{/if}',
        ),
    ),
    array('customCode'=>'{if $DISPLAY_DUPLICATE}<input title="{$APP.LBL_DUPLICATE_BUTTON_TITLE}" accessKey="{$APP.LBL_DUPLICATE_BUTTON_KEY}" class="button" onclick="this.form.return_module.value=\'{$module}\'     ; this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$id}\'; this.form.isDuplicate.value=true; this.form.action.value=\'EditView\'" type="submit" name="Duplicate" value="{$APP.LBL_DUPLICATE_BUTTON_LABEL}" id="duplicate_button">{/if}',
        //Bug#51778: The custom code will be replaced with sugar_html. customCode will be deplicated.
        'sugar_html' => array(
            'type' => 'submit',
            'value' => '{$APP.LBL_DUPLICATE_BUTTON_LABEL}',
            'htmlOptions' => array(
                'title' => '{$APP.LBL_DUPLICATE_BUTTON_TITLE}',
                'accessKey' => '{$APP.LBL_DUPLICATE_BUTTON_KEY}',
                'class' => 'button',
                'onclick' => 'this.form.return_module.value=\'{$module}\'; this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$id}\'; this.form.isDuplicate.value=true; this.form.action.value=\'EditView\';',
                'name' => 'Duplicate',
                'id' => 'duplicate_button'
            ),
            'template' => '{if $DISPLAY_DUPLICATE}[CONTENT]{/if}'
        ),
    ),
    
    array('customCode'=>'{if $DISPLAY_DELETE}<input title="{$APP.LBL_DELETE_BUTTON_LABEL}" accessKey="{$APP.LBL_DELETE_BUTTON_LABEL}" class="button" onclick="if( confirm(\'{$DELETE_WARNING}\') ) {ldelim} this.form.return_module.value=\'{$module}\'; this.form.return_action.value=\'index\'; this.form.return_id.value=\'{$id}\'; this.form.action.value=\'delete\'; this.form.submit();{rdelim}" type="button" name="Delete" value="{$APP.LBL_DELETE_BUTTON_LABEL}" id="delete_button">{/if}',
        //Bug#51778: The custom code will be replaced with sugar_html. customCode will be deplicated.
        'sugar_html' => array(
            'type' => 'button',
            'value' => '{$APP.LBL_DELETE_BUTTON_LABEL}',
                'htmlOptions' => array(
                    'title' => '{$APP.LBL_DELETE_BUTTON_LABEL}',
                    'accessKey' => '{$APP.LBL_DELETE_BUTTON_LABEL}',
                    'class' => 'button',
                    'onclick' => 'if( confirm(\'{$DELETE_WARNING}\') ) {ldelim} this.form.return_module.value=\'{$module}\'; this.form.return_action.value=\'index\'; this.form.return_id.value=\'{$id}\'; this.form.action.value=\'delete\'; this.form.submit();{rdelim}',
                    'name' => 'Delete',
                    'id' => 'delete_button',
                ),
            'template' => '{if $DISPLAY_DELETE}[CONTENT]{/if}'
        ),
    ),
                                                         )
                        ),
                        'maxColumns' => '2', 
                        'widths' => array(
                                        array('label' => '10', 'field' => '30'), 
                                        array('label' => '10', 'field' => '30')
                                        ),
                        ),
'panels' =>array (

  array (
	'employee_status',
  ),
  
  array (
    array (
      'name' => 'first_name',
      'customCode' => '{$fields.full_name.value}',
      'label' => 'LBL_NAME',
    ),
  ),
  
  array (
    
    array (
      'name' => 'title',
      'label' => 'LBL_TITLE',
    ),
    
    array (
      'name' => 'phone_work',
      'label' => 'LBL_OFFICE_PHONE',
    ),
  ),
  
  array (
    
    array (
      'name' => 'department',
      'label' => 'LBL_DEPARTMENT',
    ),
    
    array (
      'name' => 'phone_mobile',
      'label' => 'LBL_MOBILE_PHONE',
    ),
  ),
  
  array (
    
    array (
      'name' => 'reports_to_name',
      'customCode' => '<a href="index.php?module=Employees&action=DetailView&record={$fields.reports_to_id.value}">{$fields.reports_to_name.value}</a>',
      'label' => 'LBL_REPORTS_TO_NAME',
    ),
    
    array (
      'name' => 'phone_other',
      'label' => 'LBL_OTHER',
    ),
  ),
  
  array (
    '',
    array (
      'name' => 'phone_fax',
      'label' => 'LBL_FAX',
    ),
  ),
  
  array (
    
    '',
    
    array (
      'name' => 'phone_home',
      'label' => 'LBL_HOME_PHONE',
    ),
  ),
  
  array (
    
    array (
      'name' => 'messenger_type',
      'label' => 'LBL_MESSENGER_TYPE',
    ),
  ),
  
  array (
    
    array (
      'name' => 'messenger_id',
      'label' => 'LBL_MESSENGER_ID',
    ),
  ),
  
  array (
    
    array (
      'name' => 'address_country',
      'customCode' => '{$fields.address_street.value}<br>{$fields.address_city.value} {$fields.address_state.value}&nbsp;&nbsp;{$fields.address_postalcode.value}<br>{$fields.address_country.value}',
      'label' => 'LBL_ADDRESS',
    ),
  ),
  
  array (
    
    array (
      'name' => 'description',
      'label' => 'LBL_NOTES',
    ),
  ),
  array(
  array (
      'name' => 'email1',
      'label' => 'LBL_EMAIL',
    ),
  ),

)


   
);
?>