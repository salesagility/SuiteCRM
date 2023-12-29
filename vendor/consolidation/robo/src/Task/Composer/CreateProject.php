<?php

namespace Robo\Task\Composer;

/**
 * Composer CreateProject
 *
 * ``` php
 * <?php
 * // simple execution
 * $this->taskComposerCreateProject()->source('foo/bar')->target('myBar')->run();
 * ?>
 * ```
 */
class CreateProject extends Base
{
    /**
     * {@inheritdoc}
     */
    protected $action = 'create-project';

    /**
     * @var
     */
    protected $source;

    /**
     * @var string
     */
    protected $target = '';

    /**
     * @var string
     */
    protected $version = '';

    /**
     * @param string $source
     *
     * @return $this
     */
    public function source($source)
    {
        $this->source = $source;
        return $this;
    }

    /**
     * @param string $target
     *
     * @return $this
     */
    public function target($target)
    {
        $this->target = $target;
        return $this;
    }

    /**
     * @param string $version
     *
     * @return $this
     */
    public function version($version)
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @param bool $keep
     *
     * @return $this
     */
    public function keepVcs($keep = true)
    {
        if ($keep) {
            $this->option('--keep-vcs');
        }
        return $this;
    }

    /**
     * @param bool $noInstall
     *
     * @return $this
     */
    public function noInstall($noInstall = true)
    {
        if ($noInstall) {
            $this->option('--no-install');
        }
        return $this;
    }

    /**
     * @param string $repository
     *
     * @return $this
     */
    public function repository($repository)
    {
        if (!empty($repository)) {
            $this->option('repository', $repository);
        }
        return $this;
    }

    /**
     * @param string $stability
     *
     * @return $this
     */
    public function stability($stability)
    {
        if (!empty($stability)) {
            $this->option('stability', $stability);
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function buildCommand()
    {
        $this->arg($this->source);
        if (!empty($this->target)) {
            $this->arg($this->target);
        }
        if (!empty($this->version)) {
            $this->arg($this->version);
        }

        return parent::buildCommand();
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $command = $this->getCommand();
        $this->printTaskInfo('Creating project: {command}', ['command' => $command]);
        return $this->executeCommand($command);
    }
}
