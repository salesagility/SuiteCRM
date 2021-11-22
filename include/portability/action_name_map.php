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

$action_name_map = [
    'index' => 'index',
    'multieditview' => 'multieditview',
    'DetailView' => 'record',
    'EditView' => 'edit',
    'editview' => 'duplicate',
    'ListView' => 'list',
    'Popup' => 'popup',
    'vcard' => 'vcard',
    'ImportVCard' => 'importvcard',
    'modulelistmenu' => 'modulelistmenu',
    'favorites' => 'favorites',
    'noaccess' => 'noaccess',
    'Step1' => 'step1',
    'Step2' => 'step2',
    'ComposeView' => 'compose',
    'SetTimezone' => 'set-timezone',
    'WizardHome' => 'wizard-home',
    'WizardEmailSetup' => 'wizard-email-setup',
    'CampaignDiagnostic' => 'diagnostic',
    'WebToLeadCreation' => 'web-to-lead',
    'ResourceList' => 'resource-list',
    'quick_radius' => 'quick-radius',
    'Login' => 'login',
    'Authenticate' => 'authenticate',
    'Upgrade' => 'upgrade',
    'repair' => 'repair',
    'expandDatabase' => 'expand-database',
    'UpgradeAccess' => 'upgrade-access',
    'RebuildConfig' => 'rebuild-config',
    'RebuildRelationship' => 'rebuild-relationship',
    'RebuildSchedulers' => 'rebuild-schedulers',
    'RebuildDashlets' => 'rebuild-dashlets',
    'RebuildJSLang' => 'rebuild-js-lang',
    'RepairJSFile' => 'repair-js-file',
    'RepairFieldCasing' => 'repair-field-casing',
    'install_actions' => 'install-actions',
    'RepairIE' => 'repair-ie',
    'SyncInboundEmailAccounts' => 'sync-inbound-email-accounts',
    'RepairXSS' => 'repair-xss',
    'RepairActivities' => 'repair-activities',
    'RepairSeedUsers' => 'repair-seed-users',
    'RepairUploadFolder' => 'repair-upload-folder',
    'About' => 'about',
    'UnifiedSearch' => 'unified-search',
    'ConvertLead' => 'convert-lead',
];

if (file_exists('custom/application/Ext/ActionNameMap/action_name_map.ext.php')) {
    include('custom/application/Ext/ActionNameMap/action_name_map.ext.php');
}
