<?php

namespace Robo\Task\Filesystem;

use Robo\Result;
use Robo\Exception\TaskException;
use Symfony\Component\Finder\Finder;

/**
 * Searches for files in a nested directory structure and copies them to
 * a target directory with or without the parent directories. The task was
 * inspired by [gulp-flatten](https://www.npmjs.com/package/gulp-flatten).
 *
 * Example directory structure:
 *
 * ```
 * └── assets
 *     ├── asset-library1
 *     │   ├── README.md
 *     │   └── asset-library1.min.js
 *     └── asset-library2
 *         ├── README.md
 *         └── asset-library2.min.js
 * ```
 *
 * The following code will search the `*.min.js` files and copy them
 * inside a new `dist` folder:
 *
 * ``` php
 * <?php
 * $this->taskFlattenDir(['assets/*.min.js' => 'dist'])->run();
 * // or use shortcut
 * $this->_flattenDir('assets/*.min.js', 'dist');
 * ?>
 * ```
 *
 * You can also define the target directory with an additional method, instead of
 * key/value pairs. More similar to the gulp-flatten syntax:
 *
 * ``` php
 * <?php
 * $this->taskFlattenDir(['assets/*.min.js'])
 *   ->to('dist')
 *   ->run();
 * ?>
 * ```
 *
 * You can also append parts of the parent directories to the target path. If you give
 * the value `1` to the `includeParents()` method, then the top parent will be appended
 * to the target directory resulting in a path such as `dist/assets/asset-library1.min.js`.
 *
 * If you give a negative number, such as `-1` (the same as specifying `array(0, 1)` then
 * the bottom parent will be appended, resulting in a path such as
 * `dist/asset-library1/asset-library1.min.js`.
 *
 * The top parent directory will always be starting from the relative path to the current
 * directory. You can override that with the `parentDir()` method. If in the above example
 * you would specify `assets`, then the top parent directory would be `asset-library1`.
 *
 * ``` php
 * <?php
 * $this->taskFlattenDir(['assets/*.min.js' => 'dist'])
 *   ->parentDir('assets')
 *   ->includeParents(1)
 *   ->run();
 * ?>
 * ```
 */
class FlattenDir extends BaseDir
{
    /**
     * @var int
     */
    protected $chmod = 0755;

    /**
     * @var int[]
     */
    protected $parents = array(0, 0);

    /**
     * @var string
     */
    protected $parentDir = '';

    /**
     * @var string
     */
    protected $to;

    /**
     * {@inheritdoc}
     */
    public function __construct($dirs)
    {
        parent::__construct($dirs);
        $this->parentDir = getcwd();
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        // find the files
        $files = $this->findFiles($this->dirs);

        // copy the files
        $this->copyFiles($files);

        $fileNoun = count($files) == 1 ? ' file' : ' files';
        $this->printTaskSuccess("Copied {count} $fileNoun to {destination}", ['count' => count($files), 'destination' => $this->to]);

        return Result::success($this);
    }

    /**
     * Sets the default folder permissions for the destination if it does not exist.
     *
     * @link https://en.wikipedia.org/wiki/Chmod
     * @link https://php.net/manual/en/function.mkdir.php
     * @link https://php.net/manual/en/function.chmod.php
     *
     * @param int $permission
     *
     * @return $this
     */
    public function dirPermissions($permission)
    {
        $this->chmod = (int) $permission;

        return $this;
    }

    /**
     * Sets the value from which direction and how much parent dirs should be included.
     * Accepts a positive or negative integer or an array with two integer values.
     *
     * @param int|int[] $parents
     *
     * @return $this
     *
     * @throws TaskException
     */
    public function includeParents($parents)
    {
        if (is_int($parents)) {
            // if an integer is given check whether it is for top or bottom parent
            if ($parents >= 0) {
                $this->parents[0] = $parents;
                return $this;
            }
            $this->parents[1] = 0 - $parents;
            return $this;
        }

        if (is_array($parents)) {
            // check if the array has two values no more, no less
            if (count($parents) == 2) {
                $this->parents = $parents;
                return $this;
            }
        }

        throw new TaskException($this, 'includeParents expects an integer or an array with two values');
    }

    /**
     * Sets the parent directory from which the relative parent directories will be calculated.
     *
     * @param string $dir
     *
     * @return $this
     */
    public function parentDir($dir)
    {
        if (!$this->fs->isAbsolutePath($dir)) {
            // attach the relative path to current working directory
            $dir = getcwd() . '/' . $dir;
        }
        $this->parentDir = $dir;

        return $this;
    }

    /**
     * Sets the target directory where the files will be copied to.
     *
     * @param string $target
     *
     * @return $this
     */
    public function to($target)
    {
        $this->to = rtrim($target, '/');

        return $this;
    }

    /**
     * @param array $dirs
     *
     * @return array|\Robo\Result
     *
     * @throws \Robo\Exception\TaskException
     */
    protected function findFiles($dirs)
    {
        $files = array();

        // find the files
        foreach ($dirs as $k => $v) {
            // reset finder
            $finder = new Finder();

            $dir = $k;
            $to = $v;
            // check if target was given with the to() method instead of key/value pairs
            if (is_int($k)) {
                $dir = $v;
                if (isset($this->to)) {
                    $to = $this->to;
                } else {
                    throw new TaskException($this, 'target directory is not defined');
                }
            }

            try {
                $finder->files()->in($dir);
            } catch (\InvalidArgumentException $e) {
                // if finder cannot handle it, try with in()->name()
                if (strpos($dir, '/') === false) {
                    $dir = './' . $dir;
                }
                $parts = explode('/', $dir);
                $new_dir = implode('/', array_slice($parts, 0, -1));
                try {
                    $finder->files()->in($new_dir)->name(array_pop($parts));
                } catch (\InvalidArgumentException $e) {
                    return Result::fromException($this, $e);
                }
            }

            foreach ($finder as $file) {
                // store the absolute path as key and target as value in the files array
                $files[$file->getRealpath()] = $this->getTarget($file->getRealPath(), $to);
            }
            $fileNoun = count($files) == 1 ? ' file' : ' files';
            $this->printTaskInfo("Found {count} $fileNoun in {dir}", ['count' => count($files), 'dir' => $dir]);
        }

        return $files;
    }

    /**
     * @param string $file
     * @param string $to
     *
     * @return string
     */
    protected function getTarget($file, $to)
    {
        $target = $to . '/' . basename($file);
        if ($this->parents !== array(0, 0)) {
            // if the parent is set, create additional directories inside target
            // get relative path to parentDir
            $rel_path = $this->fs->makePathRelative(dirname($file), $this->parentDir);
            // get top parents and bottom parents
            $parts = explode('/', rtrim($rel_path, '/'));
            $prefix_dir = '';
            $prefix_dir .= ($this->parents[0] > 0 ? implode('/', array_slice($parts, 0, $this->parents[0])) . '/' : '');
            $prefix_dir .= ($this->parents[1] > 0 ? implode('/', array_slice($parts, (0 - $this->parents[1]), $this->parents[1])) : '');
            $prefix_dir = rtrim($prefix_dir, '/');
            $target = $to . '/' . $prefix_dir . '/' . basename($file);
        }

        return $target;
    }

    /**
     * @param array $files
     */
    protected function copyFiles($files)
    {
        // copy the files
        foreach ($files as $from => $to) {
            // check if target dir exists
            if (!is_dir(dirname($to))) {
                $this->fs->mkdir(dirname($to), $this->chmod);
            }
            $this->fs->copy($from, $to);
        }
    }
}
