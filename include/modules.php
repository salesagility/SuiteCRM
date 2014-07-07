<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/

/*********************************************************************************gf

 * Description:  Executes a step in the installation process.
 ********************************************************************************/

$moduleList = array();
// this list defines the modules shown in the top tab list of the app
//the order of this list is the default order displayed - do not change the order unless it is on purpose
$moduleList[] = 'Home';
$moduleList[] = 'Calendar';
$moduleList[] = 'Calls';
$moduleList[] = 'Meetings';
$moduleList[] = 'Tasks';
$moduleList[] = 'Notes';
$moduleList[] = 'Leads';
$moduleList[] = 'Contacts';
$moduleList[] = 'Accounts';
$moduleList[] = 'Opportunities';

$moduleList[] = 'Emails';
$moduleList[] = 'Campaigns';
$moduleList[] = 'Prospects';
$moduleList[] = 'ProspectLists';

$moduleList[] = 'Documents';
$moduleList[] = 'Cases';
$moduleList[] = 'Project';
$moduleList[] = 'Bugs';


// this list defines all of the module names and bean names in the app
// to create a new module's bean class, add the bean definition here
$beanList = array();
//ACL Objects
$beanList['ACLRoles']       = 'ACLRole';
$beanList['ACLActions']     = 'ACLAction';
//END ACL OBJECTS
$beanList['Leads']          = 'Lead';
$beanList['Cases']          = 'aCase';
$beanList['Bugs']           = 'Bug';
$beanList['ProspectLists']      = 'ProspectList';
$beanList['Prospects']  = 'Prospect';
$beanList['Project']            = 'Project';
$beanList['ProjectTask']            = 'ProjectTask';
$beanList['Campaigns']          = 'Campaign';
$beanList['EmailMarketing']  = 'EmailMarketing';
$beanList['CampaignLog']        = 'CampaignLog';
$beanList['CampaignTrackers']   = 'CampaignTracker';
$beanList['Releases']       = 'Release';
$beanList['Groups'] = 'Group';
$beanList['EmailMan'] = 'EmailMan';
$beanList['Schedulers']  = 'Scheduler';
$beanList['SchedulersJobs']  = 'SchedulersJob';
$beanList['Contacts']       = 'Contact';
$beanList['Accounts']       = 'Account';
$beanList['DynamicFields']  = 'DynamicField';
$beanList['EditCustomFields']   = 'FieldsMetaData';
$beanList['Opportunities']  = 'Opportunity';
$beanList['EmailTemplates']     = 'EmailTemplate';
$beanList['Notes']          = 'Note';
$beanList['Calls']          = 'Call';
$beanList['Emails']         = 'Email';
$beanList['Meetings']       = 'Meeting';
$beanList['Tasks']          = 'Task';
$beanList['Users']          = 'User';
$beanList['Currencies']     = 'Currency';
$beanList['Trackers']       = 'Tracker';
$beanList['Connectors']     = 'Connectors';
$beanList['Import_1']         = 'ImportMap';
$beanList['Import_2']       = 'UsersLastImport';
$beanList['Versions']       = 'Version';
$beanList['Administration'] = 'Administration';
$beanList['vCals']          = 'vCal';
$beanList['CustomFields']       = 'CustomFields';





$beanList['Documents']  = 'Document';
$beanList['DocumentRevisions']  = 'DocumentRevision';
$beanList['Roles']  = 'Role';

$beanList['Audit']  = 'Audit';

// deferred
//$beanList['Queues'] = 'Queue';

$beanList['InboundEmail'] = 'InboundEmail';


$beanList['SavedSearch']            = 'SavedSearch';
$beanList['UserPreferences']        = 'UserPreference';
$beanList['MergeRecords'] = 'MergeRecord';
$beanList['EmailAddresses'] = 'EmailAddress';
$beanList['EmailText'] = 'EmailText';
$beanList['Relationships'] = 'Relationship';
$beanList['Employees']      = 'Employee';




// this list defines all of the files that contain the SugarBean class definitions from $beanList
// to create a new module's bean class, add the file definition here
$beanFiles = array();

$beanFiles['ACLAction'] = 'modules/ACLActions/ACLAction.php';
$beanFiles['ACLRole'] = 'modules/ACLRoles/ACLRole.php';
$beanFiles['Relationship']  = 'modules/Relationships/Relationship.php';

