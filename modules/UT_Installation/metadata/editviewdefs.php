<?php
$module_name = 'UT_Installation';
$viewdefs [$module_name] = 
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
        'DEFAULT' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
      'syncDetailEditViews' => false,
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 'name',
          1 => 
          array (
            'name' => 'main_equipment',
            'studio' => 'visible',
            'label' => 'LBL_MAIN_EQUIPMENT',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'installation_id',
            'label' => 'LBL_INSTALLATION_ID',
          ),
          1 => 
          array (
            'name' => 'serial_number',
            'label' => 'LBL_SERIAL_NUMBER',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'account',
            'studio' => 'visible',
            'label' => 'LBL_ACCOUNT',
          ),
          1 => 
          array (
            'name' => 'supplier',
            'studio' => 'visible',
            'label' => 'LBL_SUPPLIER',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'software_version',
            'label' => 'LBL_SOFTWARE_VERSION',
          ),
          1 => 
          array (
            'name' => 'latest_software_version',
            'label' => 'LBL_LATEST_SOFTWARE_VERSION',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'firmware_version',
            'label' => 'LBL_FIRMWARE_VERSION',
          ),
          1 => 'assigned_user_name',
        ),
        5 => 
        array (
          0 => 'description',
          1 => '',
        ),
      ),
    ),
  ),
);
;
?>
