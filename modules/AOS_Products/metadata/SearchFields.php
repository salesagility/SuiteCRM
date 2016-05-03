<?php
// created: 2013-05-07 12:48:58
global $current_user;
$searchFields['AOS_Products'] = array (
  'name' => 
  array (
    'query_type' => 'default',
  ),
  'current_user_only' => 
  array (
    'query_type' => 'default',
    'db_field' => 
    array (
      0 => 'created_by',
    ),
    'my_items' => true,
    'vname' => 'LBL_CURRENT_USER_FILTER',
    'type' => 'bool',
  ),
  'range_price' => 
  array (
    'query_type' => 'default',
    'enable_range_search' => true,
  ),
  'start_range_price' => 
  array (
    'query_type' => 'default',
    'enable_range_search' => true,
  ),
  'end_range_price' => 
  array (
    'query_type' => 'default',
    'enable_range_search' => true,
  ),
  'range_cost' => 
  array (
    'query_type' => 'default',
    'enable_range_search' => true,
  ),
  'start_range_cost' => 
  array (
    'query_type' => 'default',
    'enable_range_search' => true,
  ),
  'end_range_cost' => 
  array (
    'query_type' => 'default',
    'enable_range_search' => true,
  ),
  'range_date_entered' => 
  array (
    'query_type' => 'default',
    'enable_range_search' => true,
    'is_date_field' => true,
  ),
  'start_range_date_entered' => 
  array (
    'query_type' => 'default',
    'enable_range_search' => true,
    'is_date_field' => true,
  ),
  'end_range_date_entered' => 
  array (
    'query_type' => 'default',
    'enable_range_search' => true,
    'is_date_field' => true,
  ),
  'range_date_modified' => 
  array (
    'query_type' => 'default',
    'enable_range_search' => true,
    'is_date_field' => true,
  ),
  'start_range_date_modified' => 
  array (
    'query_type' => 'default',
    'enable_range_search' => true,
    'is_date_field' => true,
  ),
  'end_range_date_modified' => 
  array (
    'query_type' => 'default',
    'enable_range_search' => true,
    'is_date_field' => true,
  ),
    'favorites_only' => array(
        'query_type'=>'format',
        'operator' => 'subquery',
        'subquery' => 'SELECT favorites.parent_id FROM favorites
			                    WHERE favorites.deleted = 0
			                        and favorites.parent_type = "'.$module_name.'"
			                        and favorites.assigned_user_id = "' .$current_user->id . '") OR NOT ({0}',
        'db_field'=>array('id')),
);