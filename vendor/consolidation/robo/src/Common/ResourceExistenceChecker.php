<?php

namespace Robo\Common;

trait ResourceExistenceChecker
{
    /**
     * Checks if the given input is a file or folder.
     *
     * @param string|string[] $resources
     * @param string $type
     *   Allowed values: "file", "dir", "fileAndDir"
     *
     * @return bool
     *   True if no errors were encountered otherwise false.
     */
    protected function checkResources($resources, $type = 'fileAndDir')
    {
        if (!in_array($type, ['file', 'dir', 'fileAndDir'])) {
            throw new \InvalidArgumentException(sprintf('Invalid resource check of type "%s" used!', $type));
        }
        if (is_string($resources)) {
            $resources = [$resources];
        }
        $success = true;
        foreach ($resources as $resource) {
            $glob = glob($resource);
            if ($glob === false) {
                $this->printTaskError(sprintf('Invalid glob "%s"!', $resource), $this);
                $success = false;
                continue;
            }
            foreach ($glob as $resource) {
                if (!$this->checkResource($resource, $type)) {
                    $success = false;
                }
            }
        }
        return $success;
    }

    /**
     * Checks a single resource, file or directory.
     *
     * It will print an error as well on the console.
     *
     * @param string $resource
     *   File or folder.
     * @param string $type
     *   Allowed values: "file", "dir", "fileAndDir".
     *
     * @return bool
     */
    protected function checkResource($resource, $type)
    {
        switch ($type) {
            case 'file':
                if (!$this->isFile($resource)) {
                    $this->printTaskError(sprintf('File "%s" does not exist!', $resource), $this);
                    return false;
                }
                return true;
            case 'dir':
                if (!$this->isDir($resource)) {
                    $this->printTaskError(sprintf('Directory "%s" does not exist!', $resource), $this);
                    return false;
                }
                return true;
            case 'fileAndDir':
                if (!$this->isDir($resource) && !$this->isFile($resource)) {
                    $this->printTaskError(sprintf('File or directory "%s" does not exist!', $resource), $this);
                    return false;
                }
                return true;
        }
    }

    /**
     * Convenience method to check the often uses "source => target" file / folder arrays.
     *
     * @param string|array $resources
     */
    protected function checkSourceAndTargetResource($resources)
    {
        if (is_string($resources)) {
            $resources = [$resources];
        }
        $sources = [];
        $targets = [];
        foreach ($resources as $source => $target) {
            $sources[] = $source;
            $target[] = $target;
        }
        $this->checkResources($sources);
        $this->checkResources($targets);
    }

   /**
    * Wrapper method around phps is_dir()
    *
    * @param string $directory
    *
    * @return bool
    */
    protected function isDir($directory)
    {
        return is_dir($directory);
    }

   /**
    * Wrapper method around phps file_exists()
    *
    * @param string $file
    *
    * @return bool
    */
    protected function isFile($file)
    {
        return file_exists($file);
    }
}
