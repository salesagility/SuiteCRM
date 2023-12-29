<?php

namespace Consolidation\OutputFormatters\StructuredData;

use Consolidation\OutputFormatters\Options\FormatterOptions;
use Consolidation\OutputFormatters\StructuredData\RestructureInterface;
use Consolidation\OutputFormatters\Transformations\UnstructuredDataListTransformation;

/**
 * FieldProcessor will do various alterations on field sets.
 */
class FieldProcessor
{
    public static function processFieldAliases($fields)
    {
        if (!is_array($fields)) {
            $fields = array_filter(explode(',', $fields));
        }
        $transformed_fields = [];
        foreach ($fields as $field) {
            list($machine_name,$label) = explode(' as ', $field) + [$field, preg_replace('#.*\.#', '', $field)];
            $transformed_fields[$machine_name] = $label;
        }
        return $transformed_fields;
    }

    /**
     * Determine whether the data structure has unstructured field access,
     * e.g. `a.b.c` or `foo as bar`.
     * @param type $fields
     * @return type
     */
    public static function hasUnstructuredFieldAccess($fields)
    {
        if (is_array($fields)) {
            $fields = implode(',', $fields);
        }
        return (strpos($fields, ' as ') !== false) || (strpos($fields, '.') !== false);
    }
}
