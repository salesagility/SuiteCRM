<?php

class GitPatch {
    public $name;
    public $fpath;

    public function __construct($name, $fpath){
        $this->name = $name;
        $this->fpath = $fpath;
    }
}

function usage($error = "") {
    if (!empty($error)) print(PHP_EOL . "Error: " . $error . PHP_EOL);
    print("  php " . __FILE__ . " --install package_name --remove package_name" . PHP_EOL);
    exit(1);
}

// Create Patch file with the current changes of the packages
function create_backup($git_patch_name){
    exec("find . -type d -name '.git'", $folders);
    $patch_array = array();

    foreach ($folders as $key=>$folder) {
        $folder_path = dirname($folder);
        $patch_name = $git_patch_name.$key.".patch";
        $pt = new GitPatch($patch_name, $folder_path);
        exec("git -C $pt->fpath diff --no-color -G. > $pt->name");
        array_push($patch_array, $pt);
    }

    return $patch_array;
}

// Restore the files to their previous state
function restore_files($patch_list){
    $script_path = dirname(__FILE__);
    foreach ($patch_list as $patch) {
        if (filesize("$script_path/$patch->name")) {

            // If is the root folder, we avoid git reset --hard
            // to avoid breaking symlinks
            if ($patch->fpath == ".") {
                exec("find . -type l", $links);
                foreach ($links as $link) {
                    exec("git add $link");
                }
                exec("git -C $patch->fpath apply --ignore-space-change --ignore-whitespace $script_path/$patch->name");
                foreach ($links as $link) {
                    exec("git restore --staged $link");
                }
            } else {
                exec("git -C $patch->fpath reset --hard");
                exec("git -C $patch->fpath apply --ignore-space-change --ignore-whitespace $script_path/$patch->name");
            }
        }
        shell_exec("rm $script_path/$patch->name");
    }

}

function uninstall_package($package_name, $language){
    $pm = new PackageManager();
    # Uninstall previous installed packages
    $pm->performUninstall($package_name);
    clearAllJsAndJsLangFilesWithoutOutput();
    $cache_key = "app_list_strings.".$language;
    sugar_cache_clear($cache_key);
    sugar_cache_reset();
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
$patch_name = "tempchanges";

if (!empty($option["install"])) {
    $ipackage_name = $option["install"];
    if (in_array($ipackage_name, $mb->getPackageList())) {
        $patch_list = create_backup($patch_name);
        $zip = $mb->getPackage($ipackage_name);
        $pm = new PackageManager();
        $info = $mb->packages [ $ipackage_name ]->build(false);
        $uploadDir = $pm->upload_dir."/upgrades/module/";
        mkdir_recursive($uploadDir);
        rename($info [ "zip" ], $uploadDir . $info [ "name" ] . ".zip");
        copy($info [ "manifest" ], $uploadDir . $info [ "name" ] . "-manifest.php");
        $_REQUEST['install_file'] =  $uploadDir. $info [ "name" ] . ".zip";

        # Uninstall previous installed packages
        uninstall_package($ipackage_name, $current_language);

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
        restore_files($patch_list);
        echo "Package installed\n";
    } else {
        echo "Package don't exist, available packages:\n";
        foreach($mb->getPackageList() as $available_package) {
            echo $available_package."\n";
        }
    }

}

if (!empty($option["remove"])) {
    $rpackage_name = $option["remove"];
    $package_deployed = false;
    if (in_array($rpackage_name, $mb->getPackageList())) {
        $mbpackage = $mb->getPackage($rpackage_name);
        foreach ($mbpackage->modules as $a_module) {
            if (in_array($a_module->key_name, $GLOBALS['moduleList'])) {
                $package_deployed = true;
                break;
            }
        }

        if ($package_deployed) {
            $patch_list = create_backup($patch_name);

            uninstall_package($rpackage_name, $current_language);

            restore_files($patch_list);
            echo "\nPackage Uninstalled\n";

        } else {
            echo "Package not installed\n";
        }
    } else {
        echo "Package don't exist, available packages:\n";
        foreach($mb->getPackageList() as $available_package) {
            echo $available_package."\n";
        }
    }
}

?>
