<?php
namespace Consolidation\Log;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * Interface that indicates that a logger's output / error streams
 * are settable.
 *
 * @author Greg Anderson <greg.1.anderson@greenknowe.org>
 */
interface SettableLogOutputStreamInterface
{
    /**
     * @param OutputInterface $output
     */
    public function setOutputStream($output);

    /**
     * @param OutputInterface $error
     */
    public function setErrorStream($error);
}
