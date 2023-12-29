<?php

namespace Consolidation\OutputFormatters\StructuredData;

use Consolidation\OutputFormatters\Formatters\FormatterAwareInterface;

interface RenderCellCollectionInterface extends RenderCellInterface, FormatterAwareInterface
{
    const PRIORITY_FIRST = 'first';
    const PRIORITY_NORMAL = 'normal';
    const PRIORITY_FALLBACK = 'fallback';

    /**
     * Add a renderer
     *
     * @return $this
     */
    public function addRenderer(RenderCellInterface $renderer);
}
