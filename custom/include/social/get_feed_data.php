<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 15/01/14
 * Time: 09:14
 */

require("custom/include/social/facebook/facebook.class.php");

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























function check_facebook_login($facebook_helper){
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

    return $user_home;
}

function data_insert($single, $type){
    global $db;
    $id = guid_maker();
    $message = $db->quote(generate_stream($single));
    $assigned_user = '1';
    $date = date("Y-m-d H:i:s", strtotime($single['created_time']));


    $sql_check = "SELECT * FROM sugarfeed WHERE description = '" . $message . "' AND date_entered = '" . $date . "'";
    $results = $db->query($sql_check);

    while ($row = $db->fetchByAssoc($results)){
        $found_record = $row;
        break;
    }
    if(empty($found_record)){
        $sql = "INSERT INTO sugarfeed (id, name, date_entered, date_modified, modified_user_id, created_by, description, deleted, assigned_user_id, related_module, related_id, link_url, link_type)
                    VALUES
                     ('" . $id ."',
                      NULL,
                      '" . $date . "',
                      '" . $date . "',
                      '1',
                      '1',
                      '" . $message . "',
                      '0',
                      '" . $assigned_user . "',
                      '" . $type . "',
                      '" . $assigned_user ."',
                      NULL,
                      NULL);";

        if(!empty($message)){
            $results = $db->query($sql);
        }
    }
}
//print_r($user_home);
function guid_maker(){
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }else{
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);
        $uuid = chr(123)
            .substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12)
            .chr(125);
        return $uuid;
    }
}
function generate_stream($stream){
    //if simple post
    switch($stream['type']){

        case "":
            $string = "<a href=http://www.facebook.com/". $stream['from']['id'] . ">" . $stream['from']['name'] . "<a/> - " . substr($stream['message'], 0, 100);
            break;
        case "link";
            if(!empty($stream['name'])){
                $string = "<a href=http://www.facebook.com/". $stream['from']['id'] . ">" . $stream['from']['name'] . "<a/> -  <a href=" . $stream['link'] . ">" . $stream['name'] . "</a>";
            }else{
                //must be an article
                $string = "<a href=http://www.facebook.com/". $stream['from']['id'] . ">" . $stream['from']['name'] . "<a/> -  <a href=" . $stream['actions']['0']['link'] . ">likes an article</a>";
            }
            break;
        case "status":
            //
            if(!empty($stream['story'])){
                $string = "<a href=http://www.facebook.com/". $stream['from']['id'] . ">" . $stream['from']['name'] . "<a/> - <a href=" . $stream['actions']['0']['link'] . ">" . substr($stream['story'], 0, 100) . "</a>";
            }else{
                //wall post.
                $string = "<a href=http://www.facebook.com/". $stream['from']['id'] . ">" . $stream['from']['name'] . "<a/> - <a href=" . $stream['actions']['0']['link'] . ">" . substr($stream['message'], 0, 100) . "</a>";
            }
            break;
        case "photos":
            break;
    }
    return $string;
}