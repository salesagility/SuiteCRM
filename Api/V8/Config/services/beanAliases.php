<?php

use Api\Core\Loader\CustomLoader;

/**
 * Aliases for core modules
 */
return [
    'beanAliases' => function () {
        return CustomLoader::mergeCustomArray([
            Account::class => 'Accounts',
            ACLAction::class => 'ACLActions',
            ACLRole::class => 'ACLRoles',
            Alert::class => 'Alerts',
            AOR_Chart::class => 'AOR_Charts',
            AOR_Condition::class => 'AOR_Conditions',
            AOR_Field::class => 'AOR_Fields',
            AOR_Report::class => 'AOR_Reports',
            AOW_Action::class => 'AOW_Actions',
            AOW_Condition::class => 'AOW_Conditions',
            Call::class => 'Calls',
            Campaign::class => 'Campaigns',
            CampaignTracker::class => 'CampaignTrackers',
            aCase::class => 'Cases',
            'Case' => 'Cases',
            ConnectorRecord::class => 'Connector',
            Contact::class => 'Contacts',
            Currency::class => 'Currencies',
            DocumentRevision::class => 'DocumentRevisions',
            Document::class => 'Documents',
            FieldsMetaData::class => 'DynamicFields',
            Email::class => 'Emails',
            EmailTemplate::class => 'EmailTemplates',
            Employee::class => 'Employees',
            UsersLastImport::class => 'Import',
            Lead::class => 'Leads',
            Meeting::class => 'Meetings',
            MergeRecord::class => 'MergeRecords',
            Note::class => 'Notes',
            OAuthKey::class => 'OAuthKeys',
            OAuthToken::class => 'OAuthTokens',
            Opportunity::class => 'Opportunities',
            ProspectList::class => 'ProspectLists',
            Prospect::class => 'Prospects',
            Relationship::class => 'Relationships',
            Reminder::class => 'Reminders',
            Reminder_Invitee::class => 'Reminders_Invitees',
            Role::class => 'Roles',
            SecurityGroup::class => 'SecurityGroups',
            Task::class => 'Tasks',
            Tracker::class => 'Trackers',
            User::class => 'Users',
            UserPreference::class => 'UserPreferences',
            vCal::class => 'vCals',
            'Contracts' => AOS_Contracts::class,
            'Invoices' => AOS_Invoices::class,
            'ProductQuotes' => AOS_Products_Quotes::class,
            'Quotes' => AOS_Quotes::class,
        ], basename(__FILE__));
    }
];
