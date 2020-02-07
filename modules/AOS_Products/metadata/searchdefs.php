<?php
$module_name = 'AOS_Products';
$searchdefs [$module_name] =
array(
  'layout' =>
  array(
    'basic_search' =>
    array(
      0 => 'name',
      1 =>
      array(
        'name' => 'current_user_only',
        'label' => 'LBL_CURRENT_USER_FILTER',
        'type' => 'bool',
      ),
        'favorites_only' => array('name' => 'favorites_only','label' => 'LBL_FAVORITES_FILTER','type' => 'bool',),
    ),
    'advanced_search' =>
    array(
      'name' =>
      array(
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'part_number' =>
      array(
        'name' => 'part_number',
        'default' => true,
        'width' => '10%',
      ),
      'cost' =>
      array(
        'name' => 'cost',
        'default' => true,
        'width' => '10%',
      ),
      'price' =>
      array(
        'name' => 'price',
        'default' => true,
        'width' => '10%',
      ),
      'created_by' =>
      array(
        'name' => 'created_by',
        'label' => 'LBL_CREATED',
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
