<?php
$viewdefs ['Campaigns'] = 
array (
  'DetailView' => 
  array (
    'templateMeta' => 
    array (
      'form' => 
      array (
        'hidden' => 
        array (
          0 => '<input type="hidden" name="mode" value="">',
        ),
        'buttons' => 
        array (
          0 => 'EDIT',
          1 => 'DUPLICATE',
          2 => 'DELETE',
          3 => 
          array (
            'customCode' => '<input title="{$MOD.LBL_TEST_BUTTON_TITLE}"  class="button" onclick="this.form.return_module.value=\'Campaigns\'; this.form.return_action.value=\'TrackDetailView\';this.form.action.value=\'Schedule\';this.form.mode.value=\'test\';SUGAR.ajaxUI.submitForm(this.form);" type="{$ADD_BUTTON_STATE}" name="button" id="send_test_button" value="{$MOD.LBL_TEST_BUTTON_LABEL}">',
            'sugar_html' => 
            array (
              'type' => 'input',
              'value' => '{$MOD.LBL_TEST_BUTTON_LABEL}',
              'htmlOptions' => 
              array (
                'type' => '{$ADD_BUTTON_STATE}',
                'title' => '{$MOD.LBL_TEST_BUTTON_TITLE}',
                'class' => 'button',
                'onclick' => 'this.form = document.getElementById(\'formDetailView\'); this.form.return_module.value=\'Campaigns\'; this.form.return_action.value=\'TrackDetailView\';this.form.action.value=\'Schedule\';this.form.mode.value=\'test\';SUGAR.ajaxUI.submitForm(this.form);',
                'name' => 'button',
                'id' => 'send_test_button',
              ),
            ),
          ),
          4 => 
          array (
            'customCode' => '<input title="{$MOD.LBL_QUEUE_BUTTON_TITLE}" class="button" onclick="this.form.return_module.value=\'Campaigns\'; this.form.return_action.value=\'TrackDetailView\';this.form.action.value=\'Schedule\';SUGAR.ajaxUI.submitForm(this.form);" type="{$ADD_BUTTON_STATE}" name="button" id="send_emails_button" value="{$MOD.LBL_QUEUE_BUTTON_LABEL}">',
            'sugar_html' => 
            array (
              'type' => 'input',
              'value' => '{$MOD.LBL_QUEUE_BUTTON_LABEL}',
              'htmlOptions' => 
              array (
                'type' => '{$ADD_BUTTON_STATE}',
                'title' => '{$MOD.LBL_QUEUE_BUTTON_TITLE}',
                'class' => 'button',
                'onclick' => 'this.form.return_module.value=\'Campaigns\'; this.form.return_action.value=\'TrackDetailView\';this.form.action.value=\'Schedule\';SUGAR.ajaxUI.submitForm(this.form);',
                'name' => 'button',
                'id' => 'send_emails_button',
              ),
            ),
          ),
          5 => 
          array (
            'customCode' => '<input title="{$APP.LBL_MAILMERGE}" class="button" onclick="this.form.return_module.value=\'Campaigns\'; this.form.return_action.value=\'TrackDetailView\';this.form.action.value=\'MailMerge\';SUGAR.ajaxUI.submitForm(this.form);" type="submit" name="button" id="mail_merge_button" value="{$APP.LBL_MAILMERGE}">',
            'sugar_html' => 
            array (
              'type' => 'submit',
              'value' => '{$APP.LBL_MAILMERGE}',
              'htmlOptions' => 
              array (
                'title' => '{$APP.LBL_MAILMERGE}',
                'class' => 'button',
                'onclick' => 'this.form.return_module.value=\'Campaigns\'; this.form.return_action.value=\'TrackDetailView\';this.form.action.value=\'MailMerge\';SUGAR.ajaxUI.submitForm(this.form);',
                'name' => 'button',
                'id' => 'mail_merge_button',
              ),
            ),
          ),
          6 => 
          array (
            'customCode' => '<input title="{$MOD.LBL_MARK_AS_SENT}" class="button" onclick="this.form.return_module.value=\'Campaigns\'; this.form.return_action.value=\'TrackDetailView\';this.form.action.value=\'DetailView\';this.form.mode.value=\'set_target\';SUGAR.ajaxUI.submitForm(this.form);" type="{$TARGET_BUTTON_STATE}" name="button" id="mark_as_sent_button" value="{$MOD.LBL_MARK_AS_SENT}">',
            'sugar_html' => 
            array (
              'type' => 'input',
              'value' => '{$MOD.LBL_MARK_AS_SENT}',
              'htmlOptions' => 
              array (
                'type' => '{$TARGET_BUTTON_STATE}',
                'title' => '{$MOD.LBL_MARK_AS_SENT}',
                'class' => 'button',
                'onclick' => 'this.form.return_module.value=\'Campaigns\'; this.form.return_action.value=\'TrackDetailView\';this.form.action.value=\'DetailView\';this.form.mode.value=\'set_target\';SUGAR.ajaxUI.submitForm(this.form);',
                'name' => 'button',
                'id' => 'mark_as_sent_button',
              ),
            ),
          ),
          7 => 
          array (
            'customCode' => '<script>{$MSG_SCRIPT}</script>',
          ),
        ),
        'links' => 
        array (
          0 => '<input type="button" class="button" onclick="javascript:window.location=\'index.php?module=Campaigns&action=WizardHome&record={$fields.id.value}\';" name="button" id="launch_wizard_button" value="{$MOD.LBL_TO_WIZARD_TITLE}" />',
          1 => '<input type="button" class="button" onclick="javascript:window.location=\'index.php?module=Campaigns&action=TrackDetailView&record={$fields.id.value}\';" name="button" id="view_status_button" value="{$MOD.LBL_TRACK_BUTTON_LABEL}" />',
          2 => '<input id="viewRoiButtonId" type="button" class="button" onclick="javascript:window.location=\'index.php?module=Campaigns&action=RoiDetailView&record={$fields.id.value}\';" name="button" id="view_roi_button" value="{$MOD.LBL_TRACK_ROI_BUTTON_LABEL}" />',
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
        'LBL_CAMPAIGN_INFORMATION' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
        'LBL_NAVIGATION_MENU_GEN2' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
        'LBL_PANEL_ASSIGNMENT' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' => 
    array (
      'lbl_campaign_information' => 
      array (
        0 => 
        array (
          0 => 'name',
          1 => 
          array (
            'name' => 'status',
            'label' => 'LBL_CAMPAIGN_STATUS',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'start_date',
            'label' => 'LBL_CAMPAIGN_START_DATE',
          ),
          1 => 'campaign_type',
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'end_date',
            'label' => 'LBL_CAMPAIGN_END_DATE',
          ),
          1 => 
          array (
            'name' => 'frequency',
            'customCode' => '{if $fields.campaign_type.value == "NewsLetter"}<div style=\'none\' id=\'freq_field\'>{$APP_LIST.newsletter_frequency_dom[$fields.frequency.value]}</div>{/if}&nbsp;',
            'customLabel' => '{if $fields.campaign_type.value == "NewsLetter"}<div style=\'none\' id=\'freq_label\'>{$MOD.LBL_CAMPAIGN_FREQUENCY}</div>{/if}&nbsp;',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'content',
            'label' => 'LBL_CAMPAIGN_CONTENT',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO',
          ),
        ),
      ),
      'LBL_NAVIGATION_MENU_GEN2' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'currency_id',
            'comment' => 'Currency in use for the campaign',
            'label' => 'LBL_CURRENCY',
          ),
          1 => 
          array (
            'name' => 'impressions',
            'label' => 'LBL_CAMPAIGN_IMPRESSIONS',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'budget',
            'label' => '{$MOD.LBL_CAMPAIGN_BUDGET} ({$CURRENCY})',
          ),
          1 => 
          array (
            'name' => 'expected_cost',
            'label' => '{$MOD.LBL_CAMPAIGN_EXPECTED_COST} ({$CURRENCY})',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'actual_cost',
            'label' => '{$MOD.LBL_CAMPAIGN_ACTUAL_COST} ({$CURRENCY})',
          ),
          1 => 
          array (
            'name' => 'expected_revenue',
            'label' => '{$MOD.LBL_CAMPAIGN_EXPECTED_REVENUE} ({$CURRENCY})',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'objective',
            'label' => 'LBL_CAMPAIGN_OBJECTIVE',
          ),
        ),
      ),
      'LBL_PANEL_ASSIGNMENT' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'date_entered',
            'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
          ),
          1 => 
          array (
            'name' => 'date_modified',
            'label' => 'LBL_DATE_MODIFIED',
            'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
          ),
        ),
      ),
    ),
  ),
);
?>
