<?php

namespace Consolidation\AnnotatedCommand\Attributes;

use Attribute;
use Consolidation\AnnotatedCommand\Parser\CommandInfo;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Option
{
    /**
     * @param $name
     *   The name of the option.
     * @param $description
     *   A one line description.
     */
    public function __construct(
        public string $name,
        public string $description
    ) {
    }

    public static function handle(\ReflectionAttribute $attribute, CommandInfo $commandInfo)
    {
        $args = $attribute->getArguments();
        $commandInfo->addOptionDescription($args['name'], @$args['description']);
    }
}
