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
            'name' => 'account',
            'studio' => 'visible',
            'label' => 'LBL_ACCOUNT',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'system_id',
            'studio' => 'visible',
            'label' => 'LBL_SYSTEM_ID',
          ),
          1 => 
          array (
            'name' => 'installation_id',
            'label' => 'LBL_INSTALLATION_ID',
          ),
        ),
        2 => 
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
        3 => 
        array (
          0 => 
          array (
            'name' => 'firmware_version',
            'label' => 'LBL_FIRMWARE_VERSION',
          ),
          1 => 'assigned_user_name',
        ),
        4 => 
        array (
          0 => 'description',
        ),
      ),
    ),
  ),
);
;
?>
