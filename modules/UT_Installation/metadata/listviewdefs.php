<?php
$module_name = 'UT_Installation';
$listViewDefs [$module_name] = 
array (
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'SERIAL_NUMBER' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_SERIAL_NUMBER',
    'width' => '10%',
    'default' => true,
  ),
  'MAIN_EQUIPMENT' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_MAIN_EQUIPMENT',
    'id' => 'AOS_PRODUCTS_ID_C',
    'link' => true,
    'width' => '10%',
    'default' => true,
  ),
  'INSTALLATION_ID' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_INSTALLATION_ID',
    'width' => '10%',
    'default' => true,
  ),
  'ACCOUNT' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_ACCOUNT',
    'id' => 'ACCOUNT_ID_C',
    'link' => true,
    'width' => '10%',
    'default' => true,
  ),
  'SOFTWARE_VERSION' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_SOFTWARE_VERSION',
    'width' => '10%',
    'default' => true,
  ),
  'FIRMWARE_VERSION' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_FIRMWARE_VERSION',
    'width' => '10%',
    'default' => true,
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '9%',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => true,
  ),
);
;
?>
