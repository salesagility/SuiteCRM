<?php

/* @noinspection PhpIncludeInspection */
require_once 'include/portability/ApiBeanMapper/TypeMappers/TypeMapperInterface.php';

class MultiEnumMapper implements TypeMapperInterface
{
    /**
     * @inheritDoc
     */
    public static function getType(): string
    {
        return 'multienum';
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
            $container[$newName] = [];

            return;
        }

        $enumArray = $this->unEncodeMultiEnum($bean->$name);

        if (empty($enumArray)) {
            $container[$newName] = [];

            return;
        }

        $container[$newName] = $enumArray;
    }

    /**
     * @param $string
     * @return array
     */
    public function unEncodeMultiEnum($string): array
    {
        if (is_array($string)) {
            return $string;
        }

        if (strpos($string, '^') === 0) {
            $string = substr($string, 1, strlen($string));
        }

        if (substr($string, -1) === '^') {
            $string = substr($string, 0, -1);
        }

        return explode('^,^', $string);
    }
}
