<?php

namespace Consolidation\Config;

trait ConfigAwareTrait
{
    /**
     * @var \Consolidation\Config\ConfigInterface
     */
    protected $config;

    /**
     * Set the config management object.
     *
     * @param \Consolidation\Config\ConfigInterface $config
     *
     * @return $this
     */
    public function setConfig(ConfigInterface $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Get the config management object.
     *
     * @return \Consolidation\Config\ConfigInterface
     */
    public function getConfig()
    {
        return $this->config;
    }
}
