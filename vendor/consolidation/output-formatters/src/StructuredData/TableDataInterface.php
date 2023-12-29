<?php

namespace Consolidation\OutputFormatters\StructuredData;

interface TableDataInterface
{
    /**
     * Convert structured data into a form suitable for use
     * by the table formatter.
     *
     * @param boolean $includeRowKey Add a field containing the
     *   key from each row.
     *
     * @return array
     */
    public function getTableData($includeRowKey = false);
}
