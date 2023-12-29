<?php

namespace Robo\Task\File;

use Robo\Result;
use Robo\Task\BaseTask;

/**
 * Performs search and replace inside a files.
 *
 * ``` php
 * <?php
 * $this->taskReplaceInFile('VERSION')
 *  ->from('0.2.0')
 *  ->to('0.3.0')
 *  ->run();
 *
 * $this->taskReplaceInFile('README.md')
 *  ->from(date('Y')-1)
 *  ->to(date('Y'))
 *  ->run();
 *
 * $this->taskReplaceInFile('config.yml')
 *  ->regex('~^service:~')
 *  ->to('services:')
 *  ->run();
 *
 * $this->taskReplaceInFile('box/robo.txt')
 *  ->from(array('##dbname##', '##dbhost##'))
 *  ->to(array('robo', 'localhost'))
 *  ->run();
 * ?>
 * ```
 */
class Replace extends BaseTask
{
    /**
     * @var string
     */
    protected $filename;

    /**
     * @var string|string[]
     */
    protected $from;

    /**
     * @var integer
     */
    protected $limit = -1;

    /**
     * @var string|string[]
     */
    protected $to;

    /**
     * @var string
     */
    protected $regex;

    /**
     * @param string $filename
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }

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
     * String(s) to be replaced.
     *
     * @param string|string[] $from
     *
     * @return $this
     */
    public function from($from)
    {
        $this->from = $from;
        return $this;
    }

    /**
     * Value(s) to be set as a replacement.
     *
     * @param string|string[] $to
     *
     * @return $this
     */
    public function to($to)
    {
        $this->to = $to;
        return $this;
    }

    /**
     * Regex to match string to be replaced.
     *
     * @param string $regex
     *
     * @return $this
     */
    public function regex($regex)
    {
        $this->regex = $regex;
        return $this;
    }

    /**
     * If used with $this->regexp() how many counts will be replaced
     *
     * @param int $limit
     *
     * @return $this
     */
    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if (!file_exists($this->filename)) {
            return Result::error($this, 'File {filename} does not exist', ['filename' => $this->filename]);
        }

        $text = file_get_contents($this->filename);
        if ($this->regex) {
            $text = preg_replace($this->regex, $this->to, $text, $this->limit, $count);
        } else {
            $text = str_replace($this->from, $this->to, $text, $count);
        }
        if ($count > 0) {
            $res = file_put_contents($this->filename, $text);
            if ($res === false) {
                return Result::error($this, "Error writing to file {filename}.", ['filename' => $this->filename]);
            }
            $this->printTaskSuccess("{filename} updated. {count} items replaced", ['filename' => $this->filename, 'count' => $count]);
        } else {
            $this->printTaskInfo("{filename} unchanged. {count} items replaced", ['filename' => $this->filename, 'count' => $count]);
        }
        return Result::success($this, '', ['replaced' => $count]);
    }
}
