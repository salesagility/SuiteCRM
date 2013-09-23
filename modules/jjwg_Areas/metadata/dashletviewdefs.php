<?php
$dashletData['jjwg_AreasDashlet']['searchFields'] = array (
  'name' => 
  array (
    'default' => '',
  ),
  'city' => 
  array (
    'default' => '',
  ),
  'state' => 
  array (
    'default' => '',
  ),
  'country' => 
  array (
    'default' => '',
  ),
  'assigned_user_name' => 
  array (
    'default' => '',
  ),
  'date_entered' => 
  array (
    'default' => '',
  ),
);
$dashletData['jjwg_AreasDashlet']['columns'] = array (
  'name' => 
  array (
    'width' => '40%',
    'label' => 'LBL_LIST_NAME',
    'link' => true,
    'default' => true,
    'name' => 'name',
  ),
  'city' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_CITY',
    'width' => '10%',
    'default' => true,
    'name' => 'city',
  ),
  'state' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_STATE',
    'width' => '10%',
    'default' => true,
    'name' => 'state',
  ),
  'country' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_COUNTRY',
    'width' => '10%',
    'default' => true,
    'name' => 'country',
  ),
  'assigned_user_name' => 
  array (
    'width' => '8%',
    'label' => 'LBL_LIST_ASSIGNED_USER',
    'name' => 'assigned_user_name',
    'default' => true,
  ),
  'modified_by_name' => 
  array (
    'type' => 'relate',
    'link' => 'modified_user_link',
    'label' => 'LBL_MODIFIED_NAME',
    'width' => '10%',
    'default' => false,
    'name' => 'modified_by_name',
  ),
  'created_by_name' => 
  array (
    'type' => 'relate',
    'link' => 'created_by_link',
    'label' => 'LBL_CREATED',
    'width' => '10%',
    'default' => false,
    'name' => 'created_by_name',
  ),
  'coordinates' => 
  array (
    'type' => 'text',
    'studio' => 'visible',
    'label' => 'LBL_COORDINATES',
    'sortable' => false,
    'width' => '10%',
    'default' => false,
    'name' => 'coordinates',
  ),
  'description' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '10%',
    'default' => false,
    'name' => 'description',
  ),
  'date_entered' => 
  array (
    'width' => '15%',
    'label' => 'LBL_DATE_ENTERED',
    'default' => false,
    'name' => 'date_entered',
  ),
  'date_modified' => 
  array (
    'width' => '15%',
    'label' => 'LBL_DATE_MODIFIED',
    'name' => 'date_modified',
    'default' => false,
  ),
  'created_by' => 
  array (
    'width' => '8%',
    'label' => 'LBL_CREATED',
    'name' => 'created_by',
    'default' => false,
  ),
);
