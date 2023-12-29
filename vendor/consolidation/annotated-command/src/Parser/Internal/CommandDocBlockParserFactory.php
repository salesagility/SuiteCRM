<?php
namespace Consolidation\AnnotatedCommand\Parser\Internal;

use Consolidation\AnnotatedCommand\Parser\CommandInfo;
use function get_class_methods;

/**
 * Create an appropriate CommandDocBlockParser.
 */
class CommandDocBlockParserFactory
{
    public static function parse(CommandInfo $commandInfo, \ReflectionMethod $reflection)
    {
        return static::create($commandInfo, $reflection)->parse();
    }

    private static function create(CommandInfo $commandInfo, \ReflectionMethod $reflection)
    {
        if (in_array('getAttributes', get_class_methods($reflection))) {
            $attributes = $reflection->getAttributes();
        }
        if (empty($attributes)) {
            return new BespokeDocBlockParser($commandInfo, $reflection);
        } else {
            return new AttributesDocBlockParser($commandInfo, $reflection);
        }
    }
}
