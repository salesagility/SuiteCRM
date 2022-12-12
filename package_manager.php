<?php

function usage($error = "") {
    if (!empty($error)) print(PHP_EOL . "Error: " . $error . PHP_EOL);
    print("  php " . __FILE__ . " --install package_name --remove package_name" . PHP_EOL);
    exit(1);
}

// Create Patch file with the current changes of the packages
function create_backup(){
    $folder_path = dirname(__FILE__)."/custom/";
    exec("git -C $folder_path diff --no-color -G. > tempchanges.patch");
}

// Restore the files to their previous state
function restore_files(){
    $script_path = dirname(__FILE__);
    $folder_path = $script_path."/custom/";
    exec("git -C $folder_path reset --hard");

    // Apply changes only if they exist
    if (filesize("$script_path/tempchanges.patch")) {
        exec("git -C $folder_path apply --ignore-space-change --ignore-whitespace $script_path/tempchanges.patch");
    }
    
    shell_exec("rm $script_path/tempchanges.patch");
}

// only allow CLI
$sapi_type = php_sapi_name();
if (substr($sapi_type, 0, 3) != "cli") {
    die(__FILE__ . " is CLI only.");
}

// get command line params
$option = getopt("", array("install:", "remove:"));

if (!isset($option["install"]) && !isset($option["remove"])){
    usage();
}

// sugar basic setup
define("sugarEntry", true);
require_once("include/entryPoint.php");

if (empty($current_language)) {
    $current_language = $sugar_config["default_language"];
}

$app_list_strings = return_app_list_strings_language($current_language);
$app_strings = return_application_language($current_language);
$mod_strings = return_module_language($current_language, "Administration");

global $current_user;
$current_user = BeanFactory::getBean("Users");
$current_user->getSystemUser();

$start_time = microtime(true);

require_once("modules/ModuleBuilder/MB/ModuleBuilder.php");
require_once("modules/ModuleBuilder/parsers/ParserFactory.php");
require_once("modules/ModuleBuilder/Module/StudioModuleFactory.php");
require_once("modules/ModuleBuilder/parsers/constants.php");   
require_once("ModuleInstall/PackageManager/PackageManager.php");

//increment etag for menu so the new module shows up when the AJAX UI reloads
$current_user->incrementETag("mainMenuETag");

$mb = new ModuleBuilder();

if (!empty($option["install"])) {
    $load = $option["install"];
    if (in_array($load, $mb->getPackageList())) {
        create_backup();
        $zip = $mb->getPackage($load);
        $pm = new PackageManager();
        $info = $mb->packages [ $load ]->build(false);
        $uploadDir = $pm->upload_dir."/upgrades/module/";
        mkdir_recursive($uploadDir);
        rename($info [ "zip" ], $uploadDir . $info [ "name" ] . ".zip");
        copy($info [ "manifest" ], $uploadDir . $info [ "name" ] . "-manifest.php");
        $_REQUEST['install_file'] =  $uploadDir. $info [ "name" ] . ".zip";

        # Uninstall previous installed packages
        $pm->performUninstall($load);
        clearAllJsAndJsLangFilesWithoutOutput();
        $cache_key = "app_list_strings.".$current_language;
        sugar_cache_clear($cache_key);
        sugar_cache_reset();
        //clear end
        $pm->performInstall($_REQUEST['install_file'], true);

        //clear the unified_search_module.php file
        require_once("modules/Home/UnifiedSearchAdvanced.php");
        UnifiedSearchAdvanced::unlinkUnifiedSearchModulesFile();

        //clear workflow admin modules cache
        if (isset($_SESSION["get_workflow_admin_modules_for_user"])) {
            unset($_SESSION["get_workflow_admin_modules_for_user"]);
        }

        // clear "is_admin_for_module" cache
        $sessionVar = "MLA_".$current_user->user_name;
        foreach ($mb->packages as $package) {
            foreach ($package->modules as $module) {
                $_SESSION[$sessionVar][$package->name . "_" . $module->name] = true;
            }
        }

        // recreate acl cache
        $actions = ACLAction::getUserActions($current_user->id, true);
        restore_files();
        echo "Package installed\n";
    } else {
        echo "Package don't exist!\n";
    }

}

if (!empty($option["remove"])) {
    $uninstall_package = $option["remove"];
    $package_deployed = false;
    if (in_array($uninstall_package, $mb->getPackageList())) {
        $mbpackage = $mb->getPackage($uninstall_package);
        foreach ($mbpackage->modules as $a_module) {
            if (in_array($a_module->key_name, $GLOBALS['moduleList'])) {
                $package_deployed = true;
                break;
            }
        }

        if ($package_deployed) {
            create_backup();
            $pm = new PackageManager();
            # Uninstall previous installed packages
            $pm->performUninstall($uninstall_package);
            clearAllJsAndJsLangFilesWithoutOutput();
            $cache_key = "app_list_strings.".$current_language;
            sugar_cache_clear($cache_key);
            sugar_cache_reset();
            restore_files();
            echo "\nPackage Uninstalled\n";

        } else {
            echo "Package not installed\n";
        }
    } else {
        echo "Package don't exist\n";
    }
}

?>
