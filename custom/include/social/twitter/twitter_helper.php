<?php

function check_enabled($db, $type)
{

    $query = "SELECT * FROM `config` where name = 'module_" . $type . "' and value =  1;";
    $results = $db->query($query);

    while ($row = $db->fetchByAssoc($results)) {
        return true;
        break;
    }
}


function format_feed_tweets($db, $array, $limit)
{

    if (strlen($array['text']) > $limit) {
        $array['text'] = '<br /><p style=line-height:30px;>' . substr($array['text'], 0, $limit) . '. . .<br /><a href=https://twitter.com/' . $array['user']['screen_name'] . '/status/' . $array['id'] . '>View full Tweet</a></p>';

    } else {
        $array['text'] = '<br /><p style=line-height:30px;>' . $array['text'] . '<br /><a href=https://twitter.com/' . $array['user']['screen_name'] . '/status/' . $array['id'] . '>View on Twitter</a></p>';

    }

    $array['text'] = $db->quote($array['text']);

    return $array['text'];

}

function replace_hashtags($db, $array)
{

    $i = 0;
    $count = count($array['entities']['hashtags']);

    while ($i < $count) {

        $array['text'] = str_replace('#' . $array['entities']['hashtags'][$i]['text'], "<a href=http://twitter.com/#" . $array['entities']['hashtags'][$i]['text'] . ">" . "#" . $array['entities']['hashtags'][$i]['text'] . "</a>", $array['text']);
        $i++;
    }

    return $array['text'];

}

function replace_users($db, $array)
{

    $i = 0;
    $count = count($array['entities']['user_mentions']);

    while ($i < $count) {

        $array['text'] = str_replace('@' . $array['entities']['user_mentions'][$i]['screen_name'], "<a href=http://twitter.com/" . $array['entities']['user_mentions'][$i]['screen_name'] . ">" . "@" . $array['entities']['user_mentions'][$i]['screen_name'] . "</a>", $array['text']);
        $i++;
    }

    return $array['text'];


}

function duplicate_check($db, $text, $date)
{

    $sql_check = "SELECT * FROM sugarfeed WHERE description = '" . $text . "' AND date_entered = '" . $date . "'";
    $results = $db->query($sql_check);

    while ($row = $db->fetchByAssoc($results)) {
        return true;
        break;
    }

    return false;
}

function check_auth($url)
{

    $url = $url . "/custom/include/social/twitter/twitter_auth/callback.php";

    $config = '';

    require_once('custom/include/social/twitter/twitter_auth/twitteroauth/twitteroauth.php');
    require('custom/modules/Connectors/connectors/sources/ext/rest/twitter/config.php');


    $settings = array(
        'consumer_key' => $config['properties']['consumer_key'],
        'consumer_secret' => $config['properties']['consumer_secret'],

    );

    /* Build TwitterOAuth object with client credentials. */
    $connection = new TwitterOAuth($settings['consumer_key'], $settings['consumer_secret']);

    /* Get temporary credentials. */
    $request_token = $connection->getRequestToken($url);

    /* Save temporary credentials to session. */
    $_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
    $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

    $html = '';

    /* Build authorize URL and redirect user to Twitter. */
    $url = $connection->getAuthorizeURL($token);
    $html = "<a class='button' href='" . $url . "'>Log into Twitter</a>";

    $_REQUEST['html'] = $html;
    $_REQUEST['request_token'] = $request_token;

    return $connection;


}