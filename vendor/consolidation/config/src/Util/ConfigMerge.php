<?php

namespace Consolidation\Config\Util;

/**
 * Works like 'getWithFallback', but merges results from all applicable
 * groups. Settings from most specific group take precedence.
 */
class ConfigMerge extends ConfigGroup
{
    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        return $this->getWithMerge($key, $this->group, $this->prefix, $this->postfix);
    }

    /**
     * Merge available configuration from each configuration group.
     *
     * @param string $key
     * @param string $group
     * @param string $prefix
     * @param string $postfix
     *
     * @return array
     */
    public function getWithMerge($key, $group, $prefix = '', $postfix = '.')
    {
        $configKey = "{$prefix}{$group}{$postfix}{$key}";
        $result = $this->config->get($configKey, []);
        if (!is_array($result)) {
            throw new \UnexpectedValueException($configKey . ' must be a list of settings to apply.');
        }
        $moreGeneralGroupname = $this->moreGeneralGroupName($group);
        if ($moreGeneralGroupname) {
            $result += $this->getWithMerge($key, $moreGeneralGroupname, $prefix, $postfix);
        }
        return $result;
    }
}
