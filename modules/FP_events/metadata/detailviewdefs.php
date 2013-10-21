<?php
$module_name = 'FP_events';
$viewdefs [$module_name] = 
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
          3 => 'FIND_DUPLICATES',
        ),
        'hidden' => 
        array (
          0 => '<input id="custom_hidden_1" type="hidden" name="custom_hidden_1" value=""/>',
          1 => '<input id="custom_hidden_2" type="hidden" name="custom_hidden_2" value=""/>',
        ),
      ),
      'maxColumns' => '2',
      'includes' => 
      array (
        0 => 
        array (
          'file' => 'custom/include/javascript/checkbox.js',
        ),
        1 => 
        array (
          'file' => 'cache/include/javascript/sugar_grp_yui_widgets.js',
        ),
      ),
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
      'useTabs' => false,
      'tabDefs' => 
      array (
        'LBL_EDITVIEW_PANEL1' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
      'syncDetailEditViews' => true,
    ),
    'panels' => 
    array (
      'lbl_editview_panel1' => 
      array (
        0 => 
        array (
          0 => 'name',
          1 => 
          array (
            'name' => 'fp_event_locations_fp_events_1_name',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'date_start',
            'comment' => 'Date of start of meeting',
            'label' => 'LBL_DATE',
          ),
          1 => 
          array (
            'name' => 'budget',
            'label' => 'LBL_BUDGET',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'date_end',
            'comment' => 'Date meeting ends',
            'label' => 'LBL_DATE_END',
          ),
          1 => 
          array (
            'name' => 'created_by_name',
            'label' => 'LBL_CREATED',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'duration',
            'customCode' => '{$fields.duration_hours.value}{$MOD.LBL_HOURS_ABBREV} {$fields.duration_minutes.value}{$MOD.LBL_MINSS_ABBREV} ',
            'label' => 'LBL_DURATION',
          ),
          1 => 
          array (
            'name' => 'invite_templates',
            'studio' => 'visible',
            'label' => 'LBL_INVITE_TEMPLATES',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'accept_redirect',
            'label' => 'LBL_ACCEPT_REDIRECT',
          ),
          1 => 
          array (
            'name' => 'decline_redirect',
            'label' => 'LBL_DECLINE_REDIRECT',
          ),
        ),
        5 => 
        array (
          0 => 'description',
          1 => 'assigned_user_name',
        ),
      ),
    ),
  ),
);
?>
