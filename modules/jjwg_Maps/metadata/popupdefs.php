<?php

$popupMeta = array(
    'moduleMain' => 'jjwg_Maps',
    'varName' => 'jjwg_Maps',
    'orderBy' => 'jjwg_maps.name',
    'whereClauses' => array(
  'name' => 'jjwg_maps.name',
  'module_type' => 'jjwg_maps.module_type',
),
    'searchInputs' => array(
  1 => 'name',
  4 => 'module_type',
),
    'searchdefs' => array(
  'name' =>
  array(
    'type' => 'name',
    'label' => 'LBL_NAME',
    'width' => '10%',
    'name' => 'name',
  ),
  'module_type' =>
  array(
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_MODULE_TYPE',
    'sortable' => false,
    'width' => '10%',
    'name' => 'module_type',
  ),
),
    'listviewdefs' => array(
  'NAME' =>
  array(
    'type' => 'name',
    'label' => 'LBL_NAME',
    'width' => '10%',
    'default' => true,
  ),
  'MODULE_TYPE' =>
  array(
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_MODULE_TYPE',
    'sortable' => false,
    'width' => '10%',
  ),
),
);
