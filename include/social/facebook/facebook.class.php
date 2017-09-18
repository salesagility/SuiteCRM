<?php
require_once("include/social/facebook/facebook_sdk/src/facebook.php");


class facebook_helper{

    var $facebook;

    function __construct() {
        require_once("custom/modules/Connectors/connectors/sources/ext/rest/facebook/config.php");

        $fb_config = array(
            'appId' => $config['properties']['appid'],
            'secret' => $config['properties']['secret']
        );
        $this->facebook = new Facebook($fb_config);
    }
    function get_my_user(){
        try {
            // Proceed knowing you have a logged in user who's authenticated.
            return $this->facebook->api('/me');
        } catch (FacebookApiException $e) {
            error_log($e);
            $user = null;
        }
    }
    function get_my_newsfeed(){
        return $this->facebook->api('me/home'); //get my news feed
    }
    function get_other_newsfeed($user, $limit = "100"){
        return $this->facebook->api('/' . $user . '/feed?limit=' . $limit);
    }
    function get_login_url($url){
        $params = array(
            'scope' => 'read_stream, publish_stream'

            );


        return $this->facebook->getLoginUrl($params);
    }
    function get_logout_url(){
        return $this->facebook->getLogoutUrl();
    }
    function get_facebook_user($username){
        return $this->facebook->api('/' . $username);
    }

    function process_feed($story){
        switch($story['type']){
            case "status":
                return $this->status($story);
                break;
            case "photo":
                return $this->photo_status($story);
                break;
            case "link":
                return $this->link_type($story);
                break;
            case "video":
                return $this->video_type($story);
                break;
        }
    }

    function photo_status($story){


        $string .= "<div style=' margin: 0 auto; background-color: #F7F7F7; height:160px; width:389px; ; border:1px solid #cccccc'>";
        $string .= '<div style="padding: 3px; width: 100%;">' .$story['from']['name'] . '</div>';
        $string .= '<img src=https://graph.facebook.com/' . $story['from']['id'] . '/picture>';
        $string .= '<img src=https://graph.facebook.com/' . $story['to']['id'] . '/picture>';
        $string .= '<p>' .$story['story'] .'</p>';
        $string .= '<p>' .$story['message'] .'</p>';
        $string .= "</div>";
        return $string;
    }

    function status($story){

        $to_name = $this->get_to($story);

        $string .= "<div style=' margin: 0 auto; background-color: #F7F7F7; height:160px; width:389px; ; border:1px solid #cccccc'>";
        $string .= '<div style="padding: 3px; width: 100%;">' .$story['from']['name'] . '</div>';

        if($story['status_type'] == 'approved_friend'){
            $string .= '<img src=https://graph.facebook.com/' . $story['story_tags']['0']['0']['id']. '/picture>';
            $string .= '<img src=https://graph.facebook.com/' . $story['story_tags']['18']['0']['id']. '/picture>';
        }else{
            $string .= '<img src=https://graph.facebook.com/' . $story['from']['id'] . '/picture>';
            $string .= '<img src=https://graph.facebook.com/' . $story['to']['id'] . '/picture>';
        }

        $string .= '<img src=https://graph.facebook.com/' . $story['story_tags']['0']['0']['id']. '/picture>';


        $string .= '<p>' .$story['story'] .'</p>';
        $string .= '<p>' .$story['message'] .'</p>';
        $string .= "</div>";

        return $string;


    }
    function link_type($story){
        $string .= "<div style='margin: 0 auto; background-color: #F7F7F7; height:160px; width:389px; ; border:1px solid #cccccc'>";
        $string .= '<div style="padding: 3px; width: 100%;">' . $story['message'] . '</div>';

        $string .= '<a style="padding: 5px; float:left;" href="' . $story['link'] . '"><img style=float:left; src="' . $story['picture'] . '"/></a>';
        $string .= '<a  href="' . $story['link'] . '">' .$story['description'] .'</a>';
        $string .= '<p>' . $story['caption'] . '</p>';
        $string .= "</div>";
        return $string;


    }

    function video_type($story){

        $string = '';
        $string .= "<div style=' margin: 0 auto; background-color: #F7F7F7; height:160px; width:389px; ; border:1px solid #cccccc'>";
        $string .= '<div style="padding: 3px; width: 100%;">' . $story['from']['name'] .' Shared a video with '. $story['message'] . '</div>';

        $string .= '<a style="padding: 5px; float:left;" href="' . $story['link'] . '"><img style=float:left; src="' . $story['picture'] . '"/></a>';
        $string .= '<a  href="' . $story['link'] . '">' .$story['description'] .'</a>';
        $string .= '<p>' . $story['caption'] . '</p>';
        $string .= "</div>";
        return $string;
    }

    function get_to($story){

        $value = '';

        foreach($story as $field => $value){
           if(isset($story[$field]['data'][0]['name'])){
               $value = $story['data']['0']['name'];
               break;
           }
            if($field == 'to'){
                $value = $story['data']['0']['name'];

                break;
            }
        }

        return $value;

    }
}
?>