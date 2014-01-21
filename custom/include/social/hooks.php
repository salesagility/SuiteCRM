<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 16/01/14
 * Time: 16:26
 */


class hooks{

    function load_js($bean, $event, $arguments){
        $mapping = '';
        $facebook = false;

        if($_REQUEST['action'] == 'DetailView'){
            include("custom/modules/Connectors/connectors/sources/ext/rest/facebookAPI/mapping.php");
            if(array_key_exists($_REQUEST['module'], $mapping['beans'])){
                echo '<script src="custom/include/social/social_feeds.js"></script>';
                echo '<script src="custom/include/social/facebook/facebook.js"></script>';
                $facebook = true;
            }

            $mapping = '';
            include('custom/modules/Connectors/connectors/sources/ext/rest/twitter/mapping.php');
            if(array_key_exists($_REQUEST['module'], $mapping['beans'])){
                if($facebook == false){
                    echo '<script src="custom/include/social/social_feeds.js"></script>';
                }
               echo '<script src="custom/include/social/twitter/twitter.js"></script>';
            }
        }
    }

}

