<?php
/**
 * Created by PhpStorm.
 * User: lewis
 * Date: 20/01/14
 * Time: 14:37
 */


function auth_twitter(){
    $config = '';

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

        /* If last connection failed don't display authorization link. */

                /* Build authorize URL and redirect user to Twitter. */

                $html ='';

                $url = $connection->getAuthorizeURL($token);
                $html = "<a href='". $url ."'>Log into Twitter</a>";




    }
    return $html;

}