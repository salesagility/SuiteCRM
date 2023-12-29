<?php

namespace Robo\Task\Composer;

/**
 * Composer Init
 *
 * ``` php
 * <?php
 * // simple execution
 * $this->taskComposerInit()->run();
 * ?>
 * ```
 */
class Init extends Base
{
    /**
     * {@inheritdoc}
     */
    protected $action = 'init';

    /**
     * @param string $projectName
     *
     * @return $this
     */
    public function projectName($projectName)
    {
        $this->option('name', $projectName);
        return $this;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function description($description)
    {
        $this->option('description', $description);
        return $this;
    }

    /**
     * @param string $author
     *
     * @return $this
     */
    public function author($author)
    {
        $this->option('author', $author);
        return $this;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function projectType($type)
    {
        $this->option('type', $type);
        return $this;
    }

    /**
     * @param string $homepage
     *
     * @return $this
     */
    public function homepage($homepage)
    {
        $this->option('homepage', $homepage);
        return $this;
    }

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
        if (isset($version)) {
            $project .= ":$version";
        }
        $this->option('require', $project);
        return $this;
    }

    /**
     * @param string $stability
     *
     * @return $this
     */
    public function stability($stability)
    {
        $this->option('stability', $stability);
        return $this;
    }

    /**
     * @param string $license
     *
     * @return $this
     */
    public function license($license)
    {
        $this->option('license', $license);
        return $this;
    }

    /**
     * @param string $repository
     *
     * @return $this
     */
    public function repository($repository)
    {
        $this->option('repository', $repository);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $command = $this->getCommand();
        $this->printTaskInfo('Creating composer.json: {command}', ['command' => $command]);
        return $this->executeCommand($command);
    }
}
