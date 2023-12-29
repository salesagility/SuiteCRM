<?php

namespace Consolidation\OutputFormatters\Formatters;

trait FormatterAwareTrait
{
    protected $formatter;

    public function setFormatter(FormatterInterface $formatter)
    {
        $this->formatter = $formatter;
    }

    public function getFormatter()
    {
        return $this->formatter;
    }

    public function isHumanReadable()
    {
        return $this->formatter && $this->formatter instanceof \Consolidation\OutputFormatters\Formatters\HumanReadableFormat;
    }
}
