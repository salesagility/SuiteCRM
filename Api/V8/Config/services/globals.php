<?php

use Api\Core\Loader\CustomLoader;

return CustomLoader::mergeCustomArray([
    'suiteConfig' => function () {
        global $sugar_config;
        return $sugar_config;
    },
    DBManager::class => function () {
        return DBManagerFactory::getInstance();
    },
], basename(__FILE__));
