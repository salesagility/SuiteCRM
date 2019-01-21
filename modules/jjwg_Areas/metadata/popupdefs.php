<?php
$popupMeta = array (
    'moduleMain' => 'jjwg_Areas',
    'varName' => 'jjwg_Areas',
    'orderBy' => 'jjwg_areas.name',
    'whereClauses' => array (
  'name' => 'jjwg_areas.name',
  'city' => 'jjwg_areas.city',
  'state' => 'jjwg_areas.state',
  'country' => 'jjwg_areas.country',
  'assigned_user_name' => 'jjwg_areas.assigned_user_name',
  'date_entered' => 'jjwg_areas.date_entered',
),
    'searchInputs' => array (
  1 => 'name',
  4 => 'city',
  5 => 'state',
  6 => 'country',
  7 => 'assigned_user_name',
  8 => 'date_entered',
),
    'searchdefs' => array (
  'name' => 
  array (
    'type' => 'name',
    'label' => 'LBL_NAME',
    'width' => '10%',
    'name' => 'name',
  ),
  'city' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_CITY',
    'width' => '10%',
    'name' => 'city',
  ),
  'state' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_STATE',
    'width' => '10%',
    'name' => 'state',
  ),
  'country' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_COUNTRY',
    'width' => '10%',
    'name' => 'country',
  ),
  'assigned_user_name' => 
  array (
    'link' => 'assigned_user_link',
    'type' => 'relate',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'width' => '10%',
    'name' => 'assigned_user_name',
  ),
  'date_entered' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '10%',
    'name' => 'date_entered',
  ),
),
    'listviewdefs' => array (
  'NAME' => 
  array (
    'type' => 'name',
    'label' => 'LBL_NAME',
    'width' => '10%',
    'link' => true,
    'default' => true,
    'name' => 'name',
  ),
  'CITY' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_CITY',
    'width' => '10%',
    'default' => true,
    'name' => 'city',
  ),
  'STATE' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_STATE',
    'width' => '10%',
    'default' => true,
    'name' => 'state',
  ),
  'COUNTRY' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_COUNTRY',
    'width' => '10%',
    'default' => true,
    'name' => 'country',
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'link' => 'assigned_user_link',
    'type' => 'relate',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'width' => '10%',
    'default' => true,
    'name' => 'assigned_user_name',
  ),
),
);
