<?php

namespace Consolidation\Config;

interface ConfigAwareInterface
{
    /**
     * Set the config reference.
     *
     * @param \Consolidation\Config\ConfigInterface $config
     *
     * @return $this
     */
    public function setConfig(ConfigInterface $config);

    /**
     * Get the config reference.
     *
     * @return \Consolidation\Config\ConfigInterface
     */
    public function getConfig();
}
