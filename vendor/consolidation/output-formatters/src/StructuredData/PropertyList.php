<?php

namespace Consolidation\OutputFormatters\StructuredData;

use Consolidation\OutputFormatters\Options\FormatterOptions;
use Consolidation\OutputFormatters\StructuredData\ListDataInterface;
use Consolidation\OutputFormatters\Transformations\PropertyParser;
use Consolidation\OutputFormatters\Transformations\ReorderFields;
use Consolidation\OutputFormatters\Transformations\TableTransformation;
use Consolidation\OutputFormatters\Transformations\PropertyListTableTransformation;

/**
 * Holds an array where each element of the array is one
 * key : value pair.  The keys must be unique, as is typically
 * the case for associative arrays.
 */
class PropertyList extends AbstractStructuredList implements ConversionInterface
{
    /**
     * @inheritdoc
     */
    public function convert(FormatterOptions $options)
    {
        $defaults = $this->defaultOptions();
        $fields = $this->getFields($options, $defaults);
        if (FieldProcessor::hasUnstructuredFieldAccess($fields)) {
            return new UnstructuredData($this->getArrayCopy());
        }
        return $this;
    }

    /**
     * Restructure this data for output by converting it into a table
     * transformation object.
     *
     * @param FormatterOptions $options Options that affect output formatting.
     * @return Consolidation\OutputFormatters\Transformations\TableTransformation
     */
    public function restructure(FormatterOptions $options)
    {
        $data = [$this->getArrayCopy()];
        $options->setConfigurationDefault('list-orientation', true);
        $tableTransformer = $this->createTableTransformation($data, $options);
        return $tableTransformer;
    }

    public function getListData(FormatterOptions $options)
    {
        $data = $this->getArrayCopy();

        $defaults = $this->defaultOptions();
        $fieldLabels = $this->getReorderedFieldLabels([$data], $options, $defaults);

        $result = [];
        foreach ($fieldLabels as $id => $label) {
            $result[$id] = $data[$id];
        }
        return $result;
    }

    protected function defaultOptions()
    {
        return [
            FormatterOptions::LIST_ORIENTATION => true,
        ] + parent::defaultOptions();
    }

    protected function instantiateTableTransformation($data, $fieldLabels, $rowLabels)
    {
        return new PropertyListTableTransformation($data, $fieldLabels, $rowLabels);
    }
}
