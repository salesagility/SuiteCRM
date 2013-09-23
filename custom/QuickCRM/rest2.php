<?php
 if(!defined('sugarEntry'))define('sugarEntry', true);


/**
 * This is a rest entry point for Sugar 6.0 and 6.1
 */
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Allow-Credentials: true");
require_once('../../service/v2/rest.php');
