<?php
$installation_scenarios = array(
    0 =>
        array(
            'key' => 'Sales',
            'title' => 'Sales',
            'description' => 'The sales scenario allows for ...',
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
            'description' => 'The marketing scenario allows for ...',
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
            'description' => 'The finance scenario allows for ...',
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
            'description' => 'The service management scenario allows for ...',
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
            'description' => 'The project management scenario allows for ...',
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