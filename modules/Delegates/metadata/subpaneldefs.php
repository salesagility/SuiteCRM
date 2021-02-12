<?php

$layout_defs['Delegates'] = array(
    // default subpanel provided by this SugarBean
    'default_subpanel_define' => array(
        'subpanel_title' => 'LBL_DEFAULT_SUBPANEL_TITLE',
        'top_buttons' => array(
            //array('widget_class' => 'SubPanelTopCreateNoteButton'),
            array('widget_class' => 'SubPanelTopArchiveEmailButton'),
            array('widget_class' => 'SubPanelTopSummaryButton'),
        ),
        
//TODO try and merge with the activities
        'list_fields' => array(
            'Contacts' => array(
                'columns' => array(
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
                        'vname' => 'LBL_STATUS_EVENT',
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
                ),
                /*'where' => "(meetings.status='Held' OR meetings.status='Not Held')", */
                'order_by' => 'date_entered.date_modified',
            ),
            'Leads' => array(
                'columns' => array(
                    array(
                        'name' => 'nothing',
                        'widget_class' => 'SubPanelIcon',
                        'module' => 'Emails',
                        'width' => '2%',
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
                ),
                /*'where' => "(emails.status='sent')", */
                'order_by' => 'leads.date_modified',
            ),
            'Prospects' => array(
                'columns' => array(
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
                ),
                /*'where' => "(emails.status='sent')", */
                'order_by' => 'Prospects.date_modified',
            ),
        ),
    ),
);
