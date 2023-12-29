<?php

namespace Consolidation\Config\Util;

/**
 * ConfigRuntimeInterface provides a method that returns those elements
 * of the configuration that were set at runtime, e.g. via commandline
 * options rather than being loaded from a file.
 */
interface ConfigRuntimeInterface
{
    /**
     * runtimeConfig returns those elements of the configuration not
     * loaded from a file.
     *
     * @return \Consolidation\Config\ConfigInterface
     */
    public function runtimeConfig();
}
