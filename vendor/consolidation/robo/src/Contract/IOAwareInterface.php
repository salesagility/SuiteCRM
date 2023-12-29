<?php

/**
 * Marker interface for tasks that use the IO trait
 */

namespace Robo\Contract;

use Symfony\Component\Console\Input\InputAwareInterface;
use Consolidation\AnnotatedCommand\State\SavableState;

interface IOAwareInterface extends OutputAwareInterface, InputAwareInterface, SavableState
{
}
