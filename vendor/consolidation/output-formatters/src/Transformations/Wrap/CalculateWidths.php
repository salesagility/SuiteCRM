<?php

namespace Consolidation\OutputFormatters\Transformations\Wrap;

use Symfony\Component\Console\Helper\TableStyle;

/**
 * Calculate column widths for table cells.
 *
 * Influenced by Drush and webmozart/console.
 */
class CalculateWidths
{
    public function __construct()
    {
    }

    /**
     * Given the total amount of available space, and the width of
     * the columns to place, calculate the optimum column widths to use.
     */
    public function calculate($availableWidth, ColumnWidths $dataWidths, ColumnWidths $minimumWidths)
    {
        // First, check to see if all columns will fit at their full widths.
        // If so, do no further calculations. (This may be redundant with
        // the short column width calculation.)
        if ($dataWidths->totalWidth() <= $availableWidth) {
            return $dataWidths->enforceMinimums($minimumWidths);
        }

        // Get the short columns first. If there are none, then distribute all
        // of the available width among the remaining columns.
        $shortColWidths = $this->getShortColumns($availableWidth, $dataWidths, $minimumWidths);
        if ($shortColWidths->isEmpty()) {
            return $this->distributeLongColumns($availableWidth, $dataWidths, $minimumWidths);
        }

        // If some short columns were removed, then account for the length
        // of the removed columns and make a recursive call (since the average
        // width may be higher now, if the removed columns were shorter in
        // length than the previous average).
        $availableWidth -= $shortColWidths->totalWidth();
        $remainingWidths = $dataWidths->removeColumns($shortColWidths->keys());
        $remainingColWidths = $this->calculate($availableWidth, $remainingWidths, $minimumWidths);

        return $shortColWidths->combine($remainingColWidths);
    }

    /**
     * Calculate the longest cell data from any row of each of the cells.
     */
    public function calculateLongestCell($rows)
    {
        return $this->calculateColumnWidths(
            $rows,
            function ($cell) {
                return strlen($cell);
            }
        );
    }

    /**
     * Calculate the longest word and longest line in the provided data.
     */
    public function calculateLongestWord($rows)
    {
        return $this->calculateColumnWidths(
            $rows,
            function ($cell) {
                return static::longestWordLength($cell);
            }
        );
    }

    protected function calculateColumnWidths($rows, callable $fn)
    {
        $widths = [];

        // Examine each row and find the longest line length and longest
        // word in each column.
        foreach ($rows as $rowkey => $row) {
            foreach ($row as $colkey => $cell) {
                $value = $fn((string) $cell);
                if ((!isset($widths[$colkey]) || ($widths[$colkey] < $value))) {
                    $widths[$colkey] = $value;
                }
            }
        }

        return new ColumnWidths($widths);
    }

    /**
     * Return all of the columns whose longest line length is less than or
     * equal to the average width.
     */
    public function getShortColumns($availableWidth, ColumnWidths $dataWidths, ColumnWidths $minimumWidths)
    {
        $averageWidth = $dataWidths->averageWidth($availableWidth);
        $shortColWidths = $dataWidths->findShortColumns($averageWidth);
        return $shortColWidths->enforceMinimums($minimumWidths);
    }

    /**
     * Distribute the remainig space among the columns that were not
     * included in the list of "short" columns.
     */
    public function distributeLongColumns($availableWidth, ColumnWidths $dataWidths, ColumnWidths $minimumWidths)
    {
        // First distribute the remainder without regard to the minimum widths.
        $result = $dataWidths->distribute($availableWidth);

        // Find columns that are shorter than their minimum width.
        $undersized = $result->findUndersizedColumns($minimumWidths);

        // Nothing too small? Great, we're done!
        if ($undersized->isEmpty()) {
            return $result;
        }

        // Take out the columns that are too small and redistribute the rest.
        $availableWidth -= $undersized->totalWidth();
        $remaining = $dataWidths->removeColumns($undersized->keys());
        $distributeRemaining = $this->distributeLongColumns($availableWidth, $remaining, $minimumWidths);

        return $undersized->combine($distributeRemaining);
    }

    /**
     * Return the length of the longest word in the string.
     * @param string $str
     * @return int
     */
    protected static function longestWordLength($str)
    {
        $words = preg_split('#[ /-]#', $str);
        $lengths = array_map(function ($s) {
            return strlen($s);
        }, $words);
        return max($lengths);
    }
}
