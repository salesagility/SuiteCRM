<?php

namespace Robo\Task\Composer;

use Robo\Contract\CommandInterface;
use Robo\Exception\TaskException;
use Robo\Task\BaseTask;
use Robo\Common\ExecOneCommand;

abstract class Base extends BaseTask implements CommandInterface
{
    use ExecOneCommand;

    /**
     * @var string
     */
    protected $command = '';

    /**
     * @var bool
     */
    protected $built = false;

    /**
     * @var string
     */
    protected $prefer;

    /**
     * @var string
     */
    protected $dev;

    /**
     * @var string
     */
    protected $ansi;

    /**
     * @var string
     */
    protected $nointeraction;

    /**
     * Action to use
     *
     * @var string
     */
    protected $action = '';

    /**
     * @param null|string $pathToComposer
     *
     * @throws \Robo\Exception\TaskException
     */
    public function __construct($pathToComposer = null)
    {
        $this->command = $pathToComposer;
        if (!$this->command) {
            $this->command = $this->findExecutablePhar('composer');
        }
        if (!$this->command) {
            throw new TaskException(__CLASS__, "Neither local composer.phar nor global composer installation could be found.");
        }
    }

    /**
     * adds `prefer-dist` option to composer
     *
     * @param bool $preferDist
     *
     * @return $this
     */
    public function preferDist($preferDist = true)
    {
        if (!$preferDist) {
            return $this->preferSource();
        }
        $this->prefer = '--prefer-dist';
        return $this;
    }

    /**
     * adds `prefer-source` option to composer
     *
     * @return $this
     */
    public function preferSource()
    {
        $this->prefer = '--prefer-source';
        return $this;
    }

    /**
     * adds `dev` option to composer
     *
     * @param bool $dev
     *
     * @return $this
     */
    public function dev($dev = true)
    {
        if (!$dev) {
            return $this->noDev();
        }
        $this->dev = '--dev';
        return $this;
    }

    /**
     * adds `no-dev` option to composer
     *
     * @return $this
     */
    public function noDev()
    {
        $this->dev = '--no-dev';
        return $this;
    }

    /**
     * adds `ansi` option to composer
     *
     * @param bool $ansi
     *
     * @return $this
     */
    public function ansi($ansi = true)
    {
        if (!$ansi) {
            return $this->noAnsi();
        }
        $this->ansi = '--ansi';
        return $this;
    }

    /**
     * adds `no-ansi` option to composer
     *
     * @return $this
     */
    public function noAnsi()
    {
        $this->ansi = '--no-ansi';
        return $this;
    }

    /**
     * @param bool $interaction
     *
     * @return $this
     */
    public function interaction($interaction = true)
    {
        if (!$interaction) {
            return $this->noInteraction();
        }
        return $this;
    }

    /**
     * adds `no-interaction` option to composer
     *
     * @return $this
     */
    public function noInteraction()
    {
        $this->nointeraction = '--no-interaction';
        return $this;
    }

    /**
     * adds `optimize-autoloader` option to composer
     *
     * @param bool $optimize
     *
     * @return $this
     */
    public function optimizeAutoloader($optimize = true)
    {
        if ($optimize) {
            $this->option('--optimize-autoloader');
        }
        return $this;
    }

    /**
     * adds `ignore-platform-reqs` option to composer
     *
     * @param bool $ignore
     *
     * @return $this
     */
    public function ignorePlatformRequirements($ignore = true)
    {
        $this->option('--ignore-platform-reqs');
        return $this;
    }

    /**
     * disable plugins
     *
     * @param bool $disable
     *
     * @return $this
     */
    public function disablePlugins($disable = true)
    {
        if ($disable) {
            $this->option('--no-plugins');
        }
        return $this;
    }

    /**
     * skip scripts
     *
     * @param bool $disable
     *
     * @return $this
     */
    public function noScripts($disable = true)
    {
        if ($disable) {
            $this->option('--no-scripts');
        }
        return $this;
    }

    /**
     * adds `--working-dir $dir` option to composer
     *
     * @param string $dir
     *
     * @return $this
     */
    public function workingDir($dir)
    {
        $this->option("--working-dir", $dir);
        return $this;
    }

    /**
     * Copy class fields into command options as directed.
     */
    public function buildCommand()
    {
        if (!isset($this->ansi) && $this->getConfig()->get(\Robo\Config\Config::DECORATED)) {
            $this->ansi();
        }
        if (!isset($this->nointeraction) && !$this->getConfig()->get(\Robo\Config\Config::INTERACTIVE)) {
            $this->noInteraction();
        }
        $this->option($this->prefer)
            ->option($this->dev)
            ->option($this->nointeraction)
            ->option($this->ansi);
    }

    /**
     * {@inheritdoc}
     */
    public function getCommand()
    {
        if (!$this->built) {
            $this->buildCommand();
            $this->built = true;
        }
        return "{$this->command} {$this->action}{$this->arguments}";
    }
}
