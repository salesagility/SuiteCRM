<?php

$vcap_services = json_decode($_ENV["VCAP_SERVICES" ]);
$vcap_db = $vcap_services->{'aws-rds'}[0]->credentials;

/***CONFIGURATOR***/

$sugar_config['disable_persistent_connections'] = false;

$sugar_config['dbconfig']['db_type'] = 'mysql';
$sugar_config['dbconfig']['db_name'] = $vcap_db->db_name;
$sugar_config['dbconfig']['db_user_name'] = $vcap_db->username;
$sugar_config['dbconfig']['db_password'] = $vcap_db->password;
$sugar_config['dbconfig']['db_host_name'] = $vcap_db->host;
$sugar_config['dbconfig']['db_port'] = $vcap_db->port;
$sugar_config['dbconfig']['db_host_instance'] = 'SQLEXPRESS';
$sugar_config['dbconfig']['db_manager'] = 'MysqliManager';

/***CONFIGURATOR***/
?>
