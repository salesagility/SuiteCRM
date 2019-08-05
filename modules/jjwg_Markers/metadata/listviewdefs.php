<?php
$module_name = 'jjwg_Markers';
$listViewDefs [$module_name] =
array(
  'NAME' =>
  array(
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'CITY' =>
  array(
    'type' => 'varchar',
    'label' => 'LBL_CITY',
    'width' => '10%',
    'default' => true,
  ),
  'STATE' =>
  array(
    'type' => 'varchar',
    'label' => 'LBL_STATE',
    'width' => '10%',
    'default' => true,
  ),
  'COUNTRY' =>
  array(
    'type' => 'varchar',
    'label' => 'LBL_COUNTRY',
    'width' => '10%',
    'default' => true,
  ),
  'JJWG_MAPS_LAT' =>
  array(
    'type' => 'decimal',
    'default' => true,
    'label' => 'LBL_JJWG_MAPS_LAT',
    'width' => '10%',
  ),
  'JJWG_MAPS_LNG' =>
  array(
    'type' => 'decimal',
    'default' => true,
    'label' => 'LBL_JJWG_MAPS_LNG',
    'width' => '10%',
  ),
  'MARKER_IMAGE' =>
  array(
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_MARKER_IMAGE',
    'sortable' => false,
    'width' => '10%',
  ),
  'ASSIGNED_USER_NAME' =>
  array(
    'width' => '9%',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => true,
  ),
  'DESCRIPTION' =>
  array(
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '10%',
    'default' => false,
  ),
  'CREATED_BY_NAME' =>
  array(
    'type' => 'relate',
    'link' => 'created_by_link',
    'label' => 'LBL_CREATED',
    'width' => '10%',
    'default' => false,
  ),
  'MODIFIED_BY_NAME' =>
  array(
    'type' => 'relate',
    'link' => 'modified_user_link',
    'label' => 'LBL_MODIFIED_NAME',
    'width' => '10%',
    'default' => false,
  ),
  'DATE_MODIFIED' =>
  array(
    'type' => 'datetime',
    'label' => 'LBL_DATE_MODIFIED',
    'width' => '10%',
    'default' => false,
  ),
  'DATE_ENTERED' =>
  array(
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '10%',
    'default' => false,
  ),
);
