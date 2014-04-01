<?php
// created: 2014-03-07 11:55:13
$searchFields['Cases'] = array (
  'name' => 
  array (
    'query_type' => 'default',
  ),
  'account_name' => 
  array (
    'query_type' => 'default',
    'db_field' => 
    array (
      0 => 'accounts.name',
    ),
  ),
  'status' => 
  array (
    'query_type' => 'default',
    'options' => 'case_status_dom',
    'template_var' => 'STATUS_OPTIONS',
  ),
  'priority' => 
  array (
    'query_type' => 'default',
    'options' => 'case_priority_dom',
    'template_var' => 'PRIORITY_OPTIONS',
    'options_add_blank' => true,
  ),
  'case_number' => 
  array (
    'query_type' => 'default',
    'operator' => 'in',
  ),
  'current_user_only' => 
  array (
    'query_type' => 'default',
    'db_field' => 
    array (
      0 => 'assigned_user_id',
    ),
    'my_items' => true,
    'vname' => 'LBL_CURRENT_USER_FILTER',
    'type' => 'bool',
  ),
  'assigned_user_id' => 
  array (
    'query_type' => 'default',
  ),
  'open_only' => 
  array (
    'query_type' => 'default',
    'db_field' => 
    array (
      0 => 'status',
    ),
    'operator' => 'not in',
    'closed_values' => 
    array (
      0 => 'Closed',
      1 => 'Rejected',
      2 => 'Duplicate',
      3 => 'Closed_Closed',
      4 => 'Closed_Rejected',
      5 => 'Closed_Duplicate',
    ),
    'type' => 'bool',
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
  'state' => 
  array (
    'query_type' => 'default',
  ),
);