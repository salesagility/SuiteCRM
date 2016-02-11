<?php
require_once("include/social/facebook/facebook.class.php");

$facebook_helper = new facebook_helper();
//get current user logged in
$user = $facebook_helper->facebook->getUser();
//get requested user data.
$different_user = $facebook_helper->get_facebook_user($_REQUEST['username']);
//get the last XX posted.
$content = ($facebook_helper->get_other_newsfeed($_REQUEST['username'], "50"));

//check the user is logged in and generate the correct url if logged in or not.
if ($user) {
    $logoutUrl = $facebook_helper->get_logout_url();
} else {
    $loginUrl = $facebook_helper->get_login_url($_REQUEST['url']);
}

if ($user){
    $log = '<a href="' . $logoutUrl . '">Logout</a>';
}else{
    $log = '<a href="' . $loginUrl .'">Login with Facebook</a>';
}
$html .= "<div style='height:400px;overflow:scroll'><table width='100%'>";
$html .= "<tr><th><h3>Facebook Feed</h3></th></tr>";
$html .= "<tr><td style='padding:5px'><img src=https://graph.facebook.com/" . $different_user['username'] . "/picture>";
$html .= "<b style='margin-left:5px; font-size:20px;'>".$different_user['first_name'] .  " " . $different_user['last_name'] . "</b></td></tr>";
$html .= "</table>";



foreach($content['data'] as $story){

    if(!empty($results)){
        $html . $results;
    }
}

foreach($content['data'] as $story){

        $html .= "<div style='width:30%;float:left;padding:25px;height:160px;'>";
        $results =  $facebook_helper->process_feed($story);
        $html .=  "<p style='text-align:center;'>". $results."</p>";
        $html .= "</div>";


}
echo $html;