<?php

namespace Robo\Task\Filesystem;

use Robo\Common\ResourceExistenceChecker;
use Robo\Result;

/**
 * Deletes dir
 *
 * ``` php
 * <?php
 * $this->taskDeleteDir('tmp')->run();
 * // as shortcut
 * $this->_deleteDir(['tmp', 'log']);
 * ?>
 * ```
 */
class DeleteDir extends BaseDir
{
    use ResourceExistenceChecker;

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if (!$this->checkResources($this->dirs, 'dir')) {
            return Result::error($this, 'Source directories are missing!');
        }
        foreach ($this->dirs as $dir) {
            $this->fs->remove($dir);
            $this->printTaskInfo("Deleted {dir}...", ['dir' => $dir]);
        }
        return Result::success($this);
    }
}
