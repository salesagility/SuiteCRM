<?php
/**
 * Created by PhpStorm.
 * User: lewis
 * Date: 16/02/15
 * Time: 15:42
 */


if($_SESSION['screen_height'] != $_POST['height'] || $_SESSION['screen_width'] != $_POST['width']){
    $_SESSION['screen_height'] = $_POST['height'];
    $_SESSION['screen_width'] = $_POST['width'];
}

