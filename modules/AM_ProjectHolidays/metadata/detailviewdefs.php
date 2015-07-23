<?php
$module_name = 'AM_ProjectHolidays';
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
      'useTabs' => false,
      'tabDefs' => 
      array (
        'DEFAULT' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
      'syncDetailEditViews' => true,
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 'name',
          1 => '',
        ),
          1 =>
              array (
                  0 => 'holiday_date',
              ),
        2 =>
        array (
          0 => 'description',
        ),
        3 =>
        array (
          0 => 
          array (
            'name' => 'resourse_users',
            'studio' => 'visible',
            'label' => 'LBL_RESOURSE_USERS',
          ),
          1 => '',
        ),
        4 =>
        array (
          0 => 
          array (
            'name' => 'am_projectholidays_project_name',
          ),
          1 => '',
        ),
      ),
    ),
  ),
);
?>
