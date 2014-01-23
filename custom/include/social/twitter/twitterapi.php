<?php

/*
 * @author Salesagility Ltd <support@salesagility.com>
 * Date: 15/01/14
 * Time: 09:14
 *
 * This file uses the developer account set up in the connectors to generate the feed.
 *
 */

require_once('custom/include/social/twitter/twitter_auth/twitteroauth/twitteroauth.php');
require('custom/modules/Connectors/connectors/sources/ext/rest/twitter/config.php');
require('custom/include/social/twitter/twitter_helper.php');

global $sugar_config;

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

$formatted_display = format_tweets($tweets);

echo $formatted_display;


function format_tweets($tweets){
    $i = 0;
    $html ='';
    $html = "<link rel='stylesheet' type='text/css' href='custom/include/social/twitter/twitter.css'>";


    $html .= "<div style='height:400px;overflow:scroll'><table width='100%'>";
    $html .= '<tr><th style="text-align:center">Twitter Activity</th><th style="text-align:center"></th></tr>';
    $html .= "<tr><td style='text-align:center'>" . $tweets[0]['user']['name'] ."</td><td style='text-align:center'><img src='". $tweets[0]['user']['profile_image_url'] ."'></td></tr>";
    $html .= "</table>";

    while($i < count($tweets)){
        $html .= "<div class='tweet'>";
        $html .= "<p>". $tweets[$i]['text']."</p>";
        $html .= "</div>";
        $i++;
    }
    return $html . '</div>';

}