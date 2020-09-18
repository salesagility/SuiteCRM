<?php

/* @noinspection PhpIncludeInspection */
require_once 'include/portability/ApiBeanMapper/FieldMappers/AssignedUserMapper.php';
require_once 'include/portability/ApiBeanMapper/TypeMappers/DateMapper.php';
require_once 'include/portability/ApiBeanMapper/TypeMappers/DateTimeMapper.php';

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

    public function __construct()
    {
        $this->fieldMappers[AssignedUserMapper::getField()] = new AssignedUserMapper();

        $this->typeMappers[DateMapper::getType()] = new DateMapper();
        $this->typeMappers[DateTimeMapper::getType()] = new DateTimeMapper();
    }

    /**
     * @param SugarBean $bean
     * @return array
     */
    public function toArray(SugarBean $bean): array
    {
        $arr = [];

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
        $fieldRName = $definition['rname'] ?? $field;
        $idName = $definition['id_name'] ?? '';
        $source = $definition['source'] ?? '';
        $idDefinition = $definition[$idName] ?? [];
        $groupingField = $field;

        if ($source !== 'non-db') {
            $arr[$field] = $bean->$field ?? '';

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
    ): void {
        $name = $field;

        if (!empty($alternativeName)) {
            $name = $alternativeName;
        }

        $fieldMapper = $this->fieldMappers[$field] ?? null;
        if ($fieldMapper !== null) {
            $fieldMapper->run($bean, $arr, $name);

            return;
        }

        $type = $definition['type'] ?? '';
        $typeMapper = $this->typeMappers[$type] ?? null;
        if ($typeMapper !== null) {
            $typeMapper->run($bean, $arr, $field, $name);

            return;
        }

        $arr[$name] = $bean->$field ?? '';
    }
}
