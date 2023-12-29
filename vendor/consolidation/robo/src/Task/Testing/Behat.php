<?php

namespace Robo\Task\Testing;

use Robo\Contract\CommandInterface;
use Robo\Contract\PrintedInterface;
use Robo\Task\BaseTask;
use Robo\Common\ExecOneCommand;

/**
 * Executes Behat tests
 *
 * ``` php
 * <?php
 * $this->taskBehat()
 *      ->format('pretty')
 *      ->noInteraction()
 *      ->run();
 * ?>
 * ```
 *
 */
class Behat extends BaseTask implements CommandInterface, PrintedInterface
{
    use ExecOneCommand;

    /**
     * @var string
     */
    protected $command;

    /**
     * @var string[] $formaters available formaters for format option
     */
    protected $formaters = ['progress', 'pretty', 'junit'];

    /**
     * @var string[] $verbose_levels available verbose levels
     */
    protected $verbose_levels = ['v', 'vv'];

    /**
     * Behat constructor.
     *
     * @param null|string $pathToBehat
     *
     * @throws \Robo\Exception\TaskException
     */
    public function __construct($pathToBehat = null)
    {
        $this->command = $pathToBehat;
        if (!$this->command) {
            $this->command = $this->findExecutable('behat');
        }
        if (!$this->command) {
            throw new \Robo\Exception\TaskException(__CLASS__, "Neither composer nor phar installation of Behat found");
        }
    }

    /**
     * @return $this
     */
    public function stopOnFail()
    {
        $this->option('stop-on-failure');
        return $this;
    }

    /**
     * @return $this
     */
    public function noInteraction()
    {
        $this->option('no-interaction');
        return $this;
    }

    /**
     * @param string $config_file
     *
     * @return $this
     */
    public function config($config_file)
    {
        $this->option('config', $config_file);
        return $this;
    }

    /**
     * @return $this
     */
    public function colors()
    {
        $this->option('colors');
        return $this;
    }

    /**
     * @return $this
     */
    public function noColors()
    {
        $this->option('no-colors');
        return $this;
    }

    /**
     * @param string $suite
     *
     * @return $this
     */
    public function suite($suite)
    {
        $this->option('suite', $suite);
        return $this;
    }

    /**
     * @param string $level
     *
     * @return $this
     */
    public function verbose($level = 'v')
    {
        if (!in_array($level, $this->verbose_levels)) {
            throw new \InvalidArgumentException('expected ' . implode(',', $this->verbose_levels));
        }
        $this->option('-' . $level);
        return $this;
    }

    /**
     * @param string $formater
     *
     * @return $this
     */
    public function format($formater)
    {
        if (!in_array($formater, $this->formaters)) {
            throw new \InvalidArgumentException('expected ' . implode(',', $this->formaters));
        }
        $this->option('format', $formater);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCommand()
    {
        return $this->command . $this->arguments;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->printTaskInfo('Running behat {arguments}', ['arguments' => $this->arguments]);
        return $this->executeCommand($this->getCommand());
    }
}
