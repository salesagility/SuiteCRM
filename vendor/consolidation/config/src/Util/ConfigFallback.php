<?php

namespace Consolidation\Config\Util;

/**
 * Fetch a configuration value from a configuration group. If the
 * desired configuration value is not found in the most specific
 * group named, keep stepping up to the next parent group until a
 * value is located.
 *
 * Given the following constructor inputs:
 *   - $prefix  = "command."
 *   - $group   = "foo.bar.baz"
 *   - $postfix = ".options."
 * Then the `get` method will then consider, in order:
 *   - command.foo.bar.baz.options
 *   - command.foo.bar.options
 *   - command.foo.options
 * If any of these contain an option for "$key", then return its value.
 */
class ConfigFallback extends ConfigGroup
{

    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        return $this->getWithFallback($key, $this->group, $this->prefix, $this->postfix);
    }

    /**
     * Fetch an option value from a given key, or, if that specific key does
     * not contain a value, then consult various fallback options until a
     * value is found.
     *
     */
    protected function getWithFallback($key, $group, $prefix = '', $postfix = '.')
    {
        $configKey = "{$prefix}{$group}{$postfix}{$key}";
        if ($this->config->has($configKey)) {
            return $this->config->get($configKey);
        }
        if ($this->config->hasDefault($configKey)) {
            return $this->config->getDefault($configKey);
        }
        $moreGeneralGroupname = $this->moreGeneralGroupName($group);
        if ($moreGeneralGroupname) {
            return $this->getWithFallback($key, $moreGeneralGroupname, $prefix, $postfix);
        }
        return null;
    }
}
