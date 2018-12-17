<?php
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

if (isset($_REQUEST['getnew'])) {
    $authUrl = $client->createAuthUrl();
    SugarApplication::redirect($authUrl);
}

if (isset($_REQUEST['code'])) {
    global $GLOBALS;
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
    global $GLOBALS;
    global $current_user;
    $user= new user();
    $user->retrieve($current_user->id);
    $user->setPreference('GoogleApiToken', '', false, 'GoogleSync');
    $user->savePreferencesToDB();
    $url = $sugar_config['site_url']."/index.php?module=Users&action=EditView&record=" . $current_user->id;
    SugarApplication::redirect($url);
}

if (isset($_REQUEST['error'])) {
    global $GLOBALS;
    global $current_user;
    $url = $sugar_config['site_url']."/index.php?module=Users&action=EditView&record=" . $current_user->id;
    $exitstring = "<html><head><title>SuiteCRM Google Sync - ERROR</title></head><body><h1>There was an error: " . $_REQUEST['error'] . "</h1><br><p><a href=" . $url . ">Click here</a> to continue.</body></html>";
    die($exitstring);
}

// If we don't get a known return, we just silently return to the user profile.
global $current_user;
$url = $sugar_config['site_url']."/index.php?module=Users&action=EditView&record=" . $current_user->id;
SugarApplication::redirect($url);
