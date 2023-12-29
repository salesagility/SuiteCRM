<?php

namespace Consolidation\OutputFormatters\StructuredData\Xml;

interface DomDataInterface
{
    /**
     * Convert data into a \DomDocument.
     *
     * @return \DomDocument
     */
    public function getDomData();
}
