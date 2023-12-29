<?php

namespace Robo\Task\Development;

trait Tasks
{
    /**
     * @param string $filename
     *
     * @return \Robo\Task\Development\Changelog|\Robo\Collection\CollectionBuilder
     */
    protected function taskChangelog($filename = 'CHANGELOG.md')
    {
        return $this->task(Changelog::class, $filename);
    }

    /**
     * @param string $filename
     *
     * @return \Robo\Task\Development\GenerateMarkdownDoc|\Robo\Collection\CollectionBuilder
     */
    protected function taskGenDoc($filename)
    {
        return $this->task(GenerateMarkdownDoc::class, $filename);
    }

    /**
     * @param string $className
     * @param string $wrapperClassName
     *
     * @return \Robo\Task\Development\GenerateTask|\Robo\Collection\CollectionBuilder
     */
    protected function taskGenTask($className, $wrapperClassName = '')
    {
        return $this->task(GenerateTask::class, $className, $wrapperClassName);
    }

    /**
     * @param string $pathToSemVer
     *
     * @return \Robo\Task\Development\SemVer|\Robo\Collection\CollectionBuilder
     */
    protected function taskSemVer($pathToSemVer = '.semver')
    {
        return $this->task(SemVer::class, $pathToSemVer);
    }

    /**
     * @param int $port
     *
     * @return \Robo\Task\Development\PhpServer|\Robo\Collection\CollectionBuilder
     */
    protected function taskServer($port = 8000)
    {
        return $this->task(PhpServer::class, $port);
    }

    /**
     * @param string $filename
     *
     * @return \Robo\Task\Development\PackPhar|\Robo\Collection\CollectionBuilder
     */
    protected function taskPackPhar($filename)
    {
        return $this->task(PackPhar::class, $filename);
    }

    /**
     * @param string $tag
     *
     * @return \Robo\Task\Development\GitHubRelease|\Robo\Collection\CollectionBuilder
     */
    protected function taskGitHubRelease($tag)
    {
        return $this->task(GitHubRelease::class, $tag);
    }

    /**
     * @param string|array $url
     *
     * @return \Robo\Task\Development\OpenBrowser|\Robo\Collection\CollectionBuilder
     */
    protected function taskOpenBrowser($url)
    {
        return $this->task(OpenBrowser::class, $url);
    }
}
