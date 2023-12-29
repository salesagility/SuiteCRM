<?php

namespace Consolidation\AnnotatedCommand\Attributes;

use Attribute;
use Consolidation\AnnotatedCommand\Parser\CommandInfo;

#[Attribute(Attribute::TARGET_METHOD)]
class Complete
{
    /**
     * @param $method_or_callable
     *   A method in the command class or Callable that provides argument completion.
     */
    public function __construct(
        public string $method_name_or_callable,
    ) {
    }

    public static function handle(\ReflectionAttribute $attribute, CommandInfo $commandInfo)
    {
        $args = $attribute->getArguments();
        $commandInfo->addAnnotation('complete', $args['method_name_or_callable']);
    }
}
