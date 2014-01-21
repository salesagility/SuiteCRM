<?php

function replace_urls($db,$array)
{

    $i = 0;
    $count = count($array['entities']['urls']);
    while($i < $count) {

        $text = str_replace($array['entities']['urls'][$i]['url'], "<a href='" . $array['entities']['urls'][$i]['expanded_url'] . "'target='_blank'>" . $array['entities']['urls'][$i]['display_url'] . "</a> ", $array['text']);
        $text = $db->quote($text);
        $i++;
    }

    return $text;


}

function duplicate_check($db,$text,$date){

    $sql_check = "SELECT * FROM sugarfeed WHERE description = '" . $text . "' AND date_entered = '" . $date . "'";
    $results = $db->query($sql_check);

    while ($row = $db->fetchByAssoc($results)) {
        return true;
        break;
    }
}

function check_auth(){
    require_once('custom/include/social/twitter/twitter_auth/twitteroauth/twitteroauth.php');
    require('custom/modules/Connectors/connectors/sources/ext/rest/twitter/config.php');

    $settings = array(
        'oauth_access_token' => $config['properties']['oauth_access_token'],
        'oauth_access_token_secret' => $config['properties']['oauth_access_token_secret'],
        'consumer_key' => $config['properties']['consumer_key'],
        'consumer_secret' => $config['properties']['consumer_secret'],
        'call_back_url' => $config['properties']['OAUTH_CALLBACK'],
    );

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

        $html ='';

        /* Build authorize URL and redirect user to Twitter. */
        $url = $connection->getAuthorizeURL($token);
        $html = "<a href='". $url ."'>Log into Twitter</a>";

       $_REQUEST['html'] = $html;
       $_REQUEST['request_token'] = $request_token;

        return $connection;

    }
}