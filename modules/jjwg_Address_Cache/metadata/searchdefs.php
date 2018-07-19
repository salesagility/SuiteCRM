<?php
$module_name = 'jjwg_Address_Cache';
$searchdefs [$module_name] =
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
      'lat' =>
      array(
        'type' => 'decimal',
        'label' => 'LBL_LAT',
        'width' => '10%',
        'default' => true,
        'name' => 'lat',
      ),
      'lng' =>
      array(
        'type' => 'decimal',
        'label' => 'LBL_LNG',
        'width' => '10%',
        'default' => true,
        'name' => 'lng',
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
