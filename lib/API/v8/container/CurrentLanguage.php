<?php

use SuiteCRM\Utility\CurrentLanguage;

/*
 * @param \Psr\Container\ContainerInterface $container
 * @return CurrentLanguage
 */
$container['CurrentLanguage'] = function ($container) {
    return new CurrentLanguage($container);
};
