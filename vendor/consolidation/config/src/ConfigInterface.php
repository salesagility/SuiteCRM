<?php

namespace Consolidation\Config;

interface ConfigInterface
{
    /**
     * Determine if a non-default config value exists.
     *
     * @param string $key
     */
    public function has($key);

    /**
     * Fetch a configuration value.
     *
     * @param string $key
     *   Which config item to look up
     * @param string|null $defaultFallback
     *   Fallback default value to use when configuration object has neither a
     *   value nor a default. Use is discouraged; use default context in
     *   ConfigOverlay, or provide defaults using a config processor.
     *
     * @return mixed
     */
    public function get($key, $defaultFallback = null);

    /**
     * Set a config value.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return $this
     */
    public function set($key, $value);

    /**
     * Import configuration from the provided nexted array, replacing whatever
     * was here previously. No processing is done on the provided data.
     *
     * @deprecated Use 'replace'. Dflydev\DotAccessData\Data::import() merges,
     *   which is confusing, since this method replaces.
     *
     * @param array $data
     *
     * @return Config
     */
    public function import($data);

    /**
     * Load configuration from the provided nexted array, replacing whatever
     * was here previously. No processing is done on the provided data.
     *
     * TODO: This will become a required method in version 2.0. Adding now
     * would break clients that implement ConfigInterface.
     *
     * @param array $data
     *
     * @return Config
     */
    // public function replace($data);

    /**
     * Import configuration from the provided nexted array, merging with whatever
     * was here previously. No processing is done on the provided data.
     * Any data provided to the combine() method will overwrite existing data
     * with the same key.
     *
     * TODO: This will become a required method in version 2.0. Adding now
     * would break clients that implement ConfigInterface.
     *
     * @param array $data
     *
     * @return Config
     */
    // public function combine($data);

    /**
     * Export all configuration as a nested array.
     *
     * @return array
     */
    public function export();

    /**
     * Check if the $key exists has default value.
     *
     * @param string $key
     *
     * @return bool
     */
    public function hasDefault($key);

    /**
     * Return the default value for a given configuration item.
     *
     * @param string $key
     * @param mixed $defaultFallback
     *
     * @return mixed
     */
    public function getDefault($key, $defaultFallback = null);

    /**
     * Set the default value for a configuration setting. This allows us to
     * set defaults either before or after more specific configuration values
     * are loaded. Keeping defaults separate from current settings also
     * allows us to determine when a setting has been overridden.
     *
     * @param string $key
     * @param mixed $value
     */
    public function setDefault($key, $value);
}
