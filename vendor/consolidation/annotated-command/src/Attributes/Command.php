<?php

namespace Consolidation\AnnotatedCommand\Attributes;

use Attribute;
use Consolidation\AnnotatedCommand\Parser\CommandInfo;

#[Attribute(Attribute::TARGET_METHOD)]
class Command
{
    /**
     * @param $name
     *  The name of the command or hook.
     * @param string[] $aliases
     *   An array of alternative names for this item.
     */
    public function __construct(
        public string $name,
        public array $aliases = [],
    ) {
    }

    public static function handle(\ReflectionAttribute $attribute, CommandInfo $commandInfo)
    {
        $args = $attribute->getArguments();
        $commandInfo->setName($args['name']);
        $commandInfo->addAnnotation('command', $args['name']);
        $commandInfo->setAliases($args['aliases'] ?? []);
    }
}
