<?php

namespace Consolidation\Config\Util;

use Consolidation\Config\ConfigInterface;

/**
 * Provide a configuration object that fetches values from environment
 * variables.
 */
class EnvConfig implements ConfigInterface
{
    /**
     * @var string
     */
    protected $prefix;

    /**
     * EnvConfig constructor
     *
     * @param string $prefix
     *   The string to appear before every environment variable key.
     *   For example, if the prefix is 'MYAPP_', then the key 'foo.bar' will be
     *   fetched from the environment variable MYAPP_FOO_BAR.
     */
    public function __construct($prefix)
    {
        // Ensure that the prefix is always uppercase, and always
        // ends with a '_', regardless of the form the caller provided.
        $this->prefix = strtoupper(rtrim($prefix, '_')) . '_';
    }

    /**
     * {@inheritdoc}
     */
    public function has($key)
    {
        return $this->get($key) !== null;
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $defaultFallback = null)
    {
        $envKey = $this->prefix . strtoupper(strtr($key, '.-', '__'));
        $envKey = str_replace($this->prefix . $this->prefix, $this->prefix, $envKey);
        return getenv($envKey) ?: $defaultFallback;
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value)
    {
        throw new \Exception('Cannot call "set" on environmental configuration.');
    }

    /**
     * {@inheritdoc}
     */
    public function import($data)
    {
        // no-op
    }

    /**
     * {@inheritdoc}
     */
    public function export()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function hasDefault($key)
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefault($key, $defaultFallback = null)
    {
        return $defaultFallback;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefault($key, $value)
    {
        throw new \Exception('Cannot call "setDefault" on environmental configuration.');
    }
}
