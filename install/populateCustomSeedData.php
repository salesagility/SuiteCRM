<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$customDataFiles = glob("custom/install/customData*.php");

if (empty($customDataFiles)) {
    $customDataFiles = ['install/customData.php'];
}

foreach ($customDataFiles as $file) {
    require_once $file;

    if (isset($suitecrm_custom_data)) {
        importCustomData($suitecrm_custom_data);
        unset($suitecrm_custom_data);
    }
}


function importCustomData(array $suitecrm_custom_data)
{
    foreach ($suitecrm_custom_data as $module => $data) {
        foreach ($data as $record) {
            $bean = BeanFactory::newBean($module);

            if (!$bean) {
                LoggerManager::getLogger()->error("Unable to import custom data. The module {$module} does not exists");
                continue;
            }
            LoggerManager::getLogger()->info("Importing custom data for module: {$module}");

            foreach ($record as $field => $value) {
                $bean->$field = $value;
            }
            $bean->save();
        }
    }
}
