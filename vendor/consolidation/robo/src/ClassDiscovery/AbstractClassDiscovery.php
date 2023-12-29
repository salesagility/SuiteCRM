<?php

namespace Robo\ClassDiscovery;

/**
 * Class AbstractClassDiscovery
 *
 * @package Robo\ClassDiscovery
 */
abstract class AbstractClassDiscovery implements ClassDiscoveryInterface
{
    /**
     * @var string
     */
    protected $searchPattern = '*.php';

    /**
     * {@inheritdoc}
     */
    public function setSearchPattern($searchPattern)
    {
        $this->searchPattern = $searchPattern;

        return $this;
    }
}
