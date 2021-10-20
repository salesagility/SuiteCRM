<?php
/**
 * SuiteCRM is a customer relationship management program developed by SalesAgility Ltd.
 * Copyright (C) 2021 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SALESAGILITY, SALESAGILITY DISCLAIMS THE
 * WARRANTY OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see http://www.gnu.org/licenses.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License
 * version 3, these Appropriate Legal Notices must retain the display of the
 * "Supercharged by SuiteCRM" logo. If the display of the logos is not reasonably
 * feasible for technical reasons, the Appropriate Legal Notices must display
 * the words "Supercharged by SuiteCRM".
 */

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
        global $moduleList;
        global $modInvisList;

        if (in_array($module, $moduleList, true)) {
            return true;
        }

        if (in_array($module, $modInvisList, true)) {
            return true;
        }

        if (in_array($module, ['History', 'Activities'], true)) {
            return true;
        }

        return false;
    }

    /**
     * Get visible modules
     * @return array
     */
    public function getVisibleModules(): array
    {
        global $moduleList;

        return $moduleList;
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
