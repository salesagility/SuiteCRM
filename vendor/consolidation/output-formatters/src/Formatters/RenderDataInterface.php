<?php

namespace Consolidation\OutputFormatters\Formatters;

use Consolidation\OutputFormatters\Options\FormatterOptions;

interface RenderDataInterface
{
    /**
     * Convert the contents of the output data just before it
     * is to be printed, prior to output but after restructuring
     * and validation.
     *
     * @param mixed $originalData
     * @param mixed $restructuredData
     * @param FormatterOptions $options Formatting options
     * @return mixed
     */
    public function renderData($originalData, $restructuredData, FormatterOptions $options);
}
