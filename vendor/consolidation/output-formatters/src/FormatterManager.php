<?php

namespace Consolidation\OutputFormatters;

use Consolidation\OutputFormatters\Exception\IncompatibleDataException;
use Consolidation\OutputFormatters\Exception\InvalidFormatException;
use Consolidation\OutputFormatters\Exception\UnknownFormatException;
use Consolidation\OutputFormatters\Formatters\FormatterAwareInterface;
use Consolidation\OutputFormatters\Formatters\FormatterInterface;
use Consolidation\OutputFormatters\Formatters\MetadataFormatterInterface;
use Consolidation\OutputFormatters\Formatters\RenderDataInterface;
use Consolidation\OutputFormatters\Options\FormatterOptions;
use Consolidation\OutputFormatters\Options\OverrideOptionsInterface;
use Consolidation\OutputFormatters\StructuredData\MetadataInterface;
use Consolidation\OutputFormatters\StructuredData\RestructureInterface;
use Consolidation\OutputFormatters\Transformations\DomToArraySimplifier;
use Consolidation\OutputFormatters\Transformations\OverrideRestructureInterface;
use Consolidation\OutputFormatters\Transformations\SimplifyToArrayInterface;
use Consolidation\OutputFormatters\Validate\ValidationInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Consolidation\OutputFormatters\StructuredData\OriginalDataInterface;
use Consolidation\OutputFormatters\StructuredData\ListDataFromKeys;
use Consolidation\OutputFormatters\StructuredData\ConversionInterface;
use Consolidation\OutputFormatters\Formatters\HumanReadableFormat;

/**
 * Manage a collection of formatters; return one on request.
 */
class FormatterManager
{
    /** var FormatterInterface[] */
    protected $formatters = [];
    /** var SimplifyToArrayInterface[] */
    protected $arraySimplifiers = [];

    public function __construct()
    {
    }

    public function addDefaultFormatters()
    {
        $defaultFormatters = [
            'null' => '\Consolidation\OutputFormatters\Formatters\NoOutputFormatter',
            'string' => '\Consolidation\OutputFormatters\Formatters\StringFormatter',
            'yaml' => '\Consolidation\OutputFormatters\Formatters\YamlFormatter',
            'xml' => '\Consolidation\OutputFormatters\Formatters\XmlFormatter',
            'json' => '\Consolidation\OutputFormatters\Formatters\JsonFormatter',
            'print-r' => '\Consolidation\OutputFormatters\Formatters\PrintRFormatter',
            'php' => '\Consolidation\OutputFormatters\Formatters\SerializeFormatter',
            'var_export' => '\Consolidation\OutputFormatters\Formatters\VarExportFormatter',
            'list' => '\Consolidation\OutputFormatters\Formatters\ListFormatter',
            'csv' => '\Consolidation\OutputFormatters\Formatters\CsvFormatter',
            'tsv' => '\Consolidation\OutputFormatters\Formatters\TsvFormatter',
            'table' => '\Consolidation\OutputFormatters\Formatters\TableFormatter',
            'sections' => '\Consolidation\OutputFormatters\Formatters\SectionsFormatter',
        ];
        if (class_exists('Symfony\Component\VarDumper\Dumper\CliDumper')) {
             $defaultFormatters['var_dump'] = '\Consolidation\OutputFormatters\Formatters\VarDumpFormatter';
        }
        foreach ($defaultFormatters as $id => $formatterClassname) {
            $formatter = new $formatterClassname();
            $this->addFormatter($id, $formatter);
        }
        $this->addFormatter('', $this->formatters['string']);
    }

    public function addDefaultSimplifiers()
    {
        // Add our default array simplifier (DOMDocument to array)
        $this->addSimplifier(new DomToArraySimplifier());
    }

    /**
     * Add a formatter
     *
     * @param string $key the identifier of the formatter to add
     * @param string $formatter the class name of the formatter to add
     * @return FormatterManager
     */
    public function addFormatter($key, FormatterInterface $formatter)
    {
        $this->formatters[$key] = $formatter;
        return $this;
    }

