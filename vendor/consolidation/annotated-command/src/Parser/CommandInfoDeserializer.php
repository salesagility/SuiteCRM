<?php
namespace Consolidation\AnnotatedCommand\Parser;

use Symfony\Component\Console\Input\InputOption;
use Consolidation\AnnotatedCommand\Parser\Internal\CommandDocBlockParser;
use Consolidation\AnnotatedCommand\Parser\Internal\CommandDocBlockParserFactory;
use Consolidation\AnnotatedCommand\AnnotationData;

/**
 * Deserialize a CommandInfo object
 */
class CommandInfoDeserializer
{
    // TODO: in a future version, move CommandInfo::deserialize here
    public function deserialize($data)
    {
        return CommandInfo::deserialize((array)$data);
    }

    protected static function cachedMethodExists($cache)
    {
        return method_exists($cache['class'], $cache['method_name']);
    }

    public static function isValidSerializedData($cache)
    {
        return
            isset($cache['schema']) &&
            isset($cache['method_name']) &&
            isset($cache['mtime']) &&
            ($cache['schema'] > 0) &&
            ($cache['schema'] == CommandInfo::SERIALIZATION_SCHEMA_VERSION) &&
            self::cachedMethodExists($cache);
    }

    public function constructFromCache(CommandInfo $commandInfo, $info_array)
    {
        $info_array += $this->defaultSerializationData();

        $commandInfo
            ->setName($info_array['name'])
            ->replaceRawAnnotations($info_array['annotations'])
            ->setAliases($info_array['aliases'])
            ->setHelp($info_array['help'])
            ->setDescription($info_array['description'])
            ->replaceExampleUsages($info_array['example_usages'])
            ->setReturnType($info_array['return_type'])
            ->setInjectedClasses($info_array['injected_classes'])
            ;

        $this->constructDefaultsWithDescriptions($commandInfo->arguments(), (array)$info_array['arguments']);
        $this->constructDefaultsWithDescriptions($commandInfo->options(), (array)$info_array['options']);
    }

    protected function constructDefaultsWithDescriptions(DefaultsWithDescriptions $defaults, $data)
    {
        foreach ($data as $key => $info) {
            $info = (array)$info;
            $defaults->add($key, $info['description']);
            if (array_key_exists('default', $info)) {
                $defaults->setDefaultValue($key, $info['default']);
            }
        }
    }


    /**
     * Default data. Everything should be provided during serialization;
     * this is just as a fallback for unusual circumstances.
     * @return array
     */
    protected function defaultSerializationData()
    {
        return [
            'name' => '',
            'description' => '',
            'help' => '',
            'aliases' => [],
            'annotations' => [],
            'example_usages' => [],
            'return_type' => [],
            'parameters' => [],
            'arguments' => [],
            'options' => [],
            'injected_classes' => [],
            'mtime' => 0,
        ];
    }
}
