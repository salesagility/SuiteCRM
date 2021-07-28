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

require_once __DIR__ . '/TypeMappers/TypeMapperInterface.php';
require_once __DIR__ . '/FieldMappers/FieldMapperInterface.php';
require_once __DIR__ . '/LinkMappers/LinkMapperInterface.php';

class ApiBeanModuleMappers
{
    public const MODULE = '';

    /**
     * @var FieldMapperInterface[]
     */
    protected $fieldMappers = [];

    /**
     * @var TypeMapperInterface[]
     */
    protected $typeMappers = [];

    /**
     * @var LinkMapperInterface[][]
     */
    protected $linkMappers = [];

    /**
     * @return string
     */
    public static function getModule(): string
    {
        return self::MODULE;
    }

    /**
     * @return FieldMapperInterface[]
     */
    public function getFieldMappers(): array
    {
        return $this->fieldMappers;
    }

    /**
     * @param FieldMapperInterface[] $fieldMappers
     * @return ApiBeanModuleMappers
     */
    public function setFieldMappers(array $fieldMappers): ApiBeanModuleMappers
    {
        $this->fieldMappers = $fieldMappers;

        return $this;
    }

    /**
     * @param string $field
     * @return bool
     */
    public function hasFieldMapper(string $field): bool
    {
        return isset($this->fieldMappers[$field]);
    }

    /**
     * @return TypeMapperInterface[]
     */
    public function getTypeMappers(): array
    {
        return $this->typeMappers;
    }

    /**
     * @param TypeMapperInterface[] $typeMappers
     * @return ApiBeanModuleMappers
     */
    public function setTypeMappers(array $typeMappers): ApiBeanModuleMappers
    {
        $this->typeMappers = $typeMappers;

        return $this;
    }

    /**
     * @param string $type
     * @return bool
     */
    public function hasTypeMapper(string $type): bool
    {
        return isset($this->typeMappers[$type]);
    }

    /**
     * @return LinkMapperInterface[][]
     */
    public function getLinkMappers(): array
    {
        return $this->linkMappers;
    }

    /**
     * @param string $relateModule
     * @param string $field
     * @return LinkMapperInterface|null
     */
    public function getLinkMapper(string $relateModule, string $field): ?LinkMapperInterface
    {
        $moduleLinkMappers = $this->linkMappers[$relateModule] ?? [];

        return $moduleLinkMappers[$field] ?? $moduleLinkMappers['all'] ?? null;
    }

    /**
     * @param LinkMapperInterface[][] $linkMappers
     * @return ApiBeanModuleMappers
     */
    public function setLinkMappers(array $linkMappers): ApiBeanModuleMappers
    {
        $this->linkMappers = $linkMappers;

        return $this;
    }

    /**
     * @param string $relateModule
     * @param string $field
     * @return bool
     */
    public function hasLinkMapper(string $relateModule, string $field): bool
    {
        return $this->getLinkMapper($relateModule, $field) !== null;
    }
}
