<?php

/**
 * Class ModuleNameMapper
 * @package App\Legacy
 */
class ModuleNameMapper
{
    protected const FRONTEND = 'frontend';
    protected const CORE = 'core';

    /**
     * @var array
     */
    protected $map;

    /**
     * @var array
     */
    protected $frontEndToLegacyMap;

    /**
     * ModuleNameMapper constructor.
     */
    public function __construct()
    {
        $module_name_map = [];
        require 'module_name_map.php';

        $this->map = $module_name_map;

        foreach ($this->map as $legacyName => $names) {
            $this->frontEndToLegacyMap[$names[self::FRONTEND]] = $legacyName;
        }
    }

    /**
     * Check if module is valid
     * @param string $module
     * @return bool
     */
    public function isValidModule(string $module): bool
    {
        if (empty($this->map[$module])) {
            return false;
        }

        return true;
    }

    /**
     * Map legacy module name to frontend name
     * @param string $module
     * @return string
     */
    public function toFrontEnd(string $module): string
    {
        return $this->mapName($module, self::FRONTEND);
    }

    /**
     * Map legacy module name to core name
     * @param string $module
     * @return string
     */
    public function toCore(string $module): string
    {
        return $this->mapName($module, self::CORE);
    }

    /**
     * Map FrontEnd legacy module name to legacy name
     * @param string $module
     * @return string
     */
    public function toLegacy(string $module): string
    {
        global $log;

        if (empty($this->frontEndToLegacyMap[$module])) {
            $log->warn("ModuleNameMapper | toLegacy | '$module' not mapped");

            return $module;
        }

        return $this->frontEndToLegacyMap[$module];
    }

    /**
     * Get legacy to fronted module name map
     * @return array
     */
    public function getLegacyToFrontendMap(): array
    {
        $legacyToFrontendMap = [];

        foreach ($this->map as $legacyName => $names) {
            $legacyToFrontendMap[$legacyName] = $names[self::FRONTEND];
        }

        return $legacyToFrontendMap;
    }

    /**
     * Map module name
     * @param string $module
     * @param string $type
     * @return mixed
     */
    protected function mapName(string $module, string $type)
    {
        global $log;
        if (empty($this->map[$module]) || empty($this->map[$module][$type])) {
            $log->warn("ModuleNameMapper | mapName | '$module' not mapped to '$type'");

            return $module;
        }

        return $this->map[$module][$type];
    }

}
