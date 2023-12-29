<?php

namespace Robo\Task\Npm;

/**
 * Npm Update
 *
 * ```php
 * <?php
 * // simple execution
 * $this->taskNpmUpdate()->run();
 *
 * // prefer dist with custom path
 * $this->taskNpmUpdate('path/to/my/npm')
 *      ->noDev()
 *      ->run();
 * ?>
 * ```
 */
class Update extends Base
{
    /**
     * {@inheritdoc}
     */
    protected $action = 'update';

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->printTaskInfo('Update Npm packages: {arguments}', ['arguments' => $this->arguments]);
        return $this->executeCommand($this->getCommand());
    }
}
