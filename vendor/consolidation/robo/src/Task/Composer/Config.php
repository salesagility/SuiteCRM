<?php

namespace Robo\Task\Composer;

/**
 * Composer Config
 *
 * ``` php
 * <?php
 * // simple execution
 * $this->taskComposerConfig()->set('bin-dir', 'bin/')->run();
 * ?>
 * ```
 */
class Config extends Base
{
    /**
     * {@inheritdoc}
     */
    protected $action = 'config';

    /**
     * Set a configuration value.
     *
     * @param string $key
     * @param string $value
     *
     * @return $this
     */
    public function set($key, $value)
    {
        $this->arg($key);
        $this->arg($value);
        return $this;
    }

    /**
     * Operate on the global repository
     *
     * @param bool $useGlobal
     *
     * @return $this
     */
    public function useGlobal($useGlobal = true)
    {
        if ($useGlobal) {
            $this->option('global');
        }
        return $this;
    }

    /**
     * @param string $id
     * @param string $uri
     * @param string $repoType
     *
     * @return $this
     */
    public function repository($id, $uri, $repoType = 'vcs')
    {
        $this->arg("repositories.$id");
        $this->arg($repoType);
        $this->arg($uri);
        return $this;
    }

    /**
     * @param string $id
     *
     * @return $this
     */
    public function removeRepository($id)
    {
        $this->option('unset', "repositories.$id");
        return $this;
    }

    /**
     * @param string $id
     *
     * @return $this
     */
    public function disableRepository($id)
    {
        $this->arg("repositories.$id");
        $this->arg('false');
        return $this;
    }

    /**
     * @param string $id
     *
     * @return $this
     */
    public function enableRepository($id)
    {
        $this->arg("repositories.$id");
        $this->arg('true');
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $command = $this->getCommand();
        $this->printTaskInfo('Configuring composer.json: {command}', ['command' => $command]);
        return $this->executeCommand($command);
    }
}
