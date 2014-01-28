<?php
// created: 2014-01-28 16:41:55
$viewdefs = array (
  'Cases' => 
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
        'lbl_case_information' => 
        array (
          0 => 
          array (
            0 => 
            array (
              'name' => 'case_number',
              'label' => 'LBL_CASE_NUMBER',
            ),
            1 => 'priority',
          ),
          1 => 
          array (
            0 => 'status',
            1 => 'account_name',
          ),
          2 => 
          array (
            0 => 'type',
          ),
          3 => 
          array (
            0 => 
            array (
              'name' => 'name',
              'label' => 'LBL_SUBJECT',
            ),
          ),
          4 => 
          array (
            0 => 'description',
          ),
          5 => 
          array (
            0 => 'resolution',
            1 => 
            array (
              'name' => '_user_c',
            ),
          ),
          6 => 
          array (
            0 => 
            array (
              'name' => 'twitteruser_c_user_c',
            ),
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