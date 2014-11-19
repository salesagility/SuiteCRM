<?php
ini_set('display_errors',1);
chdir('../../..');
require_once('AOPConfigAPI.php');
$webservice_path = 'service/core/SugarRestService.php';
$webservice_class = 'SugarRestService';
$webservice_impl_class = 'AOPConfigAPI';
$registry_path = 'custom/service/v4_1_custom/registry.php';
$registry_class = 'registry_v4_1_custom';
$location = 'custom/service/v4_1_custom/rest.php';
require_once('service/core/webservice.php');
?>