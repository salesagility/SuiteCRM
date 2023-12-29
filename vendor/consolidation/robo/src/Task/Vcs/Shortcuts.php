<?php

namespace Robo\Task\Vcs;

trait Shortcuts
{
    /**
     * @param string $url
     *
     * @return \Robo\Result
     */
    protected function _svnCheckout($url)
    {
        return $this->taskSvnStack()->checkout($url)->run();
    }

    /**
     * @param string $url
     *
     * @return \Robo\Result
     */
    protected function _gitClone($url)
    {
        return $this->taskGitStack()->cloneRepo($url)->run();
    }

    /**
     * @param string $url
     *
     * @return \Robo\Result
     */
    protected function _hgClone($url)
    {
        return $this->taskHgStack()->cloneRepo($url)->run();
    }
}
