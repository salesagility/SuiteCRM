<?php

namespace Consolidation\Config\Loader;

/**
 * Load configuration files, and fill in any property values that
 * need to be expanded.
 */
interface ConfigLoaderInterface
{
    /**
     * Convert loaded configuration into a simple php nested array.
     *
     * @return array
     */
    public function export();

    /**
     * Return the top-level keys in the exported data.
     *
     * @return array
     */
    public function keys();

    /**
     * Return a symbolic name for this configuration loader instance.
     *
     * @return string
     */
    public function getSourceName();
}
