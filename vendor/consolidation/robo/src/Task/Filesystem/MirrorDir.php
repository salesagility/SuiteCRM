<?php

namespace Robo\Task\Filesystem;

use Robo\Result;

/**
 * Mirrors a directory to another
 *
 * ``` php
 * <?php
 * $this->taskMirrorDir(['dist/config/' => 'config/'])->run();
 * // or use shortcut
 * $this->_mirrorDir('dist/config/', 'config/');
 *
 * ?>
 * ```
 */
class MirrorDir extends BaseDir
{
    /**
     * {@inheritdoc}
     */
    public function run()
    {
        foreach ($this->dirs as $src => $dst) {
            $this->fs->mirror(
                $src,
                $dst,
                null,
                [
                    'override' => true,
                    'copy_on_windows' => true,
                    'delete' => true
                ]
            );
            $this->printTaskInfo("Mirrored from {source} to {destination}", ['source' => $src, 'destination' => $dst]);
        }
        return Result::success($this);
    }
}
