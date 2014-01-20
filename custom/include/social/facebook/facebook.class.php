<?php
require_once("custom/include/social/facebook/facebook_sdk/src/facebook.php");


class facebook_helper{

    var $facebook;

    function __construct() {
        require("custom/modules/Connectors/connectors/sources/ext/rest/facebookAPI/config.php");

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
        }
    }
    function photo_status($story){

        $string = '<tr>
                        <td>
                            <div class="fb_bubble">
                            <span  class="facebook_img "><a href="' . $story['link'] . '"><img width="20%" src="' . $story['picture'] . '"/></a></span>
                            <span class="facebook_story">' . $story['story'] . '</span>
                            </div>

                        </td>
                        <td ><div class="fb_bubble">' . date("y/m/d H:m", strtotime($story['updated_time'])) . '</div></td>
                   </tr>';


        return $string;
    }

    function status($story){

        $string = '<tr>
                        <td>
                        <div class="fb_bubble">
                            <span class="facebook_story">' . $story['story'] . '</span>
                            <span>' . '</span>
                        </div>
                          </td>
                        <td><div class="fb_bubble">' . date("y/m/d H:m", strtotime($story['updated_time'])) . '</div></td>

                   </tr>';


        return $string;
    }
    function link_type($story){
        $string = '<tr>
                        <td>
                        <div class="fb_bubble">
                        <span class="facebook_img" ><a href="' . $story['link'] . '"><img width="20%" src="' . $story['picture'] . '"/></a></span>';
                        if($story['name']){
                            $string .= '<span class="facebook_name">' . $story['name'] . '<br></span>';
                        }else{
                            $string .= '<span class="facebook_name">' . $story['story'] . '<br></span>';
                        }

        $string .= '<span class="facebook_message">' . $story['message'] . '</span>
                        </div>
                        </td>
                        <td><div class="fb_bubble">' . date("y/m/d H:m", strtotime($story['updated_time'])) . '</div></td>
                   </tr>';


        return $string;
    }
}
?>