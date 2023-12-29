<?php

namespace Robo\Task\Composer;

/**
 * Composer Require
 *
 * ``` php
 * <?php
 * // simple execution
 * $this->taskComposerRequire()->dependency('foo/bar', '^.2.4.8')->run();
 * ?>
 * ```
 */
class RequireDependency extends Base
{
    /**
     * {@inheritdoc}
     */
    protected $action = 'require';

    /**
     * 'require' is a keyword, so it cannot be a method name.
     *
     * @param string $project
     * @param null|string $version
     *
     * @return $this
     */
    public function dependency($project, $version = null)
    {
        $project = (array)$project;

        if (isset($version)) {
            $project = array_map(
                function ($item) use ($version) {
                    return "$item:$version";
                },
                $project
            );
        }
        $this->args($project);
        return $this;
    }

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
        $this->printTaskInfo('Requiring packages: {command}', ['command' => $command]);
        return $this->executeCommand($command);
    }
}
