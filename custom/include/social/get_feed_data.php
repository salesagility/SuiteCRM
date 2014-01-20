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

/* If access tokens are not available redirect to connect page. */
if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
    if ($settings['consumer_key'] === '' || $settings['consumer_secret'] === '') {
        echo 'You need a consumer key and secret to test the sample code. Get one from <a href="https://dev.twitter.com/apps">dev.twitter.com/apps</a>';
        exit;
    }
    /* Build TwitterOAuth object with client credentials. */
    $connection = new TwitterOAuth($settings['consumer_key'], $settings['consumer_secret']);

    /* Get temporary credentials. */
    $request_token = $connection->getRequestToken($settings['call_back_url']);

    /* Save temporary credentials to session. */
    $_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
    $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

    /* If last connection failed don't display authorization link. */
    switch ($connection->http_code) {
        case 200:
            /* Build authorize URL and redirect user to Twitter. */
            $url = $connection->getAuthorizeURL($token);
            header('Location: ' . $url);
            break;
        default:
            /* Show notification if something went wrong. */
            echo 'Could not connect to Twitter. Refresh the page or try again later.';
    }
}
/* Get user access tokens out of the session. */
$access_token = $_SESSION['access_token'];

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


$facebook_helper = new facebook_helper();
//get current user logged in
$user = $facebook_helper->facebook->getUser();

$user_home = check_facebook_login($facebook_helper);

if ($user) {
    $logoutUrl = $facebook_helper->get_logout_url();
} else {
    $loginUrl = $facebook_helper->get_login_url($_REQUEST['url']);
}

if ($user){
    $log = '<a href="' . $logoutUrl . '">Logout with Facebook</a>';
}else{
    //if not loged in
    $log = '<a href="' . $loginUrl .'">Login with Facebook</a>';
}

$html =  '<div>';
$html .=  $log;
$html .= '</div>';

foreach($user_home['data'] as $single){
    data_insert($single, "facebook");
}

