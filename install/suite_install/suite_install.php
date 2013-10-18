<?php

require_once('suitecrm_version.php');

global $sugar_config;
$sugar_config['default_max_tabs'] = 10;
$sugar_config['suitecrm_version'] = $suitecrm_version;

ksort($sugar_config);
write_array_to_file('sugar_config', $sugar_config, 'config.php');

require_once('install/suite_install/AdvancedOpenWorkflow.php');
install_aow();

require_once('install/suite_install/AdvancedOpenSales.php');
install_aos();

require_once('install/suite_install/AdvancedOpenPortal.php');
install_aop();

require_once('install/suite_install/SecurityGroups.php');
install_ss();

require_once('install/suite_install/GoogleMaps.php');
install_gmaps();