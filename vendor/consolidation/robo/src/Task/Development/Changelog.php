<?php

namespace Robo\Task\Development;

use Robo\Task\BaseTask;
use Robo\Result;
use Robo\Contract\BuilderAwareInterface;
use Robo\Common\BuilderAwareTrait;

/**
 * Helps to manage changelog file.
 * Creates or updates `changelog.md` file with recent changes in current version.
 *
 * ``` php
 * <?php
 * $version = "0.1.0";
 * $this->taskChangelog()
 *  ->version($version)
 *  ->change("released to github")
 *  ->run();
 * ?>
 * ```
 *
 * Changes can be asked from Console
 *
 * ``` php
 * <?php
 * $this->taskChangelog()
 *  ->version($version)
 *  ->askForChanges()
 *  ->run();
 * ?>
 * ```
 */
class Changelog extends BaseTask implements BuilderAwareInterface
{
    use BuilderAwareTrait;

    /**
     * @var string
     */
    protected $filename;

    /**
     * @var array
     */
    protected $log = [];

    /**
     * @var string
     */
    protected $anchor = "# Changelog";

    /**
     * @var string
     */
    protected $version = "";

    /**
     * @var string
     */
    protected $body = "";

    /**
     * @var string
     */
    protected $header = "";

    /**
     * @param string $filename
     *
     * @return $this
     */
    public function filename($filename)
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * Sets the changelog body text.
     *
     * This method permits the raw changelog text to be set directly If this is set, $this->log changes will be ignored.
     *
     * @param string $body
     *
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @param string $header
     *
     * @return $this
     */
    public function setHeader($header)
    {
        $this->header = $header;
        return $this;
    }

    /**
     * @param string $item
     *
     * @return $this
     */
    public function log($item)
    {
        $this->log[] = $item;
        return $this;
    }

    /**
     * @param string $anchor
     *
     * @return $this
     */
    public function anchor($anchor)
    {
        $this->anchor = $anchor;
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
     * @param string $filename
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public function changes(array $data)
    {
        $this->log = array_merge($this->log, $data);
        return $this;
    }

    /**
     * @param string $change
     *
     * @return $this
     */
    public function change($change)
    {
        $this->log[] = $change;
        return $this;
    }

    /**
     * @return array
     */
    public function getChanges()
    {
        return $this->log;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if (empty($this->body)) {
            if (empty($this->log)) {
                return Result::error($this, "Changelog is empty");
            }
            $this->body = $this->generateBody();
        }
        if (empty($this->header)) {
            $this->header = $this->generateHeader();
        }

        $text = $this->header . $this->body;

        if (!file_exists($this->filename)) {
            $this->printTaskInfo('Creating {filename}', ['filename' => $this->filename]);
            $res = file_put_contents($this->filename, $this->anchor);
            if ($res === false) {
                return Result::error($this, "File {filename} cant be created", ['filename' => $this->filename]);
            }
        }

        /** @var \Robo\Result $result */
        // trying to append to changelog for today
        $result = $this->collectionBuilder()->taskReplaceInFile($this->filename)
            ->from($this->header)
            ->to($text)
            ->run();

        if (!isset($result['replaced']) || !$result['replaced']) {
            $result = $this->collectionBuilder()->taskReplaceInFile($this->filename)
                ->from($this->anchor)
                ->to($this->anchor . "\n\n" . $text)
                ->run();
        }

        return new Result($this, $result->getExitCode(), $result->getMessage(), $this->log);
    }

    /**
     * @return string
     */
    protected function generateBody()
    {
        $text = implode("\n", array_map([$this, 'processLogRow'], $this->log));
        $text .= "\n";

        return $text;
    }

    /**
     * @return string
     */
    protected function generateHeader()
    {
        return "#### {$this->version}\n\n";
    }

    /**
     * @param string $i
     *
     * @return string
     */
    public function processLogRow($i)
    {
        return "* $i *" . date('Y-m-d') . "*";
    }
}
