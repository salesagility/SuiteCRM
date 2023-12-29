<?php
namespace Consolidation\Log;

use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\StringInput;

/**
 * StylableLoggerInterface indicates that a logger
 * can receive a LogOutputStyler.
 *
 * @author Greg Anderson <greg.1.anderson@greenknowe.org>
 */
interface StylableLoggerInterface
{
    public function setLogOutputStyler(LogOutputStylerInterface $outputStyler, array $formatFunctionMap = array());
}
