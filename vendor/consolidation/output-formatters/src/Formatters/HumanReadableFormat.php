<?php

namespace Consolidation\OutputFormatters\Formatters;

/**
 * Marker interface that indicates that a cell data renderer
 * (@see Consolidation\OutputFormatters\SturcturedData\RenderCellInterface)
 * may test for to determine whether it is allowable to add
 * human-readable formatting into the cell data
 * (@see Consolidation\OutputFormatters\SturcturedData\NumericCallRenderer).
 */
interface HumanReadableFormat
{
}
