<?php
/**
 * Created by PhpStorm.
 * User: lewis
 * Date: 16/02/15
 * Time: 15:42
 */


if(
    (isset($_SESSION['screen_height']) ? $_SESSION['screen_height'] : null) != (isset($_POST['height']) ? $_POST['height'] : null) ||
    (isset($_SESSION['screen_width']) ? $_SESSION['screen_width'] : null) != (isset($_POST['width']) ? $_POST['width'] : null)) {
    $_SESSION['screen_height'] = $_POST['height'];
    $_SESSION['screen_width'] = $_POST['width'];
}

