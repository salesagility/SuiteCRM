<?php

namespace Consolidation\OutputFormatters\Transformations;

use Consolidation\OutputFormatters\Options\FormatterOptions;

interface OverrideRestructureInterface
{
    /**
     * Select data to use directly from the structured output,
     * before the restructure operation has been executed.
     *
     * @param mixed $structuredOutput Data to restructure
     * @param FormatterOptions $options Formatting options
     * @return mixed
     */
    public function overrideRestructure($structuredOutput, FormatterOptions $options);
}
