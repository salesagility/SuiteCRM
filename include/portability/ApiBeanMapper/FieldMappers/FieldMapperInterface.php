<?php

interface FieldMapperInterface
{
    /**
     * The field to map
     * @return string
     */
    public static function getField(): string;


    /**
     * Map the field and add it to the containser
     * @param SugarBean $bean
     * @param array $container
     * @param string $alternativeName
     * @return mixed
     */
    public function run(SugarBean $bean, array &$container, string $alternativeName = ''): void;
}