<?php

namespace Consolidation\OutputFormatters\Validate;

/**
 * Provides a default implementation of isValidDataType.
 *
 * Users of this trait are expected to implement ValidDataTypesInterface.
 */
trait ValidDataTypesTrait
{
    /**
     * Return the list of data types acceptable to this formatter
     *
     * @return \ReflectionClass[]
     */
    abstract public function validDataTypes();

    /**
     * Return the list of data types acceptable to this formatter
     */
    public function isValidDataType(\ReflectionClass $dataType)
    {
        return array_reduce(
            $this->validDataTypes(),
            function ($carry, $supportedType) use ($dataType) {
                return
                    $carry ||
                    ($dataType->getName() == $supportedType->getName()) ||
                    ($dataType->isSubclassOf($supportedType->getName()));
            },
            false
        );
    }
}
