<?php
$popupMeta = array (
    'moduleMain' => 'AM_ProjectTemplates',
    'varName' => 'AM_ProjectTemplates',
    'orderBy' => 'am_projecttemplates.name',
    'whereClauses' => array (
  'name' => 'am_projecttemplates.name',
  'status' => 'am_projecttemplates.status',
  'priority' => 'am_projecttemplates.priority',
  'assigned_user_name' => 'am_projecttemplates.assigned_user_name',
),
    'searchInputs' => array (
  1 => 'name',
  2 => 'priority',
  3 => 'status',
  4 => 'assigned_user_name',
),
    'searchdefs' => array (
  'name' => 
  array (
    'type' => 'name',
    'link' => true,
    'label' => 'LBL_NAME',
    'width' => '10%',
    'name' => 'name',
  ),
  'status' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_STATUS',
    'width' => '10%',
    'name' => 'status',
  ),
  'priority' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_PRIORITY',
    'width' => '10%',
    'name' => 'priority',
  ),
  'assigned_user_name' => 
  array (
    'link' => true,
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'id' => 'ASSIGNED_USER_ID',
    'width' => '10%',
    'name' => 'assigned_user_name',
  ),
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
  'ASSIGNED_USER_NAME' => 
  array (
    'link' => true,
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'id' => 'ASSIGNED_USER_ID',
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
),
);
