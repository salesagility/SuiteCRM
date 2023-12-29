<?php

namespace Robo\Task\Composer;

/**
 * Composer Update
 *
 * ``` php
 * <?php
 * // simple execution
 * $this->taskComposerUpdate()->run();
 *
 * // prefer dist with custom path
 * $this->taskComposerUpdate('path/to/my/composer.phar')
 *      ->preferDist()
 *      ->run();
 *
 * // optimize autoloader with custom path
 * $this->taskComposerUpdate('path/to/my/composer.phar')
 *      ->optimizeAutoloader()
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
     * adds `no-suggest` option to composer
     *
     * @param bool $noSuggest
     *
     * @return $this
     */
    public function noSuggest($noSuggest = true)
    {
        $this->option('--no-suggest');
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $command = $this->getCommand();
        $this->printTaskInfo('Updating Packages: {command}', ['command' => $command]);
        return $this->executeCommand($command);
    }
}