    /**
     * Add a simplifier
     *
     * @param SimplifyToArrayInterface $simplifier the array simplifier to add
     * @return FormatterManager
     */
    public function addSimplifier(SimplifyToArrayInterface $simplifier)
    {
        $this->arraySimplifiers[] = $simplifier;
        return $this;
    }

    /**
     * Return a set of InputOption based on the annotations of a command.
     * @param FormatterOptions $options
     * @return InputOption[]
     */
    public function automaticOptions(FormatterOptions $options, $dataType)
    {
        $automaticOptions = [];

        // At the moment, we only support automatic options for --format
        // and --fields, so exit if the command returns no data.
        if (!isset($dataType)) {
            return [];
        }

        $validFormats = $this->validFormats($dataType);
        if (empty($validFormats)) {
            return [];
        }

        $availableFields = $options->get(FormatterOptions::FIELD_LABELS);
        $hasDefaultStringField = $options->get(FormatterOptions::DEFAULT_STRING_FIELD);
        $defaultFormat = $hasDefaultStringField ? 'string' : ($availableFields ? 'table' : 'yaml');

        if (count($validFormats) > 1) {
            // Make an input option for --format
            $description = 'Format the result data. Available formats: ' . implode(',', $validFormats);
            $automaticOptions[FormatterOptions::FORMAT] = new InputOption(FormatterOptions::FORMAT, '', InputOption::VALUE_REQUIRED, $description, $defaultFormat);
        }

        $dataTypeClass = ($dataType instanceof \ReflectionClass) ? $dataType : new \ReflectionClass($dataType);

        if ($availableFields) {
            $defaultFields = $options->get(FormatterOptions::DEFAULT_FIELDS, [], '');
            $description = 'Available fields: ' . implode(', ', $this->availableFieldsList($availableFields));
            $automaticOptions[FormatterOptions::FIELDS] = new InputOption(FormatterOptions::FIELDS, '', InputOption::VALUE_REQUIRED, $description, $defaultFields);
        } elseif ($dataTypeClass->implementsInterface('Consolidation\OutputFormatters\StructuredData\RestructureInterface')) {
            $automaticOptions[FormatterOptions::FIELDS] = new InputOption(FormatterOptions::FIELDS, '', InputOption::VALUE_REQUIRED, 'Limit output to only the listed elements. Name top-level elements by key, e.g. "--fields=name,date", or use dot notation to select a nested element, e.g. "--fields=a.b.c as example".', []);
        }

        if (isset($automaticOptions[FormatterOptions::FIELDS])) {
            $automaticOptions[FormatterOptions::FIELD] = new InputOption(FormatterOptions::FIELD, '', InputOption::VALUE_REQUIRED, "Select just one field, and force format to *string*.", '');
        }

        return $automaticOptions;
    }

    /**
     * Given a list of available fields, return a list of field descriptions.
     * @return string[]
     */
    protected function availableFieldsList($availableFields)
    {
        return array_map(
            function ($key) use ($availableFields) {
                return $availableFields[$key] . " ($key)";
            },
            array_keys($availableFields)
        );
    }

    /**
     * Return the identifiers for all valid data types that have been registered.
     *
     * @param mixed $dataType \ReflectionObject or other description of the produced data type
     * @return array
     */
    public function validFormats($dataType)
    {
        $validFormats = [];
        foreach ($this->formatters as $formatId => $formatterName) {
            $formatter = $this->getFormatter($formatId);
            if (!empty($formatId) && $this->isValidFormat($formatter, $dataType)) {
                $validFormats[] = $formatId;
            }
        }
        sort($validFormats);
        return $validFormats;
    }

    public function isValidFormat(FormatterInterface $formatter, $dataType)
    {
        if (is_array($dataType)) {
            $dataType = new \ReflectionClass('\ArrayObject');
        }
        if (!is_object($dataType) && !class_exists($dataType)) {
            return false;
        }
        if (!$dataType instanceof \ReflectionClass) {
            $dataType = new \ReflectionClass($dataType);
        }
        return $this->isValidDataType($formatter, $dataType);
    }

