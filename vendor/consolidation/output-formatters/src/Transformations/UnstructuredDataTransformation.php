<?php

namespace Consolidation\OutputFormatters\Transformations;

use Consolidation\OutputFormatters\Options\FormatterOptions;

class UnstructuredDataTransformation extends \ArrayObject implements StringTransformationInterface
{
    protected $originalData;

    public function __construct($data, $fields)
    {
        $this->originalData = $data;
        $rows = static::transformRow($data, $fields);
        parent::__construct($rows);
    }

    public function simplifyToString(FormatterOptions $options)
    {
        return static::simplifyRow($this->getArrayCopy());
    }

    public static function transformRow($row, $fields)
    {
        if (empty($fields)) {
            return $row;
        }
        $fieldAccessor = new UnstructuredDataFieldAccessor($row);
        return $fieldAccessor->get($fields);
    }

    public static function simplifyRow($row)
    {
        if (is_string($row)) {
            return $row;
        }
        if (static::isSimpleArray($row)) {
            return implode("\n", $row);
        }
        // No good way to simplify - just dump a json fragment
        return json_encode($row);
    }

    protected static function isSimpleArray($row)
    {
        foreach ($row as $item) {
            if (!is_string($item)) {
                return false;
            }
        }
        return true;
    }
}
