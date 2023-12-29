<?php

namespace Consolidation\OutputFormatters\StructuredData;

use Consolidation\OutputFormatters\Options\FormatterOptions;

/**
 * UnstructuredInterface is a marker interface that indicates that the
 * data type is unstructured, and has no default conversion to a string.
 * Unstructured data supports the `string` format only if it also implements
 * StringTransformationInterface.
 */
interface UnstructuredInterface
{
}
