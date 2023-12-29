<?php

namespace Robo\Task\Remote;

use Robo\Contract\CommandInterface;
use Robo\Task\BaseTask;
use Robo\Exception\TaskException;
use Robo\Common\ExecOneCommand;

/**
 * Executes rsync in a flexible manner.
 *
 * ``` php
 * $this->taskRsync()
 *   ->fromPath('src/')
 *   ->toHost('localhost')
 *   ->toUser('dev')
 *   ->toPath('/var/www/html/app/')
 *   ->remoteShell('ssh -i public_key')
 *   ->recursive()
 *   ->excludeVcs()
 *   ->checksum()
 *   ->wholeFile()
 *   ->verbose()
 *   ->progress()
 *   ->humanReadable()
 *   ->stats()
 *   ->run();
 * ```
 *
 * You could also clone the task and do a dry-run first:
 *
 * ``` php
 * $rsync = $this->taskRsync()
 *   ->fromPath('src/')
 *   ->toPath('example.com:/var/www/html/app/')
 *   ->archive()
 *   ->excludeVcs()
 *   ->progress()
 *   ->stats();
 *
 * $dryRun = clone $rsync;
 * $dryRun->dryRun()->run();
 * if ('y' === $this->ask('Do you want to run (y/n)')) {
 *   $rsync->run();
 * }
 * ```
 */
class Rsync extends BaseTask implements CommandInterface
{
    use ExecOneCommand;

    /**
     * @var string
     */
    protected $command;

    /**
     * @var string
     */
    protected $fromUser;

    /**
     * @var string
     */
    protected $fromHost;

    /**
     * @var string
     */
    protected $fromPath;

    /**
     * @var string
     */
    protected $toUser;

    /**
     * @var string
     */
    protected $toHost;

    /**
     * @var string
     */
    protected $toPath;

    /**
     * @return static
     */
    public static function init()
    {
        return new static();
    }

    public function __construct()
    {
        $this->command = 'rsync';
    }

    /**
     * This can either be a full rsync path spec (user@host:path) or just a path.
     * In case of the former do not specify host and user.
     *
     * @param string|array $path
     *
     * @return $this
     */
    public function fromPath($path)
    {
        $this->fromPath = $path;

        return $this;
    }

    /**
     * This can either be a full rsync path spec (user@host:path) or just a path.
     * In case of the former do not specify host and user.
     *
     * @param string $path
     *
     * @return $this
     */
    public function toPath($path)
    {
        $this->toPath = $path;

        return $this;
    }

    /**
     * @param string $fromUser
     *
     * @return $this
     */
    public function fromUser($fromUser)
    {
        $this->fromUser = $fromUser;
        return $this;
    }

    /**
     * @param string $fromHost
     *
     * @return $this
     */
    public function fromHost($fromHost)
    {
        $this->fromHost = $fromHost;
        return $this;
    }

    /**
     * @param string $toUser
     *
     * @return $this
     */
    public function toUser($toUser)
    {
        $this->toUser = $toUser;
        return $this;
    }

    /**
     * @param string $toHost
     *
     * @return $this
     */
    public function toHost($toHost)
    {
        $this->toHost = $toHost;
        return $this;
    }

    /**
     * @return $this
     */
    public function progress()
    {
        $this->option(__FUNCTION__);

        return $this;
    }

    /**
     * @return $this
     */
    public function stats()
    {
        $this->option(__FUNCTION__);

        return $this;
    }

    /**
     * @return $this
     */
    public function recursive()
    {
        $this->option(__FUNCTION__);

        return $this;
    }

    /**
     * @return $this
     */
    public function verbose()
    {
        $this->option(__FUNCTION__);

        return $this;
    }

    /**
     * @return $this
     */
    public function checksum()
    {
        $this->option(__FUNCTION__);

        return $this;
    }

    /**
     * @return $this
     */
    public function archive()
    {
        $this->option(__FUNCTION__);

        return $this;
    }

