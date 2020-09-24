<?php

/* @noinspection PhpIncludeInspection */
require_once 'include/portability/ApiBeanMapper/TypeMappers/TypeMapperInterface.php';

class FullNameMapper implements TypeMapperInterface
{
    /**
     * @inheritDoc
     */
    public static function getType(): string
    {
        return 'fullname';
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

        global $locale, $current_user;
        $fullNameFormat = [];

        $localeFormat = $locale->getLocaleFormatMacro($current_user);

        foreach (explode(' ', $localeFormat) as $i => $piece) {
            switch ($piece) {
                case 'f':
                    $fullNameFormat[$i] = 'first_name';
                    break;
                case 'l':
                    $fullNameFormat[$i] = 'last_name';
                    break;
                case 's':
                    $fullNameFormat[$i] = 'salutation';
                    break;
                case 't':
                    $fullNameFormat[$i] = 'title';
                    break;
            }
        }

        $container[$newName] = implode(' ', $fullNameFormat);
    }
}
