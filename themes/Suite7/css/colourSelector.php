<?php

// config|_override.php
if(is_file('../../../config.php')) {
    require_once('../../../config.php'); // provides $sugar_config
}

// load up the config_override.php file.  This is used to provide default user settings
if(is_file('../../../config_override.php')) {
    require_once('../../../config_override.php');
}
header("Content-type: text/css; charset: UTF-8");

?>

#header {

background:<?php

    if (!empty($sugar_config['colourselector']['menu'])) {
        echo $sugar_config['colourselector']['menu'];}
    else {
        echo '#121212';
    }
?>;

}