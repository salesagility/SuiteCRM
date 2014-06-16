<?php

/*
 * @author Salesagility Ltd <support@salesagility.com>
 * Date: 15/01/14
 * Time: 09:14
 */


//Grab the twitter and facebook values from the request.

$social = $_REQUEST['social'];
$twitter_user = $_REQUEST['twitter_user'];

if(!empty($_REQUEST['code'])){
    include_once("config.php");
    //nasty way of fixing the facebook login bug.
    header("Location: " . $sugar_config['site_url'] . "?module=" . $_REQUEST['module'] . "&action=DetailView&record=" . $_REQUEST['record'] . "&");
}

//If its facebook or twitter call the relevent file.
    switch($social){

        case "facebook":
            require_once("custom/include/social/facebook/facebookapi.php");
            break;
        case "twitter";
            require_once("custom/include/social/twitter/twitterapi.php");
            break;
    }
