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

/* @noinspection PhpIncludeInspection */
require_once 'include/portability/ApiBeanMapper/FieldMappers/AssignedUserMapper.php';
require_once 'include/portability/ApiBeanMapper/TypeMappers/FullNameMapper.php';
require_once 'include/portability/ApiBeanMapper/TypeMappers/DateMapper.php';
require_once 'include/portability/ApiBeanMapper/TypeMappers/DateTimeMapper.php';
require_once 'include/portability/ApiBeanMapper/TypeMappers/MultiEnumMapper.php';
require_once 'include/portability/ApiBeanMapper/TypeMappers/BooleanMapper.php';
require_once 'include/portability/ApiBeanMapper/ApiBeanModuleMappers.php';

class ApiBeanMapper
{

    /**
     * @var FieldMapperInterface[]
     */
    protected $fieldMappers = [];

    /**
     * @var TypeMapperInterface[]
     */
    protected $typeMappers = [];

    /**
     * @var ApiBeanModuleMappers[]
     */
    protected $moduleMappers = [];

    public function __construct()
    {
        $this->fieldMappers[AssignedUserMapper::getField()] = new AssignedUserMapper();
        $this->typeMappers[FullNameMapper::getType()] = new FullNameMapper();
        $this->typeMappers[DateMapper::getType()] = new DateMapper();
        $this->typeMappers[DateTimeMapper::getType()] = new DateTimeMapper();
        $this->typeMappers[MultiEnumMapper::getType()] = new MultiEnumMapper();
        $this->typeMappers[BooleanMapper::getType()] = new BooleanMapper();
        $this->typeMappers['boolean'] = $this->typeMappers[BooleanMapper::getType()];
    }

    /**
     * @param SugarBean $bean
     * @return array
     */
    public function toArray(SugarBean $bean): array
    {
        $arr = [];

        $arr['module_name'] = $bean->module_name ?? '';
        $arr['object_name'] = $bean->object_name ?? '';

        foreach ($bean->field_defs as $field => $definition) {

            if ($this->isSensitiveField($definition)) {
                continue;
            }

            if (!$this->checkFieldAccess($bean, $definition)) {
                continue;
            }

            if ($this->isLinkField($definition)) {
                continue;
            }

            if ($this->isRelateField($definition)) {
                $this->addRelateFieldToArray($bean, $definition, $arr, $field);
                continue;
            }

            $this->setValue($bean, $field, $arr, $definition);
        }

        return $arr;
    }

    /**
     * @param $definition
     * @return bool
     */
    protected function isRelateField($definition): bool
    {
        return isset($definition['type']) && $definition['type'] === 'relate';
    }

    /**
     * @param $definition
     * @return bool
     */
    protected function isLinkField($definition): bool
    {
        return isset($definition['type']) && $definition['type'] === 'link';
    }

    /**
     * @param $fieldDefinition
     * @return bool
     */
    protected function isSensitiveField($fieldDefinition): bool
    {
        return $fieldDefinition['sensitive'] ?? false;
    }

    /**
     * @param $fieldDefinition
     * @return bool
     */
    protected function isAdminOnlyField($fieldDefinition): bool
    {
        return $fieldDefinition['admin-only'] ?? false;
    }

    /**
     * @param $fieldDefinition
     * @return bool
     */
    protected function isOwnerOnlyField($fieldDefinition): bool
    {
        return $fieldDefinition['owner-only'] ?? false;
    }

    /**
     * @param $fieldDefinition
     * @return bool
     */
    protected function checkAdminOnlyField($fieldDefinition): bool
    {
        global $current_user;

        $isAdminOnlyField = $this->isAdminOnlyField($fieldDefinition);

        if (!$isAdminOnlyField) {
            return true;
        }

        return $isAdminOnlyField && $current_user->isAdmin();
    }

    /**
     * @param $fieldDefinition
     * @param SugarBean $bean
     * @return bool
     */
    protected function checkOwnerOnlyField($fieldDefinition, SugarBean $bean): bool
    {
        global $current_user;

        $assignedUserId = $bean->assigned_user_id ?? '';
        $isOwnerOnlyField = $this->isOwnerOnlyField($fieldDefinition);

        if (!$isOwnerOnlyField) {
            return true;
        }

        return $isOwnerOnlyField && $current_user->id === $assignedUserId;
    }

    /**
     * @param SugarBean $bean
     * @param $definition
     * @return bool
     */
    protected function checkFieldAccess(SugarBean $bean, $definition): bool
    {
        if (!$this->isAdminOnlyField($definition) && !$this->isOwnerOnlyField($definition)) {
            return true;
        }

        return !$this->checkAdminOnlyField($definition) && !$this->checkOwnerOnlyField($definition, $bean);
    }

    /**
     * @param SugarBean $bean
     * @param $definition
     * @param array $arr
     * @param $field
     */
    protected function addRelateFieldToArray(SugarBean $bean, $definition, array &$arr, $field): void
    {
        $fieldRName = $definition['rname'] ?? 'name';
        $idName = $definition['id_name'] ?? '';
        $source = $definition['source'] ?? '';
        $idDefinition = $definition[$idName] ?? [];
        $groupingField = $field;

        if ($source !== 'non-db') {
            $this->setValue($bean, $field, $arr, $definition);

            return;
        }

        if ($idName === $field) {
            $this->setValue($bean, $field, $arr, $definition);

            return;
        }

        $arr[$groupingField] = $arr[$groupingField] ?? [];
        $this->setValue($bean, $field, $arr[$groupingField], $definition, $fieldRName);

        if (isset($bean->$idName)) {
            $idFieldRName = $idDefinition['rname'] ?? 'id';
            $this->setValue($bean, $idName, $arr[$groupingField], $definition, $idFieldRName);
        }
    }

    /**
     * @param SugarBean $bean
     * @param $field
     * @param array $arr
     * @param array $definition
     * @param string $alternativeName
     */
    protected function setValue(
        SugarBean $bean,
        $field,
        array &$arr,
        array $definition,
        string $alternativeName = ''
    ): void
    {
        $name = $field;

        if (!empty($alternativeName)) {
            $name = $alternativeName;
        }

        $fieldMapper = $this->getFieldMapper($bean->module_name, $field);
        if (null !== $fieldMapper) {
            $fieldMapper->run($bean, $arr, $name);

            return;
        }

        $type = $definition['type'] ?? '';
        $typeMapper = $this->getTypeMappers($bean->module_name, $type);
        if (null !== $typeMapper) {
            $typeMapper->run($bean, $arr, $field, $name);

            return;
        }

        $arr[$name] = html_entity_decode($bean->$field ?? '', ENT_QUOTES);
    }

    /**
     * @param string $module
     * @param string $field
     * @return FieldMapperInterface
     */
    protected function getFieldMapper(string $module, string $field): ?FieldMapperInterface
    {
        $moduleMappers = $this->moduleMappers[$module] ?? null;

        if ($moduleMappers !== null && $moduleMappers->hasFieldMapper($field)) {
            return $moduleMappers->getFieldMappers()[$field];
        }

        return $this->fieldMappers[$field] ?? null;
    }

    /**
     * @param string $module
     * @param string $type
     * @return TypeMapperInterface
     */
    protected function getTypeMappers(string $module, string $type): ?TypeMapperInterface
    {
        $moduleMappers = $this->moduleMappers[$module] ?? null;

        if ($moduleMappers !== null && $moduleMappers->hasTypeMapper($type)) {
            return $moduleMappers->getTypeMappers()[$type];
        }

        return $this->typeMappers[$type] ?? null;
    }
}
