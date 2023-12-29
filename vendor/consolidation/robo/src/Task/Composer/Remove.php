<?php

namespace Robo\Task\Composer;

/**
 * Composer Remove
 *
 * ``` php
 * <?php
 * // simple execution
 * $this->taskComposerRemove()->run();
 * ?>
 * ```
 */
class Remove extends Base
{
    /**
     * {@inheritdoc}
     */
    protected $action = 'remove';

    /**
     * @param bool $dev
     *
     * @return $this
     */
    public function dev($dev = true)
    {
        if ($dev) {
            $this->option('--dev');
        }
        return $this;
    }

    /**
     * @param bool $noProgress
     *
     * @return $this
     */
    public function noProgress($noProgress = true)
    {
        if ($noProgress) {
            $this->option('--no-progress');
        }
        return $this;
    }

    /**
     * @param bool $noUpdate
     *
     * @return $this
     */
    public function noUpdate($noUpdate = true)
    {
        if ($noUpdate) {
            $this->option('--no-update');
        }
        return $this;
    }

    /**
     * @param bool $updateNoDev
     *
     * @return $this
     */
    public function updateNoDev($updateNoDev = true)
    {
        if ($updateNoDev) {
            $this->option('--update-no-dev');
        }
        return $this;
    }

    /**
     * @param bool $updateWithDependencies
     *
     * @return $this
     */
    public function noUpdateWithDependencies($updateWithDependencies = true)
    {
        if ($updateWithDependencies) {
            $this->option('--no-update-with-dependencies');
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $command = $this->getCommand();
        $this->printTaskInfo('Removing packages: {command}', ['command' => $command]);
        return $this->executeCommand($command);
    }
}
