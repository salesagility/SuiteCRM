<?php
$module_name = 'AOK_KnowledgeBase';
$listViewDefs [$module_name] = 
array (
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'STATUS' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_STATUS',
    'width' => '10%',
  ),
  'AUTHOR' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_AUTHOR',
    'id' => 'USER_ID_C',
    'link' => true,
    'width' => '10%',
    'default' => true,
  ),
  'APPROVER' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_APPROVER',
    'id' => 'USER_ID1_C',
    'link' => true,
    'width' => '10%',
    'default' => true,
  ),
  'REVISION' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_REVISION',
    'width' => '10%',
    'default' => true,
  ),
  'DATE_ENTERED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '10%',
    'default' => true,
  ),
  'DATE_MODIFIED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_MODIFIED',
    'width' => '10%',
    'default' => true,
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '9%',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => false,
  ),
);
?>
