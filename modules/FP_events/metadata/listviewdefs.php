<?php
$module_name = 'FP_events';
$listViewDefs [$module_name] = 
array (
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'CREATED_BY_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_CREATED',
    'id' => 'CREATED_BY',
    'width' => '10%',
    'default' => true,
  ),
  'DATE_START' => 
  array (
    'type' => 'datetimecombo',
    'label' => 'LBL_DATE',
    'width' => '10%',
    'default' => true,
  ),
  'DATE_END' => 
  array (
    'type' => 'datetimecombo',
    'label' => 'LBL_DATE_END',
    'width' => '10%',
    'default' => true,
  ),
  'FP_EVENT_LOCATIONS_FP_EVENTS_1_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_FP_EVENT_LOCATIONS_FP_EVENTS_1_FROM_FP_EVENT_LOCATIONS_TITLE',
    'id' => 'FP_EVENT_LOCATIONS_FP_EVENTS_1FP_EVENT_LOCATIONS_IDA',
    'width' => '10%',
    'default' => true,
  ),
  'BUDGET' => 
  array (
    'type' => 'currency',
    'label' => 'LBL_BUDGET',
    'currency_format' => true,
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
?>
