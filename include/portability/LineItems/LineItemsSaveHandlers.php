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

require_once __DIR__ . '/LineItemsSaveHandlerInterface.php';
require_once __DIR__ . '/DefaultLineItemsSaveHandler.php';
require_once __DIR__ . '/EmailAddressLineItemsSaveHandler.php';

class LineItemsSaveHandlers
{
    /**
     * @var LineItemsSaveHandlerInterface[][]
     */
    protected $registry = [];

    /**
     * @var LineItemsSaveHandlers
     */
    private static $instance;

    /**
     * LineItemsSaveHandlers constructor.
     * Singleton
     */
    private function __construct()
    {
        $this->add(new DefaultLineItemsSaveHandler());
        $this->add(new EmailAddressLineItemsSaveHandler());
    }

    /**
     * @return LineItemsSaveHandlers
     */
    public static function getInstance(): LineItemsSaveHandlers
    {
        if (empty(self::$instance)) {
            self::$instance = new LineItemsSaveHandlers();
        }

        return self::$instance;
    }

    /**
     * Add save handler
     * @param LineItemsSaveHandlerInterface $handler
     */
    public function add(LineItemsSaveHandlerInterface $handler): void
    {
        $module = $handler->getModule() ?? 'default';
        $field = $handler->getField() ?? 'all';
        $relateModule = $handler->getRelateModule() ?? '';

        if ($relateModule === '') {
            return;
        }

        $moduleHandlers = $this->registry[$module] ?? $this->registry['default'] ?? [];
        $relateModuleHandlers = $moduleHandlers[$relateModule] ?? [];
        $relateModuleHandlers[$field] = $handler;
        $moduleHandlers[$relateModule] = $relateModuleHandlers;
        $this->registry[$module] = $moduleHandlers;
    }

    /**
     * Get save handler
     * @param string $module
     * @param string $relateModule
     * @param string $field
     * @return LineItemsSaveHandlerInterface|null
     */
    public function get(string $module, string $relateModule, string $field): ?LineItemsSaveHandlerInterface
    {
        if (!$module || !$field) {
            return null;
        }

        $handlers = $this->registry[$module] ?? $this->registry['default'] ?? [];

        $moduleHandlers = $handlers[$relateModule] ?? $handlers['default'] ?? null;

        if (empty($moduleHandlers)) {
            return null;
        }

        return $moduleHandlers[$field] ?? $moduleHandlers['all'] ?? null;
    }
}
