<?php

namespace Consolidation\OutputFormatters\Formatters;

interface FormatterAwareInterface
{
    public function setFormatter(FormatterInterface $formatter);
    public function getFormatter();
    public function isHumanReadable();
}