    /**
     * @return $this
     */
    public function compress()
    {
        $this->option(__FUNCTION__);

        return $this;
    }

    /**
     * @return $this
     */
    public function owner()
    {
        $this->option(__FUNCTION__);

        return $this;
    }

    /**
     * @return $this
     */
    public function group()
    {
        $this->option(__FUNCTION__);

        return $this;
    }

    /**
     * @return $this
     */
    public function times()
    {
        $this->option(__FUNCTION__);

        return $this;
    }

    /**
     * @return $this
     */
    public function delete()
    {
        $this->option(__FUNCTION__);

        return $this;
    }

    /**
     * @param int $seconds
     *
     * @return $this
     */
    public function timeout($seconds)
    {
        $this->option(__FUNCTION__, $seconds);

        return $this;
    }

    /**
     * @return $this
     */
    public function humanReadable()
    {
        $this->option('human-readable');

        return $this;
    }

    /**
     * @return $this
     */
    public function wholeFile()
    {
        $this->option('whole-file');

        return $this;
    }

    /**
     * @return $this
     */
    public function dryRun()
    {
        $this->option('dry-run');

        return $this;
    }

    /**
     * @return $this
     */
    public function itemizeChanges()
    {
        $this->option('itemize-changes');

        return $this;
    }

    /**
     * Excludes .git, .svn and .hg items at any depth.
     *
     * @return $this
     */
    public function excludeVcs()
    {
        return $this->exclude([
            '.git',
            '.svn',
            '.hg',
        ]);
    }

    /**
     * @param array|string $pattern
     *
     * @return $this
     */
    public function exclude($pattern)
    {
        return $this->optionList(__FUNCTION__, $pattern);
    }

    /**
     * @param string $file
     *
     * @return $this
     *
     * @throws \Robo\Exception\TaskException
     */
    public function excludeFrom($file)
    {
        if (!is_readable($file)) {
            throw new TaskException($this, "Exclude file $file is not readable");
        }

        return $this->option('exclude-from', $file);
    }

    /**
     * @param array|string $pattern
     *
     * @return $this
     */
    public function includeFilter($pattern)
    {
        return $this->optionList('include', $pattern);
    }

    /**
     * @param array|string $pattern
     *
     * @return $this
     */
    public function filter($pattern)
    {
        return $this->optionList(__FUNCTION__, $pattern);
    }

    /**
     * @param string $file
     *
     * @return $this
     *
     * @throws \Robo\Exception\TaskException
     */
    public function filesFrom($file)
    {
        if (!is_readable($file)) {
            throw new TaskException($this, "Files-from file $file is not readable");
        }

        return $this->option('files-from', $file);
    }

    /**
     * @param string $command
     *
     * @return $this
     */
    public function remoteShell($command)
    {
        $this->option('rsh', "$command");

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $command = $this->getCommand();

        return $this->executeCommand($command);
    }

    /**
     * Returns command that can be executed.
     * This method is used to pass generated command from one task to another.
     *
     * @return string
     */
    public function getCommand()
    {
        foreach ((array)$this->fromPath as $from) {
            $this->option(null, $this->getFromPathSpec($from));
        }
        $this->option(null, $this->getToPathSpec());

        return $this->command . $this->arguments;
    }

    /**
     * @param string $from
     *
     * @return string
     */
    protected function getFromPathSpec($from)
    {
        return $this->getPathSpec($this->fromHost, $this->fromUser, $from);
    }

    /**
     * @return string
     */
    protected function getToPathSpec()
    {
        return $this->getPathSpec($this->toHost, $this->toUser, $this->toPath);
    }

    /**
     * @param string $host
     * @param string $user
     * @param string $path
     *
     * @return string
     */
    protected function getPathSpec($host, $user, $path)
    {
        $spec = isset($path) ? $path : '';
        if (!empty($host)) {
            $spec = "{$host}:{$spec}";
        }
        if (!empty($user)) {
            $spec = "{$user}@{$spec}";
        }

        return $spec;
    }
}
