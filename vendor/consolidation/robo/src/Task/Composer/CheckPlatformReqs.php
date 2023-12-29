<?php

namespace Robo\Task\Composer;

/**
 * Composer Check Platform Requirements
 *
 * ``` php
 * <?php
 * // simple execution
 * $this->taskComposerValidate()->run();
 * ?>
 * ```
 */
class CheckPlatformReqs extends Base
{
    /**
     * {@inheritdoc}
     */
    protected $action = 'check-platform-reqs';

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $command = $this->getCommand();
        $this->printTaskInfo('Checking platform requirements: {command}', ['command' => $command]);
        return $this->executeCommand($command);
    }
}
