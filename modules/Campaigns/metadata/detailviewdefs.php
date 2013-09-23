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

$viewdefs['Campaigns']['DetailView'] = array(
'templateMeta' => array('form' => array(
                                        'hidden'=>array('<input type="hidden" name="mode" value="">'),
                                        'buttons' =>
                                            array('EDIT', 'DUPLICATE', 'DELETE',
                                            array('customCode'=>'<input title="{$MOD.LBL_TEST_BUTTON_TITLE}"  class="button" onclick="this.form.return_module.value=\'Campaigns\'; this.form.return_action.value=\'TrackDetailView\';this.form.action.value=\'Schedule\';this.form.mode.value=\'test\';SUGAR.ajaxUI.submitForm(this.form);" type="{$ADD_BUTTON_STATE}" name="button" id="send_test_button" value="{$MOD.LBL_TEST_BUTTON_LABEL}">',
                                                //Bug#51778: The custom code will be replaced with sugar_html. customCode will be deplicated.
                                                'sugar_html' => array(
                                                    'type' => 'input',
                                                    'value' => '{$MOD.LBL_TEST_BUTTON_LABEL}',
                                                    'htmlOptions' => array(
                                                        'type' => '{$ADD_BUTTON_STATE}',
                                                        'title' => '{$MOD.LBL_TEST_BUTTON_TITLE}',
                                                        'class' => 'button',
                                                        'onclick' => 'this.form = document.getElementById(\'formDetailView\'); this.form.return_module.value=\'Campaigns\'; this.form.return_action.value=\'TrackDetailView\';this.form.action.value=\'Schedule\';this.form.mode.value=\'test\';SUGAR.ajaxUI.submitForm(this.form);',
                                                        'name' => 'button',
                                                        'id' => 'send_test_button',
                                                    ),
                                                ),
                                            ),
                                            array('customCode'=>'<input title="{$MOD.LBL_QUEUE_BUTTON_TITLE}" class="button" onclick="this.form.return_module.value=\'Campaigns\'; this.form.return_action.value=\'TrackDetailView\';this.form.action.value=\'Schedule\';SUGAR.ajaxUI.submitForm(this.form);" type="{$ADD_BUTTON_STATE}" name="button" id="send_emails_button" value="{$MOD.LBL_QUEUE_BUTTON_LABEL}">',
                                                //Bug#51778: The custom code will be replaced with sugar_html. customCode will be deplicated.
                                                'sugar_html' => array(
                                                    'type' => 'input',
                                                    'value' => '{$MOD.LBL_QUEUE_BUTTON_LABEL}',
                                                    'htmlOptions' => array(
                                                        'type' => '{$ADD_BUTTON_STATE}',
                                                        'title' => '{$MOD.LBL_QUEUE_BUTTON_TITLE}',
                                                        'class' => 'button',
                                                        'onclick' => 'this.form.return_module.value=\'Campaigns\'; this.form.return_action.value=\'TrackDetailView\';this.form.action.value=\'Schedule\';SUGAR.ajaxUI.submitForm(this.form);',
                                                        'name' => 'button',
                                                        'id' => 'send_emails_button',
                                                    ),
                                                ),
                                            ),
                                            array('customCode'=>'<input title="{$APP.LBL_MAILMERGE}" class="button" onclick="this.form.return_module.value=\'Campaigns\'; this.form.return_action.value=\'TrackDetailView\';this.form.action.value=\'MailMerge\';SUGAR.ajaxUI.submitForm(this.form);" type="submit" name="button" id="mail_merge_button" value="{$APP.LBL_MAILMERGE}">',
                                                //Bug#51778: The custom code will be replaced with sugar_html. customCode will be deplicated.
                                                'sugar_html' => array(
                                                    'type' => 'submit',
                                                    'value' => '{$APP.LBL_MAILMERGE}',
                                                    'htmlOptions' => array(
                                                        'title' => '{$APP.LBL_MAILMERGE}',
                                                        'class' => 'button',
                                                        'onclick' => 'this.form.return_module.value=\'Campaigns\'; this.form.return_action.value=\'TrackDetailView\';this.form.action.value=\'MailMerge\';SUGAR.ajaxUI.submitForm(this.form);',
                                                        'name' => 'button',
                                                        'id' => 'mail_merge_button',
                                                    ),
                                                ),
                                            ),
                                            array('customCode'=>'<input title="{$MOD.LBL_MARK_AS_SENT}" class="button" onclick="this.form.return_module.value=\'Campaigns\'; this.form.return_action.value=\'TrackDetailView\';this.form.action.value=\'DetailView\';this.form.mode.value=\'set_target\';SUGAR.ajaxUI.submitForm(this.form);" type="{$TARGET_BUTTON_STATE}" name="button" id="mark_as_sent_button" value="{$MOD.LBL_MARK_AS_SENT}">',
                                                //Bug#51778: The custom code will be replaced with sugar_html. customCode will be deplicated.
                                                'sugar_html' => array(
                                                    'type' => 'input',
                                                    'value' => '{$MOD.LBL_MARK_AS_SENT}',
                                                    'htmlOptions' => array(
                                                        'type' => '{$TARGET_BUTTON_STATE}',
                                                        'title' => '{$MOD.LBL_MARK_AS_SENT}',
                                                        'class' => 'button',
                                                        'onclick' => 'this.form.return_module.value=\'Campaigns\'; this.form.return_action.value=\'TrackDetailView\';this.form.action.value=\'DetailView\';this.form.mode.value=\'set_target\';SUGAR.ajaxUI.submitForm(this.form);',
                                                        'name' => 'button',
                                                        'id' => 'mark_as_sent_button',
                                                    ),
                                                ),

                                            ),
                                            array('customCode'=>'<script>{$MSG_SCRIPT}</script>'),
                                        ),
                                        'links' => array('<input type="button" class="button" onclick="javascript:window.location=\'index.php?module=Campaigns&action=WizardHome&record={$fields.id.value}\';" name="button" id="launch_wizard_button" value="{$MOD.LBL_TO_WIZARD_TITLE}" />',
                                        				 '<input type="button" class="button" onclick="javascript:window.location=\'index.php?module=Campaigns&action=TrackDetailView&record={$fields.id.value}\';" name="button" id="view_status_button" value="{$MOD.LBL_TRACK_BUTTON_LABEL}" />',
                                        				 '<input id="viewRoiButtonId" type="button" class="button" onclick="javascript:window.location=\'index.php?module=Campaigns&action=RoiDetailView&record={$fields.id.value}\';" name="button" id="view_roi_button" value="{$MOD.LBL_TRACK_ROI_BUTTON_LABEL}" />',

			                             ),
                        ),
                        'maxColumns' => '2',
                        'widths' => array(
                                        array('label' => '10', 'field' => '30'),
                                        array('label' => '10', 'field' => '30')
                                        ),
                       
                        ),
'panels' =>array (
  'lbl_campaign_information'=> array(
	  array (
	    'name',
	    array (
	      'name' => 'status',
	      'label' => 'LBL_CAMPAIGN_STATUS',
	    ),
	  ),
	
	  array (
	
	    array (
	      'name' => 'start_date',
	      'label' => 'LBL_CAMPAIGN_START_DATE',
	    ),
		'campaign_type',
	  ),
	
	  array (
	  	array (
	      'name' => 'end_date',
	      'label' => 'LBL_CAMPAIGN_END_DATE',
	    ),
	    array(
          	'name' => 'frequency',
          	'customCode' => '{if $fields.campaign_type.value == "NewsLetter"}<div style=\'none\' id=\'freq_field\'>{$APP_LIST.newsletter_frequency_dom[$fields.frequency.value]}</div>{/if}&nbsp;',
          	'customLabel' => '{if $fields.campaign_type.value == "NewsLetter"}<div style=\'none\' id=\'freq_label\'>{$MOD.LBL_CAMPAIGN_FREQUENCY}</div>{/if}&nbsp;'
          ),
	  ),
	  
	  array (
		array (
	      'name' => 'impressions',
	      'label' => 'LBL_CAMPAIGN_IMPRESSIONS',
	    ),
	  ),
	
	  array (
	
	    array (
	      'name' => 'budget',
	      'label' => '{$MOD.LBL_CAMPAIGN_BUDGET} ({$CURRENCY})',
	    ),
	    array (
	      'name' => 'expected_cost',
	      'label' => '{$MOD.LBL_CAMPAIGN_EXPECTED_COST} ({$CURRENCY})',
	    ),
	  ),
	
	  array (
		array (
	      'name' => 'actual_cost',
	      'label' => '{$MOD.LBL_CAMPAIGN_ACTUAL_COST} ({$CURRENCY})',
	    ),
	    array (
	      'name' => 'expected_revenue',
	      'label' => '{$MOD.LBL_CAMPAIGN_EXPECTED_REVENUE} ({$CURRENCY})',
	    ),
	  ),
	
	  array (
	
	    array (
	      'name' => 'objective',
	      'label' => 'LBL_CAMPAIGN_OBJECTIVE',
	    ),
	  ),
	
	  array (
	
	    array (
	      'name' => 'content',
	      'label' => 'LBL_CAMPAIGN_CONTENT',
	    ),
	  ),
  ),
  
  'LBL_PANEL_ASSIGNMENT' => array(
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