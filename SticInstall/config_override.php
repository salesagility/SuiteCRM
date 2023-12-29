<?php
// START of Mail Merge Reports configuration
$sugar_config['DHA_templates_default_lang'] = '@@SHORT_LANGUAGE_CODE@@'; // [es|ca|gl|en ....]
$sugar_config['DHA_templates_dir'] = 'document_templates/';
$sugar_config['DHA_OpenOffice_exe'] = '';
$sugar_config['DHA_OpenOffice_cde'] = '';
$sugar_config['DHA_OpenOffice_HOME'] = '';
// END of Mail Merge Reports configuration

// START of Kreports configuration
$sugar_config['KReports']['authCheck'] = 'SecurityGroups';
// END of Kreports configuration

// START of configuration details for SinergiaCRM
$sugar_config['datef'] = 'd/m/Y';
$sugar_config['dbconfig']['db_host_name'] = '@@DB_HOST_NAME@@'; 
$sugar_config['dbconfig']['db_host_instance'] = 'SQLEXPRESS';
$sugar_config['dbconfig']['db_user_name'] = '@@DB_USER_NAME@@'; 
$sugar_config['dbconfig']['db_password'] = '@@DB_PASSWORD@@';
$sugar_config['dbconfig']['db_name'] = '@@DB_NAME@@';
$sugar_config['dbconfig']['db_type'] = 'mysql';
$sugar_config['dbconfig']['db_port'] = '@@DB_PORT@@'; // Empty string is default 3306 port
$sugar_config['dbconfig']['db_manager'] = 'MysqliManager';

$sugar_config['default_language'] = '@@DEFAULT_LANGUAGE@@'; // Full language code [es_ES|ca_ES|gl_ES|en_us|...]
$sugar_config['default_locale_name_format'] = 'f l';
$sugar_config['default_permissions']['dir_mode'] = 1533;
$sugar_config['default_permissions']['file_mode'] = 436;
$sugar_config['default_permissions']['user'] = '@@WEB_SYSTEM_USER@@'; // System user with access to installation files. Usually www-data
$sugar_config['default_permissions']['group'] = '@@WEB_SYSTEM_GROUP@@'; // System group with access to installation files. Usually www-data

$sugar_config['host_name'] = '@@HOST_NAME@@'; // subdomain.domain.org
$sugar_config['site_url'] = '@@SITE_URL@@'; // https://subdomain.domain.org/
$sugar_config['unique_key'] = '@@UNIQUE_KEY@@'; // 32 alphanumeric characters. Only lowercase letters and numbers, example: '5nuns3c1te64tkjfr6thv4q0elxlwe8d'
$sugar_config['cron']['allowed_cron_users'][] = '@@WEB_SYSTEM_USER@@'; // System user with access to installation files. Usually www-data
$sugar_config['stic_install_locked'] = true; // Deactivate to allow installation through SticInstall.php
// END of configuration
