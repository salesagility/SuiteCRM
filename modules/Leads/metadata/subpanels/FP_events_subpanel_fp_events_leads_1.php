<?php
// created: 2013-04-29 16:01:12
$subpanel_layout['list_fields'] = array (
  'checkbox' => 
  array (
    'vname' => '<ul id="selectLinkTop" class="clickMenu selectmenu SugarActionMenu" name="">
                    <li class="sugar_action_button">
                      <input class="checkallContacts" class="checkbox massall" type="checkbox" name="checkallContacts" style="float: left;margin: 2px 0 0 2px;" onclick="">
                      <ul class="cust_list" style="background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #CCCCCC;box-shadow: 0 5px 10px #999999;float: left;left: 0;list-style: none outside none;margin: 0;overflow: hidden;padding: 8px 0;position: absolute;top: 18px;width: auto;z-index: 10;display: none;">
                        <li style="clear: both;margin: 0;padding: 0;white-space: nowrap;width: 100%;"><a class="button_select_this_page_top" style="border: 0 none !important;float: left;font-size: 12px !important;padding: 1px 10px !important;text-align: left;width: 100%;line-height: 18px;display: block;" href="#">{$APP.LBL_LISTVIEW_OPTION_CURRENT}</a></li>
                        <li style="clear: both;margin: 0;padding: 0;white-space: nowrap;width: 100%;"><a class="button_select_all_top" style="border: 0 none !important;float: left;font-size: 12px !important;padding: 1px 10px !important;text-align: left;width: 100%;line-height: 18px;display: block;" href="#" name="selectall">{$APP.LBL_LISTVIEW_OPTION_ENTIRE}‎</a></li>
                        <li style="clear: both;margin: 0;padding: 0;white-space: nowrap;width: 100%;"><a class="button_deselect_top" style="border: 0 none !important;float: left;font-size: 12px !important;padding: 1px 10px !important;text-align: left;width: 100%;line-height: 18px;display: block;" href="#" name="deselect">{$APP.LBL_LISTVIEW_NONE}</a></li>
                      </ul>
                      <span class="cust_select" class="subhover"> </span>
                    </li>
                    </ul>',
    'widget_type' => 'checkbox',
    'widget_class' => 'SubPanelCheck',
    'checkbox_value' => true,
    'width' => '5%',
    'sortable' => false,
    'default' => true,
  ),
  'name' => 
  array (
    'vname' => 'LBL_LIST_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'sort_order' => 'asc',
    'sort_by' => 'last_name',
    'module' => 'Leads',
    'width' => '20%',
    'default' => true,
  ),
  'account_name' => 
  array (
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
  array (
    'vname' => 'LBL_LIST_PHONE',
    'width' => '10%',
    'default' => true,
  ),
  'email1' => 
  array (
    'vname' => 'LBL_LIST_EMAIL_ADDRESS',
    'width' => '10%',
    'widget_class' => 'SubPanelEmailLink',
    'sortable' => false,
    'default' => true,
  ),
  'event_status_name' => 
  array (
    'vname' => 'LBL_STATUS',
    'width' => '10%',
    'sortable' => false,
    'default' => true,
  ),
  'event_accept_status' => 
  array (
    'width' => '10%',
    'sortable' => false,
    'default' => true,
    'vname' => 'LBL_ACCEPT_STATUS',
  ),
  'edit_button' => 
  array (
    'vname' => 'LBL_EDIT_BUTTON',
    'widget_class' => 'SubPanelEditButton',
    'module' => 'Leads',
    'width' => '4%',
    'default' => true,
  ),
  'remove_button' => 
  array (
    'vname' => 'LBL_REMOVE',
    'widget_class' => 'SubPanelRemoveButton',
    'module' => 'Leads',
    'width' => '4%',
    'default' => true,
  ),
  'e_accept_status_fields' => 
  array (
    'usage' => 'query_only',
  ),
  'event_status_id' => 
  array (
    'usage' => 'query_only',
  ),
  'e_invite_status_fields' => 
  array (
    'usage' => 'query_only',
  ),
  'event_invite_id' => 
  array (
    'usage' => 'query_only',
  ),
  'first_name' => 
  array (
    'usage' => 'query_only',
  ),
  'last_name' => 
  array (
    'usage' => 'query_only',
  ),
  'salutation' => 
  array (
    'name' => 'salutation',
    'usage' => 'query_only',
  ),
);
