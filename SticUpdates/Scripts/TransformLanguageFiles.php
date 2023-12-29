<?php
// Modifies array mod_strings
// STIC#695

$customModules = 'custom/Extension/modules';
$backupFolder = 'custom/sticOldExtensionLanguagesBackup/';
$backupExists = false;
if (file_exists($backupFolder)) {
    $customModules = $backupFolder. '/' .$customModules;
    $backupExists = true;
}
$fileSystemIterator = new FilesystemIterator($customModules);

$entries = array();
foreach ($fileSystemIterator as $fileInfo){
    $moduleName = $fileInfo->getFilename();
    $moduleFolder = $customModules.'/'.$moduleName;
    if (is_dir($moduleFolder)) {
        $languageModuleFolder = $moduleFolder.'/Ext/Language';
        if (is_dir($languageModuleFolder)) {
            $languageFileSystemIterator = new FilesystemIterator($languageModuleFolder);
            foreach ($languageFileSystemIterator as $languageFileInfo){
                $languageFile = $languageFileInfo->getFilename();
                if (substr($languageFile, 0, 10) === "_override_") {
                    $languageFileFolder = $languageModuleFolder.'/'.$languageFile;
                    if (!$backupExists) {
                        mycopy($languageFileFolder, $backupFolder.'/'.$languageFileFolder);
                    }
                    $mod_strings = array();
                    include_once ($languageFileFolder);
                    $routeExtensionLanguageFile = fopen($languageFileFolder, "w") or die("Unable to open file!");
                    $routeExtensionLanguageFileData = "<?php\n\n";
                    foreach($mod_strings as $key => $value) {
                        $value = addslashes($value);
                        $routeExtensionLanguageFileData .= "\$mod_strings['$key'] = '$value';\n";
                    }
                    fwrite($routeExtensionLanguageFile, $routeExtensionLanguageFileData);
                    fclose($routeExtensionLanguageFile);
                }
            }
        }
    }
}

/**
 * Copy files to destination folder and create the destination folder if it doesn't exists.
 *
 * @param String $s1 Source file
 * @param String $s2 Destination file
 * @return void
 */
function mycopy($s1, $s2, $move = false) {
    $path = pathinfo($s2);
    if (!file_exists($path['dirname'])) {
        mkdir($path['dirname'], 0777, true);
    }
    if ($move) {
        if (!rename($s1, $s2)) {
            echo "<br>Move failed<br>".$s1."<br>".$s2."<br>";
        } 
    } else {
        if (!copy($s1, $s2)) {
            echo "<br>Copy failed<br>".$s1."<br>".$s2."<br>";
        } 
    }
}

function dir_is_empty($dir) {
    $handle = opendir($dir);
    while (false !== ($entry = readdir($handle))) {
      if ($entry != "." && $entry != "..") {
        closedir($handle);
        return false;
      }
    }
    closedir($handle);
    return true;
  }
