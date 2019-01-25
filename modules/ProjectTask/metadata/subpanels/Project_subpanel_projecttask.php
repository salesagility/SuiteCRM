<?php
// created: 2014-06-24 19:37:50
$subpanel_layout['list_fields'] = array(
  'name' =>
  array(
    'vname' => 'LBL_LIST_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => '20%',
    'default' => true,
  ),
  'project_name' =>
  array(
    'type' => 'relate',
    'link' => true,
    'vname' => 'LBL_PARENT_NAME',
    'id' => 'PROJECT_ID',
    'width' => '25%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Project',
    'target_record_key' => 'project_id',
  ),
  'date_start' =>
  array(
    'vname' => 'LBL_DATE_START',
    'width' => '10%',
    'default' => true,
  ),
  'date_finish' =>
  array(
    'vname' => 'LBL_DATE_FINISH',
    'width' => '10%',
    'default' => true,
  ),
  'order_number' =>
  array(
    'type' => 'int',
    'default' => true,
    'vname' => 'LBL_ORDER_NUMBER',
    'width' => '10%',
  ),
  'assigned_user_name' =>
  array(
    'type' => 'relate',
    'link' => true,
    'vname' => 'LBL_ASSIGNED_USER_NAME',
    'id' => 'ASSIGNED_USER_ID',
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Users',
    'target_record_key' => 'assigned_user_id',
  ),
  'priority' =>
  array(
    'type' => 'enum',
    'vname' => 'LBL_PRIORITY',
    'width' => '10%',
    'default' => true,
  ),
  'percent_complete' =>
  array(
    'type' => 'int',
    'vname' => 'LBL_PERCENT_COMPLETE',
    'width' => '10%',
    'default' => true,
  ),
);
