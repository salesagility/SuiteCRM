<?php
$module_name = 'AM_TaskTemplates';
$listViewDefs [$module_name] = 
array (
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'DURATION' => 
  array (
    'type' => 'int',
    'label' => 'LBL_DURATION',
    'width' => '10%',
    'default' => true,
  ),
  'STATUS' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_STATUS',
    'width' => '10%',
  ),
  'PRIORITY' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_PRIORITY',
    'width' => '10%',
  ),
  'MILESTONE_FLAG' => 
  array (
    'type' => 'bool',
    'default' => true,
    'label' => 'LBL_MILESTONE_FLAG',
    'width' => '10%',
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '9%',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => true,
  ),
  'AM_TASKTEMPLATES_AM_PROJECTTEMPLATES_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_AM_TASKTEMPLATES_AM_PROJECTTEMPLATES_FROM_AM_PROJECTTEMPLATES_TITLE',
    'id' => 'AM_TASKTEMPLATES_AM_PROJECTTEMPLATESAM_PROJECTTEMPLATES_IDA',
    'width' => '10%',
    'default' => true,
  ),
);
