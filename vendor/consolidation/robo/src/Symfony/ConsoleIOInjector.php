<?php

namespace Robo\Symfony;

use Consolidation\AnnotatedCommand\CommandData;
use Consolidation\AnnotatedCommand\CommandProcessor;
use Consolidation\AnnotatedCommand\ParameterInjector;
use Symfony\Component\Console\Style\SymfonyStyle;

class ConsoleIOInjector implements ParameterInjector
{
    public function get(CommandData $commandData, $interfaceName)
    {
        return new ConsoleIO($commandData->input(), $commandData->output());
    }
}
