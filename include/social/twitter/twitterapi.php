<?php

/*
 * @author Salesagility Ltd <support@salesagility.com>
 * Date: 15/01/14
 * Time: 09:14
 *
 * This file uses the developer account set up in the connectors to generate the feed.
 *
 */

require_once('include/social/twitter/twitter_auth/twitteroauth/twitteroauth.php');
require_once('modules/Connectors/connectors/sources/ext/rest/twitter/config.php');
require_once('include/social/twitter/twitter_helper.php');

global $sugar_config, $db;

/*
 * Pull in connector settings for creating the authentication between Suite and Twitter.
 * If these settings are blank check the connector and make sure the setting are correct.
*/

$settings = array(
    'consumer_key' => $config['properties']['consumer_key'],
    'consumer_secret' => $config['properties']['consumer_secret'],
);

//Check if we are already authenticated.
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
$tweets = $connection->get('statuses/user_timeline', array('screen_name' => $_REQUEST['twitter_user']));

$formatted_display = format_tweets($db,$tweets);

echo $formatted_display;


function format_tweets($db,$tweets){


    $i = 0;
    $html ='';
//    $html = "<link rel='stylesheet' type='text/css' href='include/social/twitter/twitter.css'>";


    $html .= "<div style='height:400px;overflow:scroll'><table width='100%'>";
    $html .= '<tr><th><h3>20 Latest Tweets</h3></th></tr>';
    $html .= "<tr><td><img style='padding:5px;'; src='". $tweets[0]['user']['profile_image_url'] ."'><b style='margin-left:5px; font-size:20px;'>" ."@". $tweets[0]['user']['screen_name'] ."</b></td></tr>";
    $html .= "</table>";


    foreach($tweets as $tweet){

        $limit = 255;

        $tweet['text'] = format_feed_tweets($db,$tweet, $limit);

        if (count($tweet['entities']['hashtags']) > 0) {
            $tweets['text'] = replace_hashtags($db, $tweet);
        }
        if (count($tweet['entities']['user_mentions']) > 0) {
            $tweet['text'] = replace_users($db, $tweet);
        }

        $html .= "<div class='tweet' style='width:30%;float:left;padding:25px;height:100px;'>";
        $html .=  "<p>". $tweet['text']."</p>";
        $html .= "</div>";
        $i++;
    }

    return $html . '</div>';

}
