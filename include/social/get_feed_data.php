<?php
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2016 Salesagility Ltd.
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
/*
 *
 * This file requires each user to log into their twitter account and authorise SuiteCRM to access it.
 *
 */

require_once('include/social/twitter/twitter_auth/twitteroauth/twitteroauth.php');
require_once('include/social/twitter/twitter_helper.php');

//Load Globals.
global $db;
global $current_user;
global $sugar_config;

//session_start();
$html = '';

$twitter_enabled = check_enabled($db, 'twitter');

if ($twitter_enabled) {

    require_once('custom/modules/Connectors/connectors/sources/ext/rest/twitter/config.php');

    /*
     * Pull in connector settings for creating the authentication between Suite and Twitter.
     * If these settings are blank check the connector and make sure the setting are correct.
    */

    $settings = array(
        'consumer_key' => $config['properties']['consumer_key'],
        'consumer_secret' => $config['properties']['consumer_secret'],
        'call_back_url' => $config['properties']['OAUTH_CALLBACK'],
    );

    /*
     * Check if the if the user is authenticated if not run the authenticating function and show the login link in the activity stream
    */

    if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
        $connection = check_auth($sugar_config['site_url']);
    }

    //Pull in values set in the authenitcation function.
    $html .= $_REQUEST['html'];
    $request_token = $_REQUEST['request_token'];

    /* Get user access tokens out of the session. */
    $access_token = $_SESSION['access_token'];

    /* Create a TwitterOauth object with consumer/user tokens. */
    $connection = new TwitterOAuth($settings['consumer_key'], $settings['consumer_secret'], $access_token['oauth_token'], $access_token['oauth_token_secret']);

    /* If method is set change API call made. Test is called by default. */
    $tweets = $connection->get('statuses/home_timeline', array('screen_name' => $_SESSION['access_token']['screen_name'], 'exclude_replies' => false));

    //Set the increment value.
    $i = 0;

    /*

    -Loop through all the tweets.
    - Replace any URLS for Hrefs first, this needs to be done first as this is what get stored in the DB so duplicate checking would not work otherwise.
    - Reformat the Date from twitters date format.
    - Check if the tweet has already been entered into the Activity Stream.
    - if no duplicates found use insert query to add tweet to activity stream.
    - Start loop again.
    */

    if (empty($tweets['errors'])) {
        while ($i < count($tweets)) {


            $limit = 104;

            $tweets[$i]['text'] = format_feed_tweets($db, $tweets[$i],$limit);

            if (count($tweets[$i]['entities']['hashtags']) > 0) {
                $tweets[$i]['text'] = replace_hashtags($db, $tweets[$i]);
            }
            if (count($tweets[$i]['entities']['user_mentions']) > 0) {
                $tweets[$i]['text'] = replace_users($db, $tweets[$i]);
            }


            $date = date("Y-m-d H:i:s", strtotime($tweets[$i]['created_at']));
            $image = "<img src=" . $tweets[$i]['user']['profile_image_url_https'] . " style=float:left;padding-right:5px;padding-bottom:5px;/>";
            $duplicate_found = duplicate_check($db, $tweets[$i]['text'], $date);

            if (!$duplicate_found) {

                $id = create_guid();

                $sql = "INSERT INTO sugarfeed (id, name, date_entered, date_modified, modified_user_id, created_by, description, deleted, assigned_user_id, related_module, related_id, link_url, link_type)
                    VALUES
                     ('" . $id . "',
                      '" . $image . "<b>" . $tweets[$i]['user']['name'] . " </b>',
                      '" . $date . "',
                      '" . $date . "',
                      '1',
                      '1',
                      '" . $tweets[$i]['text'] . "',
                      '0',
                      '" . $current_user->id . "',
                      'twitter',
                      '" . $current_user->id . "',
                      NULL,
                      NULL);";
                $results = $db->query($sql);

                $i++;
            } else {
                $i++;
            }
        }
    }

}

$facebook_enabled = check_enabled($db, 'facebook');

