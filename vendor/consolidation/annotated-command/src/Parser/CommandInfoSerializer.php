<?php
namespace Consolidation\AnnotatedCommand\Parser;

use Symfony\Component\Console\Input\InputOption;
use Consolidation\AnnotatedCommand\Parser\Internal\CommandDocBlockParser;
use Consolidation\AnnotatedCommand\Parser\Internal\CommandDocBlockParserFactory;
use Consolidation\AnnotatedCommand\AnnotationData;

/**
 * Serialize a CommandInfo object
 */
class CommandInfoSerializer
{
    public function serialize(CommandInfo $commandInfo)
    {
        $allAnnotations = $commandInfo->getAnnotations();
        $path = $allAnnotations['_path'];
        $className = $allAnnotations['_classname'];

        // Include the minimum information for command info (including placeholder records)
        $info = [
            'schema' => CommandInfo::SERIALIZATION_SCHEMA_VERSION,
            'class' => $className,
            'method_name' => $commandInfo->getMethodName(),
            'mtime' => filemtime($path),
            'injected_classes' => [],
        ];

        // If this is a valid method / hook, then add more information.
        if ($commandInfo->valid()) {
            $info += [
                'name' => $commandInfo->getName(),
                'description' => $commandInfo->getDescription(),
                'help' => $commandInfo->getHelp(),
                'aliases' => $commandInfo->getAliases(),
                'annotations' => $commandInfo->getRawAnnotations()->getArrayCopy(),
                'example_usages' => $commandInfo->getExampleUsages(),
                'return_type' => $commandInfo->getReturnType(),
            ];
            $info['arguments'] = $this->serializeDefaultsWithDescriptions($commandInfo->arguments());
            $info['options'] = $this->serializeDefaultsWithDescriptions($commandInfo->options());
            $info['injected_classes'] = $commandInfo->getInjectedClasses();
        }

        return $info;
    }

    protected function serializeDefaultsWithDescriptions(DefaultsWithDescriptions $defaults)
    {
        $result = [];
        foreach ($defaults->getValues() as $key => $val) {
            $result[$key] = [
                'description' => $defaults->getDescription($key),
            ];
            if ($defaults->hasDefault($key)) {
                $result[$key]['default'] = $val;
            }
        }
        return $result;
    }
}
