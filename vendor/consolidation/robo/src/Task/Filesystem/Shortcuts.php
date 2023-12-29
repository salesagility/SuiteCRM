<?php

namespace Robo\Task\Filesystem;

trait Shortcuts
{
    /**
     * @param string $src
     * @param string $dst
     *
     * @return \Robo\Result
     */
    protected function _copyDir($src, $dst)
    {
        return $this->taskCopyDir([$src => $dst])->run();
    }

    /**
     * @param string $src
     * @param string $dst
     *
     * @return \Robo\Result
     */
    protected function _mirrorDir($src, $dst)
    {
        return $this->taskMirrorDir([$src => $dst])->run();
    }

    /**
     * @param string|string[] $dir
     *
     * @return \Robo\Result
     */
    protected function _deleteDir($dir)
    {
        return $this->taskDeleteDir($dir)->run();
    }

    /**
     * @param string|string[] $dir
     *
     * @return \Robo\Result
     */
    protected function _cleanDir($dir)
    {
        return $this->taskCleanDir($dir)->run();
    }

    /**
     * @param string $from
     * @param string $to
     * @param bool $overwrite
     *
     * @return \Robo\Result
     */
    protected function _rename($from, $to, $overwrite = false)
    {
        return $this->taskFilesystemStack()->rename($from, $to, $overwrite)->run();
    }

    /**
     * @param string|string[] $dir
     *
     * @return \Robo\Result
     */
    protected function _mkdir($dir)
    {
        return $this->taskFilesystemStack()->mkdir($dir)->run();
    }

    /**
     * @param string $prefix
     * @param string $base
     * @param bool $includeRandomPart
     *
     * @return string
     */
    protected function _tmpDir($prefix = 'tmp', $base = '', $includeRandomPart = true)
    {
        $result = $this->taskTmpDir($prefix, $base, $includeRandomPart)->run();
        return isset($result['path']) ? $result['path'] : '';
    }

    /**
     * @param string $file
     *
     * @return \Robo\Result
     */
    protected function _touch($file)
    {
        return $this->taskFilesystemStack()->touch($file)->run();
    }

    /**
     * @param string|string[] $file
     *
     * @return \Robo\Result
     */
    protected function _remove($file)
    {
        return $this->taskFilesystemStack()->remove($file)->run();
    }

    /**
     * @param string|string[] $file
     * @param string $group
     *
     * @return \Robo\Result
     */
    protected function _chgrp($file, $group)
    {
        return $this->taskFilesystemStack()->chgrp($file, $group)->run();
    }

    /**
     * @param string|string[] $file
     * @param int $permissions
     * @param int $umask
     * @param bool $recursive
     *
     * @return \Robo\Result
     */
    protected function _chmod($file, $permissions, $umask = 0000, $recursive = false)
    {
        return $this->taskFilesystemStack()->chmod($file, $permissions, $umask, $recursive)->run();
    }

    /**
     * @param string $from
     * @param string $to
     *
     * @return \Robo\Result
     */
    protected function _symlink($from, $to)
    {
        return $this->taskFilesystemStack()->symlink($from, $to)->run();
    }

    /**
     * @param string $from
     * @param string $to
     *
     * @return \Robo\Result
     */
    protected function _copy($from, $to)
    {
        return $this->taskFilesystemStack()->copy($from, $to)->run();
    }

    /**
     * @param string $from
     * @param string $to
     *
     * @return \Robo\Result
     */
    protected function _flattenDir($from, $to)
    {
        return $this->taskFlattenDir([$from => $to])->run();
    }
}
