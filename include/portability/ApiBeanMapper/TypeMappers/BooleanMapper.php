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

require_once __DIR__  .'/TypeMapperInterface.php';

class BooleanMapper implements TypeMapperInterface
{
    /**
     * @inheritDoc
     */
    public static function getType(): string
    {
        return 'bool';
    }

    /**
     * @inheritDoc
     */
    public function toApi(SugarBean $bean, array &$container, string $name, string $alternativeName = ''): void
    {
        $newName = $name;

        if (!empty($alternativeName)) {
            $newName = $alternativeName;
        }

        if (empty($bean->$name)) {
            $container[$newName] = '';

            return;
        }

        $value = '';
        if ($this->isTrue($bean->$name)) {
            $value = 'true';
        } elseif ($this->isFalse($bean->$name)) {
            $value = 'false';
        }

        $container[$newName] = $value;
    }

    /**
     * @inheritDoc
     */
    public function toBean(SugarBean $bean, array &$container, string $name, string $alternativeName = ''): void
    {
    }

    /**
     * @param $value
     * @return bool
     */
    protected function isTrue($value): bool
    {
        return $value === 'true' || $value === '1' || $value === true || $value === 1;
    }

    /**
     * @param $value
     * @return bool
     */
    protected function isFalse($value): bool
    {
        return $value === 'false' || $value === '0' || $value === false || $value === 0;
    }
}
