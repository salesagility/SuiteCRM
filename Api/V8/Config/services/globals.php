<?php

return [
    'suiteConfig' => function () {
        global $sugar_config;
        return $sugar_config;
    },
    DBManager::class => function () {
        return DBManagerFactory::getInstance();
    },
];
