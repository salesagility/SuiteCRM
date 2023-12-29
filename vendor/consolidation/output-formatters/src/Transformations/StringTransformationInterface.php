<?php

namespace Consolidation\OutputFormatters\Transformations;

use Consolidation\OutputFormatters\Options\FormatterOptions;

interface StringTransformationInterface
{
    /**
     * simplifyToString is called by the string formatter to convert
     * structured data to a simple string.
     */
    public function simplifyToString(FormatterOptions $options);
}
