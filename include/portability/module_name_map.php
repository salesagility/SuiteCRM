<?php
/**
 * SuiteCRM is a customer relationship management program developed by SalesAgility Ltd.
 * Copyright (C) 2021 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SALESAGILITY, SALESAGILITY DISCLAIMS THE
 * WARRANTY OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see http://www.gnu.org/licenses.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License
 * version 3, these Appropriate Legal Notices must retain the display of the
 * "Supercharged by SuiteCRM" logo. If the display of the logos is not reasonably
 * feasible for technical reasons, the Appropriate Legal Notices must display
 * the words "Supercharged by SuiteCRM".
 */

$module_name_map = [
    'Home' => [
        'frontend' => 'home',
        'core' => 'Home'
    ],
    'Administration' => [
        'frontend' => 'administration',
        'core' => 'Administration'
    ],
    'Activities' => [
        'frontend' => 'activities',
        'core' => 'Activities'
    ],
    'History' => [
        'frontend' => 'history',
        'core' => 'History'
    ],
    'Calendar' => [
        'frontend' => 'calendar',
        'core' => 'Calendar'
    ],
    'Calls' => [
        'frontend' => 'calls',
        'core' => 'Calls'
    ],
    'Calls_Reschedule' => [
        'frontend' => 'calls-reschedule',
        'core' => 'CallsReschedule'
    ],
    'Meetings' => [
        'frontend' => 'meetings',
        'core' => 'Meetings'
    ],
    'Tasks' => [
        'frontend' => 'tasks',
        'core' => 'Tasks'
    ],
    'Notes' => [
        'frontend' => 'notes',
        'core' => 'Notes'
    ],
    'Leads' => [
        'frontend' => 'leads',
        'core' => 'Leads'
    ],
    'Contacts' => [
        'frontend' => 'contacts',
        'core' => 'Contacts'
    ],
    'Accounts' => [
        'frontend' => 'accounts',
        'core' => 'Accounts'
    ],
    'Opportunities' => [
        'frontend' => 'opportunities',
        'core' => 'Opportunities'
    ],
    'Import' => [
        'frontend' => 'import',
        'core' => 'Import'
    ],
    'MergeRecords' => [
        'frontend' => 'merge-records',
        'core' => 'MergeRecords'
    ],
    'Emails' => [
        'frontend' => 'emails',
        'core' => 'Emails'
    ],
    'EmailTemplates' => [
        'frontend' => 'email-templates',
        'core' => 'EmailTemplates'
    ],
    'InboundEmail' => [
        'frontend' => 'inbound-email',
        'core' => 'InboundEmail'
    ],
    'MailMerge' => [
        'frontend' => 'mail-merge',
        'core' => 'MailMerge'
    ],
    'Campaigns' => [
        'frontend' => 'campaigns',
        'core' => 'Campaigns'
    ],
    'Targets' => [
        'frontend' => 'targets',
        'core' => 'Targets'
    ],
    'Prospects' => [
        'frontend' => 'prospects',
        'core' => 'Prospects'
    ],
    'ProspectLists' => [
        'frontend' => 'prospect-lists',
        'core' => 'ProspectLists'
    ],
    'Documents' => [
        'frontend' => 'documents',
        'core' => 'Documents'
    ],
    'Cases' => [
        'frontend' => 'cases',
        'core' => 'Cases'
    ],
    'Project' => [
        'frontend' => 'project',
        'core' => 'Project'
    ],
    'ProjectTask' => [
        'frontend' => 'project-task',
        'core' => 'ProjectTask'
    ],
    'Bugs' => [
        'frontend' => 'bugs',
        'core' => 'Bugs'
    ],
    'ResourceCalendar' => [
        'frontend' => 'resource-calendar',
        'core' => 'ResourceCalendar'
    ],
    'AOBH_BusinessHours' => [
        'frontend' => 'business-hours',
        'core' => 'BusinessHours'
    ],
    'SecurityGroups' => [
        'frontend' => 'security-groups',
        'core' => 'SecurityGroups'
    ],
    'ACL' => [
        'frontend' => 'acl',
        'core' => 'ACL'
    ],
    'ACLRoles' => [
        'frontend' => 'acl-roles',
        'core' => 'ACLRoles'
    ],
    'ACLActions' => [
        'frontend' => 'acl-actions',
        'core' => 'ACLActions'
    ],
    'Roles' => [
        'frontend' => 'roles',
        'core' => 'Roles'
    ],
    'Configurator' => [
        'frontend' => 'configurator',
        'core' => 'Configurator'
    ],
    'UserPreferences' => [
        'frontend' => 'user-preferences',
        'core' => 'UserPreferences'
    ],
    'Users' => [
        'frontend' => 'users',
        'core' => 'Users'
    ],
    'Employees' => [
        'frontend' => 'employees',
        'core' => 'Employees'
    ],
    'SavedSearch' => [
        'frontend' => 'saved-search',
        'core' => 'SavedSearch'
    ],
    'Studio' => [
        'frontend' => 'studio',
        'core' => 'Studio'
    ],
    'Connectors' => [
        'frontend' => 'connectors',
        'core' => 'Connectors'
    ],
    'SugarFeed' => [
        'frontend' => 'sugar-feed',
        'core' => 'SugarFeed'
    ],
    'EAPM' => [
        'frontend' => 'eapm',
        'core' => 'EAPM'
    ],
    'OutboundEmailAccounts' => [
        'frontend' => 'outbound-email-accounts',
        'core' => 'OutboundEmailAccounts'
    ],
    'TemplateSectionLine' => [
        'frontend' => 'template-section-line',
        'core' => 'TemplateSectionLine'
    ],
    'OAuthKeys' => [
        'frontend' => 'oauth-keys',
        'core' => 'OAuthKeys'
    ],
    'OAuthTokens' => [
        'frontend' => 'oauth-tokens',
        'core' => 'OAuthTokens'
    ],
    'OAuth2Tokens' => [
        'frontend' => 'oauth2-tokens',
        'core' => 'OAuth2Tokens'
    ],
    'OAuth2Clients' => [
        'frontend' => 'oauth2-clients',
        'core' => 'OAuth2Clients'
    ],
    'Surveys' => [
        'frontend' => 'surveys',
        'core' => 'Surveys'
    ],
    'SurveyResponses' => [
        'frontend' => 'survey-responses',
        'core' => 'SurveyResponses'
    ],
    'SurveyQuestionResponses' => [
        'frontend' => 'survey-question-responses',
        'core' => 'SurveyQuestionResponses'
    ],
    'SurveyQuestions' => [
        'frontend' => 'survey-questions',
        'core' => 'SurveyQuestions'
    ],
    'SurveyQuestionOptions' => [
        'frontend' => 'survey-question-options',
        'core' => 'SurveyQuestionOptions'
    ],
    'Reminders' => [
        'frontend' => 'reminders',
        'core' => 'Reminders'
    ],
    'Reminders_Invitees' => [
        'frontend' => 'reminders-invitees',
        'core' => 'RemindersInvitees'
    ],
    'AM_ProjectTemplates' => [
        'frontend' => 'project-templates',
        'core' => 'ProjectTemplates'
    ],
    'AM_TaskTemplates' => [
        'frontend' => 'task-templates',
        'core' => 'TaskTemplates'
    ],
    'AOK_Knowledge_Base_Categories' => [
        'frontend' => 'knowledge-base-categories',
        'core' => 'KnowledgeBaseCategories'
    ],
    'AOK_KnowledgeBase' => [
        'frontend' => 'knowledge-base',
        'core' => 'KnowledgeBase'
    ],
    'FP_events' => [
        'frontend' => 'events',
        'core' => 'Events'
    ],
    'FP_Event_Locations' => [
        'frontend' => 'event-locations',
        'core' => 'EventLocations'
    ],
    'Delegates' => [
        'frontend' => 'delegates',
        'core' => 'Delegates'
    ],
    'AOS_Contracts' => [
        'frontend' => 'contracts',
        'core' => 'Contracts'
    ],
    'AOS_Invoices' => [
        'frontend' => 'invoices',
        'core' => 'Invoices'
    ],
    'AOS_PDF_Templates' => [
        'frontend' => 'pdf-templates',
        'core' => 'PDFTemplates'
    ],
    'AOS_Product_Categories' => [
        'frontend' => 'product-categories',
        'core' => 'ProductCategories'
    ],
    'AOS_Products' => [
        'frontend' => 'products',
        'core' => 'Products'
    ],
    'AOS_Quotes' => [
        'frontend' => 'quotes',
        'core' => 'Quotes'
    ],
    'AOS_Products_Quotes' => [
        'frontend' => 'products-quotes',
        'core' => 'ProductsQuotes'
    ],
    'AOS_Line_Item_Groups' => [
        'frontend' => 'line-item-groups',
        'core' => 'LineItemGroups'
    ],
    'jjwg_Maps' => [
        'frontend' => 'maps',
        'core' => 'Maps'
    ],
    'jjwg_Markers' => [
        'frontend' => 'markers',
        'core' => 'Markers'
    ],
    'jjwg_Areas' => [
        'frontend' => 'areas',
        'core' => 'Areas'
    ],
    'jjwg_Address_Cache' => [
        'frontend' => 'address-cache',
        'core' => 'AddressCache'
    ],
    'AOP_Case_Events' => [
        'frontend' => 'case-events',
        'core' => 'CaseEvents'
    ],
    'AOP_Case_Updates' => [
        'frontend' => 'case-updates',
        'core' => 'CaseUpdates'
    ],
    'AOR_Reports' => [
        'frontend' => 'reports',
        'core' => 'Reports'
    ],
    'AOR_Scheduled_Reports' => [
        'frontend' => 'scheduled-reports',
        'core' => 'ScheduledReports'
    ],
    'AOR_Fields' => [
        'frontend' => 'report-fields',
        'core' => 'ReportFields'
    ],
    'AOR_Charts' => [
        'frontend' => 'report-charts',
        'core' => 'ReportCharts'
    ],
    'AOR_Conditions' => [
        'frontend' => 'report-conditions',
        'core' => 'ReportConditions'
    ],
    'AOW_WorkFlow' => [
        'frontend' => 'workflow',
        'core' => 'Workflow'
    ],
    'AOW_Actions' => [
        'frontend' => 'workflow-actions',
        'core' => 'WorkflowActions'
    ],
    'AOW_Processed' => [
        'frontend' => 'workflow-processed',
        'core' => 'WorflowProcessed'
    ],
    'AOW_Conditions' => [
        'frontend' => 'workflow-conditions',
        'core' => 'WorkflowConditions'
    ],
    'Help' => [
        'frontend' => 'help',
        'core' => 'Help'
    ],
    'Currencies' => [
        'frontend' => 'currencies',
        'core' => 'Currencies'
    ],
    'EditCustomFields' => [
        'frontend' => 'edit-custom-fields',
        'core' => 'EditCustomFields'
    ],
    'Trackers' => [
        'frontend' => 'trackers',
        'core' => 'Trackers'
    ],
    'Releases' => [
        'frontend' => 'releases',
        'core' => 'Releases'
    ],
    'EmailMarketing' => [
        'frontend' => 'email-marketing',
        'core' => 'EmailMarketing'
    ],
    'EmailAddresses' => [
        'frontend' => 'email-addresses',
        'core' => 'EmailAddresses'
    ],
    'EmailText' => [
        'frontend' => 'email-text',
        'core' => 'EmailText'
    ],
    'Schedulers' => [
        'frontend' => 'schedulers',
        'core' => 'Schedulers'
    ],
    'Schedulers_jobs' => [
        'frontend' => 'schedulers-jobs',
        'core' => 'SchedulersJobs'
    ],
    'SchedulersJobs' => [
        'frontend' => 'schedulers-jobs',
        'core' => 'SchedulersJobs'
    ],
    'CampaignTrackers' => [
        'frontend' => 'campaign-trackers',
        'core' => 'CampaignTrackers'
    ],
    'CampaignLog' => [
        'frontend' => 'campaign-log',
        'core' => 'CampaignLog'
    ],
    'EmailMan' => [
        'frontend' => 'emailman',
        'core' => 'EmailMan'
    ],
    'Groups' => [
        'frontend' => 'groups',
        'core' => 'Groups'
    ],
    'DocumentRevisions' => [
        'frontend' => 'document-revisions',
        'core' => 'DocumentRevisions'
    ],
    'Alerts' => [
        'frontend' => 'alerts',
        'core' => 'Alerts'
    ],
    'CustomFields' => [
        'frontend' => 'custom-fields',
        'core' => 'CustomFields'
    ],
    'Dropdown' => [
        'frontend' => 'dropdown',
        'core' => 'Dropdown'
    ],
    'Dynamic' => [
        'frontend' => 'dynamic',
        'core' => 'Dynamic'
    ],
    'DynamicFields' => [
        'frontend' => 'dynamic-fields',
        'core' => 'DynamicFields'
    ],
    'DynamicLayout' => [
        'frontend' => 'dynamic-layout',
        'core' => 'DynamicLayout'
    ],
    'MySettings' => [
        'frontend' => 'my-settings',
        'core' => 'MySettings'
    ],
    'FieldsMetaData' => [
        'frontend' => 'fields-metaData',
        'core' => 'FieldsMetaData'
    ],
    'UpgradeWizard' => [
        'frontend' => 'upgrade-wizard',
        'core' => 'UpgradeWizard'
    ],
    'Versions' => [
        'frontend' => 'versions',
        'core' => 'Versions'
    ],
    'LabelEditor' => [
        'frontend' => 'label-editor',
        'core' => 'LabelEditor'
    ],
    'OptimisticLock' => [
        'frontend' => 'optimistic-lock',
        'core' => 'OptimisticLock'
    ],
    'Audit' => [
        'frontend' => 'audit',
        'core' => 'Audit'
    ],
    'ModuleBuilder' => [
        'frontend' => 'module-builder',
        'core' => 'ModuleBuilder'
    ],
    'Sync' => [
        'frontend' => 'sync',
        'core' => 'Sync'
    ],
    'Alert' => [
        'frontend' => 'alert',
        'core' => 'Alert'
    ],
];

if (file_exists('custom/application/Ext/ModuleNameMap/module_name_map.ext.php')) {
    /* @noinspection PhpIncludeInspection */
    include('custom/application/Ext/ModuleNameMap/module_name_map.ext.php');
}
