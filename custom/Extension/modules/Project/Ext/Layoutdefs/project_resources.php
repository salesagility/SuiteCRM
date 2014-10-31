<?php

global $modules_exempt_from_availability_check;
$modules_exempt_from_availability_check = array('Holidays'=>'Holidays',
    'AM_ProjectHolidays' => 'AM_ProjectHolidays',
    'Users'=>'Users',
);


// created: 2014-06-24 15:48:56
$layout_defs["Project"]["subpanel_setup"]['project_resources'] = array (
    'order' => 100,
    'module' => 'Project',
    'subpanel_name' => 'Project',
    'type' => 'collection',
    'sort_order' => 'asc',
    'sort_by' => 'id',
    'title_key' => 'LBL_PROJECT_USERS_1_FROM_USERS_TITLE',
    // 'get_subpanel_data' => 'project_contacts_1',
    'top_buttons' =>
        array (
            0 =>
                array (
                    'widget_class' => 'SubPanelTopSelectUsersButton', 'mode'=>'MultiSelect',
                ),
            1 =>
                array (
                    'widget_class' => 'SubPanelTopSelectContactsButton', 'mode'=>'MultiSelect',
                ),
        ),
    'collection_list' => array(
        'users' => array(
            'module' => 'Users',
            'subpanel_name' => 'ForProject',
            'get_subpanel_data' => 'project_users_1',
        ),
        'contacts' => array(
            'module' => 'Contacts',
            'subpanel_name' => 'ForProject',
            'get_subpanel_data' => 'project_contacts_1',
        ),
    )
);