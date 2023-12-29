<?php

namespace Consolidation\OutputFormatters\Validate;

/**
 * Formatters may implement ValidationInterface in order to indicate
 * whether a particular data structure is supported.  Any formatter that does
 * not implement ValidationInterface is assumed to only operate on arrays,
 * or data types that implement SimplifyToArrayInterface.
 */
interface ValidationInterface
{
    /**
     * Return true if the specified format is valid for use with
     * this formatter.
     */
    public function isValidDataType(\ReflectionClass $dataType);

    /**
     * Throw an IncompatibleDataException if the provided data cannot
     * be processed by this formatter.  Return the source data if it
     * is valid. The data may be encapsulated or converted if necessary.
     *
     * @param mixed $structuredData Data to validate
     *
     * @return mixed
     */
    public function validate($structuredData);
}
