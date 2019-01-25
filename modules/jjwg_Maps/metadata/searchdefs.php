<?php

$module_name = 'jjwg_Maps';

$searchdefs[$module_name] =
array(
  'layout' =>
  array(
    'basic_search' =>
    array(
      'name' =>
      array(
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'module_type' =>
      array(
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_MODULE_TYPE',
        'sortable' => false,
        'width' => '10%',
        'name' => 'module_type',
      ),
      'current_user_only' =>
      array(
        'name' => 'current_user_only',
        'label' => 'LBL_CURRENT_USER_FILTER',
        'type' => 'bool',
        'default' => true,
        'width' => '10%',
      ),
    ),
    'advanced_search' =>
    array(
      'name' =>
      array(
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'unit_type' =>
      array(
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_UNIT_TYPE',
        'sortable' => false,
        'width' => '10%',
        'name' => 'unit_type',
      ),
      'distance' =>
      array(
        'type' => 'float',
        'label' => 'LBL_DISTANCE',
        'width' => '10%',
        'default' => true,
        'name' => 'distance',
      ),
      'module_type' =>
      array(
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_MODULE_TYPE',
        'sortable' => false,
        'width' => '10%',
        'name' => 'module_type',
      ),
      'description' =>
      array(
        'type' => 'text',
        'label' => 'LBL_DESCRIPTION',
        'sortable' => false,
        'width' => '10%',
        'default' => true,
        'name' => 'description',
      ),
      'assigned_user_id' =>
      array(
        'name' => 'assigned_user_id',
        'label' => 'LBL_ASSIGNED_TO',
        'type' => 'enum',
        'function' =>
        array(
          'name' => 'get_user_array',
          'params' =>
          array(
            0 => false,
          ),
        ),
        'default' => true,
        'width' => '10%',
      ),
    ),
  ),
  'templateMeta' =>
  array(
    'maxColumns' => '3',
    'widths' =>
    array(
      'label' => '10',
      'field' => '30',
    ),
  ),
);
