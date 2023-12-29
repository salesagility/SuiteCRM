<?php

namespace Consolidation\OutputFormatters\Formatters;

use Consolidation\OutputFormatters\Options\FormatterOptions;
use Symfony\Component\Console\Output\OutputInterface;

interface FormatterInterface
{
    /**
     * Given structured data, apply appropriate
     * formatting, and return a printable string.
     *
     * @param OutputInterface output stream to write to
     * @param mixed $data Structured data to format
     * @param FormatterOptions formating options
     */
    public function write(OutputInterface $output, $data, FormatterOptions $options);
}
