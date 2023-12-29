<?php

namespace Consolidation\OutputFormatters\Formatters;

use Consolidation\OutputFormatters\Options\FormatterOptions;
use Consolidation\OutputFormatters\StructuredData\ListDataInterface;
use Consolidation\OutputFormatters\StructuredData\RenderCellInterface;
use Consolidation\OutputFormatters\Transformations\OverrideRestructureInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Display the data in a simple list.
 *
 * This formatter prints a plain, unadorned list of data,
 * with each data item appearing on a separate line.  If you
 * wish your list to contain headers, then use the table
 * formatter, and wrap your data in an PropertyList.
 */
class ListFormatter implements FormatterInterface, OverrideRestructureInterface, RenderDataInterface
{
    /**
     * @inheritdoc
     */
    public function write(OutputInterface $output, $data, FormatterOptions $options)
    {
        $output->writeln(implode("\n", $data));
    }

    /**
     * @inheritdoc
     */
    public function overrideRestructure($structuredOutput, FormatterOptions $options)
    {
        // If the structured data implements ListDataInterface,
        // then we will render whatever data its 'getListData'
        // method provides.
        if ($structuredOutput instanceof ListDataInterface) {
            return $this->renderData($structuredOutput, $structuredOutput->getListData($options), $options);
        }
    }

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
        foreach ($restructuredData as $key => $cellData) {
            $restructuredData[$key] = $originalData->renderCell($key, $cellData, $options, $restructuredData);
        }
        return $restructuredData;
    }
}
