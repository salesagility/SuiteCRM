<?php
// created: 2016-02-04 07:26:21
$module_name='FP_events';
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'vname' => 'LBL_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => '45%',
    'default' => true,
  ),
  'date_start' => 
  array (
    'type' => 'date',
    'vname' => 'LBL_DATE',
    'width' => '10%',
    'default' => true,
  ),
		'e_prospects_invite_status_fields'=>array(
			'usage' => 'query_only',
		),
		'event_prospect_invite_id'=>array(
			'usage' => 'query_only',
		),
		'event_prospect_status_name'=>array(
			'name'=>'event_prospect_status_name',
			'vname' => 'LBL_LIST_INVITE_STATUS_EVENT',
			'width' => '10%',
			'sortable'=>false,
		),
		'event_prospect_accept_status'=>array(
			'name'=>'event_prospect_accept_status',
			'vname' => 'LBL_LIST_ACCEPT_STATUS_EVENT',
			'width' => '10%',
			'sortable'=>false,
		),
  'edit_button' => 
  array (
    'vname' => 'LBL_EDIT_BUTTON',
    'widget_class' => 'SubPanelEditButton',
    'module' => 'FP_events',
    'width' => '4%',
    'default' => true,
  ),
  'remove_button' => 
  array (
    'vname' => 'LBL_REMOVE',
    'widget_class' => 'SubPanelRemoveButton',
    'module' => 'FP_events',
    'width' => '5%',
    'default' => true,
  ),
);