<?php

namespace Robo\Task\Vcs;

use Robo\Task\CommandStack;
use Robo\Common\ProcessUtils;

/**
 * Runs Git commands in stack. You can use `stopOnFail()` to point that stack should be terminated on first fail.
 *
 * ``` php
 * <?php
 * $this->taskGitStack()
 *  ->stopOnFail()
 *  ->add('-A')
 *  ->commit('adding everything')
 *  ->push('origin','master')
 *  ->tag('0.6.0')
 *  ->push('origin','0.6.0')
 *  ->run()
 *
 * $this->taskGitStack()
 *  ->stopOnFail()
 *  ->add('doc/*')
 *  ->commit('doc updated')
 *  ->push()
 *  ->run();
 * ?>
 * ```
 */
class GitStack extends CommandStack
{
    /**
     * @param string $pathToGit
     */
    public function __construct($pathToGit = 'git')
    {
        $this->executable = $pathToGit;
    }

    /**
     * Executes `git clone`
     *
     * @param string $repo
     * @param string $to
     * @param string $branch
     *
     * @return $this
     */
    public function cloneRepo($repo, $to = "", $branch = "")
    {
        $cmd = ['clone', $repo, $to];
        if (!empty($branch)) {
            $cmd[] = "--branch $branch";
        }
        return $this->exec($cmd);
    }

    /**
     * Executes `git clone` with depth 1 as default
     *
     * @param string $repo
     * @param string $to
     * @param string $branch
     * @param int    $depth
     *
     * @return $this
     */
    public function cloneShallow($repo, $to = '', $branch = "", $depth = 1)
    {
        $cmd = ["clone --depth $depth", $repo, $to];
        if (!empty($branch)) {
            $cmd[] = "--branch $branch";
        }

        return $this->exec($cmd);
    }

    /**
     * Executes `git add` command with files to add pattern
     *
     * @param string $pattern
     *
     * @return $this
     */
    public function add($pattern)
    {
        return $this->exec([__FUNCTION__, $pattern]);
    }

    /**
     * Executes `git commit` command with a message
     *
     * @param string $message
     * @param string $options
     *
     * @return $this
     */
    public function commit($message, $options = "")
    {
        $message = ProcessUtils::escapeArgument($message);
        return $this->exec([__FUNCTION__, "-m $message", $options]);
    }

    /**
     * Executes `git pull` command.
     *
     * @param string $origin
     * @param string $branch
     *
     * @return $this
     */
    public function pull($origin = '', $branch = '')
    {
        return $this->exec([__FUNCTION__, $origin, $branch]);
    }

    /**
     * Executes `git push` command
     *
     * @param string $origin
     * @param string $branch
     *
     * @return $this
     */
    public function push($origin = '', $branch = '')
    {
        return $this->exec([__FUNCTION__, $origin, $branch]);
    }

    /**
     * Performs git merge
     *
     * @param string $branch
     *
     * @return $this
     */
    public function merge($branch)
    {
        return $this->exec([__FUNCTION__, $branch]);
    }

    /**
     * Executes `git checkout` command
     *
     * @param string $branch
     *
     * @return $this
     */
    public function checkout($branch)
    {
        return $this->exec([__FUNCTION__, $branch]);
    }

    /**
     * Executes `git tag` command
     *
     * @param string $tag_name
     * @param string $message
     *
     * @return $this
     */
    public function tag($tag_name, $message = "")
    {
        if ($message != "") {
            $message = "-m '$message'";
        }
        return $this->exec([__FUNCTION__, $message, $tag_name]);
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->printTaskInfo("Running git commands...");
        return parent::run();
    }
}
