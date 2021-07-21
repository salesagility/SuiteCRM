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
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License
 * version 3, these Appropriate Legal Notices must retain the display of the
 * "Supercharged by SuiteCRM" logo. If the display of the logos is not reasonably
 * feasible for technical reasons, the Appropriate Legal Notices must display
 * the words "Supercharged by SuiteCRM".
 */

require_once __DIR__ . '/FilterMapperInterface.php';

class FilterMappers
{
    protected const MSG_HANDLER_NOT_FOUND = 'Filter mapper is not defined';

    /**
     * @var FilterMapperInterface[]
     */
    protected $registry = [];

    /**
     * FilterMappers constructor.
     */
    public function __construct()
    {
        /**
         * @var FilterMapperInterface[]
         */
        $filter_mappers = [];
        require 'filter_mappers.php';

        foreach ($filter_mappers as $handler) {
            $type = $handler->getType();
            $this->registry[$type] = $handler;
        }

    }

    /**
     * Get the mapper for field type
     * @param string $type
     * @return FilterMapperInterface
     */
    public function get(string $type): FilterMapperInterface
    {

        if (empty($this->registry[$type])) {
            throw new RuntimeException(self::MSG_HANDLER_NOT_FOUND);
        }

        return $this->registry[$type];
    }

    /**
     * Has mapper for the given type
     * @param string $type
     * @return bool
     */
    public function hasMapper(string $type): bool
    {
        return !(empty($this->registry[$type]));
    }
}
