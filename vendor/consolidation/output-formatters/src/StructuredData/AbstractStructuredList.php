<?php

namespace Consolidation\OutputFormatters\StructuredData;

use Consolidation\OutputFormatters\StructuredData\RestructureInterface;
use Consolidation\OutputFormatters\Options\FormatterOptions;
use Consolidation\OutputFormatters\StructuredData\ListDataInterface;
use Consolidation\OutputFormatters\Transformations\TableTransformation;

/**
 * Holds an array where each element of the array is one row,
 * and each row contains an associative array where the keys
 * are the field names, and the values are the field data.
 *
 * It is presumed that every row contains the same keys.
 */
abstract class AbstractStructuredList extends AbstractListData implements RestructureInterface, RenderCellCollectionInterface
{
    use RenderCellCollectionTrait;

    public function __construct($data)
    {
        parent::__construct($data);
    }

    abstract public function restructure(FormatterOptions $options);

    protected function createTableTransformation($data, $options)
    {
        $defaults = $this->defaultOptions();
        $fieldLabels = $this->getReorderedFieldLabels($data, $options, $defaults);

        $tableTransformer = $this->instantiateTableTransformation($data, $fieldLabels, $options->get(FormatterOptions::ROW_LABELS, $defaults));
        if ($options->get(FormatterOptions::LIST_ORIENTATION, $defaults)) {
            $tableTransformer->setLayout(TableTransformation::LIST_LAYOUT);
        }

        return $tableTransformer;
    }

    protected function instantiateTableTransformation($data, $fieldLabels, $rowLabels)
    {
        return new TableTransformation($data, $fieldLabels, $rowLabels);
    }

    protected function defaultOptions()
    {
        return [
            FormatterOptions::ROW_LABELS => [],
            FormatterOptions::DEFAULT_FIELDS => [],
        ] + parent::defaultOptions();
    }
}
