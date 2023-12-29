<?php

namespace Consolidation\OutputFormatters\StructuredData;

use Consolidation\OutputFormatters\Options\FormatterOptions;

/**
 * A RowsOfFields data structure that also contains metadata.
 * @see MetadataHolderTrait
 */
class RowsOfFieldsWithMetadata extends RowsOfFields implements MetadataInterface, MetadataHolderInterface
{
    use MetadataHolderTrait;

    /**
     * Restructure this data for output by converting it into a table
     * transformation object. First, though, remove any metadata items.
     *
     * @param FormatterOptions $options Options that affect output formatting.
     * @return Consolidation\OutputFormatters\Transformations\TableTransformation
     */
    public function restructure(FormatterOptions $options)
    {
        $originalData = $this->getArrayCopy();
        $data = $this->extractData($originalData);
        $tableTranformer = $this->createTableTransformation($data, $options);
        $tableTranformer->setOriginalData($this);
        return $tableTranformer;
    }

    public function getMetadata()
    {
        return $this->extractMetadata($this->getArrayCopy());
    }
}
