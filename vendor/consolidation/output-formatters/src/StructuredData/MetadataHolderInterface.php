<?php

namespace Consolidation\OutputFormatters\StructuredData;

use Consolidation\OutputFormatters\Options\FormatterOptions;

interface MetadataHolderInterface
{
    public function getDataKey();
    public function setDataKey($key);
    public function getMetadataKey();
    public function setMetadataKey($key);
    public function extractData($data);
    public function extractMetadata($data);
    public function reconstruct($data, $metadata);
}
