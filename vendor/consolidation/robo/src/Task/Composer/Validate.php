<?php

namespace Robo\Task\Composer;

/**
 * Composer Validate
 *
 * ``` php
 * <?php
 * // simple execution
 * $this->taskComposerValidate()->run();
 * ?>
 * ```
 */
class Validate extends Base
{
    /**
     * {@inheritdoc}
     */
    protected $action = 'validate';

    /**
     * @param bool $noCheckAll
     *
     * @return $this
     */
    public function noCheckAll($noCheckAll = true)
    {
        if ($noCheckAll) {
            $this->option('--no-check-all');
        }
        return $this;
    }

    /**
     * @param bool $noCheckLock
     *
     * @return $this
     */
    public function noCheckLock($noCheckLock = true)
    {
        if ($noCheckLock) {
            $this->option('--no-check-lock');
        }
        return $this;
    }

    /**
     * @param bool $noCheckPublish
     *
     * @return $this
     */
    public function noCheckPublish($noCheckPublish = true)
    {
        if ($noCheckPublish) {
            $this->option('--no-check-publish');
        }
        return $this;
    }

    /**
     * @param bool $withDependencies
     *
     * @return $this
     */
    public function withDependencies($withDependencies = true)
    {
        if ($withDependencies) {
            $this->option('--with-dependencies');
        }
        return $this;
    }

    /**
     * @param bool $strict
     *
     * @return $this
     */
    public function strict($strict = true)
    {
        if ($strict) {
            $this->option('--strict');
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $command = $this->getCommand();
        $this->printTaskInfo('Validating composer.json: {command}', ['command' => $command]);
        return $this->executeCommand($command);
    }
}
