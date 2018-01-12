<?php

use SuiteCRM\Utility\ModuleLanguage;

/**
 * @param \Psr\Container\ContainerInterface $container
 * @return ModuleLanguage
 */
$container['ModuleLanguage'] = function($container) {
    $moduleLanguage = new ModuleLanguage();
    return $moduleLanguage;
};

