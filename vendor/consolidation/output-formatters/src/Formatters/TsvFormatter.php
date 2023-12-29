<?php

namespace Consolidation\OutputFormatters\Formatters;

use Consolidation\OutputFormatters\Validate\ValidDataTypesInterface;
use Consolidation\OutputFormatters\Options\FormatterOptions;
use Consolidation\OutputFormatters\Transformations\TableTransformation;
use Consolidation\OutputFormatters\Exception\IncompatibleDataException;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Tab-separated value formatters
 *
 * Display the provided structured data in a tab-separated list.  Output
 * escaping is much lighter, since there is no allowance for altering
 * the delimiter.
 */
class TsvFormatter extends CsvFormatter
{
    protected function getDefaultFormatterOptions()
    {
        return [
            FormatterOptions::INCLUDE_FIELD_LABELS => false,
        ];
    }

    protected function writeOneLine(OutputInterface $output, $data, $options)
    {
        $output->writeln($this->tsvEscape($data));
    }

    protected function tsvEscape($data)
    {
        return implode("\t", array_map(
            function ($item) {
                return str_replace(["\t", "\n"], ['\t', '\n'], $item);
            },
            $data
        ));
    }
}
