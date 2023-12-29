<?php

namespace Consolidation\OutputFormatters\Validate;

/**
 * Formatters may implement ValidDataTypesInterface in order to indicate
 * exactly which formats they support.  The validDataTypes method can be
 * called to retrieve a list of data types useful in providing hints in
 * exception messages about which data types can be used with the formatter.
 *
 * Note that it is OPTIONAL for formatters to implement this interface.
 * If a formatter implements only ValidationInterface, then clients that
 * request the formatter via FormatterManager::write() will still get a list
 * (via an InvalidFormatException) of all of the formats that are usable
 * with the provided data type.  Implementing ValidDataTypesInterface is
 * benefitial to clients who instantiate a formatter directly (via `new`).
 *
 * Formatters that implement ValidDataTypesInterface may wish to use
 * ValidDataTypesTrait.
 */
interface ValidDataTypesInterface extends ValidationInterface
{
    /**
     * Return the list of data types acceptable to this formatter
     *
     * @return \ReflectionClass[]
     */
    public function validDataTypes();
}
