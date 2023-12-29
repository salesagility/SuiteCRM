<?php
// Removing PHP Warnings in output
error_reporting(0);
echo "<br>Starting SinergiaCRM Installation.<br>";

if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

if (!defined('SUGARCRM_IS_INSTALLING')) {
    define('SUGARCRM_IS_INSTALLING', true);
}

// Requiring this after defining SugarCRM constants (sugarEntry, SUGARCRM_IS_INSTALLING)
require_once 'modules/Administration/QuickRepairAndRebuild.php';

$adminPassword = 'admin'; // Password for the Admin user with ID 1
$sinergiaCRMPassword = 'sinergiacrm'; // Password for the SinergiaCRM Admin user with ID 2
$emailSinergiaCRM = 'test@test.com'; // Default email for the SinergiaCRM User
$emailCapsSinergiaCRM = 'TEST@TEST.COM'; // Default email for the SinergiaCRM User

// If config_override.php file doesn't exist, we can't continue installation
if (!is_file('config_override.php')) {
    die("A SuiteCRM configuration file (config_override.php) can't be found in the project path.
    <br>For new installations, please copy config_override.php from SticInstall/config_override.php into the root path (./),
    <br>and fill it with all the configuration variables.");
}

// It's necessary to include here both config files. If not, the entryPoint.php will include them again and it will fail.
include_once 'config.php';
include_once 'config_override.php';
$GLOBALS['sugar_config'] = $sugar_config;
if (!isset($sugar_config['stic_install_locked']) || $sugar_config['stic_install_locked']) {
    die('<br>Installation is locked or locker not defined. Please turn "false" stic_install_locked parameter in config_override.php');
}
echo "<br>Checking if all the configuration variables are available.<br>";
// Defining which of the parameters are required for a SinergiaCRM-SuiteCRM Installation
// The permission parameters aren't required. Actually, depending the Web server configuration, they can be empty
$requiredDbParameters = array(
    'db_host_name',
    'db_port',
    'db_name',
    'db_user_name',
    'db_password',
);

$requiredParameters = array(
    'default_language',
    'host_name',
    'site_url',
    'unique_key',
);

array_map(function($elem) use ($sugar_config) {
    if (!isset($sugar_config[$elem])){
        die("The following config parameter isn't defined: ".$elem);
    }
}, $requiredParameters);

// The DB configuration parameters need a special mapping.
array_map(function($elem) use ($sugar_config) {
    if (!isset($sugar_config['dbconfig'][$elem])){
        die("The following Database config parameter isn't defined: ".$elem);
    }
}, $requiredDbParameters);

$dbHostName = $sugar_config['dbconfig']['db_host_name'];
$dbPort = $sugar_config['dbconfig']['db_port'];
$dbName = $sugar_config['dbconfig']['db_name'];
$dbUserName = $sugar_config['dbconfig']['db_user_name'];
$dbPassword = $sugar_config['dbconfig']['db_password'];
$webSystemUser = $sugar_config['default_permissions']['user'];
$defaultLanguage = $sugar_config['default_language'];
$shortLanguageCode = explode('_', $defaultLanguage)[0];
ok();

// If dbPort is empty, the mysqli connection doesn't work. Therefore we set it by default
if(empty($dbPort)) {
    $dbPort = 3306;
}

// Setting up permissions of the folder. This might fail in some systems
echo "<br>Changing file permissions to 775, and user, on folder<br>";
if (!chmod(".", 0775) || !(isset($webSystemUser) && chown(".", $webSystemUser))) {
    echo "<br>Changing permissions failed. Installation will continue, please change them manually.<br>";
}
ok();

// Starting connection withouth specifying database
$conn = new mysqli($dbHostName, $dbUserName, $dbPassword, null, $dbPort);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "<br>Deleting the database if it exists [$dbName]<br>";
$result = $conn->query("DROP DATABASE IF EXISTS $dbName");
if (!$result) {
    die("Connection failed: " . $conn->connect_error);
}
ok();

echo "<br>Creating the database again if it does not exist [$dbName]<br>";
$result = $conn->query("CREATE DATABASE IF NOT EXISTS $dbName");
if (!$result) {
    die("Connection failed: " . $conn->connect_error);
}
ok();

// Close the connection and open a new connection with the created database
$conn->close();

$conn = new mysqli($dbHostName, $dbUserName, $dbPassword, $dbName, $dbPort);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<br>Loading the initial dump of SugarCRM [SticInstall/sql/SuitecrmBase.sql] into $dbName<br>";
$sqlFileContent = file_get_contents("SticInstall/sql/SuitecrmBase.sql");
if ($conn->multi_query($sqlFileContent)) {
    do {
        if ($result = $conn->store_result()) {
            $result->free();
        } 
    } while ($conn->next_result());
}
ok();


echo "<br>Repairing instance<br>";
require_once 'include/entryPoint.php';
$current_user = BeanFactory::getBean('Users', 1);
// $current_user->getSystemUser();
$actions = array('clearAll');
$randc = new RepairAndClear();
$randc->repairAndClearAll($actions, array(translate('LBL_ALL_MODULES')), true, false);
ok();

echo "<br>Loading common SQL files into the database<br>";
foreach (glob("SticInstall/sql/common/*sql") as $sqlFile) {
    $sqlFileContent = file_get_contents($sqlFile);
    if ($sqlFile == 'SticInstall/sql/common/UsersConfiguration.sql') {
        echo "<br>Found UsersConfiguration.sql. Preparing and dump it into the database<br>";
        $sqlFileContent = str_replace('@@pwdAdmin@@', $adminPassword, $sqlFileContent);
        $sqlFileContent = str_replace('@@pwdSinergiaCRM@@', $sinergiaCRMPassword, $sqlFileContent);
        $sqlFileContent = str_replace('@@emailSinergiaCRM@@', $emailSinergiaCRM, $sqlFileContent);
        $sqlFileContent = str_replace('@@emailCapsSinergiaCRM@@', $emailCapsSinergiaCRM, $sqlFileContent);
        file_put_contents('SticInstall/sql/common/UsersConfiguration.sql', $sqlFileContent);
    }
    echo "- $sqlFile _________________________________________________<br>";
    if ($conn->multi_query($sqlFileContent)) {
        do {
            if ($result = $conn->store_result()) {
                $result->free();
            }
        } while ($conn->next_result());
    }
}
ok();

echo "<br>Loading SQL files from the folder [SticInstall/sql/$shortLanguageCode]<br>";
foreach (glob("SticInstall/sql/$shortLanguageCode/*sql") as $sqlFile) {
    echo "- $sqlFile _________________________________________________<br>";
    $sqlFileContent = file_get_contents("SticInstall/sql/common/UsersConfiguration.sql");
    if ($conn->multi_query($sqlFileContent)) {
        do {
            if ($result = $conn->store_result()) {
                $result->free();
            }
        } while ($conn->next_result());
    }
}
ok();

echo "<br>Changing password for Admin and SinergiaCRM users<br>";
$result = $conn->query("UPDATE users set user_hash = md5('$adminPassword') WHERE id = 1");
if (!$result) {
    die("Connection failed: " . $conn->connect_error);
}
$result = $conn->query("UPDATE users set user_hash = md5('$sinergiaCRMPassword') WHERE id = 2");
if (!$result) {
    die("Connection failed: " . $conn->connect_error);
}
ok();
echo "<br>Changing email address for SinergiaCRM user<br>";
$result = $conn->query("UPDATE email_addresses set email_address = '$emailSinergiaCRM', email_address_caps = '$emailCapsSinergiaCRM' WHERE id = '2f2df9cc-5718-8d4d-9082-5b4001239c92'");
if (!$result) {
    die("Connection failed: " . $conn->connect_error);
}
ok();

echo "<br>Repairing instance<br>";
$randc->repairAndClearAll($actions, array(translate('LBL_ALL_MODULES')), true, false);
ok();

// Close the connection
$conn->close();

echo "<br>Enable default modules<br>";
include "SticInstall/scripts/PostInstall.php";
ok();

copy('SticInstall/.htaccess', '.htaccess');

// Locking installation
require_once 'modules/Configurator/Configurator.php';
$configurator = new Configurator();
$configurator->config['stic_install_locked'] = true;
$configurator->saveConfig();

echo "<br>Installation completed successfully.<br>";

// Used to display an OK message
function ok()
{
    echo "OK<br>";
}
 
?>
