<?php
require_once('TwitterAPIExchange.php');
require('custom/modules/Connectors/connectors/sources/ext/rest/twitter/config.php');


/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => $config['properties']['oauth_access_token'],
    'oauth_access_token_secret' => $config['properties']['oauth_access_token_secret'],
    'consumer_key' => $config['properties']['consumer_key'],
    'consumer_secret' => $config['properties']['consumer_secret'],
);
$limit = $config['properties']['max_number_of_tweets'];

$twitter_user = $_REQUEST['twitter_user'];
$type = 'user_timeline';

$tweets_json = request_tweets($settings,$twitter_user,$type);
$tweets = json_decode($tweets_json, true);

$display = display_tweets($tweets,$limit);
$formatted_display = format_tweets($display);

echo $formatted_display;

function request_tweets($settings,$twitter_user,$type){
    $url = 'https://api.twitter.com/1.1/statuses/' . $type .'.json';
    $getfield = "?screen_name=". $twitter_user ."";
    $requestMethod = 'GET';
    $twitter = new TwitterAPIExchange($settings);
    $tweets_json= $twitter->setGetfield($getfield)
        ->buildOauth($url, $requestMethod)
        ->performRequest();

    return $tweets_json;
}

function format_tweets($display){

    $html ='';
    $html = "<link rel='stylesheet' type='text/css' href='custom/include/social/twitter/twitter.css'>";


    $html .= "<div style='height:400px;overflow:scroll'><table width='100%'>";
    $html .= '<tr><th style="text-align:center">Twitter Activity</th><th style="text-align:center"></th></tr>';
    $html .= "<tr><td style='text-align:center'>" . $display['name'] ."</td><td style='text-align:center'><img src='". $display['picture'] ."'></td></tr>";
    $html .= "</table>";

    foreach($display['tweets'] as $tweet){
        $html .= "<div class='tweet'>";
        $html .= "<p>". $tweet."</p>";
        $html .= "</div>";
    }
    return $html . '</div>';

}


function display_tweets($tweets,$limit){
if(count($tweets) > 0){
    if(count($tweets) < $limit){
        $limit = count($tweets);
    }

    $i = 0;
    $display_tweets_array = array();

    $display_tweets_array['name'] = $tweets[$i]['user']['name'];
    $display_tweets_array['follow'] = $tweets[$i]['user']['url'];
    $display_tweets_array['picture'] = $tweets[$i]['user']['profile_image_url_https'];

    while($i < $limit){


        $display_tweets_array['tweets'][] =  $tweets[$i]['text'];

        if(count($tweets[$i]['entities']['urls']) != 0){

            $u = 0;
            while($u < count($tweets[$i]['entities']['urls'])){
                $display_tweets_array['tweets'][$i] = str_replace($tweets[$i]['entities']['urls'][0]['url'], "<a href='".$tweets[$i]['entities']['urls'][0]['expanded_url']."'>". $tweets[$i]['entities']['urls'][0]['display_url'] ."</a> ",$display_tweets_array['tweets'][$i]);
                $u++;
            }

        }
        $i++;
    }
    return $display_tweets_array;
}else{
    return false;
}






}
