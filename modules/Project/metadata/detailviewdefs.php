<?php
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
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
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/




$viewdefs['Project']['DetailView'] = array(
	'templateMeta' => array( 
		'maxColumns' => '2',
		'widths' => array(	
			array('label' => '10', 'field' => '30'),
			array('label' => '10', 'field' => '30')
		),
		'includes'=> array(
			 array('file'=>'modules/Project/Project.js'),
	 	),
		'form' => array(
	 		'buttons'=> array(
			 	array( 'customCode' =>
                        '<input title="{$APP.LBL_EDIT_BUTTON_TITLE}" ' .
                        'accessKey="{$APP.LBL_EDIT_BUTTON_KEY}" class="button" type="submit" ' .
                        'name="Edit" id="edit_button" value="{$APP.LBL_EDIT_BUTTON_LABEL}"'.
                        'onclick="'.
                        '{if $IS_TEMPLATE}'.
                            'this.form.return_module.value=\'Project\'; this.form.return_action.value=\'ProjectTemplatesDetailView\'; this.form.return_id.value=\'{$id}\'; this.form.action.value=\'ProjectTemplatesEditView\';'.
                        '{else}'.
                            'this.form.return_module.value=\'Project\'; this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$id}\'; this.form.action.value=\'EditView\'; '.
                        '{/if}"'.
                        '/>',
                    //Bug#51778: The custom code will be replaced with sugar_html. customCode will be deplicated.
                    'sugar_html' => array(
                        'type' => 'submit',
                        'value' => ' {$APP.LBL_EDIT_BUTTON_LABEL} ',
                        'htmlOptions' => array(
                            'id' => 'edit_button',
                            'class' => 'button',
                            'accessKey' => '{$APP.LBL_EDIT_BUTTON_KEY}',
                            'name' => 'Edit',
                            'onclick' =>
                                '{if $IS_TEMPLATE}'.
                                    'this.form.return_module.value=\'Project\'; this.form.return_action.value=\'ProjectTemplatesDetailView\'; this.form.return_id.value=\'{$id}\'; this.form.action.value=\'ProjectTemplatesEditView\';'.
                                '{else}'.
                                    'this.form.return_module.value=\'Project\'; this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$id}\'; this.form.action.value=\'EditView\'; '.
                                '{/if}',
                        ),
                    ),
				),
				array( 'customCode' =>
                        '<input title="{$APP.LBL_DELETE_BUTTON_TITLE}" ' .
                        'accessKey="{$APP.LBL_DELETE_BUTTON_KEY}" class="button" type="button" ' .
                        'name="Delete" id="delete_button" value="{$APP.LBL_DELETE_BUTTON_LABEL}"'.
                        'onclick="'.
                        '{if $IS_TEMPLATE}'.
                            'this.form.return_module.value=\'Project\'; this.form.return_action.value=\'ProjectTemplatesListView\'; this.form.action.value=\'Delete\'; if( confirm(\'{$APP.NTC_DELETE_CONFIRMATION}\') )  this.form.submit(); '.
                        '{else}'.
                            'this.form.return_module.value=\'Project\'; this.form.return_action.value=\'ListView\'; this.form.action.value=\'Delete\'; if( confirm(\'{$APP.NTC_DELETE_CONFIRMATION}\'))  this.form.submit(); '.
                        '{/if}"'.
                        '/>',
                    //Bug#51778: The custom code will be replaced with sugar_html. customCode will be deplicated.
                    'sugar_html' => array(
                        'type' => 'button',
                        'id'    => 'delete_button',
                        'value' => '{$APP.LBL_DELETE_BUTTON_LABEL}',
                        'htmlOptions' => array(
                            'title' => '{$APP.LBL_DELETE_BUTTON_TITLE}',
                            'accessKey' => '{$APP.LBL_DELETE_BUTTON_KEY}',
                            'id'    => 'delete_button',
                            'class' => 'button',
                            'onclick' =>
                                '{if $IS_TEMPLATE}'.
                                    'this.form.return_module.value=\'Project\'; this.form.return_action.value=\'ProjectTemplatesListView\'; this.form.action.value=\'Delete\'; if (confirm(\'{$APP.NTC_DELETE_CONFIRMATION}\')) this.form.submit();'.
                                '{else}'.
                                    'this.form.return_module.value=\'Project\'; this.form.return_action.value=\'ListView\'; this.form.action.value=\'Delete\'; if (confirm(\'{$APP.NTC_DELETE_CONFIRMATION}\')) this.form.submit();'.
                                '{/if}',
                        ),

                    ),
				),

				 array( 'customCode' =>
                        '<input title="{$APP.LBL_DUPLICATE_BUTTON_TITLE}" ' .
                        'accessKey="{$APP.LBL_DUPLICATE_BUTTON_KEY}" class="button" type="submit" ' .
                        'name="Duplicate" id="duplicate_button" value="{$APP.LBL_DUPLICATE_BUTTON_LABEL}"'.
                        'onclick="'.
                        '{if $IS_TEMPLATE}'.
                            'this.form.return_module.value=\'Project\'; this.form.return_action.value=\'ProjectTemplatesDetailView\'; this.form.isDuplicate.value=true; this.form.action.value=\'projecttemplateseditview\'; this.form.return_id.value=\'{$id}\';'.
                        '{else}'.
                            'this.form.return_module.value=\'Project\'; this.form.return_action.value=\'DetailView\'; this.form.isDuplicate.value=true; this.form.action.value=\'EditView\'; this.form.return_id.value=\'{$id}\';'.
                        '{/if}"'.
                        '"/>',
                     //Bug#51778: The custom code will be replaced with sugar_html. customCode will be deplicated.
                     'sugar_html' => array(
                         'type' => 'submit',
                         'value' => '{$APP.LBL_DUPLICATE_BUTTON_LABEL}',
                         'htmlOptions' => array(
                             'title' => '{$APP.LBL_DUPLICATE_BUTTON_TITLE}',
                             'accessKey' => '{$APP.LBL_DUPLICATE_BUTTON_KEY}',
                             'class' => 'button',
                             'name' => 'Duplicate',
                             'id' => 'duplicate_button',
                             'onclick' =>
                                 '{if $IS_TEMPLATE}'.
                                     'this.form.return_module.value=\'Project\'; this.form.return_action.value=\'ProjectTemplatesDetailView\'; this.form.isDuplicate.value=true; this.form.action.value=\'projecttemplateseditview\'; this.form.return_id.value=\'{$id}\';'.
                                 '{else}'.
                                     'this.form.return_module.value=\'Project\'; this.form.return_action.value=\'DetailView\'; this.form.isDuplicate.value=true; this.form.action.value=\'EditView\'; this.form.return_id.value=\'{$id}\';'.
                                 '{/if}',
                         ),
                     ),
                ),

 			),
 		),
	),
	'panels' => array ( 
	  'lbl_project_information' =>
	  array (
			array ( 
				'name', 
				'status', ),
			array (
				array ( 
					'name' => 'estimated_start_date',
					'label' => 'LBL_DATE_START',
  				),
				'priority',
			),
			array (
			    array (
					'name' => 'estimated_end_date',
					'label' => 'LBL_DATE_END',
  				  ),
			  	),
			array (
				'description',
	  		),
  	  ),				
	  'LBL_PANEL_ASSIGNMENT' => 
	  array (
		array (
		  array (
			'name' => 'assigned_user_name',
			'label' => 'LBL_ASSIGNED_TO',
		  ),
		  array (
			'name' => 'modified_by_name',
			'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}&nbsp;',
			'label' => 'LBL_DATE_MODIFIED',
		  ),
		),
		array (
			array (
				'name' => 'created_by_name',
				'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}&nbsp;',
				'label' => 'LBL_DATE_ENTERED',
			),
		),
	  ),  						
	),
);
?>