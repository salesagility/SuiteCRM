<?php
$module_name = 'UT_Installation';
$searchdefs [$module_name] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'system_id' => 
      array (
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_SYSTEM_ID',
        'id' => 'AOS_PRODUCTS_ID_C',
        'link' => true,
        'width' => '10%',
        'default' => true,
        'name' => 'system_id',
      ),
      'installation_id' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_INSTALLATION_ID',
        'width' => '10%',
        'default' => true,
        'name' => 'installation_id',
      ),
      'software_version' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_SOFTWARE_VERSION',
        'width' => '10%',
        'default' => true,
        'name' => 'software_version',
      ),
      'firmware_version' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_FIRMWARE_VERSION',
        'width' => '10%',
        'default' => true,
        'name' => 'firmware_version',
      ),
      'account' => 
      array (
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_ACCOUNT',
        'id' => 'ACCOUNT_ID_C',
        'link' => true,
        'width' => '10%',
        'default' => true,
        'name' => 'account',
      ),
      'current_user_only' => 
      array (
        'name' => 'current_user_only',
        'label' => 'LBL_CURRENT_USER_FILTER',
        'type' => 'bool',
        'default' => true,
        'width' => '10%',
      ),
    ),
    'advanced_search' => 
    array (
      0 => 'name',
      1 => 
      array (
        'name' => 'assigned_user_id',
        'label' => 'LBL_ASSIGNED_TO',
        'type' => 'enum',
        'function' => 
        array (
          'name' => 'get_user_array',
          'params' => 
          array (
            0 => false,
          ),
        ),
      ),
    ),
  ),
  'templateMeta' => 
  array (
    'maxColumns' => '3',
    'maxColumnsBasic' => '4',
    'widths' => 
    array (
      'label' => '10',
      'field' => '30',
    ),
  ),
);
;
?>
