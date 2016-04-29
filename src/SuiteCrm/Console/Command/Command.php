<?php
/**
 * Created by Adam Jakab.
 * Date: 07/10/15
 * Time: 14.27
 */

namespace SuiteCrm\Console\Command;

use Symfony\Component\Console\Command\Command as ConsoleCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Command
 * @package SuiteCrm\Console\Command
 */
class Command extends ConsoleCommand
{
    /** @var  InputInterface */
    protected $cmdInput;

    /** @var  OutputInterface */
    protected $cmdOutput;

    /**
     * @param string $name
     */
    public function __construct($name = NULL)
    {
        parent::__construct($name);
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function _execute(InputInterface $input, OutputInterface $output)
    {
        $this->cmdInput = $input;
        $this->cmdOutput = $output;
    }

    /**
     * @param string $msg
     */
    protected function log($msg)
    {
        $this->cmdOutput->writeln($msg);
    }
}