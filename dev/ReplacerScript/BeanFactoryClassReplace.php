<?php

$moduleClassList = [
    'ACLRoles' => 'ACLRole',
    'ACLActions' => 'ACLAction',
    'Leads' => 'Lead',
    'Cases' => 'aCase',
    'Bugs' => 'Bug',
    'ProspectLists' => 'ProspectList',
    'Prospects' => 'Prospect',
    'Project' => 'Project',
    'ProjectTask' => 'ProjectTask',
    'Campaigns' => 'Campaign',
    'EmailMarketing' => 'EmailMarketing',
    'CampaignLog' => 'CampaignLog',
    'CampaignTrackers' => 'CampaignTracker',
    'Releases' => 'Release',
    'Groups' => 'Group',
    'EmailMan' => 'EmailMan',
    'Schedulers' => 'Scheduler',
    'SchedulersJobs' => 'SchedulersJob',
    'Contacts' => 'Contact',
    'Accounts' => 'Account',
    'DynamicFields' => 'DynamicField',
    'EditCustomFields' => 'FieldsMetaData',
    'Opportunities' => 'Opportunity',
    'EmailTemplates' => 'EmailTemplate',
    'Notes' => 'Note',
    'Calls' => 'Call',
    'Emails' => 'Email',
    'Meetings' => 'Meeting',
    'Tasks' => 'Task',
    'Users' => 'User',
    'Currencies' => 'Currency',
    'Trackers' => 'Tracker',
    'Connectors' => 'Connectors',
    'Import_1' => 'ImportMap',
    'Import_2' => 'UsersLastImport',
    'Versions' => 'Version',
    'Administration' => 'Administration',
    'vCals' => 'vCal',
    'CustomFields' => 'CustomFields',
    'Alerts' => 'Alert',
    'Documents' => 'Document',
    'DocumentRevisions' => 'DocumentRevision',
    'Roles' => 'Role',
    'Audit' => 'Audit',
    'InboundEmail' => 'InboundEmail',
    'SavedSearch' => 'SavedSearch',
    'UserPreferences' => 'UserPreference',
    'MergeRecords' => 'MergeRecord',
    'EmailAddresses' => 'EmailAddress',
    'EmailText' => 'EmailText',
    'Relationships' => 'Relationship',
    'Employees' => 'Employee',
    'Spots' => 'Spots',
    'AOBH_BusinessHours' => 'AOBH_BusinessHours',
    'SugarFeed' => 'SugarFeed',
    'EAPM' => 'EAPM',
    'OAuthKeys' => 'OAuthKey',
    'OAuthTokens' => 'OAuthToken',
    'AM_ProjectTemplates' => 'AM_ProjectTemplates',
    'AM_TaskTemplates' => 'AM_TaskTemplates',
    'Favorites' => 'Favorites',
    'AOK_Knowledge_Base_Categories' => 'AOK_Knowledge_Base_Categories',
    'AOK_KnowledgeBase' => 'AOK_KnowledgeBase',
    'Reminders' => 'Reminder',
    'Reminders_Invitees' => 'Reminder_Invitee',
    'FP_events' => 'FP_events',
    'FP_Event_Locations' => 'FP_Event_Locations',
    'AOD_IndexEvent' => 'AOD_IndexEvent',
    'AOD_Index' => 'AOD_Index',
    'AOP_Case_Events' => 'AOP_Case_Events',
    'AOP_Case_Updates' => 'AOP_Case_Updates',
    'AOR_Reports' => 'AOR_Report',
    'AOR_Fields' => 'AOR_Field',
    'AOR_Charts' => 'AOR_Chart',
    'AOR_Conditions' => 'AOR_Condition',
    'AOR_Scheduled_Reports' => 'AOR_Scheduled_Reports',
    'AOS_Contracts' => 'AOS_Contracts',
    'AOS_Invoices' => 'AOS_Invoices',
    'AOS_PDF_Templates' => 'AOS_PDF_Templates',
    'AOS_Product_Categories' => 'AOS_Product_Categories',
    'AOS_Products' => 'AOS_Products',
    'AOS_Products_Quotes' => 'AOS_Products_Quotes',
    'AOS_Line_Item_Groups' => 'AOS_Line_Item_Groups',
    'AOS_Quotes' => 'AOS_Quotes',
    'AOW_Actions' => 'AOW_Action',
    'AOW_WorkFlow' => 'AOW_WorkFlow',
    'AOW_Processed' => 'AOW_Processed',
    'AOW_Conditions' => 'AOW_Condition',
    'jjwg_Maps' => 'jjwg_Maps',
    'jjwg_Markers' => 'jjwg_Markers',
    'jjwg_Areas' => 'jjwg_Areas',
    'jjwg_Address_Cache' => 'jjwg_Address_Cache',
    'Calls_Reschedule' => 'Calls_Reschedule',
    'SecurityGroups' => 'SecurityGroup',
    'OutboundEmailAccounts' => 'OutboundEmailAccounts',
    'TemplateSectionLine' => 'TemplateSectionLine',
    'OAuth2Tokens' => 'OAuth2Tokens',
    'OAuth2Clients' => 'OAuth2Clients',
    'SurveyResponses' => 'SurveyResponses',
    'Surveys' => 'Surveys',
    'SurveyQuestionResponses' => 'SurveyQuestionResponses',
    'SurveyQuestions' => 'SurveyQuestions',
    'SurveyQuestionOptions' => 'SurveyQuestionOptions',
];

