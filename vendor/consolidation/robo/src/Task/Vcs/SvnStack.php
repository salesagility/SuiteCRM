<?php

namespace Robo\Task\Vcs;

use Robo\Contract\CommandInterface;
use Robo\Result;
use Robo\Task\CommandStack;

/**
 * Runs Svn commands in stack. You can use `stopOnFail()` to point that stack should be terminated on first fail.
 *
 * ``` php
 * <?php
 * $this->taskSvnStack()
 *  ->checkout('http://svn.collab.net/repos/svn/trunk')
 *  ->run()
 *
 * // alternatively
 * $this->_svnCheckout('http://svn.collab.net/repos/svn/trunk');
 *
 * $this->taskSvnStack('username', 'password')
 *  ->stopOnFail()
 *  ->update()
 *  ->add('doc/*')
 *  ->commit('doc updated')
 *  ->run();
 * ?>
 * ```
 */
class SvnStack extends CommandStack implements CommandInterface
{
    /**
     * @var bool
     */
    protected $stopOnFail = false;

    /**
     * {@inheritdoc}
     */
    protected $result;

    /**
     * @param string $username
     * @param string $password
     * @param string $pathToSvn
     */
    public function __construct($username = '', $password = '', $pathToSvn = 'svn')
    {
        $this->executable = $pathToSvn;
        if (!empty($username)) {
            $this->executable .= " --username $username";
        }
        if (!empty($password)) {
            $this->executable .= " --password $password";
        }
        $this->result = Result::success($this);
    }

    /**
     * Updates `svn update` command
     *
     * @param string $path
     *
     * @return $this
     */
    public function update($path = '')
    {
        return $this->exec("update $path");
    }

    /**
     * Executes `svn add` command with files to add pattern
     *
     * @param string $pattern
     *
     * @return $this
     */
    public function add($pattern = '')
    {
        return $this->exec("add $pattern");
    }

    /**
     * Executes `svn commit` command with a message
     *
     * @param string $message
     * @param string $options
     *
     * @return $this
     */
    public function commit($message, $options = "")
    {
        return $this->exec("commit -m '$message' $options");
    }

    /**
     * Executes `svn checkout` command
     *
     * @param string $branch
     *
     * @return $this
     */
    public function checkout($branch)
    {
        return $this->exec("checkout $branch");
    }
}
