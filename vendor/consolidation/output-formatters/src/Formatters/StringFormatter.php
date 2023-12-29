<?php

namespace Consolidation\OutputFormatters\Formatters;

use Consolidation\OutputFormatters\Options\FormatterOptions;
use Consolidation\OutputFormatters\Options\OverrideOptionsInterface;
use Consolidation\OutputFormatters\StructuredData\RestructureInterface;
use Consolidation\OutputFormatters\StructuredData\UnstructuredInterface;
use Consolidation\OutputFormatters\Transformations\SimplifiedFormatterInterface;
use Consolidation\OutputFormatters\Transformations\StringTransformationInterface;
use Consolidation\OutputFormatters\Validate\ValidationInterface;
use Consolidation\OutputFormatters\Validate\ValidDataTypesTrait;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * String formatter
 *
 * This formatter is used as the default action when no
 * particular formatter is requested.  It will print the
 * provided data only if it is a string; if any other
 * type is given, then nothing is printed.
 */
class StringFormatter implements FormatterInterface, ValidationInterface, OverrideOptionsInterface
{
    /**
     * By default, we assume that we can convert any data type to `string`,
     * unless it implements UnstructuredInterface, in which case we won't
     * allow the `string` format unless the data type also implements
     * StringTransformationInterface.
     */
    public function isValidDataType(\ReflectionClass $dataType)
    {
        if ($dataType->implementsInterface('\Consolidation\OutputFormatters\StructuredData\UnstructuredInterface') && !$dataType->implementsInterface('\Consolidation\OutputFormatters\Transformations\StringTransformationInterface')) {
            return false;
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function write(OutputInterface $output, $data, FormatterOptions $options)
    {
        if (is_string($data)) {
            return $output->writeln($data);
        }
        return $this->reduceToSigleFieldAndWrite($output, $data, $options);
    }

    /**
     * @inheritdoc
     */
    public function overrideOptions($structuredOutput, FormatterOptions $options)
    {
        $defaultField = $options->get(FormatterOptions::DEFAULT_STRING_FIELD, [], '');
        $userFields = $options->get(FormatterOptions::FIELDS, [FormatterOptions::FIELDS => $options->get(FormatterOptions::FIELD)]);
        $optionsOverride = $options->override([]);
        if (empty($userFields) && !empty($defaultField)) {
            $optionsOverride->setOption(FormatterOptions::FIELDS, $defaultField);
        }
        return $optionsOverride;
    }

    /**
     * If the data provided to a 'string' formatter is a table, then try
     * to emit it in a simplified form (by default, TSV).
     *
     * @param OutputInterface $output
     * @param mixed $data
     * @param FormatterOptions $options
     */
    protected function reduceToSigleFieldAndWrite(OutputInterface $output, $data, FormatterOptions $options)
    {
        if ($data instanceof StringTransformationInterface) {
            $simplified = $data->simplifyToString($options);
            return $output->write($simplified);
        }

        $alternateFormatter = new TsvFormatter();
        try {
            $data = $alternateFormatter->validate($data);
            $alternateFormatter->write($output, $data, $options);
        } catch (\Exception $e) {
        }
    }

    /**
     * Always validate any data, though. This format will never
     * cause an error if it is selected for an incompatible data type; at
     * worse, it simply does not print any data.
     */
    public function validate($structuredData)
    {
        return $structuredData;
    }
}
