<?php

/* @noinspection PhpIncludeInspection */
require_once 'include/portability/ApiBeanMapper/FieldMappers/FieldMapperInterface.php';


class AssignedUserMapper implements FieldMapperInterface
{
    public const FIELD_NAME = 'assigned_user_name';

    /**
     * @inheritDoc
     */
    public static function getField(): string
    {
        return self::FIELD_NAME;
    }

    /**
     * @inheritDoc
     */
    public function run(SugarBean $bean, array &$container, string $alternativeName = ''): void
    {
        $name = self::FIELD_NAME;

        if (!empty($alternativeName)) {
            $name = $alternativeName;
        }

        if (empty($bean->assigned_user_id)) {
            $container[$name] = '';

            return;
        }

        $container[$name] = get_assigned_user_name($bean->assigned_user_id);
    }
}