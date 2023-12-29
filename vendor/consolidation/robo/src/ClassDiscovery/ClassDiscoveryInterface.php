<?php

namespace Robo\ClassDiscovery;

/**
 * Interface ClassDiscoveryInterface
 *
 * @package Robo\Plugin\ClassDiscovery
 */
interface ClassDiscoveryInterface
{
    /**
     * @param string $searchPattern
     *
     * @return $this
     */
    public function setSearchPattern($searchPattern);

    /**
     * @return string[]
     */
    public function getClasses();

    /**
     * @param string $class
     *
     * @return string|null
     */
    public function getFile($class);
}
