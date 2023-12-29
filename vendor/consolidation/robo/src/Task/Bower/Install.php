<?php

namespace Robo\Task\Bower;

use Robo\Contract\CommandInterface;

/**
 * Bower Install
 *
 * ``` php
 * <?php
 * // simple execution
 * $this->taskBowerInstall()->run();
 *
 * // prefer dist with custom path
 * $this->taskBowerInstall('path/to/my/bower')
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
        $this->printTaskInfo('Install Bower packages: {arguments}', ['arguments' => $this->arguments]);
        return $this->executeCommand($this->getCommand());
    }
}