if ($facebook_enabled) {

    require_once("include/social/facebook/facebook.class.php");

    $facebook_helper = new facebook_helper();

    //get current user logged in
    $user = $facebook_helper->facebook->getUser();

    $user_home = check_facebook_login($facebook_helper);

    if ($user) {
        $logoutUrl = $facebook_helper->get_logout_url();
    } else {
        $loginUrl = $facebook_helper->get_login_url($_REQUEST['url']);
    }

    if ($user) {
       // $log = '<a class="button" href="' . $logoutUrl . '">Facebook Logout</a>';
    } else {;
        $log = '<a class="button" href="' . $loginUrl . '">Facebook Login</a>';
    }

    $html .= '<span>';
    $html .= $log;
    $html .= '</span>';

    if (isset($user_home['data'])) { // Check to prevent Undefined index error
        foreach ($user_home['data'] as $single) {
            data_insert($single, "facebook");
        }
    }

}
    function check_facebook_login($facebook_helper)
    {
        $user = $facebook_helper->facebook->getUser();

        if ($user) {

            $user_profile = $facebook_helper->get_my_user(); //get my user details

            $user_home = $facebook_helper->get_my_newsfeed(); //gets my newsfeed,
        }


        if ($user) {
            $logoutUrl = $facebook_helper->get_logout_url();
        } else {
            $loginUrl = $facebook_helper->get_login_url($url);
        }

        return $user_home;
    }

    function data_insert($single, $type)
    {
        global $db;
        $id = guid_maker();
        $temp = generate_stream($single);
        $message = $db->quote($temp[1]);
        $name = $db->quote($temp[0]);
        $assigned_user = '1';
        $date = date("Y-m-d H:i:s", strtotime($single['created_time']));


        $sql_check = "SELECT * FROM sugarfeed WHERE description = '" . $message . "' AND date_entered = '" . $date . "'";
        $results = $db->query($sql_check);

        while ($row = $db->fetchByAssoc($results)) {
            $found_record = $row;
            break;
        }
        if (empty($found_record)) {
            $sql = "INSERT INTO sugarfeed (id, name, date_entered, date_modified, modified_user_id, created_by, description, deleted, assigned_user_id, related_module, related_id, link_url, link_type)
                    VALUES
                     ('" . $id . "',
                      '" . $name . "',
                      '" . $date . "',
                      '" . $date . "',
                      '1',
                      '1',
                      '" . $message . "',
                      '0',
                      '" . $assigned_user . "',
                      '" . $type . "',
                      '" . $assigned_user . "',
                      NULL,
                      NULL);";

            if (!empty($message)) {
                $results = $db->query($sql);
            }
        }
    }

    function guid_maker()
    {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand((double)microtime() * 10000); //optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);
            $uuid = chr(123)
                . substr($charid, 0, 8) . $hyphen
                . substr($charid, 8, 4) . $hyphen
                . substr($charid, 12, 4) . $hyphen
                . substr($charid, 16, 4) . $hyphen
                . substr($charid, 20, 12)
                . chr(125);
            return $uuid;
        }
    }

    function generate_stream($stream)
    {
        // Fix to prevent undefined index notice
        if (!isset($stream['type'])) {
            $stream['type'] = "";
        }
        
        //if simple post
        switch ($stream['type']) {
            case "":
                $string[1] = "<a href=http://www.facebook.com/" . $stream['from']['id'] . ">" . $stream['from']['name'] . "<a/> - " . substr($stream['message'], 0, 100);
                break;
            case "link";
                $string[0] = "<img style=float:left;padding-right:5px;padding-bottom:5px; src=http://graph.facebook.com/" . $stream['from']['id'] . "/picture />";
                if (!empty($stream['name'])) {

                    $string[1] = '<b>' . $stream['from']['name']. '</b><p style=line-height:30px;>' .  $stream['name']  . '</p>' . '<a href=' . $stream['link'] . '>View article</a>';
                } else {
                    //must be an article
                    $string[1] = '<b>' . $stream['from']['name']. '</b>' . "  <a href=" . $stream['actions']['0']['link'] . ">likes an article</a>";
                }
                break;
            case "status":
                //
                $string[0] = "<img style=float:left;padding-right:5px;padding-bottom:5px; src=http://graph.facebook.com/" . $stream['from']['id'] . "/picture />";
                if (!empty($stream['story'])) {
                    $string[1] = '<b>' . $stream['from']['name']. '</b><p style=line-height:30px;>' . substr($stream['story'], 0, 100) . "</p><a href=" . $stream['actions']['0']['link'] . ">View post on Facebook</a>";
                } else {
                    //wall post.
                    $string[1] = '<b>' . $stream['from']['name'] . '</b><p style=line-height:30px;>' . substr($stream['message'], 0, 100) . "</p><a href=" . $stream['actions']['0']['link'] .">View post on Facebook</a>";
                }
                break;
            case "photos":
                break;
        }
        return $string;
    }

