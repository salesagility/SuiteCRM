<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Allow-Credentials: true");

ob_clean();
if ($_REQUEST['param']=='plugin') {
	echo file_get_contents('mobile/plugins/'.$_REQUEST['name'],true);
}
elseif ($_REQUEST['param']=='custom') {
	echo file_get_contents('custom/QuickCRM/custom.js',true);
}
else {
	$prefix='QuickCRM_';
	if (isset($_REQUEST['trial'])) $prefix .= 'trial';
	require_once('modules/Administration/Administration.php');
	$admin = new Administration();
	$admin->retrieveSettings($prefix); // load all settings from db
	
	if (isset($admin->settings[$prefix.$_REQUEST['param'].'f']) && $admin->settings[$prefix.$_REQUEST['param'].'f']=='1'){
		$f='mobile'.(isset($_REQUEST['trial'])?'_trial':'').'/fielddefs/';
		echo file_get_contents($f.$_REQUEST['param'].'.js',true);
	}
	else {
		echo base64_decode($admin->settings[$prefix.$_REQUEST['param']]);
	}
}
die;
