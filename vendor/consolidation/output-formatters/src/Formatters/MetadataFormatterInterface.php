<?php

namespace Consolidation\OutputFormatters\Formatters;

use Consolidation\OutputFormatters\Options\FormatterOptions;
use Symfony\Component\Console\Output\OutputInterface;

interface MetadataFormatterInterface
{
    /**
     * Given some metadata, decide how to display it.
     *
     * @param OutputInterface output stream to write to
     * @param array $metadata associative array containing metadata
     * @param FormatterOptions formating options
     */
    public function writeMetadata(OutputInterface $output, $metadata, FormatterOptions $options);
}
