<?php

namespace Consolidation\Config\Inject;

use Consolidation\Config\Util\ConfigMerge;

/**
 * Given an object that contains configuration methods, inject any
 * configuration found in the configuration file.
 *
 * The proper use for this method is to call setter methods of the
 * provided object. Using configuration to call methods that do work
 * is an abuse of this mechanism.
 */
class ConfigForSetters
{

    /**
     * @var \Consolidation\Config\Util\ConfigMerge
     */
    protected $config;

    /**
     * @param \Consolidation\Config\ConfigInterface $config
     * @param string $group
     * @param string $prefix
     * @param string $postfix
     */
    public function __construct($config, $group, $prefix = '', $postfix = '')
    {
        if (!empty($group) && empty($postfix)) {
            $postfix = '.';
        }

        $this->config = new ConfigMerge($config, $group, $prefix, $postfix);
    }

    /**
     * @param object $object
     * @param string $configurationKey
     */
    public function apply($object, $configurationKey)
    {
        $settings = $this->config->get($configurationKey);
        foreach ($settings as $setterMethod => $args) {
            $fn = [$object, $setterMethod];
            if (is_callable($fn)) {
                $result = call_user_func_array($fn, (array)$args);

                // We require that $fn must only be used with setter methods.
                // Setter methods are required to always return $this so that
                // they may be chained. We will therefore throw an exception
                // for any setter that returns something else.
                if ($result != $object) {
                    $methodDescription = get_class($object) . "::$setterMethod";
                    $propertyDescription = $this->config->describe($configurationKey);
                    throw new \Exception("$methodDescription did not return '\$this' when processing $propertyDescription.");
                }
            }
        }
    }
}