    public function isValidDataType(FormatterInterface $formatter, \ReflectionClass $dataType)
    {
        if ($this->canSimplifyToArray($dataType)) {
            if ($this->isValidFormat($formatter, [])) {
                return true;
            }
        }
        // If the formatter does not implement ValidationInterface, then
        // it is presumed that the formatter only accepts arrays.
        if (!$formatter instanceof ValidationInterface) {
            return $dataType->isSubclassOf('ArrayObject') || ($dataType->getName() == 'ArrayObject');
        }
        return $formatter->isValidDataType($dataType);
    }

    /**
     * Format and write output
     *
     * @param OutputInterface $output Output stream to write to
     * @param string $format Data format to output in
     * @param mixed $structuredOutput Data to output
     * @param FormatterOptions $options Formatting options
     */
    public function write(OutputInterface $output, $format, $structuredOutput, FormatterOptions $options)
    {
        // Convert the data to another format (e.g. converting from RowsOfFields to
        // UnstructuredListData when the fields indicate an unstructured transformation
        // is requested).
        $structuredOutput = $this->convertData($structuredOutput, $options);

        // TODO: If the $format is the default format (not selected by the user), and
        // if `convertData` switched us to unstructured data, then select a new default
        // format (e.g. yaml) if the selected format cannot render the converted data.
        $formatter = $this->getFormatter((string)$format);

        // If the data format is not applicable for the selected formatter, throw an error.
        if (!is_string($structuredOutput) && !$this->isValidFormat($formatter, $structuredOutput)) {
            $validFormats = $this->validFormats($structuredOutput);
            throw new InvalidFormatException((string)$format, $structuredOutput, $validFormats);
        }
        if ($structuredOutput instanceof FormatterAwareInterface) {
            $structuredOutput->setFormatter($formatter);
        }
        // Give the formatter a chance to override the options
        $options = $this->overrideOptions($formatter, $structuredOutput, $options);
        $restructuredOutput = $this->validateAndRestructure($formatter, $structuredOutput, $options);
        if ($formatter instanceof MetadataFormatterInterface) {
            $formatter->writeMetadata($output, $structuredOutput, $options);
        }
        $formatter->write($output, $restructuredOutput, $options);
    }

    protected function validateAndRestructure(FormatterInterface $formatter, $structuredOutput, FormatterOptions $options)
    {
        // Give the formatter a chance to do something with the
        // raw data before it is restructured.
        $overrideRestructure = $this->overrideRestructure($formatter, $structuredOutput, $options);
        if ($overrideRestructure) {
            return $overrideRestructure;
        }

        // Restructure the output data (e.g. select fields to display, etc.).
        $restructuredOutput = $this->restructureData($structuredOutput, $options);

        // Make sure that the provided data is in the correct format for the selected formatter.
        $restructuredOutput = $this->validateData($formatter, $restructuredOutput, $options);

        // Give the original data a chance to re-render the structured
        // output after it has been restructured and validated.
        $restructuredOutput = $this->renderData($formatter, $structuredOutput, $restructuredOutput, $options);

        return $restructuredOutput;
    }

    /**
     * Fetch the requested formatter.
     *
     * @param string $format Identifier for requested formatter
     * @return FormatterInterface
     */
    public function getFormatter($format)
    {
        // The client must inject at least one formatter before asking for
        // any formatters; if not, we will provide all of the usual defaults
        // as a convenience.
        if (empty($this->formatters)) {
            $this->addDefaultFormatters();
            $this->addDefaultSimplifiers();
        }
        if (!$this->hasFormatter($format)) {
            throw new UnknownFormatException($format);
        }
        $formatter = $this->formatters[$format];
        return $formatter;
    }

    /**
     * Test to see if the stipulated format exists
     */
    public function hasFormatter($format)
    {
        return array_key_exists($format, $this->formatters);
    }

    /**
     * Render the data as necessary (e.g. to select or reorder fields).
     *
     * @param FormatterInterface $formatter
     * @param mixed $originalData
     * @param mixed $restructuredData
     * @param FormatterOptions $options Formatting options
     * @return mixed
     */
    public function renderData(FormatterInterface $formatter, $originalData, $restructuredData, FormatterOptions $options)
    {
        if ($formatter instanceof RenderDataInterface) {
            return $formatter->renderData($originalData, $restructuredData, $options);
        }
        return $restructuredData;
    }