$beanFiles['Lead']          = 'modules/Leads/Lead.php';
$beanFiles['aCase']         = 'modules/Cases/Case.php';
$beanFiles['Bug']           = 'modules/Bugs/Bug.php';
$beanFiles['Group'] = 'modules/Groups/Group.php';
$beanFiles['CampaignLog']  = 'modules/CampaignLog/CampaignLog.php';
$beanFiles['Project']           = 'modules/Project/Project.php';
$beanFiles['ProjectTask']           = 'modules/ProjectTask/ProjectTask.php';
$beanFiles['Campaign']          = 'modules/Campaigns/Campaign.php';
$beanFiles['ProspectList']      = 'modules/ProspectLists/ProspectList.php';
$beanFiles['Prospect']  = 'modules/Prospects/Prospect.php';

$beanFiles['EmailMarketing']          = 'modules/EmailMarketing/EmailMarketing.php';
$beanFiles['CampaignTracker']  = 'modules/CampaignTrackers/CampaignTracker.php';
$beanFiles['Release']           = 'modules/Releases/Release.php';
$beanFiles['EmailMan']          = 'modules/EmailMan/EmailMan.php';

$beanFiles['Scheduler']  = 'modules/Schedulers/Scheduler.php';
$beanFiles['SchedulersJob']  = 'modules/SchedulersJobs/SchedulersJob.php';
$beanFiles['Contact']       = 'modules/Contacts/Contact.php';
$beanFiles['Account']       = 'modules/Accounts/Account.php';
$beanFiles['Opportunity']   = 'modules/Opportunities/Opportunity.php';
$beanFiles['EmailTemplate']         = 'modules/EmailTemplates/EmailTemplate.php';
$beanFiles['Note']          = 'modules/Notes/Note.php';
$beanFiles['Call']          = 'modules/Calls/Call.php';
$beanFiles['Email']         = 'modules/Emails/Email.php';
$beanFiles['Meeting']       = 'modules/Meetings/Meeting.php';
$beanFiles['Task']          = 'modules/Tasks/Task.php';
$beanFiles['User']          = 'modules/Users/User.php';
$beanFiles['Employee']      = 'modules/Employees/Employee.php';
$beanFiles['Currency']          = 'modules/Currencies/Currency.php';
$beanFiles['Tracker']          = 'modules/Trackers/Tracker.php';
$beanFiles['ImportMap']     = 'modules/Import/maps/ImportMap.php';
$beanFiles['UsersLastImport']= 'modules/Import/UsersLastImport.php';
$beanFiles['Administration']= 'modules/Administration/Administration.php';
$beanFiles['UpgradeHistory']= 'modules/Administration/UpgradeHistory.php';
$beanFiles['vCal']          = 'modules/vCals/vCal.php';

$beanFiles['Version']           = 'modules/Versions/Version.php';



$beanFiles['Role']          = 'modules/Roles/Role.php';

$beanFiles['Document']  = 'modules/Documents/Document.php';
$beanFiles['DocumentRevision']  = 'modules/DocumentRevisions/DocumentRevision.php';
$beanFiles['FieldsMetaData']    = 'modules/DynamicFields/FieldsMetaData.php';
//$beanFiles['Audit']           = 'modules/Audit/Audit.php';

// deferred
//$beanFiles['Queue'] = 'modules/Queues/Queue.php';

$beanFiles['InboundEmail'] = 'modules/InboundEmail/InboundEmail.php';



$beanFiles['SavedSearch']  = 'modules/SavedSearch/SavedSearch.php';
$beanFiles['UserPreference']  = 'modules/UserPreferences/UserPreference.php';
$beanFiles['MergeRecord']  = 'modules/MergeRecords/MergeRecord.php';
$beanFiles['EmailAddress'] = 'modules/EmailAddresses/EmailAddress.php';
$beanFiles['EmailText'] = 'modules/EmailText/EmailText.php';



// TODO: Remove the Library module, it is an example.
//$moduleList[] = 'Library';
//$beanList['Library']= 'Library';
//$beanFiles['Library'] = 'modules/Library/Library.php';

$beanFiles['Configurator']          = 'modules/Configurator/Configurator.php';

