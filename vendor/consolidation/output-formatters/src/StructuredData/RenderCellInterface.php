<?php

namespace Consolidation\OutputFormatters\StructuredData;

use Consolidation\OutputFormatters\Options\FormatterOptions;

interface RenderCellInterface
{
    /**
     * Convert the contents of one table cell into a string,
     * so that it may be placed in the table.  Renderer should
     * return the $cellData passed to it if it does not wish to
     * process it.
     *
     * @param string $key Identifier of the cell being rendered
     * @param mixed $cellData The data to render
     * @param FormatterOptions $options The formatting options
     * @param array $rowData The rest of the row data
     *
     * @return mixed
     */
    public function renderCell($key, $cellData, FormatterOptions $options, $rowData);
}
