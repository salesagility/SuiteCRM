<?php
$popupMeta = array (
    'moduleMain' => 'jjwg_Adress_Cache',
    'varName' => 'jjwg_Adress_Cache',
    'orderBy' => 'jjwg_adress_cache.name',
    'whereClauses' => array (
  'name' => 'jjwg_adress_cache.name',
  'lat' => 'jjwg_adress_cache.lat',
  'lng' => 'jjwg_adress_cache.lng',
  'date_entered' => 'jjwg_adress_cache.date_entered',
  'assigned_user_name' => 'jjwg_adress_cache.assigned_user_name',
),
    'searchInputs' => array (
  1 => 'name',
  4 => 'lat',
  5 => 'lng',
  6 => 'date_entered',
  7 => 'assigned_user_name',
),
    'searchdefs' => array (
  'name' => 
  array (
    'type' => 'name',
    'label' => 'LBL_NAME',
    'width' => '10%',
    'name' => 'name',
  ),
  'lat' => 
  array (
    'type' => 'decimal',
    'label' => 'LBL_LAT',
    'width' => '10%',
    'name' => 'lat',
  ),
  'lng' => 
  array (
    'type' => 'decimal',
    'label' => 'LBL_LNG',
    'width' => '10%',
    'name' => 'lng',
  ),
  'date_entered' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '10%',
    'name' => 'date_entered',
  ),
  'assigned_user_name' => 
  array (
    'link' => 'assigned_user_link',
    'type' => 'relate',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'width' => '10%',
    'name' => 'assigned_user_name',
  ),
),
    'listviewdefs' => array (
  'NAME' => 
  array (
    'type' => 'name',
    'label' => 'LBL_NAME',
    'width' => '10%',
    'default' => true,
  ),
  'LAT' => 
  array (
    'type' => 'decimal',
    'label' => 'LBL_LAT',
    'width' => '10%',
    'default' => true,
  ),
  'LNG' => 
  array (
    'type' => 'decimal',
    'label' => 'LBL_LNG',
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
  'ASSIGNED_USER_NAME' => 
  array (
    'link' => 'assigned_user_link',
    'type' => 'relate',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'width' => '10%',
    'default' => true,
  ),
),
);
