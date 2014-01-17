<?php

global $sugar_config;
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