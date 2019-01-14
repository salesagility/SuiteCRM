<?php
$popupMeta = array (
    'moduleMain' => 'jjwg_Markers',
    'varName' => 'jjwg_Markers',
    'orderBy' => 'jjwg_markers.name',
    'whereClauses' => array (
  'name' => 'jjwg_markers.name',
  'city' => 'jjwg_markers.city',
  'state' => 'jjwg_markers.state',
  'country' => 'jjwg_markers.country',
  'marker_image' => 'jjwg_markers.marker_image',
  'assigned_user_name' => 'jjwg_markers.assigned_user_name',
  'date_entered' => 'jjwg_markers.date_entered',
),
    'searchInputs' => array (
  1 => 'name',
  4 => 'city',
  5 => 'state',
  6 => 'country',
  7 => 'marker_image',
  8 => 'assigned_user_name',
  9 => 'date_entered',
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
  'marker_image' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_MARKER_IMAGE',
    'sortable' => false,
    'width' => '10%',
    'name' => 'marker_image',
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
  'MARKER_IMAGE' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_MARKER_IMAGE',
    'sortable' => false,
    'width' => '10%',
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
