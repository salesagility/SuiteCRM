<?php

namespace Robo\Task\Filesystem;

use Robo\Result;
use Robo\Contract\RollbackInterface;
use Robo\Contract\BuilderAwareInterface;
use Robo\Common\BuilderAwareTrait;

/**
 * Create a temporary working directory that is automatically renamed to its
 * final desired location if all of the tasks in the collection succeed.  If
 * there is a rollback, then the working directory is deleted.
 *
 * ``` php
 * <?php
 * $collection = $this->collectionBuilder();
 * $workingPath = $collection->workDir("build")->getPath();
 * $collection->taskFilesystemStack()
 *           ->mkdir("$workingPath/log")
 *           ->touch("$workingPath/log/error.txt");
 * $collection->run();
 * ?>
 * ```
 */
class WorkDir extends TmpDir implements RollbackInterface, BuilderAwareInterface
{
    use BuilderAwareTrait;

    /**
     * @var string
     */
    protected $finalDestination;

    /**
     * @param string $finalDestination
     */
    public function __construct($finalDestination)
    {
        $this->finalDestination = $finalDestination;

        // Create a temporary directory to work in. We will place our
        // temporary directory in the same location as the final destination
        // directory, so that the work directory can be moved into place
        // without having to be copied, e.g. in a cross-volume rename scenario.
        parent::__construct(basename($finalDestination), dirname($finalDestination));
    }

    /**
     * Create our working directory.
     *
     * @return \Robo\Result
     */
    public function run()
    {
        // Destination cannot be empty
        if (empty($this->finalDestination)) {
            return Result::error($this, "Destination directory not specified.");
        }

        // Before we do anything else, ensure that any directory in the
        // final destination is writable, so that we can at a minimum
        // move it out of the way before placing our results there.
        if (is_dir($this->finalDestination)) {
            if (!is_writable($this->finalDestination)) {
                return Result::error($this, "Destination directory {dir} exists and cannot be overwritten.", ['dir' => $this->finalDestination]);
            }
        }

        return parent::run();
    }

    /**
     * Move our working directory into its final destination once the
     * collection it belongs to completes.
     */
    public function complete()
    {
        $this->restoreWorkingDirectory();

        // Delete the final destination, if it exists.
        // Move it out of the way first, in case it cannot
        // be completely deleted.
        if (file_exists($this->finalDestination)) {
            $temporaryLocation = static::randomLocation($this->finalDestination . '_TO_DELETE_');
            // This should always work, because we already created a temporary
            // folder in the parent directory of the final destination, and we
            // have already checked to confirm that the final destination is
            // writable.
            rename($this->finalDestination, $temporaryLocation);
            // This may silently fail, leaving artifacts behind, if there
            // are permissions problems with some items somewhere inside
            // the folder being deleted.
            $this->fs->remove($temporaryLocation);
        }

        // Move our working directory over the final destination.
        // This should never be a cross-volume rename, so this should
        // always succeed.
        $workDir = reset($this->dirs);
        if (file_exists($workDir)) {
            rename($workDir, $this->finalDestination);
        }
    }

    /**
     * Delete our working directory
     */
    public function rollback()
    {
        $this->restoreWorkingDirectory();
        $this->deleteTmpDir();
    }

    /**
     * Get a reference to the path to the temporary directory, so that
     * it may be used to create other tasks.  Note that the directory
     * is not actually created until the task runs.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->dirs[0];
    }
}
