<?php

namespace Consolidation\OutputFormatters\StructuredData;

use Consolidation\OutputFormatters\Options\FormatterOptions;

interface ListDataInterface
{
    /**
     * Convert data to a format suitable for use in a list.
     * By default, the array values will be used.  Implement
     * ListDataInterface to use some other criteria (e.g. array keys).
     *
     * @return array
     */
    public function getListData(FormatterOptions $options);
}
