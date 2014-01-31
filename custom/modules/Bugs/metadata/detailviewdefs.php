<?php
// created: 2014-01-31 09:36:39
$viewdefs = array (
  'Bugs' => 
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
        'lbl_bug_information' => 
        array (
          0 => 
          array (
            0 => 'bug_number',
            1 => 'priority',
          ),
          1 => 
          array (
            0 => 
            array (
              'name' => 'name',
              'label' => 'LBL_SUBJECT',
            ),
            1 => 'status',
          ),
          2 => 
          array (
            0 => 'type',
            1 => 'source',
          ),
          3 => 
          array (
            0 => 'product_category',
            1 => 'resolution',
          ),
          4 => 
          array (
            0 => 
            array (
              'name' => 'found_in_release',
              'label' => 'LBL_FOUND_IN_RELEASE',
            ),
            1 => 'fixed_in_release',
          ),
          5 => 
          array (
            0 => 'description',
          ),
          6 => 
          array (
            0 => 'work_log',
          ),
        ),
        'LBL_PANEL_ASSIGNMENT' => 
        array (
          0 => 
          array (
            0 => 
            array (
              'name' => 'assigned_user_name',
              'label' => 'LBL_ASSIGNED_TO_NAME',
            ),
            1 => 
            array (
              'name' => 'date_modified',
              'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
              'label' => 'LBL_DATE_MODIFIED',
            ),
          ),
          1 => 
          array (
            0 => 
            array (
              'name' => 'date_entered',
              'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
              'label' => 'LBL_DATE_ENTERED',
            ),
          ),
        ),
      ),
    ),
  ),
);