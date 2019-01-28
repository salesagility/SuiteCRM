<?php
$module_name = 'OutboundEmailAccounts';
$listViewDefs [$module_name] = 
array (
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
//  'ASSIGNED_USER_NAME' =>
//  array (
//    'width' => '9%',
//    'label' => 'LBL_ASSIGNED_TO_NAME',
//    'module' => 'Employees',
//    'id' => 'ASSIGNED_USER_ID',
//    'default' => true,
//  ),
  'USERNAME' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_USERNAME',
    'width' => '10%',
    'default' => false,
  ),
  'smtp_servername' =>
  array (
    'type' => 'varchar',
    'label' => 'LBL_SMTP_SERVERNAME',
    'width' => '10%',
    'default' => false,
  ),
);

