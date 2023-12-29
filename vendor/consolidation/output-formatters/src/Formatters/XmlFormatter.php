<?php

namespace Consolidation\OutputFormatters\Formatters;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableStyle;
use Consolidation\OutputFormatters\Validate\ValidDataTypesInterface;
use Consolidation\OutputFormatters\Options\FormatterOptions;
use Consolidation\OutputFormatters\Validate\ValidDataTypesTrait;
use Consolidation\OutputFormatters\StructuredData\TableDataInterface;
use Consolidation\OutputFormatters\Transformations\ReorderFields;
use Consolidation\OutputFormatters\Exception\IncompatibleDataException;
use Consolidation\OutputFormatters\StructuredData\Xml\DomDataInterface;

/**
 * Display a table of data with the Symfony Table class.
 *
 * This formatter takes data of either the RowsOfFields or
 * PropertyList data type.  Tables can be rendered with the
 * rows running either vertically (the normal orientation) or
 * horizontally.  By default, associative lists will be displayed
 * as two columns, with the key in the first column and the
 * value in the second column.
 */
class XmlFormatter implements FormatterInterface, ValidDataTypesInterface
{
    use ValidDataTypesTrait;

    public function __construct()
    {
    }

    public function validDataTypes()
    {
        return
            [
                new \ReflectionClass('\DOMDocument'),
                new \ReflectionClass('\ArrayObject'),
            ];
    }

    /**
     * @inheritdoc
     */
    public function validate($structuredData)
    {
        if ($structuredData instanceof \DOMDocument) {
            return $structuredData;
        }
        if ($structuredData instanceof DomDataInterface) {
            return $structuredData->getDomData();
        }
        if ($structuredData instanceof \ArrayObject) {
            return $structuredData->getArrayCopy();
        }
        if (!is_array($structuredData)) {
            throw new IncompatibleDataException(
                $this,
                $structuredData,
                $this->validDataTypes()
            );
        }
        return $structuredData;
    }

    /**
     * @inheritdoc
     */
    public function write(OutputInterface $output, $dom, FormatterOptions $options)
    {
        if (is_array($dom)) {
            $schema = $options->getXmlSchema();
            $dom = $schema->arrayToXML($dom);
        }
        $dom->formatOutput = true;
        $output->writeln($dom->saveXML());
    }
}
