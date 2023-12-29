<?php

namespace Robo\Task\ApiGen;

use Robo\Contract\CommandInterface;
use Robo\Exception\TaskException;
use Robo\Task\BaseTask;
use Traversable;
use Robo\Common\ExecOneCommand;

/**
 * Executes ApiGen command to generate documentation
 *
 * ``` php
 * <?php
 * // ApiGen Command
 * $this->taskApiGen('./vendor/apigen/apigen.phar')
 *      ->config('./apigen.neon')
 *      ->templateConfig('vendor/apigen/apigen/templates/bootstrap/config.neon')
 *      ->wipeout(true)
 *       ->run();
 * ?>
 * ```
 */
class ApiGen extends BaseTask implements CommandInterface
{
    use ExecOneCommand;

    const BOOL_NO = 'no';
    const BOOL_YES = 'yes';

    /**
     * @var string
     */
    protected $command;

    /**
     * @var string
     */
    protected $operation = 'generate';

    /**
     * @param null|string $pathToApiGen
     *
     * @throws \Robo\Exception\TaskException
     */
    public function __construct($pathToApiGen = null)
    {
        $this->command = $pathToApiGen;
        $command_parts = [];
        preg_match('/((?:.+)?apigen(?:\.phar)?) ?( \w+)? ?(.+)?/', $this->command, $command_parts);
        if (count($command_parts) === 3) {
            list(, $this->command, $this->operation) = $command_parts;
        }
        if (count($command_parts) === 4) {
            list(, $this->command, $this->operation, $arg) = $command_parts;
            $this->arg($arg);
        }
        if (!$this->command) {
            $this->command = $this->findExecutablePhar('apigen');
        }
        if (!$this->command) {
            throw new TaskException(__CLASS__, "No apigen installation found");
        }
    }

    /**
     * Pass methods parameters as arguments to executable. Argument values
     * are automatically escaped.
     *
     * @param string|string[] $args
     *
     * @return $this
     */
    public function args($args)
    {
        $func_args = func_get_args();
        if (!is_array($args)) {
            $args = $func_args;
        }
        $args = array_map(function ($arg) {
            if (preg_match('/^\w+$/', trim($arg)) === 1) {
                $this->operation = $arg;
                return null;
            }
            return $arg;
        }, $args);
        $args = array_filter($args);
        $this->arguments .= ' ' . implode(' ', array_map('static::escape', $args));
        return $this;
    }

    /**
     * @param array|\Traversable|string $arg
     *   A single object or something traversable.
     *
     * @return array|\Traversable
     *   The provided argument if it was already traversable, or the given
     *   argument returned as a one-element array.
     */
    protected static function forceTraversable($arg)
    {
        $traversable = $arg;
        if (!is_array($traversable) && !($traversable instanceof \Traversable)) {
            $traversable = array($traversable);
        }
        return $traversable;
    }

    /**
     * @param array|string $arg
     *   A single argument or an array of multiple string values.
     *
     * @return string
     *   A comma-separated string of all of the provided arguments, suitable as
     *   a command-line "list" type argument for ApiGen.
     */
    protected static function asList($arg)
    {
        $normalized = is_array($arg) ? $arg : array($arg);
        return implode(',', $normalized);
    }

    /**
     * @param bool|string $val
     *   An argument to be normalized.
     * @param string $default
     *   One of self::BOOL_YES or self::BOOK_NO if the provided value could not
     *   deterministically be converted to a yes or no value.
     *
     * @return string
     *   The given value as a command-line "yes|no" type of argument for ApiGen,
     *   or the default value if none could be determined.
     */
    protected static function asTextBool($val, $default)
    {
        if ($val === self::BOOL_YES || $val === self::BOOL_NO) {
            return $val;
        }
        if (!$val) {
            return self::BOOL_NO;
        }
        if ($val === true) {
            return self::BOOL_YES;
        }
        if (is_numeric($val) && $val != 0) {
            return self::BOOL_YES;
        }
        if (strcasecmp($val[0], 'y') === 0) {
            return self::BOOL_YES;
        }
        if (strcasecmp($val[0], 'n') === 0) {
            return self::BOOL_NO;
        }
        // meh, good enough, let apigen sort it out
        return $default;
    }

