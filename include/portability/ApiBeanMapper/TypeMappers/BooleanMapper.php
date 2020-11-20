<?php

/* @noinspection PhpIncludeInspection */
require_once 'include/portability/ApiBeanMapper/TypeMappers/TypeMapperInterface.php';

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

        $value = '';
        if ($this->isTrue($bean->$name)) {
            $value = 'true';
        } elseif ($this->isFalse($bean->$name)) {
            $value = 'false';
        }

        $container[$newName] = $value;
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
