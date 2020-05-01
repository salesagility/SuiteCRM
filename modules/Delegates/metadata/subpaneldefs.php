<?php

$layout_defs['Delegates'] = [
    // default subpanel provided by this SugarBean
    'default_subpanel_define' => [
        'subpanel_title' => 'LBL_DEFAULT_SUBPANEL_TITLE',
        'top_buttons' => [
            //array('widget_class' => 'SubPanelTopCreateNoteButton'),
            ['widget_class' => 'SubPanelTopArchiveEmailButton'],
            ['widget_class' => 'SubPanelTopSummaryButton'],
        ],

        //TODO try and merge with the activities
        'list_fields' => [
            'Contacts' => [
                'columns' => [
                    'checkbox' => [
                        'vname' => '<ul id="selectLinkTop" class="clickMenu selectmenu SugarActionMenu" name="">
					                    <li class="sugar_action_button">
					                      <input class="checkallContacts" class="checkbox massall" type="checkbox" name="checkallContacts" style="float: left;margin: 2px 0 0 2px;" onclick="">
					                      <ul class="cust_list" style="background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #CCCCCC;box-shadow: 0 5px 10px #999999;float: left;left: 0;list-style: none outside none;margin: 0;overflow: hidden;padding: 8px 0;position: absolute;top: 18px;width: auto;z-index: 10;display: none;">
					                        <li style="clear: both;margin: 0;padding: 0;white-space: nowrap;width: 100%;"><a class="button_select_this_page_top" style="border: 0 none !important;float: left;font-size: 12px !important;padding: 1px 10px !important;text-align: left;width: 100%;line-height: 18px;display: block;" href="#">Select This Page</a></li>
					                        <li style="clear: both;margin: 0;padding: 0;white-space: nowrap;width: 100%;"><a class="button_select_all_top" style="border: 0 none !important;float: left;font-size: 12px !important;padding: 1px 10px !important;text-align: left;width: 100%;line-height: 18px;display: block;" href="#" name="selectall">Select All‎</a></li>
					                        <li style="clear: both;margin: 0;padding: 0;white-space: nowrap;width: 100%;"><a class="button_deselect_top" style="border: 0 none !important;float: left;font-size: 12px !important;padding: 1px 10px !important;text-align: left;width: 100%;line-height: 18px;display: block;" href="#" name="deselect">Deselect All</a></li>
					                      </ul>
					                      <span class="cust_select subhover"><span class="suitepicon suitepicon-action-caret"></span></span>
					                    </li>
					                    </ul>',
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
                        'vname' => 'LBL_STATUS_EVENT',
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
                ],
                // 'where' => "(meetings.status='Held' OR meetings.status='Not Held')",
                'order_by' => 'date_entered.date_modified',
            ],
            'Leads' => [
                'columns' => [
                    [
                        'name' => 'nothing',
                        'widget_class' => 'SubPanelIcon',
                        'module' => 'Emails',
                        'width' => '2%',
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
                ],
                // 'where' => "(emails.status='sent')",
                'order_by' => 'leads.date_modified',
            ],
            'Prospects' => [
                'columns' => [
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
                ],
                // 'where' => "(emails.status='sent')",
                'order_by' => 'Prospects.date_modified',
            ],
        ],
    ],
];
