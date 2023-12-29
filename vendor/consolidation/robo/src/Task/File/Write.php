<?php

namespace Robo\Task\File;

use Robo\Result;
use Robo\Task\BaseTask;

/**
 * Writes to file.
 *
 * ``` php
 * <?php
 * $this->taskWriteToFile('blogpost.md')
 *      ->line('-----')
 *      ->line(date('Y-m-d').' '.$title)
 *      ->line('----')
 *      ->run();
 * ?>
 * ```
 */
class Write extends BaseTask
{
    /**
     * @var array
     */
    protected $stack = [];

    /**
     * @var string
     */
    protected $filename;

    /**
     * @var bool
     */
    protected $append = false;

    /**
     * @var null|string
     */
    protected $originalContents = null;

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
     * @param bool $append
     *
     * @return $this
     */
    public function append($append = true)
    {
        $this->append = $append;
        return $this;
    }

    /**
     * add a line.
     *
     * @param string $line
     *
     * @return $this
     *   The current instance.
     */
    public function line($line)
    {
        $this->text($line . "\n");
        return $this;
    }

    /**
     * add more lines.
     *
     * @param array $lines
     *
     * @return $this
     *   The current instance.
     */
    public function lines(array $lines)
    {
        $this->text(implode("\n", $lines) . "\n");
        return $this;
    }

    /**
     * add a text.
     *
     * @param string $text
     *
     * @return $this
     *   The current instance.
     */
    public function text($text)
    {
        $this->stack[] = array_merge([__FUNCTION__ . 'Collect'], func_get_args());
        return $this;
    }

    /**
     * add a text from a file.
     *
     * Note that the file is read in the run() method of this task.
     * To load text from the current state of a file (e.g. one that may
     * be deleted or altered by other tasks prior the execution of this one),
     * use:
     *       $task->text(file_get_contents($filename));
     *
     * @param string $filename
     *
     * @return $this
     *   The current instance.
     */
    public function textFromFile($filename)
    {
        $this->stack[] = array_merge([__FUNCTION__ . 'Collect'], func_get_args());
        return $this;
    }

    /**
     * substitute a placeholder with value, placeholder must be enclosed by `{}`.
     *
     * @param string $name
     * @param string $val
     *
     * @return $this
     *   The current instance.
     */
    public function place($name, $val)
    {
        $this->replace('{' . $name . '}', $val);

        return $this;
    }

    /**
     * replace any string with value.
     *
     * @param string $string
     * @param string $replacement
     *
     * @return $this
     *   The current instance.
     */
    public function replace($string, $replacement)
    {
        $this->stack[] = array_merge([__FUNCTION__ . 'Collect'], func_get_args());
        return $this;
    }

    /**
     * replace any string with value using regular expression.
     *
     * @param string $pattern
     * @param string $replacement
     *
     * @return $this
     *   The current instance.
     */
    public function regexReplace($pattern, $replacement)
    {
        $this->stack[] = array_merge([__FUNCTION__ . 'Collect'], func_get_args());
        return $this;
    }

    /**
     * Append the provided text to the end of the buffer if the provided
     * regex pattern matches any text already in the buffer.
     *
     * @param string $pattern
     * @param string $text
     *
     * @return $this
     */
    public function appendIfMatches($pattern, $text)
    {
        $this->stack[] = array_merge(['appendIfMatchesCollect'], [$pattern, $text, true]);
        return $this;
    }

    /**
     * Append the provided text to the end of the buffer unless the provided
     * regex pattern matches any text already in the buffer.
     *
     * @param string $pattern
     * @param string $text
     *
     * @return $this
     */
    public function appendUnlessMatches($pattern, $text)
    {
        $this->stack[] = array_merge(['appendIfMatchesCollect'], [$pattern, $text, false]);
        return $this;
    }

    /**
     * @param string $contents
     * @param string $filename
     *
     * @return string
     */
    protected function textFromFileCollect($contents, $filename)
    {
        if (file_exists($filename)) {
            $contents .= file_get_contents($filename);
        }
        return $contents;
    }

    /**
     * @param string|string[] $contents
     * @param string|string[] $string
     * @param string|string[] $replacement
     *
     * @return string|string[]
     */
    protected function replaceCollect($contents, $string, $replacement)
    {
        return str_replace($string, $replacement, $contents);
    }

    /**
     * @param string|string[] $contents
     * @param string|string[] $pattern
     * @param string|string[] $replacement
     *
     * @return string|string[]
     */
    protected function regexReplaceCollect($contents, $pattern, $replacement)
    {
        return preg_replace($pattern, $replacement, $contents);
    }

    /**
     * @param string $contents
     * @param string $text
     *
     * @return string
     */
    protected function textCollect($contents, $text)
    {
        return $contents . $text;
    }

    /**
     * @param string $contents
     * @param string $pattern
     * @param string $text
     * @param bool $shouldMatch
     *
     * @return string
     */
    protected function appendIfMatchesCollect($contents, $pattern, $text, $shouldMatch)
    {
        if (preg_match($pattern, $contents) == $shouldMatch) {
            $contents .= $text;
        }
        return $contents;
    }

    /**
     * @return string
     */
    public function originalContents()
    {
        if (!isset($this->originalContents)) {
            $this->originalContents = '';
            if (file_exists($this->filename)) {
                $this->originalContents = file_get_contents($this->filename);
            }
        }
        return $this->originalContents;
    }

    /**
     * @return bool
     */
    public function wouldChange()
    {
        return $this->originalContents() != $this->getContentsToWrite();
    }

    /**
     * @return string
     */
    protected function getContentsToWrite()
    {
        $contents = "";
        if ($this->append) {
            $contents = $this->originalContents();
        }
        foreach ($this->stack as $action) {
            $command = array_shift($action);
            if (method_exists($this, $command)) {
                array_unshift($action, $contents);
                $contents = call_user_func_array([$this, $command], $action);
            }
        }
        return $contents;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->printTaskInfo("Writing to {filename}.", ['filename' => $this->filename]);
        $contents = $this->getContentsToWrite();
        if (!file_exists(dirname($this->filename))) {
            mkdir(dirname($this->filename), 0777, true);
        }
        $res = file_put_contents($this->filename, $contents);
        if ($res === false) {
            return Result::error($this, "File {$this->filename} couldn't be created");
        }

        return Result::success($this);
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->filename;
    }
}
