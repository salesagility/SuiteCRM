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

require_once __DIR__ . '/BeanSaveHandlerInterface.php';
require_once __DIR__ . '/../LineItems/BeanLineItemSaveHandler.php';

class BeanSaveHandlers
{
    public const TYPE_BEFORE = 'before';
    public const TYPE_AFTER = 'after';
    public const MODULE_DEFAULT = 'default';

    /**
     * @var BeanSaveHandlerInterface[][]
     */
    protected $beforeSaveRegistry = [];

    /**
     * @var BeanSaveHandlerInterface[][]
     */
    protected $afterSaveRegistry = [];

    /**
     * @var BeanSaveHandlers
     */
    private static $instance;

    /**
     * BeanSaveHandlers constructor.
     * Singleton
     */
    private function __construct()
    {
        $this->add(self::TYPE_BEFORE, new BeanLineItemSaveHandler());
    }

    /**
     * @return BeanSaveHandlers
     */
    public static function getInstance(): BeanSaveHandlers
    {
        if (empty(self::$instance)) {
            self::$instance = new BeanSaveHandlers();
        }

        return self::$instance;
    }

    /**
     * Add save handler
     * @param string $type
     * @param BeanSaveHandlerInterface $handler
     */
    public function add(string $type, BeanSaveHandlerInterface $handler): void
    {
        if ($type !== self::TYPE_BEFORE && $type !== self::TYPE_AFTER) {
            return;
        }

        $registry = $this->getRegistry($type);

        $module = $handler->getModule() ?? self::MODULE_DEFAULT;

        $moduleHandlers = $registry[$module] ?? [];
        $moduleHandlers[] = $handler;
        $registry[$module] = $moduleHandlers;

        $this->setRegistry($type, $registry);
    }

    /**
     * Get save handler
     * @param string $module
     * @param string $type
     * @return BeanSaveHandlerInterface[]
     */
    public function get(string $module, string $type): array
    {
        if (!$module || ($type !== self::TYPE_BEFORE && $type !== self::TYPE_AFTER)) {
            return [];
        }

        $registry = $this->getRegistry($type);

        return $registry[$module] ?? $registry['default'] ?? [];
    }

    /**
     * Get Registry
     * @param string $type
     * @return  BeanSaveHandlerInterface[][]
     */
    protected function getRegistry(string $type): array
    {
        return $type === self::TYPE_BEFORE ? $this->beforeSaveRegistry : $this->afterSaveRegistry;
    }

    /**
     * Set Registry
     * @param string $type
     * @param BeanSaveHandlerInterface[][] $registry
     */
    protected function setRegistry(string $type, array $registry): void
    {
        if ($type === self::TYPE_BEFORE) {
            $this->beforeSaveRegistry = $registry;
        }

        $this->afterSaveRegistry = $registry;
    }
}
