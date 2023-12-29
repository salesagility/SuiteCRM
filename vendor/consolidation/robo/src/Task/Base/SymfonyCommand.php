<?php

namespace Robo\Task\Base;

use Robo\Robo;
use Robo\Result;
use Robo\Task\BaseTask;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;

/**
 * Executes Symfony Command
 *
 * ``` php
 * <?php
 * // Symfony Command
 * $this->taskSymfonyCommand(new \Codeception\Command\Run('run'))
 *      ->arg('suite','acceptance')
 *      ->opt('debug')
 *      ->run();
 *
 * // Artisan Command
 * $this->taskSymfonyCommand(new ModelGeneratorCommand())
 *      ->arg('name', 'User')
 *      ->run();
 * ?>
 * ```
 */
class SymfonyCommand extends BaseTask
{
    /**
     * @var \Symfony\Component\Console\Command\Command
     */
    protected $command;

    /**
     * @var string[]
     */
    protected $input;

    public function __construct(Command $command)
    {
        $this->command = $command;
        $this->input = [];
    }

    /**
     * @param string $arg
     * @param string $value
     *
     * @return $this
     */
    public function arg($arg, $value)
    {
        $this->input[$arg] = $value;
        return $this;
    }

    public function opt($option, $value = null)
    {
        $this->input["--$option"] = $value;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->printTaskInfo('Running command {command}', ['command' => $this->command->getName()]);
        return new Result(
            $this,
            $this->command->run(new ArrayInput($this->input), $this->output())
        );
    }
}
