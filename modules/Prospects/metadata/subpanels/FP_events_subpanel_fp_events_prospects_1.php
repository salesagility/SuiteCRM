<?php
// created: 2013-04-29 15:58:53
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
    'name' => 'name',
    'vname' => 'LBL_LIST_NAME',
    'sort_by' => 'last_name',
    'sort_order' => 'asc',
    'widget_class' => 'SubPanelDetailViewLink',
    'module' => 'Prospects',
    'width' => '23%',
    'default' => true,
  ),
  'account_name' =>
  array(
    'type' => 'varchar',
    'vname' => 'LBL_ACCOUNT_NAME',
    'width' => '10%',
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
    'width' => '15%',
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
    'module' => 'Contacts',
    'width' => '5%',
    'default' => true,
  ),
  'remove_button' =>
  array(
    'vname' => 'LBL_REMOVE',
    'widget_class' => 'SubPanelRemoveButton',
    'module' => 'Contacts',
    'width' => '5%',
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
);
