<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

/*********************************************************************************

 * Description:
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc. All Rights
 * Reserved. Contributor(s): ______________________________________..
 * *******************************************************************************/

/**
 * Known Entry Points as of 4.5
 * acceptDecline.php
 * campaign_tracker.php
 * campaign_trackerv2.php
 * cron.php
 * dictionary.php
 * download.php
 * emailmandelivery.php
 * export_dataset.php
 * export.php
 * image.php
 * index.php
 * install.php
 * json.php
 * json_server.php
 * leadCapture.php
 * maintenance.php
 * metagen.php
 * pdf.php
 * phprint.php
 * process_queue.php
 * process_workflow.php
 * removeme.php
 * schedulers.php
 * soap.php
 * su.php
 * sugar_version.php
 * TreeData.php
 * tree_level.php
 * tree.php
 * vcal_server.php
 * vCard.php
 * zipatcher.php
 * WebToLeadCapture.php
 * HandleAjaxCall.php */
 /*
  * for 50, added:
  * minify.php
  */
  /*
  * for 510, added:
  * dceActionCleanup.php
  */
$GLOBALS['starttTime'] = microtime(true);

set_include_path(
    dirname(__FILE__) . '/..' . PATH_SEPARATOR .
    get_include_path()
);

if (!defined('PHP_VERSION_ID')) {
    $version_array = explode('.', phpversion());
    define('PHP_VERSION_ID', ($version_array[0]*10000 + $version_array[1]*100 + $version_array[2]));
}

if(empty($GLOBALS['installing']) && !file_exists('config.php'))
{
	header('Location: install.php');
	exit ();
}


// config|_override.php
if(is_file('config.php')) {
	require_once('config.php'); // provides $sugar_config
}

// load up the config_override.php file.  This is used to provide default user settings
if(is_file('config_override.php')) {
	require_once('config_override.php');
}
if(empty($GLOBALS['installing']) &&empty($sugar_config['dbconfig']['db_name']))
{
	    header('Location: install.php');
	    exit ();
}

if (!empty($sugar_config['xhprof_config']))
{
    require_once 'include/SugarXHprof/SugarXHprof.php';
    SugarXHprof::getInstance()->start();
}

// make sure SugarConfig object is available
require_once 'include/SugarObjects/SugarConfig.php';

///////////////////////////////////////////////////////////////////////////////
////	DATA SECURITY MEASURES
require_once('include/utils.php');
require_once('include/clean.php');
clean_special_arguments();
clean_incoming_data();
////	END DATA SECURITY MEASURES
///////////////////////////////////////////////////////////////////////////////

// cn: set php.ini settings at entry points
setPhpIniSettings();

require_once('sugar_version.php'); // provides $sugar_version, $sugar_db_version, $sugar_flavor
require_once('include/database/DBManagerFactory.php');
require_once('include/dir_inc.php');

require_once('include/Localization/Localization.php');
require_once('include/javascript/jsAlerts.php');
require_once('include/TimeDate.php');
require_once('include/modules.php'); // provides $moduleList, $beanList, $beanFiles, $modInvisList, $adminOnlyList, $modInvisListActivities

require('include/utils/autoloader.php');
spl_autoload_register(array('SugarAutoLoader', 'autoload'));
require_once('data/SugarBean.php');
require_once('include/utils/mvc_utils.php');
require('include/SugarObjects/LanguageManager.php');
require('include/SugarObjects/VardefManager.php');

require('modules/DynamicFields/templates/Fields/TemplateText.php');

require_once('include/utils/file_utils.php');
require_once('include/SugarEmailAddress/SugarEmailAddress.php');
require_once('include/SugarLogger/LoggerManager.php');
require_once('modules/Trackers/BreadCrumbStack.php');
require_once('modules/Trackers/Tracker.php');
require_once('modules/Trackers/TrackerManager.php');
require_once('modules/ACL/ACLController.php');
require_once('modules/Administration/Administration.php');
require_once('modules/Administration/updater_utils.php');
require_once('modules/Users/User.php');
require_once('modules/Users/authentication/AuthenticationController.php');
require_once('include/utils/LogicHook.php');
require_once('include/SugarTheme/SugarTheme.php');
require_once('include/MVC/SugarModule.php');
require_once('include/SugarCache/SugarCache.php');
require('modules/Currencies/Currency.php');
require_once('include/MVC/SugarApplication.php');

require_once('include/upload_file.php');
UploadStream::register();
//
//SugarApplication::startSession();

///////////////////////////////////////////////////////////////////////////////
////    Handle loading and instantiation of various Sugar* class
if (!defined('SUGAR_PATH')) {
    define('SUGAR_PATH', realpath(dirname(__FILE__) . '/..'));
}
require_once 'include/SugarObjects/SugarRegistry.php';

if(empty($GLOBALS['installing'])){
///////////////////////////////////////////////////////////////////////////////
////	SETTING DEFAULT VAR VALUES
$GLOBALS['log'] = LoggerManager::getLogger('SugarCRM');
$error_notice = '';
$use_current_user_login = false;

// Allow for the session information to be passed via the URL for printing.
if(isset($_GET['PHPSESSID'])){
    if(!empty($_COOKIE['PHPSESSID']) && strcmp($_GET['PHPSESSID'],$_COOKIE['PHPSESSID']) == 0) {
        session_id($_REQUEST['PHPSESSID']);
    }else{
        unset($_GET['PHPSESSID']);
    }
}

if(!empty($sugar_config['session_dir'])) {
	session_save_path($sugar_config['session_dir']);
}

SugarApplication::preLoadLanguages();

$timedate = TimeDate::getInstance();

$GLOBALS['sugar_version'] = $sugar_version;
$GLOBALS['sugar_flavor'] = $sugar_flavor;
$GLOBALS['timedate'] = $timedate;
$GLOBALS['js_version_key'] = md5($GLOBALS['sugar_config']['unique_key'].$GLOBALS['sugar_version'].$GLOBALS['sugar_flavor']);

$db = DBManagerFactory::getInstance();
$db->resetQueryCount();
$locale = new Localization();

// Emails uses the REQUEST_URI later to construct dynamic URLs.
// IIS does not pass this field to prevent an error, if it is not set, we will assign it to ''.
if (!isset ($_SERVER['REQUEST_URI'])) {
	$_SERVER['REQUEST_URI'] = '';
}

$current_user = new User();
$current_entity = null;
$system_config = new Administration();
$system_config->retrieveSettings();

LogicHook::initialize()->call_custom_logic('', 'after_entry_point');
}


////	END SETTING DEFAULT VAR VALUES
///////////////////////////////////////////////////////////////////////////////

?>
