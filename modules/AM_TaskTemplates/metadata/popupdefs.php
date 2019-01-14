<?php
$popupMeta = array (
    'moduleMain' => 'AM_TaskTemplates',
    'varName' => 'AM_TaskTemplates',
    'orderBy' => 'am_tasktemplates.name',
    'whereClauses' => array (
  'name' => 'am_tasktemplates.name',
),
    'searchInputs' => array (
  0 => 'am_tasktemplates_number',
  1 => 'name',
  2 => 'priority',
  3 => 'status',
),
    'listviewdefs' => array (
  'NAME' => 
  array (
    'type' => 'name',
    'link' => true,
    'label' => 'LBL_NAME',
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
  'ORDER_NUMBER' => 
  array (
    'type' => 'int',
    'label' => 'LBL_ORDER_NUMBER',
    'width' => '10%',
    'default' => true,
  ),
  'RELATIONSHIP_TYPE' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_RELATIONSHIP_TYPE',
    'width' => '10%',
  ),
  'DURATION' => 
  array (
    'type' => 'int',
    'label' => 'LBL_DURATION',
    'width' => '10%',
    'default' => true,
  ),
),
);
