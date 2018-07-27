<?php

/**
 * @param \Psr\Container\ContainerInterface $container
 * @return \SuiteCRM\Utility\ApplicationLanguage
 */
$container['ApplicationLanguages'] = function ($container) {
    $applicationLanguage = new \SuiteCRM\Utility\ApplicationLanguage();
    return $applicationLanguage;
};
