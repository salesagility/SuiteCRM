<?php

namespace Consolidation\OutputFormatters\StructuredData;

use Consolidation\OutputFormatters\Options\FormatterOptions;

class CallableRenderer implements RenderCellInterface
{
    /** @var callable */
    protected $renderFunction;

    public function __construct(callable $renderFunction)
    {
        $this->renderFunction = $renderFunction;
    }

    /**
     * {@inheritdoc}
     */
    public function renderCell($key, $cellData, FormatterOptions $options, $rowData)
    {
        return call_user_func($this->renderFunction, $key, $cellData, $options, $rowData);
    }
}
