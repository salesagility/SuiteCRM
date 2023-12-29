<?php

namespace Robo\Common;

use Robo\Robo;
use Consolidation\Config\ConfigInterface;

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

    /**
     * Any class that uses ConfigAwareTrait SHOULD override this method
     * , and define a prefix for its configuration items. This is usually
     * done in a base class. When used, this method should return a string
     * that ends with a "."; see BaseTask::configPrefix().
     *
     * @return string
     */
    protected static function configPrefix()
    {
        return '';
    }

    protected static function configClassIdentifier($classname)
    {
        $configIdentifier = strtr($classname, '\\', '.');
        $configIdentifier = preg_replace('#^(.*\.Task\.|\.)#', '', $configIdentifier);

        return $configIdentifier;
    }

    protected static function configPostfix()
    {
        return '';
    }

    /**
     * @param string $key
     *
     * @return string
     */
    private static function getClassKey($key)
    {
        $configPrefix = static::configPrefix();                            // task.
        $configClass = static::configClassIdentifier(get_called_class());  // PARTIAL_NAMESPACE.CLASSNAME
        $configPostFix = static::configPostfix();                          // .settings

        return sprintf('%s%s%s.%s', $configPrefix, $configClass, $configPostFix, $key);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param \Consolidation\Config\ConfigInterface|null $config
     */
    public static function configure($key, $value, $config = null)
    {
        if (!$config) {
            $config = Robo::config();
        }
        $config->setDefault(static::getClassKey($key), $value);
    }

    /**
     * @param string $key
     * @param mixed|null $default
     *
     * @return mixed|null
     */
    protected function getConfigValue($key, $default = null)
    {
        if (!$this->getConfig()) {
            return $default;
        }
        return $this->getConfig()->get(static::getClassKey($key), $default);
    }
}
