<?php

/**
 * Provide OutputAwareInterface, not present in Symfony Console
 */

namespace Robo\Contract;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * @deprecated Use \Consolidation\AnnotatedCommand\Output\OutputAwareInterface directly
 */
interface OutputAwareInterface extends \Consolidation\AnnotatedCommand\Output\OutputAwareInterface
{
}
