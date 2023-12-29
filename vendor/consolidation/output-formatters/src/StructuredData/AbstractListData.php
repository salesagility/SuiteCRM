<?php

namespace Consolidation\OutputFormatters\StructuredData;

use Consolidation\OutputFormatters\Options\FormatterOptions;
use Consolidation\OutputFormatters\Transformations\ReorderFields;

/**
 * Base class for all list data types.
 */
class AbstractListData extends \ArrayObject implements ListDataInterface
{
    public function __construct($data)
    {
        parent::__construct($data);
    }

    public function getListData(FormatterOptions $options)
    {
        return array_keys($this->getArrayCopy());
    }

    protected function getReorderedFieldLabels($data, $options, $defaults)
    {
        $reorderer = new ReorderFields();
        $fieldLabels = $reorderer->reorder(
            $this->getFields($options, $defaults),
            $options->get(FormatterOptions::FIELD_LABELS, $defaults),
            $data
        );
        return $fieldLabels;
    }

    protected function getFields($options, $defaults)
    {
        $fieldShortcut = $options->get(FormatterOptions::FIELD);
        if (!empty($fieldShortcut)) {
            return [$fieldShortcut];
        }
        $result = $options->get(FormatterOptions::FIELDS);
        if (!empty($result)) {
            return $result;
        }
        $isHumanReadable = $options->get(FormatterOptions::HUMAN_READABLE);
        if ($isHumanReadable) {
            $result = $options->get(FormatterOptions::DEFAULT_TABLE_FIELDS);
            if (!empty($result)) {
                return $result;
            }
        }
        return $options->get(FormatterOptions::DEFAULT_FIELDS, $defaults);
    }

    /**
     * A structured list may provide its own set of default options. These
     * will be used in place of the command's default options (from the
     * annotations) in instances where the user does not provide the options
     * explicitly (on the commandline) or implicitly (via a configuration file).
     *
     * @return array
     */
    protected function defaultOptions()
    {
        return [
            FormatterOptions::FIELDS => [],
            FormatterOptions::FIELD_LABELS => [],
        ];
    }
}
