<?php

namespace Consolidation\OutputFormatters\StructuredData;

interface OriginalDataInterface
{
    /**
     * Return the original data for this table.  Used by any
     * formatter that expects an array.
     */
    public function getOriginalData();
}
