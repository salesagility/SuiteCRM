<?php
$dashletData['AM_ProjectTemplatesDashlet']['searchFields'] = array(
  'name' =>
  array(
    'default' => '',
  ),
  'assigned_user_name' =>
  array(
    'default' => '',
  ),
  'status' =>
  array(
    'default' => '',
  ),
  'priority' =>
  array(
    'default' => '',
  ),
  'date_entered' =>
  array(
    'default' => '',
  ),
  'date_modified' =>
  array(
    'default' => '',
  ),
  'assigned_user_id' =>
  array(
    'default' => '',
  ),
);
$dashletData['AM_ProjectTemplatesDashlet']['columns'] = array(
  'name' =>
  array(
    'width' => '40%',
    'label' => 'LBL_LIST_NAME',
    'link' => true,
    'default' => true,
    'name' => 'name',
  ),
  'status' =>
  array(
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_STATUS',
    'width' => '10%',
    'name' => 'status',
  ),
  'priority' =>
  array(
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_PRIORITY',
    'width' => '10%',
    'name' => 'priority',
  ),
  'date_entered' =>
  array(
    'width' => '15%',
    'label' => 'LBL_DATE_ENTERED',
    'default' => true,
    'name' => 'date_entered',
  ),
  'date_modified' =>
  array(
    'width' => '15%',
    'label' => 'LBL_DATE_MODIFIED',
    'name' => 'date_modified',
    'default' => false,
  ),
  'assigned_user_name' =>
  array(
    'width' => '8%',
    'label' => 'LBL_LIST_ASSIGNED_USER',
    'name' => 'assigned_user_name',
    'default' => false,
  ),
  'created_by' =>
  array(
    'width' => '8%',
    'label' => 'LBL_CREATED',
    'name' => 'created_by',
    'default' => false,
  ),
);
