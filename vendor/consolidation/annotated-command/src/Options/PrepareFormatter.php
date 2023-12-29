<?php
namespace Consolidation\AnnotatedCommand\Options;

use Consolidation\AnnotatedCommand\CommandData;
use Consolidation\OutputFormatters\Options\FormatterOptions;

interface PrepareFormatter
{
    public function prepare(CommandData $commandData, FormatterOptions $options);
}
