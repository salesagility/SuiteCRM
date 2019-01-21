<?php

$module_name = 'jjwg_Maps';

$listViewDefs[$module_name] = 
array (
  'MAP_ACTION' =>
  array (
    'type' => 'url',
    'label' => 'LBL_MAP_DISPLAY',
    'width' => '10%',
    'sortable' => false,
    'link' => true,
    'default' => true,
    'related_fields' => 
    array (
      0 => 'parent_type',
      1 => 'module_type',
      2 => 'id',
    ),
    'customCode' => '<a href="index.php?module='.$module_name.'&action=map_display'.
            '&relate_module={$PARENT_TYPE}&display_module={$MODULE_TYPE}&record={$ID}" >'.$GLOBALS['app_strings']['LBL_MAP'].' {$MODULE_TYPE}</a>',
  ),
  'NAME' => 
  array (
    'width' => '25%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'PARENT_NAME' => 
  array (
    'type' => 'parent',
    'studio' => 'visible',
    'label' => 'LBL_FLEX_RELATE',
    'link' => true,
    'sortable' => false,
    'ACLTag' => 'PARENT',
    'dynamic_module' => 'PARENT_TYPE',
    'id' => 'PARENT_ID',
    'related_fields' => 
    array (
      0 => 'parent_id',
      1 => 'parent_type',
    ),
    'width' => '25%',
    'default' => true,
  ),
  'MODULE_TYPE' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_MODULE_TYPE',
    'sortable' => false,
    'width' => '10%',
  ),
  'DISTANCE' => 
  array (
    'type' => 'float',
    'label' => 'LBL_DISTANCE',
    'width' => '10%',
    'default' => true,
  ),
  'UNIT_TYPE' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_UNIT_TYPE',
    'sortable' => false,
    'width' => '10%',
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
    'width' => '9%',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'default' => true,
  ),
  'DESCRIPTION' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '10%',
    'default' => false,
  ),
  'CREATED_BY_NAME' => 
  array (
    'type' => 'relate',
    'link' => 'created_by_link',
    'label' => 'LBL_CREATED',
    'width' => '10%',
    'default' => false,
  ),
  'DATE_MODIFIED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_MODIFIED',
    'width' => '10%',
    'default' => false,
  ),
);
