<?php
header("Content-type: text/css; charset: UTF-8");
global $sugar_config;
?>

#header {

background:<?php if (!empty($sugar_config)) {
    echo $sugar_config['colourselector']['menu'];
} ?>;

}