<?php

namespace Consolidation\OutputFormatters\Formatters;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use Consolidation\OutputFormatters\Validate\ValidDataTypesInterface;
use Consolidation\OutputFormatters\Options\FormatterOptions;
use Consolidation\OutputFormatters\Validate\ValidDataTypesTrait;
use Consolidation\OutputFormatters\StructuredData\TableDataInterface;
use Consolidation\OutputFormatters\Transformations\ReorderFields;
use Consolidation\OutputFormatters\Exception\IncompatibleDataException;
use Consolidation\OutputFormatters\StructuredData\PropertyList;

/**
 * Display sections of data.
 *
 * This formatter takes data in the RowsOfFields data type.
 * Each row represents one section; the data in each section
 * is rendered in two columns, with the key in the first column
 * and the value in the second column.
 */
class SectionsFormatter implements FormatterInterface, ValidDataTypesInterface, RenderDataInterface
{
    use ValidDataTypesTrait;
    use RenderTableDataTrait;

    public function validDataTypes()
    {
        return
            [
                new \ReflectionClass('\Consolidation\OutputFormatters\StructuredData\RowsOfFields')
            ];
    }

    /**
     * @inheritdoc
     */
    public function validate($structuredData)
    {
        // If the provided data was of class RowsOfFields
        // or PropertyList, it will be converted into
        // a TableTransformation object by the restructure call.
        if (!$structuredData instanceof TableDataInterface) {
            throw new IncompatibleDataException(
                $this,
                $structuredData,
                $this->validDataTypes()
            );
        }
        return $structuredData;
    }

    /**
     * @inheritdoc
     */
    public function write(OutputInterface $output, $tableTransformer, FormatterOptions $options)
    {
        $table = new Table($output);
        $table->setStyle('compact');
        foreach ($tableTransformer as $rowid => $row) {
            $rowLabel = $tableTransformer->getRowLabel($rowid);
            $output->writeln('');
            $output->writeln($rowLabel);
            $sectionData = new PropertyList($row);
            $sectionOptions = new FormatterOptions([], $options->getOptions());
            $sectionTableTransformer = $sectionData->restructure($sectionOptions);
            $table->setRows($sectionTableTransformer->getTableData(true));
            $table->render();
        }
    }
}
