<?php

namespace Robo\Common;

use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;

trait OutputAwareTrait
{
    /**
     * @var \Symfony\Component\Console\Output\OutputInterface
     */
    protected $output;

    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return $this
     *
     * @see \Robo\Contract\OutputAwareInterface::setOutput()
     */
    public function setOutput(OutputInterface $output)
    {
        $this->output = $output;

        return $this;
    }

    /**
     * @return \Symfony\Component\Console\Output\OutputInterface
     */
    protected function output()
    {
        if (!isset($this->output)) {
            $this->setOutput(new NullOutput());
        }
        return $this->output;
    }

    /**
     * @return \Symfony\Component\Console\Output\OutputInterface
     */
    protected function stderr()
    {
        $output = $this->output();
        if ($output instanceof ConsoleOutputInterface) {
            $output = $output->getErrorOutput();
        }
        return $output;
    }

    /**
     * Backwards compatibility
     *
     * @return \Symfony\Component\Console\Output\OutputInterface
     *
     * @deprecated
     */
    protected function getOutput()
    {
        return $this->output();
    }
}
