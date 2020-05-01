<?php

global $app_strings;
if ($app_strings === null) {
    $app_strings = return_application_language($current_language);
}

$installation_scenarios = [
    0 => [
        'key' => 'Sales',
        'title' => $app_strings['LBL_SCENARIO_SALES'],
        'description' => $app_strings['LBL_SCENARIO_SALES_DESCRIPTION'],
        'groupedTabs' => 'LBL_TABGROUP_SALES',
        'modules' => [
            0 => 'Opportunities',
            1 => 'Leads'
        ],
        'modulesScenarioDisplayName' => [
            0 => $app_strings['LBL_OPPORTUNITIES'],
            1 => $app_strings['LBL_LEADS']
        ],
        'dashlets' => [
            0 => 'MyOpportunitiesDashlet',
            1 => 'MyLeadsDashlet'
        ]
    ],
    1 => [
        'key' => 'Marketing',
        'title' => $app_strings['LBL_SCENARIO_MARKETING'],
        'description' => $app_strings['LBL_SCENARIO_MAKETING_DESCRIPTION'],
        'groupedTabs' => 'LBL_TABGROUP_MARKETING',
        'modules' => [
            0 => 'Prospects',         //Not enabled by default
            1 => 'ProspectLists',    //Not enabled by default
            2 => 'Campaigns',
            3 => 'FP_events',
            4 => 'FP_Event_Locations'
        ],
        'modulesScenarioDisplayName' => [
            0 => 'Targets',
            1 => 'Target Lists',
            2 => 'Campaigns',
            3 => 'Events',
            4 => 'Event Locations'
        ],
        'dashlets' => []
    ],
    2 => [
        'key' => 'Finance',
        'title' => $app_strings['LBL_SCENARIO_FINANCE'],
        'description' => $app_strings['LBL_SCENARIO_FINANCE_DESCRIPTION'],
        'groupedTabs' => '',
        'modules' => [
            0 => 'AOS_Products',
            1 => 'AOS_Product_Categories',
            2 => 'AOS_Quotes',
            3 => 'AOS_Invoices',
            4 => 'AOS_Contracts'
        ],
        'modulesScenarioDisplayName' => [
            0 => 'Products',
            1 => 'Product_Categories',
            2 => 'Quotes',
            3 => 'Invoices',
            4 => 'Contracts'
        ],
        'dashlets' => []
    ],
    3 => [
        'key' => 'ServiceManagement',
        'title' => $app_strings['LBL_SCENARIO_SERVICE'],
        'description' => $app_strings['LBL_SCENARIO_SERVICE_DESCRIPTION'],
        'groupedTabs' => 'LBL_TABGROUP_SUPPORT',
        'modules' => [
            0 => 'Cases',
            1 => 'AOK_KnowledgeBase',
            2 => 'AOK_Knowledge_Base_Categories'    //Is this the same as Knowledge Base Articles
        ],
        'modulesScenarioDisplayName' => [
            0 => 'Cases',
            1 => 'Knowledge Base',
            2 => 'Knowledge Base Categories'
        ],
        'dashlets' => []
    ],
    4 => [
        'key' => 'ProjectManagement',
        'title' => $app_strings['LBL_SCENARIO_PROJECT'],
        'description' => $app_strings['LBL_SCENARIO_PROJECT_DESCRIPTION'],
        'groupedTabs' => '',
        'modules' => [
            0 => 'AM_TaskTemplates',    //Project Task Templates'
            1 => 'Project Tasks',
            2 => 'AM_ProjectTemplates',
            3 => 'Project'
        ],
        'modulesScenarioDisplayName' => [
            0 => 'Project Task Templates',    //Project Task Templates'
            1 => 'Project Tasks',
            2 => 'Project Templates',
            3 => 'Project'
        ],
        'dashlets' => []
    ]
];
