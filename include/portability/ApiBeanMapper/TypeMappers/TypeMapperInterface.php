<?php

interface TypeMapperInterface
{
    /**
     * The type to map
     * @return string
     */
    public static function getType(): string;


    /**
     * Map the field and add it to the container
     * @param SugarBean $bean
     * @param array $container
     * @param string $name
     * @param string $alternativeName
     * @return mixed
     */
    public function run(SugarBean $bean, array &$container, string $name, string $alternativeName = ''): void;

}
