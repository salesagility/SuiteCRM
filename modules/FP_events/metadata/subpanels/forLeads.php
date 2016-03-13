<?php
// created: 2016-02-04 07:25:09
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
		'e_leads_invite_status_fields'=>array(
			'usage' => 'query_only',
		),
		'event_lead_invite_id'=>array(
			'usage' => 'query_only',
		),
		'event_lead_status_name'=>array(
			'name'=>'event_status_name',
			'vname' => 'LBL_LIST_INVITE_STATUS_EVENT',
			'width' => '10%',
			'sortable'=>false,
		),
		'event_lead_accept_status'=>array(
			'name'=>'event_lead_accept_status',
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