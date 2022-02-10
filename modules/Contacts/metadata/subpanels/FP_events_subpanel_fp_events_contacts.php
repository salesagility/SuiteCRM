<?php
// created: 2013-04-25 14:25:35
global $app_strings;
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
    'module' => 'Contacts',
    'width' => '23%',
    'default' => true,
  ),
  'account_name' =>
  array(
    'name' => 'account_name',
    'module' => 'Accounts',
    'target_record_key' => 'account_id',
    'target_module' => 'Accounts',
    'widget_class' => 'SubPanelDetailViewLink',
    'vname' => 'LBL_LIST_ACCOUNT_NAME',
    'width' => '22%',
    'sortable' => false,
    'default' => true,
  ),
  'phone_work' =>
  array(
    'name' => 'phone_work',
    'vname' => 'LBL_LIST_PHONE',
    'width' => '15%',
    'default' => true,
  ),
  'email1' =>
  array(
    'name' => 'email1',
    'vname' => 'LBL_LIST_EMAIL',
    'widget_class' => 'SubPanelEmailLink',
    'width' => '20%',
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
    'name' => 'first_name',
    'usage' => 'query_only',
  ),
  'last_name' =>
  array(
    'name' => 'last_name',
    'usage' => 'query_only',
  ),
  'salutation' =>
  array(
    'name' => 'salutation',
    'usage' => 'query_only',
  ),
  'account_id' =>
  array(
    'usage' => 'query_only',
  ),
);
