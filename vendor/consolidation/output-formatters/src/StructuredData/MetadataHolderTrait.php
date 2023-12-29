<?php

namespace Consolidation\OutputFormatters\StructuredData;

/**
 * A structured data object may contains some elements that
 * are actually metadata. Metadata is not included in the
 * output of tabular data formatters (e.g. table, csv), although
 * some of these (e.g. table) may render the metadata alongside
 * the data. Raw data formatters (e.g. yaml, json) will render
 * both the data and the metadata.
 *
 * There are two possible options for the data format; either the
 * data is nested inside some element, and ever other item is
 * metadata, or the metadata may be nested inside some element,
 * and every other item is the data rows.
 *
 * Example 1: nested data
 *
 * [
 *     'data' => [ ... rows of field data ... ],
 *     'metadata1' => '...',
 *     'metadata2' => '...',
 * ]
 *
 * Example 2: nested metadata
 *
 * [
 *      'metadata' => [ ... metadata items ... ],
 *      'rowid1' => [ ... ],
 *      'rowid2' => [ ... ],
 * ]
 *
 * It is, of course, also possible that both the data and
 * the metadata may be nested inside subelements.
 */
trait MetadataHolderTrait
{
    protected $dataKey = false;
    protected $metadataKey = false;

    public function getDataKey()
    {
        return $this->dataKey;
    }

    public function setDataKey($key)
    {
        $this->dataKey = $key;
        return $this;
    }

    public function getMetadataKey()
    {
        return $this->metadataKey;
    }

    public function setMetadataKey($key)
    {
        $this->metadataKey = $key;
        return $this;
    }

    public function extractData($data)
    {
        if ($this->metadataKey) {
            unset($data[$this->metadataKey]);
        }
        if ($this->dataKey) {
            if (!isset($data[$this->dataKey])) {
                return [];
            }
            return $data[$this->dataKey];
        }
        return $data;
    }

    public function extractMetadata($data)
    {
        if (!$this->dataKey && !$this->metadataKey) {
            return [];
        }
        if ($this->dataKey) {
            unset($data[$this->dataKey]);
        }
        if ($this->metadataKey) {
            if (!isset($data[$this->metadataKey])) {
                return [];
            }
            return $data[$this->metadataKey];
        }
        return $data;
    }

    public function reconstruct($data, $metadata)
    {
        $reconstructedData = ($this->dataKey) ? [$this->dataKey => $data] : $data;
        $reconstructedMetadata = ($this->metadataKey) ? [$this->metadataKey => $metadata] : $metadata;

        return $reconstructedData + $reconstructedMetadata;
    }
}
