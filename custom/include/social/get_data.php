<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 14/01/14
 * Time: 16:08
 */

$social = $_REQUEST['social'];
$twitter_user = $_REQUEST['twitter_user'];

if(!empty($_REQUEST['code'])){
    include("config.php");
    //nasty way of fixing the facebook login bug.
    header("Location: " . $sugar_config['site_url'] . "?module=" . $_REQUEST['module'] . "&action=DetailView&record=" . $_REQUEST['record'] . "&");
}
    switch($social){

        case "facebook":
            require("custom/include/social/facebook/facebookapi.php");
            break;
        case "twitter";
            require("custom/include/social/twitter/twitter_process.php");
            break;
    }
