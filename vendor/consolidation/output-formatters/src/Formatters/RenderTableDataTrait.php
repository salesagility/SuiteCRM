<?php

namespace Consolidation\OutputFormatters\Formatters;

use Consolidation\OutputFormatters\Options\FormatterOptions;
use Consolidation\OutputFormatters\StructuredData\RenderCellInterface;

trait RenderTableDataTrait
{
    /**
     * @inheritdoc
     */
    public function renderData($originalData, $restructuredData, FormatterOptions $options)
    {
        if ($originalData instanceof RenderCellInterface) {
            return $this->renderEachCell($originalData, $restructuredData, $options);
        }
        return $restructuredData;
    }

    protected function renderEachCell($originalData, $restructuredData, FormatterOptions $options)
    {
        foreach ($restructuredData as $id => $row) {
            foreach ($row as $key => $cellData) {
                $restructuredData[$id][$key] = $originalData->renderCell($key, $cellData, $options, $row);
            }
        }
        return $restructuredData;
    }
}
