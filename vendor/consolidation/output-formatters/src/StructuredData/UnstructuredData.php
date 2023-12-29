<?php

namespace Consolidation\OutputFormatters\StructuredData;

use Consolidation\OutputFormatters\Options\FormatterOptions;
use Consolidation\OutputFormatters\StructuredData\RestructureInterface;
use Consolidation\OutputFormatters\Transformations\UnstructuredDataTransformation;

/**
 * Represents aribtrary unstructured array data where the
 * data to display in --list format comes from the array keys.
 *
 * Unstructured list data can have variable keys in every rown (unlike
 * RowsOfFields, which expects uniform rows), and the data elements may
 * themselves be deep arrays.
 */
class UnstructuredData extends AbstractListData implements UnstructuredInterface, RestructureInterface
{
    public function __construct($data)
    {
        parent::__construct($data);
    }

    public function restructure(FormatterOptions $options)
    {
        $defaults = $this->defaultOptions();
        $fields = $this->getFields($options, $defaults);

        return new UnstructuredDataTransformation($this->getArrayCopy(), FieldProcessor::processFieldAliases($fields));
    }
}
