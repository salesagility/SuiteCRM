<?php
global $app_strings;
if($app_strings === NULL)
{
        $app_strings = return_application_language($current_language);
}

$installation_scenarios = array(
    0 =>
        array(
            'key' => 'Sales',
            'title' => 'Sales',
            'description' => $app_strings['LBL_SCENARIO_SALES_DESCRIPTION'],
            'groupedTabs'=> 'LBL_TABGROUP_SALES',
            'modules' =>
                array(
                    0 => 'Opportunities',
                    1 => 'Leads'
                ),
            'modulesScenarioDisplayName' =>
                array(
                    0 => 'Opportunities',
                    1 => 'Leads'
                ),
            'dashlets'=>
                array(
                    0 => 'MyOpportunitiesDashlet',
                    1 => 'MyLeadsDashlet'
                )
        ),
    1 =>
        array(
            'key' => 'Marketing',
            'title' => 'Marketing',
            'description' => $app_strings['LBL_SCENARIO_MAKETING_DESCRIPTION'],
            'groupedTabs'=> 'LBL_TABGROUP_MARKETING',
            'modules' =>
                array(
                    0 => 'Prospects',         //Not enabled by default
                    1 => 'ProspectLists',    //Not enabled by default
                    2 => 'Campaigns',
                    3 => 'FP_events',
                    4 => 'FP_Event_Locations'
                ),
            'modulesScenarioDisplayName' =>
                array(
                    0 => 'Targets',
                    1 => 'Target Lists',
                    2 => 'Campaigns',
                    3 => 'Events',
                    4 => 'Event Locations'
                ),
            'dashlets'=>array()
        ),
    2 =>
        array(
            'key' => 'Finance',
            'title' => 'Finance',
            'description' => $app_strings['LBL_SCENARIO_FINANCE_DESCRIPTION'],
            'groupedTabs'=> '',
            'modules' =>
                array(
                    0 => 'AOS_Products',
                    1 => 'AOS_Product_Categories',
                    2 => 'AOS_Quotes',
                    3 => 'AOS_Invoices',
                    4 => 'AOS_Contracts'
                ),
            'modulesScenarioDisplayName' =>
                array(
                    0 => 'Products',
                    1 => 'Product_Categories',
                    2 => 'Quotes',
                    3 => 'Invoices',
                    4 => 'Contracts'
                ),
            'dashlets'=>array()
        ),
    3 =>
        array(
            'key' => 'ServiceManagement',
            'title' => 'Service Management',
            'description' => $app_strings['LBL_SCENARIO_SERVICE_DESCRIPTION'],
            'groupedTabs'=> 'LBL_TABGROUP_SUPPORT',
            'modules' =>
                array(
                    0 => 'Cases',
                    1 => 'AOK_KnowledgeBase',
                    2 => 'AOK_Knowledge_Base_Categories'    //Is this the same as Knowledge Base Articles
                ),
            'modulesScenarioDisplayName' =>
                array(
                    0 => 'Cases',
                    1 => 'Knowledge Base',
                    2 => 'Knowledge Base Categories'
                ),
            'dashlets'=>array()
        ),
    4 =>
        array(
            'key' => 'ProjectManagement',
            'title' => 'Project Management',
            'description' => $app_strings['LBL_SCENARIO_PROJECT_DESCRIPTION'],
            'groupedTabs'=> '',
            'modules' =>
                array(
                    0 => 'AM_TaskTemplates',    //Project Task Templates'
                    1 => 'Project Tasks',
                    2 => 'AM_ProjectTemplates',
                    3 => 'Project'
                ),
            'modulesScenarioDisplayName' =>
                array(
                    0 => 'Project Task Templates',    //Project Task Templates'
                    1 => 'Project Tasks',
                    2 => 'Project Templates',
                    3 => 'Project'
                ),
            'dashlets'=>array()
        )
);