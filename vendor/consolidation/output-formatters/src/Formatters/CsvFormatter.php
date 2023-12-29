<?php

namespace Consolidation\OutputFormatters\Formatters;

use Consolidation\OutputFormatters\Validate\ValidDataTypesInterface;
use Consolidation\OutputFormatters\Options\FormatterOptions;
use Consolidation\OutputFormatters\Validate\ValidDataTypesTrait;
use Consolidation\OutputFormatters\Transformations\TableTransformation;
use Consolidation\OutputFormatters\Exception\IncompatibleDataException;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Comma-separated value formatters
 *
 * Display the provided structured data in a comma-separated list. If
 * there are multiple records provided, then they will be printed
 * one per line.  The primary data types accepted are RowsOfFields and
 * PropertyList. The later behaves exactly like the former, save for
 * the fact that it contains but a single row. This formmatter can also
 * accept a PHP array; this is also interpreted as a single-row of data
 * with no header.
 */
class CsvFormatter implements FormatterInterface, ValidDataTypesInterface, RenderDataInterface
{
    use ValidDataTypesTrait;
    use RenderTableDataTrait;

    public function validDataTypes()
    {
        return
            [
                new \ReflectionClass('\Consolidation\OutputFormatters\StructuredData\RowsOfFields'),
                new \ReflectionClass('\Consolidation\OutputFormatters\StructuredData\PropertyList'),
                new \ReflectionClass('\ArrayObject'),
            ];
    }

    public function validate($structuredData)
    {
        // If the provided data was of class RowsOfFields
        // or PropertyList, it will be converted into
        // a TableTransformation object.
        if (!is_array($structuredData) && (!$structuredData instanceof TableTransformation)) {
            throw new IncompatibleDataException(
                $this,
                $structuredData,
                $this->validDataTypes()
            );
        }
        // If the data was provided to us as a single array, then
        // convert it to a single row.
        if (is_array($structuredData) && !empty($structuredData)) {
            $firstRow = reset($structuredData);
            if (!is_array($firstRow)) {
                return [$structuredData];
            }
        }
        return $structuredData;
    }

    /**
     * Return default values for formatter options
     * @return array
     */
    protected function getDefaultFormatterOptions()
    {
        return [
            FormatterOptions::INCLUDE_FIELD_LABELS => true,
            FormatterOptions::DELIMITER => ',',
            FormatterOptions::CSV_ENCLOSURE => '"',
            FormatterOptions::CSV_ESCAPE_CHAR => "\\",
        ];
    }

    /**
     * @inheritdoc
     */
    public function write(OutputInterface $output, $data, FormatterOptions $options)
    {
        $defaults = $this->getDefaultFormatterOptions();

        $includeFieldLabels = $options->get(FormatterOptions::INCLUDE_FIELD_LABELS, $defaults);
        if ($includeFieldLabels && ($data instanceof TableTransformation)) {
            $headers = $data->getHeaders();
            $this->writeOneLine($output, $headers, $options);
        }

        foreach ($data as $line) {
            $this->writeOneLine($output, $line, $options);
        }
    }

  /**
   * Writes a single a single line of formatted CSV data to the output stream.
   *
   * @param OutputInterface $output the output stream to write to.
   * @param array $data an array of field data to convert to a CSV string.
   * @param FormatterOptions $options the specified options for this formatter.
   */
    protected function writeOneLine(OutputInterface $output, $data, $options)
    {
        $defaults = $this->getDefaultFormatterOptions();
        $delimiter = $options->get(FormatterOptions::DELIMITER, $defaults);
        $enclosure = $options->get(FormatterOptions::CSV_ENCLOSURE, $defaults);
        $escapeChar = $options->get(FormatterOptions::CSV_ESCAPE_CHAR, $defaults);
        $output->write($this->csvEscape($data, $delimiter, $enclosure, $escapeChar));
    }

  /**
   * Generates a CSV-escaped string from an array of field data.
   *
   * @param array $data an array of field data to format as a CSV.
   * @param string $delimiter the delimiter to use between fields.
   * @param string $enclosure character to use when enclosing complex fields.
   * @param string $escapeChar character to use when escaping special characters.
   *
   * @return string|bool the formatted CSV string, or FALSE if the formatting failed.
   */
    protected function csvEscape($data, $delimiter = ',', $enclosure = '"', $escapeChar = "\\")
    {
        $buffer = fopen('php://temp', 'r+');
        if (version_compare(PHP_VERSION, '5.5.4', '>=')) {
            fputcsv($buffer, $data, $delimiter, $enclosure, $escapeChar);
        } else {
            fputcsv($buffer, $data, $delimiter, $enclosure);
        }
        rewind($buffer);
        $csv = fgets($buffer);
        fclose($buffer);
        return $csv;
    }
}
