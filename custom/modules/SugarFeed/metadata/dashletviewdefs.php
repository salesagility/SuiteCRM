<?php
$dashletData['SugarFeedDashlet']['searchFields'] = array (
  'date_entered' => 
  array (
    'default' => '',
  ),
  'date_modified' => 
  array (
    'default' => '',
  ),
  'assigned_user_id' => 
  array (
    'type' => 'assigned_user_name',
    'default' => 'Administrator',
  ),
);
$dashletData['SugarFeedDashlet']['columns'] = array (
  'created_by_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_CREATED',
    'id' => 'CREATED_BY',
    'width' => '10%',
    'default' => true,
  ),
  'name' => 
  array (
    'width' => '40%',
    'label' => '',
    'link' => false,
    'sortable' => false,
    'default' => true,
    'name' => 'name',
  ),
);