try {
    ini_set('memory_limit', '512M');

    $basePath = dirname(dirname(__DIR__));

    chdir($basePath);

    echo <<<EOT
<style>
pre 
{
    background: #f5f5f5;
    padding: 15px 20px;
    border-radius: 8px;
    display: inline-block;
}
</style>
EOT;

    ob_start();

    $directories = new RecursiveDirectoryIterator(
        $basePath
    );

    $filteredDirectories = new RecursiveCallbackFilterIterator(
        $directories,
        function (SplFileInfo $current, $key, RecursiveDirectoryIterator $iterator) {
            if ($current->isDir() && $iterator->hasChildren()) {
                return strpos(basename($key), '.') === false;
            }

            $current->getExtension();

            if (!$current->isFile()) {
                return false;
            }

            return $current->getExtension() === 'php';
        }
    );

    $recursiveDirectoryIterator = new RecursiveIteratorIterator(
        $filteredDirectories
    );

    $searchList = [];

    $replaceList = [];

    $classList = [];

    foreach ($moduleClassList as $beanName => $className) {
        $searchList[] = sprintf(
            'new %s()',
            $className
        );

        $replaceList[] = sprintf(
            'BeanFactory::newBean(\'%s\')',
            $beanName
        );

        $classList[] = $className;
    }

    $fileCount = 0;

    $fileCommitTracker = 0;

    $updatedFileCount = 0;

    $totalOccurrences = 0;

    $totalOccurrencesFound = [];

    $commitModuleListItems = '';

    $commitFileListItemLine = <<<EOT
-m "" \
-m "- File: '%s'" \

EOT;

    $commitOccurrencesListItemLine = <<<EOT
-m "   - Replaced %s occurrence(s) of '%s'" \

EOT;

    foreach ($recursiveDirectoryIterator as $file) {
        $fileCount++;

        if (!$file->isFile()) {
            continue;
        }

        $fileContents = file_get_contents($file->getRealPath());

        if ($fileContents === false) {
            throw new RuntimeException(
                sprintf(
                    'Failed to read from: &apos;%s&apos;',
                    $file->getRealPath()
                ),
                400
            );
        }

        $occurrencesFound = [];

        foreach ($searchList as $searchString) {
            $occurrences = substr_count($fileContents, $searchString);

            if ($occurrences > 0) {
                $totalOccurrences += $occurrences;

                $occurrencesFound[] = [
                    'searchString' => $searchString,
                    'count' => $occurrences,
                ];

                $totalOccurrencesFound[$searchString] += $occurrences;
            }
        }

        if (empty($occurrencesFound)) {
            continue;
        }

        $fileContents = str_replace(
            $searchList,
            $replaceList,
            $fileContents
        );

        if (preg_match('/\nnamespace ([\w\\\\]+);/', $fileContents)) {
            $fileContents = str_replace(
                'BeanFactory::newBean',
                '\\BeanFactory::newBean',
                $fileContents
            );
        }

        $fileCommitTracker++;

        $success = file_put_contents($file->getRealPath(), $fileContents);

        if (function_exists('opcache_invalidate')) {
            opcache_invalidate($file->getRealPath());
        }

        if ($success === false) {
            throw new RuntimeException(
                sprintf(
                    'Failed to write to: &apos;%s&apos;',
                    $file->getRealPath()
                ),
                400
            );
        }

        $printFilePath = str_replace(
            $basePath,
            '... ',
            $file->getRealPath()
        );

        echo sprintf(
            '<h4>%s - File: &apos;%s&apos;</h4>',
            ++$updatedFileCount,
            $printFilePath
        );

        $commitModuleListItems .= sprintf(
            $commitFileListItemLine,
            $printFilePath
        );

        echo sprintf(
            '<p>Found occurrence(s) of %s search string(s):</p>',
            count($occurrencesFound)
        );

        $moduleClassCount = 0;

        foreach ($occurrencesFound as $occurrenceFound) {
            echo sprintf(
                '<p>%s occurrence(s) of &apos;%s&apos;</p>',
                $occurrenceFound['count'],
                $occurrenceFound['searchString']
            );

            $commitModuleListItem = sprintf(
                $commitOccurrencesListItemLine,
                $occurrenceFound['count'],
                $occurrenceFound['searchString']
            );

            $commitModuleListItems .= $commitModuleListItem;
        }

        $fileStartIndex = ($updatedFileCount - $fileCommitTracker) + 1;

        $commitCommand = <<<EOT
git -c user.name="j.dang" -c user.email="jason.dang@salesagility.com" \
commit -m "Replace explicit bean instantiations in files {$fileStartIndex} - {$updatedFileCount}" \

EOT;

        if ($fileCommitTracker === 10) {
            $commitCommand .= $commitModuleListItems;

            $commitCommand = rtrim(rtrim($commitCommand), '\\');

            echo sprintf(
                '<pre>%s</pre>',
                $commitCommand
            );

            sleep(1);

            shell_exec('git add .');

            $commitOutput = shell_exec($commitCommand);

            echo sprintf(
                '<p>%s</p>',
                !empty($commitOutput) ? $commitOutput : 'Commit Failed.'
            );

            $commitModuleListItems = '';

            $fileCommitTracker = 0;
        }

        ob_end_flush();
        ob_flush();
        flush();
        ob_start();
    }

    if (!empty($commitModuleListItems)) {
        $commitCommand .= $commitModuleListItems;

        $commitCommand = rtrim(rtrim($commitCommand), '\\');

        echo sprintf(
            '<pre>%s</pre>',
            $commitCommand
        );

        sleep(1);

        shell_exec('git add .');

        $commitOutput = shell_exec($commitCommand);

        echo sprintf(
            '<p>%s</p>',
            !empty($commitOutput) ? $commitOutput : 'Commit Failed.'
        );
    }

    echo '<p>Done Diddly Done.</p>';

    echo sprintf(
        '<p>Found %s total occurrence(s) of %s search string(s) in %s of %s files.</p>',
        $totalOccurrences,
        count($totalOccurrencesFound),
        $updatedFileCount,
        $fileCount
    );
} catch (Throwable $throwable) {
    echo '<p>Error Encountered...</p>';

    echo sprintf(
        '<p>Code: %s</p>',
        $throwable->getCode()
    );

    echo sprintf(
        '<p>Message: %s</p>',
        $throwable->getMessage()
    );

    echo sprintf(
        '<p>File: %s</p>',
        $throwable->getFile()
    );

    echo sprintf(
        '<p>Line: %s</p>',
        $throwable->getLine()
    );

    echo sprintf(
        '<p>Trace: %s</p>',
        $throwable->getTraceAsString()
    );
}
