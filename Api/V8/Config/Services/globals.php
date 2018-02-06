<?php

return [
    'suiteConfig' => function () {
        global $sugar_config;
        return $sugar_config;
    },
    'currentUser' => function () {
        global $current_user;
        return $current_user;
    },
];
