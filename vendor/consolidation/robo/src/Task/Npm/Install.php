<?php

namespace Robo\Task\Npm;

use Robo\Contract\CommandInterface;

/**
 * Npm Install
 *
 * ``` php
 * <?php
 * // simple execution
 * $this->taskNpmInstall()->run();
 *
 * // prefer dist with custom path
 * $this->taskNpmInstall('path/to/my/npm')
 *      ->noDev()
 *      ->run();
 * ?>
 * ```
 */
class Install extends Base implements CommandInterface
{
    /**
     * {@inheritdoc}
     */
    protected $action = 'install';

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->printTaskInfo('Install Npm packages: {arguments}', ['arguments' => $this->arguments]);
        return $this->executeCommand($this->getCommand());
    }
}
