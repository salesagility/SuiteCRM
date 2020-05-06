<?php

class ActionNameMapper
{
    /**
     * @var array
     */
    private $legacyActionNameMap;

    /**
     * @var array
     */
    private $frontEndToLegacyMap;

    /**
     * ActionNameMapper constructor.
     */
    public function __construct()
    {
        $action_name_map = [];
        require 'action_name_map.php';

        $this->legacyActionNameMap = $action_name_map;
        $this->frontEndToLegacyMap = array_flip($this->legacyActionNameMap);
    }

    /**
     * Map legacy action name to FrontEnd name
     * @param string $action
     * @return string
     */
    public function toFrontend(string $action): string
    {
        if (empty($this->legacyActionNameMap[$action])) {
            return $action;
        }

        return $this->legacyActionNameMap[$action];
    }

    /**
     * Map front end action name to legacy name
     * @param string $action
     * @return string
     */
    public function toLegacy(string $action): string
    {
        if (empty($this->frontEndToLegacyMap[$action])) {
            return $action;
        }

        return $this->frontEndToLegacyMap[$action];
    }

    /**
     * Check if given $action is valid
     * @param string|null $action
     * @return bool
     */
    public function isValidAction(?string $action): bool
    {
        if (empty($action)) {
            return true;
        }

        if (empty($this->legacyActionNameMap[$action]) && empty($this->frontEndToLegacyMap[$action])) {
            return false;
        }

        return true;
    }

    /**
     * Get map
     * @return array
     */
    public function getMap(): array
    {
        return $this->legacyActionNameMap;
    }
}
