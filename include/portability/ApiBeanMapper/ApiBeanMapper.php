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

require_once __DIR__ . '/FieldMappers/AssignedUserMapper.php';
require_once __DIR__ . '/LinkMappers/LinkMapperInterface.php';
require_once __DIR__ . '/LinkMappers/EmailAddressLinkMapper.php';
require_once __DIR__ . '/LinkMappers/DefaultLinkMapper.php';
require_once __DIR__ . '/TypeMappers/FullNameMapper.php';
require_once __DIR__ . '/TypeMappers/ParentMapper.php';
require_once __DIR__ . '/TypeMappers/DateMapper.php';
require_once __DIR__ . '/TypeMappers/DateTimeMapper.php';
require_once __DIR__ . '/TypeMappers/DateTimeComboMapper.php';
require_once __DIR__ . '/TypeMappers/MultiEnumMapper.php';
require_once __DIR__ . '/TypeMappers/BooleanMapper.php';
require_once __DIR__ . '/ApiBeanModuleMappers.php';
require_once __DIR__ . '/ModuleMappers/SavedSearch/SavedSearchMappers.php';
require_once __DIR__ . '/ModuleMappers/AOP_Case_Updates/CaseUpdatesMappers.php';

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
     * @var LinkMapperInterface[][]
     */
    protected $linkMappers = [];

    /**
     * @var ApiBeanModuleMappers[]
     */
    protected $moduleMappers = [];

    public function __construct()
    {
        $this->fieldMappers[AssignedUserMapper::getField()] = new AssignedUserMapper();
        $this->typeMappers[FullNameMapper::getType()] = new FullNameMapper();
        $this->typeMappers[ParentMapper::getType()] = new ParentMapper();
        $this->typeMappers[DateMapper::getType()] = new DateMapper();
        $this->typeMappers[DateTimeMapper::getType()] = new DateTimeMapper();
        $this->typeMappers[MultiEnumMapper::getType()] = new MultiEnumMapper();
        $this->typeMappers[BooleanMapper::getType()] = new BooleanMapper();
        $this->typeMappers['boolean'] = $this->typeMappers[BooleanMapper::getType()];
        $this->moduleMappers[SavedSearchMappers::getModule()] = new SavedSearchMappers();
        $this->typeMappers[DateTimeComboMapper::getType()] = new DateTimeMapper();
        $this->linkMappers[EmailAddressLinkMapper::getRelateModule()] = [];
        $this->linkMappers[EmailAddressLinkMapper::getRelateModule()]['all'] = new EmailAddressLinkMapper();
        $this->moduleMappers[CaseUpdatesMappers::getModule()] = new CaseUpdatesMappers();
        $this->linkMappers[DefaultLinkMapper::getRelateModule()] = [];
        $this->linkMappers[DefaultLinkMapper::getRelateModule()]['all'] = new DefaultLinkMapper();
    }

    /**
     * @param SugarBean $bean
     * @return array
     */
    public function toApi(SugarBean $bean): array
    {
        $bean->field_defs = $this->mapLinkedModule($bean);

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
                if (!$this->hasLinkMapper($bean->module_name, $definition)) {
                    continue;
                }

                $this->mapLinkFieldToApi($bean, $arr, $definition);

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
     * @param SugarBean $bean
     * @param array $values
     * @return void
     */
    public function toBean(SugarBean $bean, array $values): void
    {
        require_once __DIR__ . '/../../../include/SugarFields/SugarFieldHandler.php';

        $bean->field_defs = $this->mapLinkedModule($bean);

        foreach ($bean->field_defs as $field => $properties) {
            if (!isset($values[$field])) {
                continue;
            }

            $this->toBeanMap($bean, $values, $properties, $field);

            if ($this->isLinkField($properties)) {
                if (!$this->hasLinkMapper($bean->module_name, $properties)) {
                    continue;
                }

                $this->mapLinkFieldToBean($bean, $values, $properties);
            }

            $bean->$field = $values[$field];
        }

        foreach ($bean->relationship_fields as $field => $link) {
            if (!empty($values[$field])) {
                $bean->$field = $values[$field];
            }
        }
    }

    /**
     * @param SugarBean $bean
     * @param array $values
     * @return void
     */
    public function toBeanAttributes(SugarBean $bean, array &$values): void
    {
        require_once __DIR__ . '/../../../include/SugarFields/SugarFieldHandler.php';

        foreach ($bean->field_defs as $field => $properties) {
            if (!isset($values[$field])) {
                continue;
            }

            $this->toBeanMap($bean, $values, $properties, $field);
        }
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
        array     &$arr,
        array     $definition,
        string    $alternativeName = ''
    ): void
    {
        $name = $field;

        if (!empty($alternativeName)) {
            $name = $alternativeName;
        }

        $fieldMapper = $this->getFieldMapper($bean->module_name, $field);
        if (null !== $fieldMapper) {
            $fieldMapper->toApi($bean, $arr, $name);

            return;
        }

        $type = $definition['type'] ?? '';
        $typeMapper = $this->getTypeMappers($bean->module_name, $type);
        if (null !== $typeMapper) {
            $typeMapper->toApi($bean, $arr, $field, $name);

            return;
        }

        $arr[$name] = html_entity_decode($bean->$field ?? '', ENT_QUOTES);
    }

    /**
     * @param SugarBean $bean
     * @param array $container
     * @param array $definition
     */
    protected function mapLinkFieldToApi(SugarBean $bean, array &$container, array $definition): void
    {
        $module = $bean->module_name ?? '';
        $relateModule = $definition['module'] ?? '';
        $name = $definition['name'] ?? '';

        $linkMapper = $this->getLinkMapper($module, $relateModule, $name);
        if ($linkMapper === null) {
            return;
        }

        $linkMapper->toApi($bean, $container, $name);
    }

    /**
     * @param SugarBean $bean
     * @param array $container
     * @param array $definition
     */
    protected function mapLinkFieldToBean(SugarBean $bean, array &$container, array $definition): void
    {
        $module = $bean->module_name ?? '';
        $relateModule = $definition['module'] ?? '';
        $name = $definition['name'] ?? '';

        $linkMapper = $this->getLinkMapper($module, $relateModule, $name);

        if ($linkMapper === null) {
            return;
        }

        $linkMapper->toBean($bean, $container, $name);
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
     * @param string $relateModule
     * @param string $field
     * @return LinkMapperInterface
     */
    protected function getLinkMapper(string $module, string $relateModule, string $field): ?LinkMapperInterface
    {
        if ($module === '' || $relateModule === '' || $field === '') {
            return null;
        }

        $moduleMappers = $this->moduleMappers[$module] ?? null;

        if ($moduleMappers !== null && $moduleMappers->hasLinkMapper($relateModule, $field)) {
            return $moduleMappers->getLinkMapper($relateModule, $field);
        }

        $moduleLinkMappers = $this->linkMappers[$relateModule] ?? $this->linkMappers['default'] ?? [];

        return $moduleLinkMappers[$field] ?? $moduleLinkMappers['all'] ?? null;
    }

    /**
     * @param $definition
     * @return bool
     */
    protected function hasLinkMapper($module, $definition): bool
    {
        $relateModule = $definition['module'] ?? '';
        $name = $definition['name'] ?? '';

        if ($relateModule === '' || $name === '') {
            return false;
        }

        return $this->getLinkMapper($module, $relateModule, $name) !== null;
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

    /**
     * @param SugarBean $bean
     * @param array $values
     * @param $properties
     * @param $field
     */
    protected function toBeanMap(SugarBean $bean, array &$values, $properties, $field): void
    {
        $type = $properties['type'] ?? '';

        if ($type === 'relate' && isset($bean->field_defs[$field])) {
            $idName = $bean->field_defs[$field]['id_name'] ?? '';

            if ($idName !== $field) {

                $idValue = $values[$field]['id'] ?? '';
                if (empty($values[$idName]) && !empty($idValue)) {
                    $values[$idName] = $idValue;
                }

                $rName = $bean->field_defs[$field]['rname'] ?? '';
                $value = $values[$field][$rName] ?? '';
                $values[$field] = $value;
            }
        }

        if (!empty($properties['isMultiSelect']) || $type === 'multienum') {
            $multiSelectValue = $values[$field];
            if (!is_array($values[$field])) {
                $multiSelectValue = [];
            }
            $values[$field] = encodeMultienumValue($multiSelectValue);
        }

        $fieldMapper = $this->getFieldMapper($bean->module_name, $field);
        if (null !== $fieldMapper) {
            $fieldMapper->toBean($bean, $values, $field);
        }

        $typeMapper = $this->getTypeMappers($bean->module_name, $type);
        if (null !== $typeMapper) {
            $typeMapper->toBean($bean, $values, $field, $field);
        }
    }

    /**
     * @param SugarBean $bean
     * @return array
     */
    public function mapLinkedModule(SugarBean $bean): array
    {
        $beanModule = $bean->module_name;
        if (empty($beanModule)) {
            return [];
        }

        $field_defs = $bean->field_defs;
        if (empty($field_defs)) {
            return [];
        }

        $beanObject = BeanFactory::newBean($beanModule);
        if ($beanObject === null) {
            return [];
        }

        $beanObject->load_relationships();
        if (empty($beanObject)) {
            return [];
        }

        foreach ($field_defs as $fieldName => $fieldDefinition) {

            //skip, if module property already exists in fieldDefinition
            $module = $fieldDefinition['module'] ?? '';
            if (!empty($module)) {
                continue;
            }

            $type = $fieldDefinition['type'] ?? '';
            if ($type !== 'link') {
                continue;
            }

            $relationship = $fieldDefinition['relationship'] ?? '';
            if (empty($relationship)) {
                continue;
            }

            $name = $fieldDefinition['name'] ?? '';
            if (empty($name)) {
                continue;
            }

            if (!property_exists($beanObject, $name)) {
                continue;
            }

            if (!property_exists($beanObject->$name, 'relationship')) {
                continue;
            }

            if (!property_exists($beanObject->$name->relationship, 'def')) {
                continue;
            }

            $relationshipMetadata = $beanObject->$name->relationship->def;
            if (empty($relationshipMetadata)) {
                continue;
            }

            $this->injectRelatedModule($fieldDefinition, $relationshipMetadata, $beanModule);

            $field_defs[$fieldName] = $fieldDefinition;
        }

        return $field_defs;
    }

    /**
     * @param array $fieldDefinition
     * @param array $relationshipMetadata
     * @param string $beanModule
     * @return void
     * @desc this function retrieves the related module for the link type field.
     * this information is required to link the relationship between the two modules
     */
    public function injectRelatedModule(array &$fieldDefinition, array $relationshipMetadata, string $beanModule): void
    {
        if (empty($relationshipMetadata)) {
            return;
        }

        $lhsModule = $relationshipMetadata['lhs_module'] ?? '';
        $rhsModule = $relationshipMetadata['rhs_module'] ?? '';

        if ($lhsModule === $beanModule) {
            $fieldDefinition['module'] = $rhsModule;
        }

        if ($rhsModule === $beanModule) {
            $fieldDefinition['module'] = $lhsModule;
        }
    }

}
