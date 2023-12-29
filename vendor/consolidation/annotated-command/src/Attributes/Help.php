<?php

namespace Consolidation\AnnotatedCommand\Attributes;

use Attribute;
use Consolidation\AnnotatedCommand\Parser\CommandInfo;

#[Attribute(Attribute::TARGET_METHOD)]
class Help
{
    /**
     * @param $description
     *   A one line description.
     * @param $synopsis
     *   A multi-line help text.
     * @param bool|null $hidden
     *   Hide the command from the help list.
     */
    public function __construct(
        public string $description,
        public ?string $synopsis,
        public bool $hidden = false
    ) {
    }

    public static function handle(\ReflectionAttribute $attribute, CommandInfo $commandInfo)
    {
        $args = $attribute->getArguments();
        $commandInfo->setDescription($args['description']);
        $commandInfo->setHelp(@$args['synopsis']);
        $commandInfo->setHidden(@$args['hidden']);
    }
}
