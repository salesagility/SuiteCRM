<?php
/**
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
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
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$entry_point_registry = [
    'emailImage' => ['file' => 'modules/EmailMan/EmailImage.php', 'auth' => false],
    'download' => ['file' => 'download.php', 'auth' => true],
    'export' => ['file' => 'export.php', 'auth' => true],
    'export_dataset' => ['file' => 'export_dataset.php', 'auth' => true],
    'Changenewpassword' => ['file' => 'modules/Users/Changenewpassword.php', 'auth' => false],
    'GeneratePassword' => ['file' => 'modules/Users/GeneratePassword.php', 'auth' => false],
    'vCard' => ['file' => 'vCard.php', 'auth' => true],
    'pdf' => ['file' => 'pdf.php', 'auth' => true],
    'minify' => ['file' => 'jssource/minify.php', 'auth' => true],
    'json_server' => ['file' => 'json_server.php', 'auth' => true],
    'get_url' => ['file' => 'get_url.php', 'auth' => true],
    'HandleAjaxCall' => ['file' => 'HandleAjaxCall.php', 'auth' => true],
    'TreeData' => ['file' => 'TreeData.php', 'auth' => true],
    'image' => ['file' => 'modules/Campaigns/image.php', 'auth' => false],
    'campaign_trackerv2' => ['file' => 'modules/Campaigns/Tracker.php', 'auth' => false],
    'WebToLeadCapture' => ['file' => 'modules/Campaigns/WebToLeadCapture.php', 'auth' => false],
    'WebToPersonCapture' => ['file' => 'modules/Campaigns/WebToPersonCapture.php', 'auth' => false],
    'removeme' => ['file' => 'modules/Campaigns/RemoveMe.php', 'auth' => false],
    'ConfirmOptIn' => ['file' => 'include/entryPointConfirmOptInConnector.php', 'auth' => false],
    'acceptDecline' => ['file' => 'modules/Contacts/AcceptDecline.php', 'auth' => false],
    'leadCapture' => ['file' => 'modules/Leads/Capture.php', 'auth' => false],
    'process_queue' => ['file' => 'process_queue.php', 'auth' => true],
    'zipatcher' => ['file' => 'zipatcher.php', 'auth' => true],
    'mm_get_doc' => ['file' => 'modules/MailMerge/get_doc.php', 'auth' => true],
    'getImage' => ['file' => 'include/SugarTheme/getImage.php', 'auth' => false],
    'GenerateQuickComposeFrame' => ['file' => 'modules/Emails/GenerateQuickComposeFrame.php', 'auth' => true],
    'DetailUserRole' => ['file' => 'modules/ACLRoles/DetailUserRole.php', 'auth' => true],
    'getYUIComboFile' => ['file' => 'include/javascript/getYUIComboFile.php', 'auth' => false],
    'UploadFileCheck' => ['file' => 'modules/Configurator/UploadFileCheck.php', 'auth' => true],
    'SAML' => ['file' => 'modules/Users/authentication/SAMLAuthenticate/index.php', 'auth' => false],
    'SAML2Metadata' => ['file' => 'modules/Users/authentication/SAML2Authenticate/SAML2Metadata.php', 'auth' => false],
    'jslang' => ['file' => 'include/language/getJSLanguage.php', 'auth' => true],
    'deleteAttachment' => ['file' => 'include/SugarFields/Fields/Image/deleteAttachment.php', 'auth' => false],
    'responseEntryPoint' => ['file' => 'modules/FP_events/responseEntryPoint.php', 'auth' => false],
    'formLetter' => ['file' => 'modules/AOS_PDF_Templates/formLetterPdf.php', 'auth' => true],
    'generatePdf' => ['file' => 'modules/AOS_PDF_Templates/generatePdf.php', 'auth' => true],
    'Reschedule' => ['file' => 'modules/Calls_Reschedule/Reschedule_popup.php', 'auth' => true],
    'Reschedule2' => ['file' => 'modules/Calls/Reschedule.php', 'auth' => true],
    'social' => ['file' => 'include/social/get_data.php', 'auth' => true],
    'social_reader' => ['file' => 'include/social/get_feed_data.php', 'auth' => true],
    'add_dash_page' => ['file' => 'modules/Home/AddDashboardPages.php', 'auth' => true],
    'retrieve_dash_page' => ['file' => 'include/MySugar/retrieve_dash_page.php', 'auth' => true],
    'remove_dash_page' => ['file' => 'modules/Home/RemoveDashboardPages.php', 'auth' => true],
    'rename_dash_page' => ['file' => 'modules/Home/RenameDashboardPages.php', 'auth' => true],
    'emailTemplateData' => ['file' => 'modules/EmailTemplates/EmailTemplateData.php', 'auth' => true],
    'emailMarketingData' => ['file' => 'modules/EmailMarketing/Save.php', 'auth' => true],
    'campaignTrackerSave' => ['file' => 'modules/CampaignTrackers/Save.php', 'auth' => true],
    'emailMarketingList' => ['file' => 'modules/EmailMarketing/List.php', 'auth' => true],
    'setCampaignMarketingAndTemplate' => ['file' => 'modules/Campaigns/WizardCampaignSave.php', 'auth' => true],
    'survey' => ['file' => 'modules/Surveys/Entry/Survey.php', 'auth' => false],
    'surveySubmit' => ['file' => 'modules/Surveys/Entry/SurveySubmit.php', 'auth' => false],
    'surveyThanks' => ['file' => 'modules/Surveys/Entry/Thanks.php', 'auth' => false],
    'sendConfirmOptInEmail' => ['file' => 'include/entryPointConfirmOptInConnector.php', 'auth' => true],
    'saveGoogleApiKey' => ['file' => 'modules/Users/entryPointSaveGoogleApiKey.php', 'auth' => true],
    'setImapTestSettings' => ['file' => 'include/Imap/ImapTestSettingsEntry.php', 'auth' => true],
];
