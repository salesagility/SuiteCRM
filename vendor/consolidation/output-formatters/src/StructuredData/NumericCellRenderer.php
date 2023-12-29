<?php

namespace Consolidation\OutputFormatters\StructuredData;

use Consolidation\OutputFormatters\Options\FormatterOptions;
use Consolidation\OutputFormatters\Formatters\FormatterAwareInterface;
use Consolidation\OutputFormatters\Formatters\FormatterAwareTrait;

/**
 * Create a formatter to add commas to numeric data.
 *
 * Example:
 *
 *    -------
 *     Value
 *    -------
 *      2,384
 *    143,894
 *         23
 *     98,538
 *
 * This formatter may also be re-used for other purposes where right-justified
 * data is desired by simply making a subclass. See method comments below.
 *
 * Usage:
 *
 *     return (new RowsOfFields($data))->addRenderer(
 *          new NumericCellRenderer($data, ['value'])
 *     );
 *
 */
class NumericCellRenderer implements RenderCellInterface, FormatterAwareInterface
{
    use FormatterAwareTrait;

    protected $data;
    protected $renderedColumns;
    protected $widths = [];

    /**
     * NumericCellRenderer constructor
     */
    public function __construct($data, $renderedColumns)
    {
        $this->data = $data;
        $this->renderedColumns = $renderedColumns;
    }

    /**
     * @inheritdoc
     */
    public function renderCell($key, $cellData, FormatterOptions $options, $rowData)
    {
        if (!$this->isRenderedFormat($options) || !$this->isRenderedColumn($key)) {
            return $cellData;
        }
        if ($this->isRenderedData($cellData)) {
            $cellData = $this->formatCellData($cellData);
        }
        return $this->justifyCellData($key, $cellData);
    }

    /**
     * Right-justify the cell data.
     */
    protected function justifyCellData($key, $cellData = "")
    {
        return str_pad((string) $cellData, $this->columnWidth($key), " ", STR_PAD_LEFT);
    }

    /**
     * Determine if this format is to be formatted.
     */
    protected function isRenderedFormat(FormatterOptions $options)
    {
        return $this->isHumanReadable();
    }

    /**
     * Determine if this is a column that should be formatted.
     */
    protected function isRenderedColumn($key)
    {
        return array_key_exists($key, $this->renderedColumns);
    }

    /**
     * Ignore cell data that should not be formatted.
     */
    protected function isRenderedData($cellData)
    {
        return is_numeric($cellData);
    }

    /**
     * Format the cell data.
     */
    protected function formatCellData($cellData)
    {
        return number_format($this->convertCellDataToString($cellData));
    }

    /**
     * This formatter only works with columns whose columns are strings.
     * To use this formatter for another purpose, override this method
     * to ensure that the cell data is a string before it is formatted.
     */
    protected function convertCellDataToString($cellData)
    {
        return $cellData;
    }

    /**
     * Get the cached column width for the provided key.
     */
    protected function columnWidth($key)
    {
        if (!isset($this->widths[$key])) {
            $this->widths[$key] = $this->calculateColumnWidth($key);
        }
        return $this->widths[$key];
    }

    /**
     * Using the cached table data, calculate the largest width
     * for the data in the table for use when right-justifying.
     */
    protected function calculateColumnWidth($key)
    {
        $width = isset($this->renderedColumns[$key]) ? $this->renderedColumns[$key] : 0;
        foreach ($this->data as $row) {
            $data = $this->formatCellData($row[$key]);
            $width = max(strlen($data), $width);
        }
        return $width;
    }
}
