<?php

namespace Consolidation\OutputFormatters\Formatters;

use Symfony\Component\Yaml\Yaml;
use Consolidation\OutputFormatters\Options\FormatterOptions;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Yaml formatter
 *
 * Convert an array or ArrayObject into Yaml.
 */
class YamlFormatter implements FormatterInterface
{
    /**
     * @inheritdoc
     */
    public function write(OutputInterface $output, $data, FormatterOptions $options)
    {
        // Set Yaml\Dumper's default indentation for nested nodes/collections to
        // 2 spaces for consistency with Drupal coding standards.
        $indent = 2;
        // The level where you switch to inline YAML is set to PHP_INT_MAX to
        // ensure this does not occur.
        $output->writeln(Yaml::dump($data, PHP_INT_MAX, $indent, false, true));
    }
}
