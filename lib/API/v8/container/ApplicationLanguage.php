<?php

/**
 * @param \Psr\Container\ContainerInterface $container
 *
 * @return \SuiteCRM\Utility\ApplicationLanguage
 */
$container['ApplicationLanguages'] = function ($container) {
    return new \SuiteCRM\Utility\ApplicationLanguage();
};
