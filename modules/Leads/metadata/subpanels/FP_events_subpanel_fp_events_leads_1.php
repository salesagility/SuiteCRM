<?php
// created: 2013-04-29 16:01:12
$subpanel_layout['list_fields'] = array(
  'checkbox' =>
  array(
      'vname' =>  'LBL_Blank',
    'widget_type' => 'checkbox',
    'widget_class' => 'SubPanelCheck',
    'checkbox_value' => true,
    'width' => '5%',
    'sortable' => false,
    'default' => true,
  ),
  'name' =>
  array(
    'vname' => 'LBL_LIST_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'sort_order' => 'asc',
    'sort_by' => 'last_name',
    'module' => 'Leads',
    'width' => '20%',
    'default' => true,
  ),
  'account_name' =>
  array(
    'name' => 'account_name',
    'module' => 'Accounts',
    'target_record_key' => 'account_id',
    'target_module' => 'Accounts',
    'widget_class' => 'SubPanelDetailViewLink',
    'vname' => 'LBL_ACCOUNT_NAME',
    'width' => '22%',
    'sortable' => false,
    'default' => true,
  ),
  'phone_work' =>
  array(
    'vname' => 'LBL_LIST_PHONE',
    'width' => '10%',
    'default' => true,
  ),
  'email1' =>
  array(
    'vname' => 'LBL_LIST_EMAIL_ADDRESS',
    'width' => '10%',
    'widget_class' => 'SubPanelEmailLink',
    'sortable' => false,
    'default' => true,
  ),
  'event_status_name' =>
  array(
    'vname' => 'LBL_STATUS',
    'width' => '10%',
    'sortable' => false,
    'default' => true,
  ),
  'event_accept_status' =>
  array(
    'width' => '10%',
    'sortable' => false,
    'default' => true,
    'vname' => 'LBL_ACCEPT_STATUS',
  ),
  'edit_button' =>
  array(
    'vname' => 'LBL_EDIT_BUTTON',
    'widget_class' => 'SubPanelEditButton',
    'module' => 'Leads',
    'width' => '4%',
    'default' => true,
  ),
  'remove_button' =>
  array(
    'vname' => 'LBL_REMOVE',
    'widget_class' => 'SubPanelRemoveButton',
    'module' => 'Leads',
    'width' => '4%',
    'default' => true,
  ),
  'e_accept_status_fields' =>
  array(
    'usage' => 'query_only',
  ),
  'event_status_id' =>
  array(
    'usage' => 'query_only',
  ),
  'e_invite_status_fields' =>
  array(
    'usage' => 'query_only',
  ),
  'event_invite_id' =>
  array(
    'usage' => 'query_only',
  ),
  'first_name' =>
  array(
    'usage' => 'query_only',
  ),
  'last_name' =>
  array(
    'usage' => 'query_only',
  ),
  'salutation' =>
  array(
    'name' => 'salutation',
    'usage' => 'query_only',
  ),
);
