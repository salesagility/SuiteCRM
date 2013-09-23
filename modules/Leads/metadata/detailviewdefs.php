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

$viewdefs['Leads']['DetailView'] = array (
	'templateMeta' => array (
		'form' => array (
			'buttons' => array (
				'EDIT',
				'DUPLICATE',
				'DELETE',
				array (
					'customCode' => '{if $bean->aclAccess("edit") && !$DISABLE_CONVERT_ACTION}<input title="{$MOD.LBL_CONVERTLEAD_TITLE}" accessKey="{$MOD.LBL_CONVERTLEAD_BUTTON_KEY}" type="button" class="button" onClick="document.location=\'index.php?module=Leads&action=ConvertLead&record={$fields.id.value}\'" name="convert" value="{$MOD.LBL_CONVERTLEAD}">{/if}',
                    //Bug#51778: The custom code will be replaced with sugar_html. customCode will be deplicated.
                    'sugar_html' => array(
                        'type' => 'button',
                        'value' => '{$MOD.LBL_CONVERTLEAD}',
                        'htmlOptions' => array(
                            'title' => '{$MOD.LBL_CONVERTLEAD_TITLE}',
                            'accessKey' => '{$MOD.LBL_CONVERTLEAD_BUTTON_KEY}',
                            'class' => 'button',
                            'onClick' => 'document.location=\'index.php?module=Leads&action=ConvertLead&record={$fields.id.value}\'',
                            'name' => 'convert',
                            'id' => 'convert_lead_button',
                        ),
                        'template' => '{if $bean->aclAccess("edit") && !$DISABLE_CONVERT_ACTION}[CONTENT]{/if}',
                    ),
				),
				'FIND_DUPLICATES',
				array (
					'customCode' => '<input title="{$APP.LBL_MANAGE_SUBSCRIPTIONS}" class="button" onclick="this.form.return_module.value=\'Leads\'; this.form.return_action.value=\'DetailView\';this.form.return_id.value=\'{$fields.id.value}\'; this.form.action.value=\'Subscriptions\'; this.form.module.value=\'Campaigns\'; this.form.module_tab.value=\'Leads\';" type="submit" name="Manage Subscriptions" value="{$APP.LBL_MANAGE_SUBSCRIPTIONS}">',
                    //Bug#51778: The custom code will be replaced with sugar_html. customCode will be deplicated.
                    'sugar_html' => array(
                        'type' => 'submit',
                        'value' => '{$APP.LBL_MANAGE_SUBSCRIPTIONS}',
                        'htmlOptions' => array(
                            'title' => '{$APP.LBL_MANAGE_SUBSCRIPTIONS}',
                            'class' => 'button',
                            'id' => 'manage_subscriptions_button',
                            'onclick' => 'this.form.return_module.value=\'Leads\'; this.form.return_action.value=\'DetailView\';this.form.return_id.value=\'{$fields.id.value}\'; this.form.action.value=\'Subscriptions\'; this.form.module.value=\'Campaigns\'; this.form.module_tab.value=\'Leads\';',
                            'name' => '{$APP.LBL_MANAGE_SUBSCRIPTIONS}',
                        )
                    )
				),
				
			),
			'headerTpl'=>'modules/Leads/tpls/DetailViewHeader.tpl',
		),
		'maxColumns' => '2',
		'widths' => array (
			array (
				'label' => '10',
				'field' => '30'
			),
			array (
				'label' => '10',
				'field' => '30'
			)
		),
		 'includes'=> array(
                            array('file'=>'modules/Leads/Lead.js'),
                         ),		
	),
	'panels' => array (

	'LBL_CONTACT_INFORMATION' =>
	array (
		array (
			array (
				'name' => 'full_name',
				'label' => 'LBL_NAME',
			),
			'phone_work',
		),

		array (
			'title',
		    'phone_mobile',   
		),			
        
		array (
			'department',
			'phone_fax'
		),					

	    array (
            array (
              'name' => 'account_name',
            ),
			'website'
	    ),		
		
		array (
			array (
				'name' => 'primary_address_street',
				'label' => 'LBL_PRIMARY_ADDRESS',
				'type' => 'address',
				'displayParams' => array (
					'key' => 'primary'
				),
				
			),

			array (
				'name' => 'alt_address_street',
				'label' => 'LBL_ALTERNATE_ADDRESS',
				'type' => 'address',
				'displayParams' => array (
					'key' => 'alt'
				),
				
			),
			
		),

		array (
			'email1',
		),			
		
		array (
			'description',
		),		
	
	),
	
	'LBL_PANEL_ADVANCED' =>
	array (
	
		array (
			'status',
		    'lead_source'	
		),

		array (
			'status_description',
			'lead_source_description',
		),	
	
		array (
			'opportunity_amount',
			'refered_by',
		),	
		
		array (
			array (
				'name' => 'campaign_name',
				'label' => 'LBL_CAMPAIGN',
				
			),
		    'do_not_call'
		)
		
	),
	
	'LBL_PANEL_ASSIGNMENT' =>
	array(
        array (
          array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO',
          ),
          array (
            'name' => 'date_modified',
            'label' => 'LBL_DATE_MODIFIED',
            'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
          ),
        ),
        array (
          array (
            'name' => 'date_entered',
            'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
          ),
        ),	
	),
	
	)
);
?>