    /**
     * @param string $config
     *
     * @return $this
     */
    public function config($config)
    {
        $this->option('config', $config);
        return $this;
    }

    /**
     * @param array|string|\Traversable $src
     *   One or more source values.
     *
     * @return $this
     */
    public function source($src)
    {
        foreach (self::forceTraversable($src) as $source) {
            $this->option('source', $source);
        }
        return $this;
    }

    /**
     * @param string $dest
     *
     * @return $this
     */
    public function destination($dest)
    {
        $this->option('destination', $dest);
        return $this;
    }

    /**
     * @param array|string $exts
     *   One or more extensions.
     *
     * @return $this
     */
    public function extensions($exts)
    {
        $this->option('extensions', self::asList($exts));
        return $this;
    }

    /**
     * @param array|string $exclude
     *   One or more exclusions.
     *
     * @return $this
     */
    public function exclude($exclude)
    {
        foreach (self::forceTraversable($exclude) as $excl) {
            $this->option('exclude', $excl);
        }
        return $this;
    }

    /**
     * @param array|string|\Traversable $path
     *   One or more skip-doc-path values.
     *
     * @return $this
     */
    public function skipDocPath($path)
    {
        foreach (self::forceTraversable($path) as $skip) {
            $this->option('skip-doc-path', $skip);
        }
        return $this;
    }

    /**
     * @param array|string|\Traversable $prefix
     *   One or more skip-doc-prefix values.
     *
     * @return $this
     */
    public function skipDocPrefix($prefix)
    {
        foreach (self::forceTraversable($prefix) as $skip) {
            $this->option('skip-doc-prefix', $skip);
        }
        return $this;
    }

