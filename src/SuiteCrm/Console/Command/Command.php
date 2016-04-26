<?php
/**
 * Created by Adam Jakab.
 * Date: 07/10/15
 * Time: 14.27
 */

namespace SuiteCrm\Console\Command;

use SuiteCrm\Install\LoggerManager;
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

    /** @var  LoggerManager */
    protected $loggerManager;

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
        $this->loggerManager = new LoggerManager($this->cmdOutput);
    }

    /**
     * @param string $msg
     * @param string $level - available: debug|info|warn|deprecated|error|fatal|security|off
     */
    protected function log($msg, $level = 'warn')
    {
        $this->loggerManager->log($msg, $level);
    }
}