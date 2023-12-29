<?php

namespace Consolidation\Config\Loader;

/**
 * Load configuration files.
 */
abstract class ConfigLoader implements ConfigLoaderInterface
{

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var string
     */
    protected $source = '';

    /**
     * {@inheritdoc}
     */
    public function getSourceName()
    {
        return $this->source;
    }

    /**
     * @param string $source
     *
     * @return $this
     */
    protected function setSourceName($source)
    {
        $this->source = $source;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function export()
    {
        return $this->config;
    }

    /**
     * {@inheritdoc}
     */
    public function keys()
    {
        return array_keys($this->config);
    }

    /**
     * @param string $path
     *
     * @return $this
     */
    abstract public function load($path);
}
