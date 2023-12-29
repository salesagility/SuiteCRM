<?php

namespace Consolidation\OutputFormatters\StructuredData;

use Consolidation\OutputFormatters\Options\FormatterOptions;

interface RestructureInterface
{
    /**
     * Allow structured data to be restructured -- i.e. to select fields
     * to show, reorder fields, etc.
     *
     * @param FormatterOptions $options Formatting options
     */
    public function restructure(FormatterOptions $options);
}