    /**
     * @param array|string $charset
     *   One or more charsets.
     *
     * @return $this
     */
    public function charset($charset)
    {
        $this->option('charset', self::asList($charset));
        return $this;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function mainProjectNamePrefix($name)
    {
        $this->option('main', $name);
        return $this;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function title($title)
    {
        $this->option('title', $title);
        return $this;
    }

    /**
     * @param string $baseUrl
     *
     * @return $this
     */
    public function baseUrl($baseUrl)
    {
        $this->option('base-url', $baseUrl);
        return $this;
    }

    /**
     * @param string $id
     *
     * @return $this
     */
    public function googleCseId($id)
    {
        $this->option('google-cse-id', $id);
        return $this;
    }

    /**
     * @param string $trackingCode
     *
     * @return $this
     */
    public function googleAnalytics($trackingCode)
    {
        $this->option('google-analytics', $trackingCode);
        return $this;
    }

    /**
     * @param mixed $templateConfig
     *
     * @return $this
     */
    public function templateConfig($templateConfig)
    {
        $this->option('template-config', $templateConfig);
        return $this;
    }

    /**
     * @param array|string $tags
     *   One or more supported html tags.
     *
     * @return $this
     */
    public function allowedHtml($tags)
    {
        $this->option('allowed-html', self::asList($tags));
        return $this;
    }

    /**
     * @param string $groups
     *
     * @return $this
     */
    public function groups($groups)
    {
        $this->option('groups', $groups);
        return $this;
    }

    /**
     * @param array|string $types
     *   One or more supported autocomplete types.
     *
     * @return $this
     */
    public function autocomplete($types)
    {
        $this->option('autocomplete', self::asList($types));
        return $this;
    }

    /**
     * @param array|string $levels
     *   One or more access levels.
     *
     * @return $this
     */
    public function accessLevels($levels)
    {
        $this->option('access-levels', self::asList($levels));
        return $this;
    }

    /**
     * @param boolean|string $internal
     *   'yes' or true if internal, 'no' or false if not.
     *
     * @return $this
     */
    public function internal($internal)
    {
        $this->option('internal', self::asTextBool($internal, self::BOOL_NO));
        return $this;
    }

    /**
     * @param bool|string $php
     *   'yes' or true to generate documentation for internal php classes, 'no'
     *   or false otherwise.
     *
     * @return $this
     */
    public function php($php)
    {
        $this->option('php', self::asTextBool($php, self::BOOL_YES));
        return $this;
    }

    /**
     * @param bool|string $tree
     *   'yes' or true to generate a tree view of classes, 'no' or false
     *   otherwise.
     *
     * @return $this
     */
    public function tree($tree)
    {
        $this->option('tree', self::asTextBool($tree, self::BOOL_YES));
        return $this;
    }

    /**
     * @param bool|string $dep
     *   'yes' or true to generate documentation for deprecated classes, 'no' or
     *   false otherwise.
     *
     * @return $this
     */
    public function deprecated($dep)
    {
        $this->option('deprecated', self::asTextBool($dep, self::BOOL_NO));
        return $this;
    }

    /**
     * @param bool|string $todo
     *   'yes' or true to document tasks, 'no' or false otherwise.
     *
     * @return $this
     */
    public function todo($todo)
    {
        $this->option('todo', self::asTextBool($todo, self::BOOL_NO));
        return $this;
    }

    /**
     * @param bool|string $src
     *   'yes' or true to generate highlighted source code, 'no' or false
     *   otherwise.
     *
     * @return $this
     */
    public function sourceCode($src)
    {
        $this->option('source-code', self::asTextBool($src, self::BOOL_YES));
        return $this;
    }

    /**
     * @param bool|string $zipped
     *   'yes' or true to generate downloadable documentation, 'no' or false
     *   otherwise.
     *
     * @return $this
     */
    public function download($zipped)
    {
        $this->option('download', self::asTextBool($zipped, self::BOOL_NO));
        return $this;
    }

    /**
     * @param string $path
     *
     * @return $this
     */
    public function report($path)
    {
        $this->option('report', $path);
        return $this;
    }

    /**
     * @param bool|string $wipeout
     *   'yes' or true to clear out the destination directory, 'no' or false
     *   otherwise.
     *
     * @return $this
     */
    public function wipeout($wipeout)
    {
        $this->option('wipeout', self::asTextBool($wipeout, self::BOOL_YES));
        return $this;
    }

    /**
     * @param bool|string $quiet
     *   'yes' or true for quiet, 'no' or false otherwise.
     *
     * @return $this
     */
    public function quiet($quiet)
    {
        $this->option('quiet', self::asTextBool($quiet, self::BOOL_NO));
        return $this;
    }

    /**
     * @param bool|string $bar
     *   'yes' or true to display a progress bar, 'no' or false otherwise.
     *
     * @return $this
     */
    public function progressbar($bar)
    {
        $this->option('progressbar', self::asTextBool($bar, self::BOOL_YES));
        return $this;
    }

    /**
     * @param bool|string $colors
     *   'yes' or true colorize the output, 'no' or false otherwise.
     *
     * @return $this
     */
    public function colors($colors)
    {
        $this->option('colors', self::asTextBool($colors, self::BOOL_YES));
        return $this;
    }

    /**
     * @param bool|string $check
     *   'yes' or true to check for updates, 'no' or false otherwise.
     *
     * @return $this
     */
    public function updateCheck($check)
    {
        $this->option('update-check', self::asTextBool($check, self::BOOL_YES));
        return $this;
    }

    /**
     * @param bool|string $debug
     *   'yes' or true to enable debug mode, 'no' or false otherwise.
     *
     * @return $this
     */
    public function debug($debug)
    {
        $this->option('debug', self::asTextBool($debug, self::BOOL_NO));
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCommand()
    {
        return "$this->command $this->operation$this->arguments";
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->printTaskInfo('Running ApiGen {args}', ['args' => $this->arguments]);
        return $this->executeCommand($this->getCommand());
    }
}
