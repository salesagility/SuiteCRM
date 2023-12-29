<?php

namespace Consolidation\OutputFormatters\Transformations\Wrap;

use Symfony\Component\Console\Helper\TableStyle;

/**
 * Calculate the width of data in table cells in preparation for word wrapping.
 */
class ColumnWidths
{
    protected $widths;

    public function __construct($widths = [])
    {
        $this->widths = $widths;
    }

    public function paddingSpace(
        $paddingInEachCell,
        $extraPaddingAtEndOfLine = 0,
        $extraPaddingAtBeginningOfLine = 0
    ) {
        return ($extraPaddingAtBeginningOfLine + $extraPaddingAtEndOfLine + (count($this->widths) * $paddingInEachCell));
    }

    /**
     * Find all of the columns that are shorter than the specified threshold.
     */
    public function findShortColumns($thresholdWidth)
    {
        $thresholdWidths = array_fill_keys(array_keys($this->widths), $thresholdWidth);

        return $this->findColumnsUnderThreshold($thresholdWidths);
    }

    /**
     * Find all of the columns that are shorter than the corresponding minimum widths.
     */
    public function findUndersizedColumns($minimumWidths)
    {
        return $this->findColumnsUnderThreshold($minimumWidths->widths());
    }

    protected function findColumnsUnderThreshold(array $thresholdWidths)
    {
        $shortColWidths = [];
        foreach ($this->widths as $key => $maxLength) {
            if (isset($thresholdWidths[$key]) && ($maxLength <= $thresholdWidths[$key])) {
                $shortColWidths[$key] = $maxLength;
            }
        }

        return new ColumnWidths($shortColWidths);
    }

    /**
     * If the widths specified by this object do not fit within the
     * provided avaiable width, then reduce them all proportionally.
     */
    public function adjustMinimumWidths($availableWidth, $dataCellWidths)
    {
        $result = $this->selectColumns($dataCellWidths->keys());
        if ($result->isEmpty()) {
            return $result;
        }
        $numberOfColumns = $dataCellWidths->count();

        // How many unspecified columns are there?
        $unspecifiedColumns = $numberOfColumns - $result->count();
        $averageWidth = $this->averageWidth($availableWidth);

        // Reserve some space for the columns that have no minimum.
        // Make sure they collectively get at least half of the average
        // width for each column. Or should it be a quarter?
        $reservedSpacePerColumn = ($averageWidth / 2);
        $reservedSpace = $reservedSpacePerColumn * $unspecifiedColumns;

        // Calculate how much of the available space is remaining for use by
        // the minimum column widths after the reserved space is accounted for.
        $remainingAvailable = $availableWidth - $reservedSpace;

        // Don't do anything if our widths fit inside the available widths.
        if ($result->totalWidth() <= $remainingAvailable) {
            return $result;
        }

        // Shrink the minimum widths if the table is too compressed.
        return $result->distribute($remainingAvailable);
    }

    /**
     * Return proportional weights
     */
    public function distribute($availableWidth)
    {
        $result = [];
        $totalWidth = $this->totalWidth();
        $lastColumn = $this->lastColumn();
        $widths = $this->widths();

        // Take off the last column, and calculate proportional weights
        // for the first N-1 columns.
        array_pop($widths);
        foreach ($widths as $key => $width) {
            $result[$key] = round(($width / $totalWidth) * $availableWidth);
        }

        // Give the last column the rest of the available width
        $usedWidth = $this->sumWidth($result);
        $result[$lastColumn] = $availableWidth - $usedWidth;

        return new ColumnWidths($result);
    }

    public function lastColumn()
    {
        $keys = $this->keys();
        return array_pop($keys);
    }

    /**
     * Return the number of columns.
     */
    public function count()
    {
        return count($this->widths);
    }

    /**
     * Calculate how much space is available on average for all columns.
     */
    public function averageWidth($availableWidth)
    {
        if ($this->isEmpty()) {
            debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        }
        return $availableWidth / $this->count();
    }

    /**
     * Return the available keys (column identifiers) from the calculated
     * data set.
     */
    public function keys()
    {
        return array_keys($this->widths);
    }

    /**
     * Set the length of the specified column.
     */
    public function setWidth($key, $width)
    {
        $this->widths[$key] = $width;
    }

    /**
     * Return the length of the specified column.
     */
    public function width($key)
    {
        return isset($this->widths[$key]) ? $this->widths[$key] : 0;
    }

    /**
     * Return all of the lengths
     */
    public function widths()
    {
        return $this->widths;
    }

    /**
     * Return true if there is no data in this object
     */
    public function isEmpty()
    {
        return empty($this->widths);
    }

    /**
     * Return the sum of the lengths of the provided widths.
     */
    public function totalWidth()
    {
        return static::sumWidth($this->widths());
    }

    /**
     * Return the sum of the lengths of the provided widths.
     */
    public static function sumWidth($widths)
    {
        return array_reduce(
            $widths,
            function ($carry, $item) {
                return $carry + $item;
            }
        );
    }

    /**
     * Ensure that every item in $widths that has a corresponding entry
     * in $minimumWidths is as least as large as the minimum value held there.
     */
    public function enforceMinimums($minimumWidths)
    {
        $result = [];
        if ($minimumWidths instanceof ColumnWidths) {
            $minimumWidths = $minimumWidths->widths();
        }
        $minimumWidths += $this->widths;

        foreach ($this->widths as $key => $value) {
            $result[$key] = max($value, $minimumWidths[$key]);
        }

        return new ColumnWidths($result);
    }

    /**
     * Remove all of the specified columns from this data structure.
     */
    public function removeColumns($columnKeys)
    {
        $widths = $this->widths();

        foreach ($columnKeys as $key) {
            unset($widths[$key]);
        }

        return new ColumnWidths($widths);
    }

    /**
     * Select all columns that exist in the provided list of keys.
     */
    public function selectColumns($columnKeys)
    {
        $widths = [];

        foreach ($columnKeys as $key) {
            if (isset($this->widths[$key])) {
                $widths[$key] = $this->width($key);
            }
        }

        return new ColumnWidths($widths);
    }

    /**
     * Combine this set of widths with another set, and return
     * a new set that contains the entries from both.
     */
    public function combine(ColumnWidths $combineWith)
    {
        // Danger: array_merge renumbers numeric keys; that must not happen here.
        $combined = $combineWith->widths();
        foreach ($this->widths() as $key => $value) {
            $combined[$key] = $value;
        }
        return new ColumnWidths($combined);
    }
}