    /**
     * Determine if the provided data is compatible with the formatter being used.
     *
     * @param FormatterInterface $formatter Formatter being used
     * @param mixed $structuredOutput Data to validate
     * @return mixed
     */
    public function validateData(FormatterInterface $formatter, $structuredOutput, FormatterOptions $options)
    {
        // If the formatter implements ValidationInterface, then let it
        // test the data and throw or return an error
        if ($formatter instanceof ValidationInterface) {
            return $formatter->validate($structuredOutput);
        }
        // If the formatter does not implement ValidationInterface, then
        // it will never be passed an ArrayObject; we will always give
        // it a simple array.
        $structuredOutput = $this->simplifyToArray($structuredOutput, $options);
        // If we could not simplify to an array, then throw an exception.
        // We will never give a formatter anything other than an array
        // unless it validates that it can accept the data type.
        if (!is_array($structuredOutput)) {
            throw new IncompatibleDataException(
                $formatter,
                $structuredOutput,
                []
            );
        }
        return $structuredOutput;
    }

    protected function simplifyToArray($structuredOutput, FormatterOptions $options)
    {
        // We can do nothing unless the provided data is an object.
        if (!is_object($structuredOutput)) {
            return $structuredOutput;
        }
        // Check to see if any of the simplifiers can convert the given data
        // set to an array.
        $outputDataType = new \ReflectionClass($structuredOutput);
        foreach ($this->arraySimplifiers as $simplifier) {
            if ($simplifier->canSimplify($outputDataType)) {
                $structuredOutput = $simplifier->simplifyToArray($structuredOutput, $options);
            }
        }
        // Convert data structure back into its original form, if necessary.
        if ($structuredOutput instanceof OriginalDataInterface) {
            return $structuredOutput->getOriginalData();
        }
        // Convert \ArrayObjects to a simple array.
        if ($structuredOutput instanceof \ArrayObject) {
            return $structuredOutput->getArrayCopy();
        }
        return $structuredOutput;
    }

    protected function canSimplifyToArray(\ReflectionClass $structuredOutput)
    {
        foreach ($this->arraySimplifiers as $simplifier) {
            if ($simplifier->canSimplify($structuredOutput)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Convert from one format to another if necessary prior to restructuring.
     */
    public function convertData($structuredOutput, FormatterOptions $options)
    {
        if ($structuredOutput instanceof ConversionInterface) {
            return $structuredOutput->convert($options);
        }
        return $structuredOutput;
    }

    /**
     * Restructure the data as necessary (e.g. to select or reorder fields).
     *
     * @param mixed $structuredOutput
     * @param FormatterOptions $options
     * @return mixed
     */
    public function restructureData($structuredOutput, FormatterOptions $options)
    {
        if ($structuredOutput instanceof RestructureInterface) {
            return $structuredOutput->restructure($options);
        }
        return $structuredOutput;
    }

    /**
     * Allow the formatter access to the raw structured data prior
     * to restructuring.  For example, the 'list' formatter may wish
     * to display the row keys when provided table output.  If this
     * function returns a result that does not evaluate to 'false',
     * then that result will be used as-is, and restructuring and
     * validation will not occur.
     *
     * @param mixed $structuredOutput
     * @param FormatterOptions $options
     * @return mixed
     */
    public function overrideRestructure(FormatterInterface $formatter, $structuredOutput, FormatterOptions $options)
    {
        if ($formatter instanceof OverrideRestructureInterface) {
            return $formatter->overrideRestructure($structuredOutput, $options);
        }
    }

    /**
     * Allow the formatter to mess with the configuration options before any
     * transformations et. al. get underway.
     * @param FormatterInterface $formatter
     * @param mixed $structuredOutput
     * @param FormatterOptions $options
     * @return FormatterOptions
     */
    public function overrideOptions(FormatterInterface $formatter, $structuredOutput, FormatterOptions $options)
    {
        // Set the "Human Readable" option if the formatter has the HumanReadable marker interface
        if ($formatter instanceof HumanReadableFormat) {
            $options->setHumanReadable();
        }
        // The formatter may also make dynamic adjustment to the options.
        if ($formatter instanceof OverrideOptionsInterface) {
            return $formatter->overrideOptions($structuredOutput, $options);
        }
        return $options;
    }
}
