<?php

namespace Consolidation\AnnotatedCommand\Attributes;

use Attribute;
use Consolidation\AnnotatedCommand\Hooks\HookManager;
use Consolidation\AnnotatedCommand\Parser\CommandInfo;
use JetBrains\PhpStorm\ExpectedValues;

#[Attribute(Attribute::TARGET_METHOD)]
class Hook
{
    /**
     * @param $type
     *  When during the command lifecycle this hook will be called (e.g. validate).
     * @param $target
     *   Specifies which command(s) the hook will be attached to.
     */
    public function __construct(
        #[ExpectedValues(valuesFromClass: HookManager::class)] public string $type,
        public ?string $target
    ) {
    }

    public static function handle(\ReflectionAttribute $attribute, CommandInfo $commandInfo)
    {
        $args = $attribute->getArguments();
        $commandInfo->setName($args['target'] ?? '');
        $commandInfo->addAnnotation('hook', $args['type'] . ' ' . $args['target'] ?? '');
    }
}
