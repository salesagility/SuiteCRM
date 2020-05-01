<?php

// created: 2013-04-25 14:25:35
global $app_strings;
$subpanel_layout['list_fields'] = [
    'checkbox' => [
        'vname' => "<ul id='selectLinkTop' class='clickMenu selectmenu SugarActionMenu' name=''>
                    <li class='sugar_action_button'>
                      <input class='checkallContacts' class='checkbox massall' type='checkbox' name='checkallContacts' style='float: left;margin: 2px 0 0 2px;' onclick=''>
                      <ul class='cust_list' style='background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #CCCCCC;box-shadow: 0 5px 10px #999999;float: left;left: 0;list-style: none outside none;margin: 0;overflow: hidden;padding: 8px 0;position: absolute;top: 18px;width: auto;z-index: 10;display: none;'>
                        <li style='clear: both;margin: 0;padding: 0;white-space: nowrap;width: 100%;'><a class='button_select_this_page_top' style='border: 0 none !important;float: left;font-size: 12px !important;padding: 1px 10px !important;text-align: left;width: 100%;line-height: 18px;display: block;' href='#'>{$app_strings['LBL_LISTVIEW_OPTION_CURRENT']}</a></li>
                        <li style='clear: both;margin: 0;padding: 0;white-space: nowrap;width: 100%;'><a class='button_select_all_top' style='border: 0 none !important;float: left;font-size: 12px !important;padding: 1px 10px !important;text-align: left;width: 100%;line-height: 18px;display: block;' href='#' name='selectall'>{$app_strings['LBL_LISTVIEW_OPTION_ENTIRE']}</a></li>
                        <li style='clear: both;margin: 0;padding: 0;white-space: nowrap;width: 100%;'><a class='button_deselect_top' style='border: 0 none !important;float: left;font-size: 12px !important;padding: 1px 10px !important;text-align: left;width: 100%;line-height: 18px;display: block;' href='#' name='deselect'>{$app_strings['LBL_LISTVIEW_NONE']}</a></li>
                      </ul>
                      <span class='cust_select' class='subhover dropDownHandle.addClass(\"subhover\");'><span class=\"suitepicon suitepicon-action-caret\"></span></span>
                    </li>
                    </ul>",
        'widget_type' => 'checkbox',
        'widget_class' => 'SubPanelCheck',
        'checkbox_value' => true,
        'width' => '5%',
        'sortable' => false,
        'default' => true,
    ],
    'name' => [
        'name' => 'name',
        'vname' => 'LBL_LIST_NAME',
        'sort_by' => 'last_name',
        'sort_order' => 'asc',
        'widget_class' => 'SubPanelDetailViewLink',
        'module' => 'Contacts',
        'width' => '23%',
        'default' => true,
    ],
    'account_name' => [
        'name' => 'account_name',
        'module' => 'Accounts',
        'target_record_key' => 'account_id',
        'target_module' => 'Accounts',
        'widget_class' => 'SubPanelDetailViewLink',
        'vname' => 'LBL_LIST_ACCOUNT_NAME',
        'width' => '22%',
        'sortable' => false,
        'default' => true,
    ],
    'phone_work' => [
        'name' => 'phone_work',
        'vname' => 'LBL_LIST_PHONE',
        'width' => '15%',
        'default' => true,
    ],
    'email1' => [
        'name' => 'email1',
        'vname' => 'LBL_LIST_EMAIL',
        'widget_class' => 'SubPanelEmailLink',
        'width' => '20%',
        'sortable' => false,
        'default' => true,
    ],
    'event_status_name' => [
        'vname' => 'LBL_STATUS',
        'width' => '10%',
        'sortable' => false,
        'default' => true,
    ],
    'event_accept_status' => [
        'width' => '10%',
        'sortable' => false,
        'default' => true,
        'vname' => 'LBL_ACCEPT_STATUS',
    ],
    'edit_button' => [
        'vname' => 'LBL_EDIT_BUTTON',
        'widget_class' => 'SubPanelEditButton',
        'module' => 'Contacts',
        'width' => '5%',
        'default' => true,
    ],
    'remove_button' => [
        'vname' => 'LBL_REMOVE',
        'widget_class' => 'SubPanelRemoveButton',
        'module' => 'Contacts',
        'width' => '5%',
        'default' => true,
    ],
    'e_accept_status_fields' => [
        'usage' => 'query_only',
    ],
    'event_status_id' => [
        'usage' => 'query_only',
    ],
    'e_invite_status_fields' => [
        'usage' => 'query_only',
    ],
    'event_invite_id' => [
        'usage' => 'query_only',
    ],
    'first_name' => [
        'name' => 'first_name',
        'usage' => 'query_only',
    ],
    'last_name' => [
        'name' => 'last_name',
        'usage' => 'query_only',
    ],
    'salutation' => [
        'name' => 'salutation',
        'usage' => 'query_only',
    ],
    'account_id' => [
        'usage' => 'query_only',
    ],
];
