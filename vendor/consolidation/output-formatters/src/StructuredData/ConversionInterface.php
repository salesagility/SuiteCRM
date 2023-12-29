<?php

namespace Consolidation\OutputFormatters\StructuredData;

use Consolidation\OutputFormatters\Options\FormatterOptions;

interface ConversionInterface
{
    /**
     * Allow structured data to be converted -- i.e. from
     * RowsOfFields to UnstructuredListData.
     *
     * @param FormatterOptions $options Formatting options
     */
    public function convert(FormatterOptions $options);
}
