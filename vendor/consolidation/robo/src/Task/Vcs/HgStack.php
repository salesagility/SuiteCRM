<?php

namespace Robo\Task\Vcs;

use Robo\Task\CommandStack;

/**
 * Runs hg commands in stack. You can use `stopOnFail()` to point that stack should be terminated on first fail.
 *
 * ``` php
 * <?php
 * $this->hgStack
 *  ->cloneRepo('https://bitbucket.org/durin42/hgsubversion')
 *  ->pull()
 *  ->add()
 *  ->commit('changed')
 *  ->push()
 *  ->tag('0.6.0')
 *  ->push('0.6.0')
 *  ->run();
 * ?>
 * ```
 */
class HgStack extends CommandStack
{

    /**
     * @param string $pathToHg
     */
    public function __construct($pathToHg = 'hg')
    {
        $this->executable = $pathToHg;
    }

    /**
     * Executes `hg clone`
     *
     * @param string $repo
     * @param string $to
     *
     * @return $this
     */
    public function cloneRepo($repo, $to = '')
    {
        return $this->exec(['clone', $repo, $to]);
    }

    /**
     * Executes `hg add` command with files to add by pattern
     *
     * @param string $include
     * @param string $exclude
     *
     * @return $this
     */
    public function add($include = '', $exclude = '')
    {
        if (strlen($include) > 0) {
            $include = "-I {$include}";
        }

        if (strlen($exclude) > 0) {
            $exclude = "-X {$exclude}";
        }

        return $this->exec([__FUNCTION__, $include, $exclude]);
    }

    /**
     * Executes `hg commit` command with a message
     *
     * @param string $message
     * @param string $options
     *
     * @return $this
     */
    public function commit($message, $options = '')
    {
        return $this->exec([__FUNCTION__, "-m '{$message}'", $options]);
    }

    /**
     * Executes `hg pull` command.
     *
     * @param string $branch
     *
     * @return $this
     */
    public function pull($branch = '')
    {
        if (strlen($branch) > 0) {
            $branch = "-b '{$branch}''";
        }

        return $this->exec([__FUNCTION__, $branch]);
    }

    /**
     * Executes `hg push` command
     *
     * @param string $branch
     *
     * @return $this
     */
    public function push($branch = '')
    {
        if (strlen($branch) > 0) {
            $branch = "-b '{$branch}'";
        }

        return $this->exec([__FUNCTION__, $branch]);
    }

    /**
     * Performs hg merge
     *
     * @param string $revision
     *
     * @return $this
     */
    public function merge($revision = '')
    {
        if (strlen($revision) > 0) {
            $revision = "-r {$revision}";
        }

        return $this->exec([__FUNCTION__, $revision]);
    }

    /**
     * Executes `hg tag` command
     *
     * @param string $tag_name
     * @param string $message
     *
     * @return $this
     */
    public function tag($tag_name, $message = '')
    {
        if ($message !== '') {
            $message = "-m '{$message}'";
        }
        return $this->exec([__FUNCTION__, $message, $tag_name]);
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->printTaskInfo('Running hg commands...');
        return parent::run();
    }
}