// added these lists for security settings for tabs
$modInvisList = array('Administration', 'Currencies', 'CustomFields', 'Connectors',
    'Dropdown', 'Dynamic', 'DynamicFields', 'DynamicLayout', 'EditCustomFields',
    'Help', 'Import',  'MySettings', 'EditCustomFields','FieldsMetaData',
    'UpgradeWizard', 'Trackers', 'Connectors', 'Employees', 'Calendar',
    'Releases','Sync',
    'Users',  'Versions', 'LabelEditor','Roles','EmailMarketing'
    ,'OptimisticLock', 'TeamMemberships', 'TeamSets', 'TeamSetModule', 'Audit', 'MailMerge', 'MergeRecords', 'EmailAddresses','EmailText',
    'Schedulers','Schedulers_jobs', /*'Queues',*/ 'EmailTemplates',
    'CampaignTrackers', 'CampaignLog', 'EmailMan', 'Prospects', 'ProspectLists',
    'Groups','InboundEmail',
    'ACLActions', 'ACLRoles',
    'DocumentRevisions',
    'ProjectTask',
    );
$adminOnlyList = array(
                    //module => list of actions  (all says all actions are admin only)
                   //'Administration'=>array('all'=>1, 'SupportPortal'=>'allow'),
                    'Dropdown'=>array('all'=>1),
                    'Dynamic'=>array('all'=>1),
                    'DynamicFields'=>array('all'=>1),
                    'Currencies'=>array('all'=>1),
                    'EditCustomFields'=>array('all'=>1),
                    'FieldsMetaData'=>array('all'=>1),
                    'LabelEditor'=>array('all'=>1),
                    'ACL'=>array('all'=>1),
                    'ACLActions'=>array('all'=>1),
                    'ACLRoles'=>array('all'=>1),
                    'UpgradeWizard' => array('all' => 1),
                    'Studio' => array('all' => 1),
                    'Schedulers' => array('all' => 1),
                    );


$modInvisList[] = 'ACL';
$modInvisList[] = 'ACLRoles';
$modInvisList[] = 'Configurator';
$modInvisList[] = 'UserPreferences';
$modInvisList[] = 'SavedSearch';
// deferred
//$modInvisList[] = 'Queues';
$modInvisList[] = 'Studio';
$modInvisList[] = 'Connectors';

$report_include_modules = array();
$report_include_modules['Currencies']='Currency';
//add prospects
$report_include_modules['Prospects']='Prospect';
$report_include_modules['DocumentRevisions'] = 'DocumentRevision';
$report_include_modules['ProductCategories'] = 'ProductCategory';
$report_include_modules['ProductTypes'] = 'ProductType';
//add Tracker modules

$report_include_modules['Trackers']         = 'Tracker';



$beanList['SugarFeed'] = 'SugarFeed';
$beanFiles['SugarFeed'] = 'modules/SugarFeed/SugarFeed.php';
$modInvisList[] = 'SugarFeed';

// This is the mapping for modules that appear under a different module's tab
// Be sure to also add the modules to $modInvisList, otherwise their tab will still appear
$GLOBALS['moduleTabMap'] = array(
    'UpgradeWizard' => 'Administration',
    'EmailMan' => 'Administration',
    'ModuleBuilder' => 'Administration',
    'Configurator' => 'Administration',
    'Studio' => 'Administration',
    'Currencies' => 'Administration',
    'SugarFeed' => 'Administration',
    'DocumentRevisions' => 'Documents',
    'EmailTemplates' => 'Emails',
    'EmailMarketing' => 'Campaigns',
 );
$beanList['EAPM'] = 'EAPM';
$beanFiles['EAPM'] = 'modules/EAPM/EAPM.php';
$modules_exempt_from_availability_check['EAPM'] = 'EAPM';
$modInvisList[] = 'EAPM';
$beanList['OAuthKeys'] = 'OAuthKey';
$beanFiles['OAuthKey'] = 'modules/OAuthKeys/OAuthKey.php';
$modules_exempt_from_availability_check['OAuthKeys'] = 'OAuthKeys';
$modInvisList[] = 'OAuthKeys';
$beanList['OAuthTokens'] = 'OAuthToken';
$beanFiles['OAuthToken'] = 'modules/OAuthTokens/OAuthToken.php';
$modules_exempt_from_availability_check['OAuthTokens'] = 'OAuthTokens';
$modInvisList[] = 'OAuthTokens';



//Object list is only here to correct for modules that break
//the bean class name == dictionary entry/object name convention
//No future module should need an entry here.
$objectList = array();
$objectList['Cases'] =  'Case';
$objectList['Groups'] =  'User';
$objectList['Users'] =  'User';

if (file_exists('include/modules_override.php'))
{
    include('include/modules_override.php');
}
if (file_exists('custom/application/Ext/Include/modules.ext.php'))
{
    include('custom/application/Ext/Include/modules.ext.php');
}
?>
