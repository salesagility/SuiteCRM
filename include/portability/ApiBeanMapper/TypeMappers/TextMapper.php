<?php

/* @noinspection PhpIncludeInspection */
require_once 'include/portability/ApiBeanMapper/TypeMappers/TypeMapperInterface.php';

class TextMapper implements TypeMapperInterface
{

    /**
     * @inheritDoc
     */
    public static function getType(): string
    {
        return 'varchar';
    }

    /**
     * @inheritDoc
     */
    public function run(SugarBean $bean, array &$container, string $name, string $alternativeName = ''): void
    {
        $newName = $name;

        if (!empty($alternativeName)) {
            $newName = $alternativeName;
        }

        if (empty($bean->$name)) {
            $container[$newName] = '';

            return;
        }

        $decoded = html_entity_decode($bean->$name);

        $container[$newName] = $decoded;
    }
}
