<?php

namespace Consolidation\Config;

use Dflydev\DotAccessData\Data;
use Consolidation\Config\Util\ConfigInterpolatorInterface;
use Consolidation\Config\Util\ConfigInterpolatorTrait;

class Config implements ConfigInterface, ConfigInterpolatorInterface
{
    use ConfigInterpolatorTrait;

    /**
     * @var \Dflydev\DotAccessData\Data
     */
    protected $config;

    /**
     * TODO: make this private in 2.0 to prevent being saved as an array
     * Making private now breaks backward compatibility
     *
     * @var \Dflydev\DotAccessData\Data
     */
    protected $defaults;

    /**
     * Create a new configuration object, and initialize it with
     * the provided nested array containing configuration data.
     *
     * @param array $data
     *   Config data to store.
     */
    public function __construct(array $data = null)
    {
        $this->config = new Data($data ?: []);
        $this->setDefaults(new Data());
    }

    /**
     * {@inheritdoc}
     */
    public function has($key)
    {
        return ($this->config->has($key));
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $defaultFallback = null)
    {
        if ($this->has($key)) {
            return $this->config->get($key);
        }
        return $this->getDefault($key, $defaultFallback);
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value)
    {
        $this->config->set($key, $value);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function import($data)
    {
        return $this->replace($data);
    }

    /**
     * {@inheritdoc}
     */
    public function replace($data)
    {
        $this->config = new Data($data ?: []);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function combine($data)
    {
        if (!empty($data)) {
            $this->config->import($data, true);
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function export()
    {
        return $this->config->export();
    }

    /**
     * {@inheritdoc}
     */
    public function hasDefault($key)
    {
        return $this->getDefaults()->has($key);
    }

    /**
     * {@inheritdoc}
     */
    public function getDefault($key, $defaultFallback = null)
    {
        return $this->hasDefault($key) ? $this->getDefaults()->get($key) : $defaultFallback;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefault($key, $value)
    {
        $this->getDefaults()->set($key, $value);
        return $this;
    }

    /**
     * Return the class $defaults property and ensure it's a Data object
     * TODO: remove Data object validation in 2.0
     *
     * @return \Dflydev\DotAccessData\Data
     */
    protected function getDefaults()
    {
        // Ensure $this->defaults is a Data object (not an array)
        if (!$this->defaults instanceof Data) {
            $this->setDefaults($this->defaults);
        }
        return $this->defaults;
    }

    /**
     * Sets the $defaults class parameter
     * TODO: remove support for array in 2.0 as this would currently break backward compatibility
     *
     * @param \Dflydev\DotAccessData\Data|array $defaults
     *
     * @throws \Exception
     */
    protected function setDefaults($defaults)
    {
        if (is_array($defaults)) {
            $this->defaults = new Data($defaults);
        } elseif ($defaults instanceof Data) {
            $this->defaults = $defaults;
        } else {
            throw new \Exception("Unknown type provided for \$defaults");
        }
    }
}
