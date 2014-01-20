<?php

require("custom/include/social/facebook/facebook.class.php");
require_once('custom/include/social/twitter/twitter_auth/twitteroauth/twitteroauth.php');
require('custom/modules/Connectors/connectors/sources/ext/rest/twitter/config.php');

global $db;
global $current_user;

$settings = array(
    'oauth_access_token' => $config['properties']['oauth_access_token'],
    'oauth_access_token_secret' => $config['properties']['oauth_access_token_secret'],
    'consumer_key' => $config['properties']['consumer_key'],
    'consumer_secret' => $config['properties']['consumer_secret'],
    'call_back_url' => $config['properties']['OAUTH_CALLBACK'],
);

session_start();

/* Create a TwitterOauth object with consumer/user tokens. */
$connection = new TwitterOAuth($settings['consumer_key'], $settings['consumer_secret'], $access_token['oauth_token'], $access_token['oauth_token_secret']);

/* If method is set change API call made. Test is called by default. */
$tweets = $connection->get('statuses/home_timeline', array('screen_name' => $content['screen_name'], 'exclude_replies ' => true));

$i = 0;
$assigned_user = $current_user->id;

if ($tweets) {
    while ($i < count($tweets)) {


        if (count($tweets[$i]['entities']['urls'][0]['url']) != '') {
            $tweets[$i]['text'] = str_replace($tweets[$i]['entities']['urls'][0]['url'], "<a href='" . $tweets[$i]['entities']['urls'][0]['expanded_url'] . "'target='_blank'>" . $tweets[$i]['entities']['urls'][0]['display_url'] . "</a> ", $tweets[$i]['text']);
            $tweets[$i]['text'] = $db->quote($tweets[$i]['text']);

        }

        $date = date("Y-m-d H:i:s", strtotime($tweets[$i]['created_at']));
        $sql_check = "SELECT * FROM sugarfeed WHERE description = '" . $tweets[$i]['text'] . "' AND date_entered = '" . $date . "'";
        $results = $db->query($sql_check);

        while ($row = $db->fetchByAssoc($results)) {
            $found_record = $row;

            break;
        }
        if (empty($found_record)) {

            $id = create_guid();

            $sql = "INSERT INTO sugarfeed (id, name, date_entered, date_modified, modified_user_id, created_by, description, deleted, assigned_user_id, related_module, related_id, link_url, link_type)
                    VALUES
                     ('" . $id . "',
                      '<b>" . $tweets[$i]['user']['name'] . " </b>',
                      '" . $date . "',
                      '" . $date . "',
                      '1',
                      '1',
                      '" . $tweets[$i]['text'] . "',
                      '0',
                      '" . $assigned_user . "',
                      'UserFeed',
                      '" . $assigned_user . "',
                      NULL,
                      NULL);";
            $results = $db->query($sql);

            $sql2 = "INSERT INTO sugarfeed_cstm WHERE (id_c, social_c) values ('" . $id . "','twitter');";
            $results = $db->query($sql2);

            $i++;
        }else{
            $i++;
        }
    }
}

$facebook_helper = new facebook_helper();

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


//$single = $user_home['data'][0];

foreach ($user_home['data'] as $single) {
    $id = guid_maker();
    $message = $db->quote(generate_stream($single));
    $assigned_user = '1';

    $date = date("Y-m-d H:m:s", strtotime($single['created_time']));

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
                      NULL,
                      '" . $date . "',
                      '" . $date . "',
                      '1',
                      '1',
                      '" . $message . "',
                      '0',
                      '" . $assigned_user . "',
                      'UserFeed',
                      '" . $assigned_user . "',
                      NULL,
                      NULL);";

        if (!empty($message)) {
            $results = $db->query($sql);
            $sql2 = "INSERT INTO sugarfeed_cstm WHERE (id_c, social_c) values ('" . $id . "','facebook');";
            $results = $db->query($sql2);
        }
    }
}

//print_r($user_home);

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

    //if simple post
    if ($stream['from']['name'] == "Gina Scott") {
        $var = "asd";
    }
    switch ($stream['type']) {

        case "":
            $string = "<a href=http://www.facebook.com/" . $stream['from']['id'] . ">" . $stream['from']['name'] . "<a/> - " . $stream['message'];
            break;
        case "link";
            $string = "<a href=http://www.facebook.com/" . $stream['from']['id'] . ">" . $stream['from']['name'] . "<a/> -  <a href=" . $stream['link'] . ">" . $stream['name'] . "</a>";
            break;
        case "status":
            //
            if (!empty($stream['story'])) {
                $string = "<a href=http://www.facebook.com/" . $stream['from']['id'] . ">" . $stream['from']['name'] . "<a/> - <a href=" . $stream['actions']['0']['link'] . ">" . $stream['story'] . "</a>";
            } else {
                //wall post.
                $string = "<a href=http://www.facebook.com/" . $stream['from']['id'] . ">" . $stream['from']['name'] . "<a/> - <a href=" . $stream['actions']['0']['link'] . ">" . $stream['message'] . "</a>";
            }
            break;
        case "photos":
            break;
    }


    return $string;

}

