<?php

namespace Consolidation\AnnotatedCommand\Attributes;

use Attribute;
use Consolidation\AnnotatedCommand\Parser\CommandInfo;

#[Attribute(Attribute::TARGET_METHOD)]
class Topics
{
    /**
     * @param string[] $topics
     *   An array of topics that are related to this command.
     * @param $isTopic
     *   This command should appear on the list of topics.
     */
    public function __construct(
        public ?array $topics,
        public bool $isTopic = false,
    ) {
    }

    public static function handle(\ReflectionAttribute $attribute, CommandInfo $commandInfo)
    {
        $args = $attribute->getArguments();
        $commandInfo->addAnnotation('topics', $args['topics'] ?? []);
        $commandInfo->addAnnotation('topic', $args['is_topic'] ?? false);
    }
}
