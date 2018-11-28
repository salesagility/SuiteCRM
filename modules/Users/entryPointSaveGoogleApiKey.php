<?php
/**
 *
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

 /**
 * Entry Point for saving Google API tokens during account authorization.
 *
 * @license https://raw.githubusercontent.com/salesagility/SuiteCRM/master/LICENSE.txt
 * GNU Affero General Public License version 3
 * @author Benjamin Long <ben@offsite.guru>
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

global $sugar_config;

$client = new Google_Client();
$client->setApplicationName('SuiteCRM');
$client->setScopes(Google_Service_Calendar::CALENDAR);
$json = base64_decode($sugar_config['google_auth_json']);
if (!$config = json_decode($json, true)) {
    die('Invalid json for auth config');
}
$client->setAuthConfig($config);
$client->setAccessType('offline');
$client->setApprovalPrompt('force');

if (isset($_REQUEST['getnew'])) {
    $authUrl = $client->createAuthUrl();
    SugarApplication::redirect($authUrl);
}

if (isset($_REQUEST['code'])) {
    global $current_user;
    $user= new user();
    $user->retrieve($current_user->id);
    $accessToken = $client->fetchAccessTokenWithAuthCode($_REQUEST['code']);
    $user->setPreference('GoogleApiToken', base64_encode(json_encode($accessToken)), false, 'GoogleSync');
    $accessRefreshToken = $accessToken['refresh_token'];
    if (isset($accessRefreshToken)) {
        $user->setPreference('GoogleApiRefreshToken', base64_encode($accessRefreshToken), false, 'GoogleSync');
    }
    $user->savePreferencesToDB();
    $url = $sugar_config['site_url']."/index.php?module=Users&action=EditView&record=" . $current_user->id;
    SugarApplication::redirect($url);
}

if (isset($_REQUEST['setinvalid'])) {
    global $current_user;
    $user= new user();
    $user->retrieve($current_user->id);
    $user->setPreference('GoogleApiToken', '', false, 'GoogleSync');
    $user->savePreferencesToDB();
    $url = $sugar_config['site_url']."/index.php?module=Users&action=EditView&record=" . $current_user->id;
    SugarApplication::redirect($url);
}

if (isset($_REQUEST['error'])) {
    global $current_user;
    $url = $sugar_config['site_url']."/index.php?module=Users&action=EditView&record=" . $current_user->id;
    $exitstring = "<html><head><title>SuiteCRM Google Sync - ERROR</title></head><body><h1>There was an error: " . $_REQUEST['error'] . "</h1><br><p><a href=" . $url . ">Click here</a> to continue.</body></html>";
    die($exitstring);
}

// If we don't get a known return, we just silently return to the user profile.
global $current_user;
$url = $sugar_config['site_url']."/index.php?module=Users&action=EditView&record=" . $current_user->id;
SugarApplication::redirect($url);
