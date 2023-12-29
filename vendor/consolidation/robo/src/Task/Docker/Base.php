<?php

namespace Robo\Task\Docker;

use Robo\Common\ExecOneCommand;
use Robo\Contract\CommandInterface;
use Robo\Contract\PrintedInterface;
use Robo\Task\BaseTask;

abstract class Base extends BaseTask implements CommandInterface, PrintedInterface
{
    use ExecOneCommand;

    /**
     * @var string
     */
    protected $command = '';

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $command = $this->getCommand();
        return $this->executeCommand($command);
    }

    abstract public function getCommand();
}
