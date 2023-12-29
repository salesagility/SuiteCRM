<?php

namespace Consolidation\Config\Util;

use Consolidation\Config\Config;
use Consolidation\Config\ConfigInterface;

/**
 * Overlay different configuration objects that implement ConfigInterface
 * to make a priority-based, merged configuration object.
 *
 * Note that using a ConfigOverlay hides the defaults stored in each
 * individual configuration context. When using overlays, always call
 * getDefault / setDefault on the ConfigOverlay object itself.
 */
class ConfigOverlay implements ConfigInterface, ConfigInterpolatorInterface, ConfigRuntimeInterface
{
    use ConfigInterpolatorTrait;

    /**
     * @var array
     */
    protected $contexts = [];

    const DEFAULT_CONTEXT = 'default';

    const PROCESS_CONTEXT = 'process';

    public function __construct()
    {
        $this->contexts[self::DEFAULT_CONTEXT] = new Config();
        $this->contexts[self::PROCESS_CONTEXT] = new Config();
    }

    /**
     * Add a named configuration object to the configuration overlay.
     * Configuration objects added LAST have HIGHEST priority, with the
     * exception of the fact that the process context always has the
     * highest priority.
     *
     * If a context has already been added, its priority will not change.
     *
     * @param string $name
     * @param \Consolidation\Config\ConfigInterface $config
     *
     * @return $this
     */
    public function addContext($name, ConfigInterface $config)
    {
        $process = $this->contexts[self::PROCESS_CONTEXT];
        unset($this->contexts[self::PROCESS_CONTEXT]);
        $this->contexts[$name] = $config;
        $this->contexts[self::PROCESS_CONTEXT] = $process;

        return $this;
    }

    /**
     * Add a placeholder context that will be prioritized higher than
     * existing contexts. This is done to ensure that contexts added
     * later will maintain a higher priority if the placeholder context
     * is later relaced with a different configuration set via addContext().
     *
     * @param string $name
     *
     * @return $this
     */
    public function addPlaceholder($name)
    {
        return $this->addContext($name, new Config());
    }

    /**
     * Increase the priority of the named context such that it is higher
     * in priority than any existing context except for the 'process'
     * context.
     *
     * @param string $name
     *
     * @return $this
     */
    public function increasePriority($name)
    {
        $config = $this->getContext($name);
        unset($this->contexts[$name]);
        return $this->addContext($name, $config);
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasContext($name)
    {
        return isset($this->contexts[$name]);
    }

    /**
     * @param string $name
     *
     * @return \Consolidation\Config\ConfigInterface
     */
    public function getContext($name)
    {
        if ($this->hasContext($name)) {
            return $this->contexts[$name];
        }
        return new Config();
    }

    /**
     * @return \Consolidation\Config\ConfigInterface
     */
    public function runtimeConfig()
    {
        return $this->getContext(self::PROCESS_CONTEXT);
    }

    /**
     * @param string $name
     */
    public function removeContext($name)
    {
        unset($this->contexts[$name]);
    }

    /**
     * Determine if a non-default config value exists.
     *
     * @param string $key
     *
     * @return false|\Consolidation\Config\ConfigInterface
     */
    public function findContext($key)
    {
        foreach (array_reverse($this->contexts) as $name => $config) {
            if ($config->has($key)) {
                return $config;
            }
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function has($key)
    {
        return $this->findContext($key) != false;
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $default = null)
    {
        if (is_array($default)) {
            return $this->getUnion($key);
        }
        return $this->getSingle($key, $default);
    }

    /**
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function getSingle($key, $default = null)
    {
        $context = $this->findContext($key);
        if ($context) {
            return $context->get($key, $default);
        }
        return $default;
    }

    /**
     * @param string $key
     *
     * @return array
     */
    public function getUnion($key)
    {
        $result = [];
        foreach (array_reverse($this->contexts) as $name => $config) {
            $item = (array) $config->get($key, []);
            if ($item !== null) {
                $result = array_merge($result, $item);
            }
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value)
    {
        $this->contexts[self::PROCESS_CONTEXT]->set($key, $value);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function import($data)
    {
        $this->unsupported(__FUNCTION__);
    }

    public function replace($data)
    {
        $this->unsupported(__FUNCTION__);
    }

    public function combine($data)
    {
        $this->unsupported(__FUNCTION__);
    }

    protected function unsupported($fn)
    {
        throw new \Exception("The method '$fn' is not supported for the ConfigOverlay class.");
    }

    /**
     * {@inheritdoc}
     */
    public function export()
    {
        $export = [];
        foreach ($this->contexts as $name => $config) {
            $exportToMerge = $config->export();
            $export = \array_replace_recursive($export, $exportToMerge);
        }
        return $export;
    }

    /**
     * exportAll returns the export of all contexts, separated into
     * separate buckets keyed by context name.
     *
     * @return array
     */
    public function exportAll()
    {
        $export = [];
        foreach ($this->contexts as $name => $config) {
            $exportToInsert = $config->export();
            $export[$name] = $exportToInsert;
        }
        return $export;
    }

    /**
     * {@inheritdoc}
     */
    public function hasDefault($key)
    {
        return $this->contexts[self::DEFAULT_CONTEXT]->has($key);
    }

    /**
     * {@inheritdoc}
     */
    public function getDefault($key, $default = null)
    {
        return $this->contexts[self::DEFAULT_CONTEXT]->get($key, $default);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefault($key, $value)
    {
        $this->contexts[self::DEFAULT_CONTEXT]->set($key, $value);
        return $this;
    }
}
