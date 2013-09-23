<?php
 if(!defined('sugarEntry'))define('sugarEntry', true);


/**
 * This is a rest entry point for rest version Sugar 6.5 +
 */
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Allow-Credentials: true");
require_once('../../service/v4_1/rest.php');
