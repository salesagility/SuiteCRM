<?php
// created: 2014-01-28 16:47:08
$viewdefs = array (
  'Notes' => 
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
        'useTabs' => false,
      ),
      'panels' => 
      array (
        'lbl_note_information' => 
        array (
          0 => 
          array (
            0 => 'contact_name',
            1 => 
            array (
              'name' => 'parent_name',
              'customLabel' => '{sugar_translate label=\'LBL_MODULE_NAME\' module=$fields.parent_type.value}',
            ),
          ),
          1 => 
          array (
            0 => 
            array (
              'name' => 'name',
              'label' => 'LBL_SUBJECT',
            ),
          ),
          2 => 
          array (
            0 => 
            array (
              'name' => 'filename',
            ),
          ),
          3 => 
          array (
            0 => 
            array (
              'name' => 'description',
              'label' => 'LBL_NOTE_STATUS',
            ),
            1 => 
            array (
              'name' => 'twitter_user_c',
            ),
          ),
          4 => 
          array (
            0 => 
            array (
              'name' => 'twitter_user_c',
            ),
            1 => 
            array (
              'name' => 'facebook_user_c',
            ),
          ),
          5 => 
          array (
            0 => 
            array (
              'name' => 'facebook_user_c',
            ),
            1 => 
            array (
              'name' => 'facebook_user_c',
            ),
          ),
          6 => 
          array (
            0 => 
            array (
              'name' => 'twitter_user_c',
            ),
          ),
        ),
        'LBL_PANEL_ASSIGNMENT' => 
        array (
          0 => 
          array (
            0 => 'assigned_user_name',
            1 => 
            array (
              'name' => 'date_modified',
              'label' => 'LBL_DATE_MODIFIED',
              'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
            ),
          ),
          1 => 
          array (
            0 => 
            array (
              'name' => 'date_entered',
              'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
            ),
          ),
        ),
      ),
    ),
  ),
);