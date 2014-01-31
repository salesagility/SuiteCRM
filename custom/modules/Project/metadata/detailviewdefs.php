<?php
// created: 2014-01-29 16:53:32
$viewdefs = array (
  'Project' => 
  array (
    'DetailView' => 
    array (
      'templateMeta' => 
      array (
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
        'includes' => 
        array (
          0 => 
          array (
            'file' => 'modules/Project/Project.js',
          ),
        ),
        'form' => 
        array (
          'buttons' => 
          array (
            0 => 
            array (
              'customCode' => '<input title="{$APP.LBL_EDIT_BUTTON_TITLE}" accessKey="{$APP.LBL_EDIT_BUTTON_KEY}" class="button" type="submit" name="Edit" id="edit_button" value="{$APP.LBL_EDIT_BUTTON_LABEL}"onclick="{if $IS_TEMPLATE}this.form.return_module.value=\'Project\'; this.form.return_action.value=\'ProjectTemplatesDetailView\'; this.form.return_id.value=\'{$id}\'; this.form.action.value=\'ProjectTemplatesEditView\';{else}this.form.return_module.value=\'Project\'; this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$id}\'; this.form.action.value=\'EditView\'; {/if}"/>',
              'sugar_html' => 
              array (
                'type' => 'submit',
                'value' => ' {$APP.LBL_EDIT_BUTTON_LABEL} ',
                'htmlOptions' => 
                array (
                  'id' => 'edit_button',
                  'class' => 'button',
                  'accessKey' => '{$APP.LBL_EDIT_BUTTON_KEY}',
                  'name' => 'Edit',
                  'onclick' => '{if $IS_TEMPLATE}this.form.return_module.value=\'Project\'; this.form.return_action.value=\'ProjectTemplatesDetailView\'; this.form.return_id.value=\'{$id}\'; this.form.action.value=\'ProjectTemplatesEditView\';{else}this.form.return_module.value=\'Project\'; this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$id}\'; this.form.action.value=\'EditView\'; {/if}',
                ),
              ),
            ),
            1 => 
            array (
              'customCode' => '<input title="{$APP.LBL_DELETE_BUTTON_TITLE}" accessKey="{$APP.LBL_DELETE_BUTTON_KEY}" class="button" type="button" name="Delete" id="delete_button" value="{$APP.LBL_DELETE_BUTTON_LABEL}"onclick="{if $IS_TEMPLATE}this.form.return_module.value=\'Project\'; this.form.return_action.value=\'ProjectTemplatesListView\'; this.form.action.value=\'Delete\'; if( confirm(\'{$APP.NTC_DELETE_CONFIRMATION}\') )  this.form.submit(); {else}this.form.return_module.value=\'Project\'; this.form.return_action.value=\'ListView\'; this.form.action.value=\'Delete\'; if( confirm(\'{$APP.NTC_DELETE_CONFIRMATION}\'))  this.form.submit(); {/if}"/>',
              'sugar_html' => 
              array (
                'type' => 'button',
                'id' => 'delete_button',
                'value' => '{$APP.LBL_DELETE_BUTTON_LABEL}',
                'htmlOptions' => 
                array (
                  'title' => '{$APP.LBL_DELETE_BUTTON_TITLE}',
                  'accessKey' => '{$APP.LBL_DELETE_BUTTON_KEY}',
                  'id' => 'delete_button',
                  'class' => 'button',
                  'onclick' => '{if $IS_TEMPLATE}this.form.return_module.value=\'Project\'; this.form.return_action.value=\'ProjectTemplatesListView\'; this.form.action.value=\'Delete\'; if (confirm(\'{$APP.NTC_DELETE_CONFIRMATION}\')) this.form.submit();{else}this.form.return_module.value=\'Project\'; this.form.return_action.value=\'ListView\'; this.form.action.value=\'Delete\'; if (confirm(\'{$APP.NTC_DELETE_CONFIRMATION}\')) this.form.submit();{/if}',
                ),
              ),
            ),
            2 => 
            array (
              'customCode' => '<input title="{$APP.LBL_DUPLICATE_BUTTON_TITLE}" accessKey="{$APP.LBL_DUPLICATE_BUTTON_KEY}" class="button" type="submit" name="Duplicate" id="duplicate_button" value="{$APP.LBL_DUPLICATE_BUTTON_LABEL}"onclick="{if $IS_TEMPLATE}this.form.return_module.value=\'Project\'; this.form.return_action.value=\'ProjectTemplatesDetailView\'; this.form.isDuplicate.value=true; this.form.action.value=\'projecttemplateseditview\'; this.form.return_id.value=\'{$id}\';{else}this.form.return_module.value=\'Project\'; this.form.return_action.value=\'DetailView\'; this.form.isDuplicate.value=true; this.form.action.value=\'EditView\'; this.form.return_id.value=\'{$id}\';{/if}""/>',
              'sugar_html' => 
              array (
                'type' => 'submit',
                'value' => '{$APP.LBL_DUPLICATE_BUTTON_LABEL}',
                'htmlOptions' => 
                array (
                  'title' => '{$APP.LBL_DUPLICATE_BUTTON_TITLE}',
                  'accessKey' => '{$APP.LBL_DUPLICATE_BUTTON_KEY}',
                  'class' => 'button',
                  'name' => 'Duplicate',
                  'id' => 'duplicate_button',
                  'onclick' => '{if $IS_TEMPLATE}this.form.return_module.value=\'Project\'; this.form.return_action.value=\'ProjectTemplatesDetailView\'; this.form.isDuplicate.value=true; this.form.action.value=\'projecttemplateseditview\'; this.form.return_id.value=\'{$id}\';{else}this.form.return_module.value=\'Project\'; this.form.return_action.value=\'DetailView\'; this.form.isDuplicate.value=true; this.form.action.value=\'EditView\'; this.form.return_id.value=\'{$id}\';{/if}',
                ),
              ),
            ),
          ),
        ),
      ),
      'panels' => 
      array (
        'lbl_project_information' => 
        array (
          0 => 
          array (
            0 => 'name',
            1 => 'status',
          ),
          1 => 
          array (
            0 => 
            array (
              'name' => 'estimated_start_date',
              'label' => 'LBL_DATE_START',
            ),
            1 => 'priority',
          ),
          2 => 
          array (
            0 => 
            array (
              'name' => 'estimated_end_date',
              'label' => 'LBL_DATE_END',
            ),
          ),
          3 => 
          array (
            0 => 'description',
            1 => 
            array (
              'name' => 'twitter_user_c',
            ),
          ),
        ),
        'LBL_PANEL_ASSIGNMENT' => 
        array (
          0 => 
          array (
            0 => 
            array (
              'name' => 'assigned_user_name',
              'label' => 'LBL_ASSIGNED_TO',
            ),
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