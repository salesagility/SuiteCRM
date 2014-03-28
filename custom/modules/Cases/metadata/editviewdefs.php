<?php
$viewdefs ['Cases'] = 
array (
  'EditView' => 
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
      'tabDefs' =>
      array (
        'LBL_CASE_INFORMATION' =>
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_PANEL_ASSIGNMENT' =>
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
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
            'type' => 'readonly',
          ),
        ),
        1 => 
        array (
          0 => 'priority',
        ),
        2 => 
        array (
          0 =>
          array (
            'name' => 'state',
            'comment' => 'The state of the case (i.e. open/closed)',
            'label' => 'LBL_STATE',
          ),
          1 => '',
        ),
        3 =>
        array (
          0 => 'status',
          1 => 'account_name',
        ),
        4 =>
        array (
          0 => 'type',
        ),
        5 =>
        array (
          0 => 
          array (
            'name' => 'name',
            'displayParams' => 
            array (
              'size' => 75,
            ),
          ),
        ),
        6 =>
        array (
          0 => 
          array (
            'name' => 'description',
            'nl2br' => true,
          ),
        ),
        7 =>
        array (
          0 => 
          array (
            'name' => 'resolution',
            'nl2br' => true,
          ),
        ),
        8 =>
        array (
          0 => 
          array (
            'name' => 'update_text',
            'studio' => 'visible',
            'label' => 'LBL_UPDATE_TEXT',
          ),
          1 => 
          array (
            'name' => 'internal',
            'studio' => 'visible',
            'label' => 'LBL_INTERNAL',
          ),
        ),
      ),
      'LBL_PANEL_ASSIGNMENT' => 
      array (
        0 => 
        array (
          0 => 'assigned_user_name',
        ),
      ),
    ),
  ),
);
?>
