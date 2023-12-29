<?php

namespace Consolidation\AnnotatedCommand\Attributes;

use Attribute;
use Consolidation\AnnotatedCommand\Parser\CommandInfo;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Argument
{
    /**
     * @param $name
     *   The name of the argument.
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
        $commandInfo->addArgumentDescription($args['name'], @$args['description']);
    }
}
