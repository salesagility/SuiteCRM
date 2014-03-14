<?php
// created: 2014-01-29 16:53:32
$viewdefs = array (
  'Prospects' => 
  array (
    'DetailView' => 
    array (
      'templateMeta' => 
      array (
        'form' => 
        array (
          'buttons' => 
          array (
            0 => 'EDIT',
            1 => 'DUPLICATE',
            2 => 'DELETE',
            3 => 
            array (
              'customCode' => '<input title="{$MOD.LBL_CONVERT_BUTTON_TITLE}" class="button" onclick="this.form.return_module.value=\'Prospects\'; this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$fields.id.value}\';this.form.module.value=\'Leads\';this.form.action.value=\'EditView\';" type="submit" name="CONVERT_LEAD_BTN" value="{$MOD.LBL_CONVERT_BUTTON_LABEL}"/>',
              'sugar_html' => 
              array (
                'type' => 'submit',
                'value' => '{$MOD.LBL_CONVERT_BUTTON_LABEL}',
                'htmlOptions' => 
                array (
                  'class' => 'button',
                  'name' => 'CONVERT_LEAD_BTN',
                  'id' => 'convert_target_button',
                  'title' => '{$MOD.LBL_CONVERT_BUTTON_TITLE}',
                  'onclick' => 'this.form.return_module.value=\'Prospects\'; this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$fields.id.value}\';this.form.module.value=\'Leads\';this.form.action.value=\'EditView\';',
                ),
              ),
            ),
            4 => 
            array (
              'customCode' => '<input title="{$APP.LBL_MANAGE_SUBSCRIPTIONS}" class="button" onclick="this.form.return_module.value=\'Prospects\'; this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$fields.id.value}\'; this.form.action.value=\'Subscriptions\'; this.form.module.value=\'Campaigns\';" type="submit" name="Manage Subscriptions" value="{$APP.LBL_MANAGE_SUBSCRIPTIONS}"/>',
              'sugar_html' => 
              array (
                'type' => 'submit',
                'value' => '{$APP.LBL_MANAGE_SUBSCRIPTIONS}',
                'htmlOptions' => 
                array (
                  'class' => 'button',
                  'id' => 'manage_subscriptions_button',
                  'name' => 'Manage Subscriptions',
                  'title' => '{$APP.LBL_MANAGE_SUBSCRIPTIONS}',
                  'onclick' => 'this.form.return_module.value=\'Prospects\'; this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$fields.id.value}\'; this.form.action.value=\'Subscriptions\'; this.form.module.value=\'Campaigns\';',
                ),
              ),
            ),
          ),
          'hidden' => 
          array (
            0 => '<input type="hidden" name="prospect_id" value="{$fields.id.value}">',
          ),
          'headerTpl' => 'modules/Prospects/tpls/DetailViewHeader.tpl',
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
      ),
      'panels' => 
      array (
        'lbl_prospect_information' => 
        array (
          0 => 
          array (
            0 => 
            array (
              'name' => 'full_name',
            ),
          ),
          1 => 
          array (
            0 => 'title',
            1 => 
            array (
              'name' => 'phone_work',
              'label' => 'LBL_OFFICE_PHONE',
            ),
          ),
          2 => 
          array (
            0 => 'department',
            1 => 'phone_mobile',
          ),
          3 => 
          array (
            0 => 
            array (
              'name' => 'account_name',
              'displayParams' => 
              array (
              ),
            ),
            1 => 'phone_fax',
          ),
          4 => 
          array (
            0 => 
            array (
              'name' => 'primary_address_street',
              'label' => 'LBL_PRIMARY_ADDRESS',
              'type' => 'address',
              'displayParams' => 
              array (
                'key' => 'primary',
              ),
            ),
            1 => 
            array (
              'name' => 'alt_address_street',
              'label' => 'LBL_ALTERNATE_ADDRESS',
              'type' => 'address',
              'displayParams' => 
              array (
                'key' => 'alt',
              ),
            ),
          ),
          5 => 
          array (
            0 => 'email1',
          ),
          6 => 
          array (
            0 => 'description',
            1 => 
            array (
              'name' => 'twitter_user_c',
            ),
          ),
        ),
        'LBL_MORE_INFORMATION' => 
        array (
          0 => 
          array (
            0 => 'email_opt_out',
            1 => 'do_not_call',
          ),
        ),
        'LBL_PANEL_ASSIGNMENT' => 
        array (
          0 => 
          array (
            0 => 'assigned_user_name',
            1 => 
            array (
              'name' => 'modified_by_name',
              'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}&nbsp;',
              'label' => 'LBL_DATE_MODIFIED',
            ),
          ),
          1 => 
          array (
            0 => 
            array (
              'name' => 'created_by_name',
              'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}&nbsp;',
              'label' => 'LBL_DATE_ENTERED',
            ),
          ),
        ),
      ),
    ),
  ),
);