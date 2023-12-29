<?php

namespace Consolidation\OutputFormatters\Transformations;

class PropertyListTableTransformation extends TableTransformation
{
    public function getOriginalData()
    {
        $data = $this->getArrayCopy();
        return $data[0];
    }
}
