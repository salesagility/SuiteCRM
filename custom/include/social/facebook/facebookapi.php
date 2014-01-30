<?php
require_once("custom/include/social/facebook/facebook.class.php");

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


echo '<div style="height:400px;overflow:scroll"><table width="100%">';
echo '<tr><th style="text-align:center">Facebook Activity</th><th style="text-align:center">' . $log . '</th></tr>';
echo '<tr>';
echo '<td style="text-align:center"><a href="' . $different_user['link'] . '">' . $different_user['first_name'] . ' ' . $different_user['last_name'] . ' (' . $different_user['username'] .')</a><br>
        ' . $different_user['gender']. ' <br>
        ' . $different_user['location']['name'] . '</td>';
echo '<td style="text-align:center"><img src="https://graph.facebook.com/' . $different_user['username'] . '/picture"></td>';
echo '</tr>';

foreach($content['data'] as $story){
    $results =  $facebook_helper->process_feed($story);
    if(!empty($results)){
        echo $results;
    }
}
echo '</table></div>';
?>
<style>
    .fb_bubble {
        border-bottom: 0 none;
        border-radius: 0;
        border-top: 1px solid #E8E8E8;
        cursor: default;
        font-size: 12px;
        min-height: 32px;
        padding: 9px 15px 12px;
    }
</style>