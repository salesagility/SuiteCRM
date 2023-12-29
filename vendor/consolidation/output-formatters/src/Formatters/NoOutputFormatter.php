<?php

namespace Consolidation\OutputFormatters\Formatters;

use Consolidation\OutputFormatters\Validate\ValidationInterface;
use Consolidation\OutputFormatters\Options\FormatterOptions;
use Consolidation\OutputFormatters\Validate\ValidDataTypesTrait;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * No output formatter
 *
 * This formatter never produces any output. It is useful in cases where
 * a command should not produce any output by default, but may do so if
 * the user explicitly includes a --format option.
 */
class NoOutputFormatter implements FormatterInterface, ValidationInterface
{
    /**
     * All data types are acceptable.
     */
    public function isValidDataType(\ReflectionClass $dataType)
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function validate($structuredData)
    {
        return $structuredData;
    }

    /**
     * @inheritdoc
     */
    public function write(OutputInterface $output, $data, FormatterOptions $options)
    {
    }
}
