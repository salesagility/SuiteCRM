<?php

namespace Consolidation\OutputFormatters\StructuredData;

use Consolidation\OutputFormatters\Options\FormatterOptions;

interface MetadataInterface
{
    /**
     * Return the metadata associated with the structured data (if any)
     */
    public function getMetadata();
}
