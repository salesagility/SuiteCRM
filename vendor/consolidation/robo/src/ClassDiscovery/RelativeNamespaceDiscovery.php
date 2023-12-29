<?php

namespace Robo\ClassDiscovery;

use Symfony\Component\Finder\Finder;
use Composer\Autoload\ClassLoader;

/**
 * Class RelativeNamespaceDiscovery
 *
 * @package Robo\Plugin\ClassDiscovery
 */
class RelativeNamespaceDiscovery extends AbstractClassDiscovery
{
    /**
     * @var \Composer\Autoload\ClassLoader
     */
    protected $classLoader;

    /**
     * @var string
     */
    protected $relativeNamespace = '';

    /**
     * RelativeNamespaceDiscovery constructor.
     *
     * @param \Composer\Autoload\ClassLoader $classLoader
     */
    public function __construct(ClassLoader $classLoader)
    {
        $this->classLoader = $classLoader;
    }

    /**
     * @param string $relativeNamespace
     *
     * @return $this
     */
    public function setRelativeNamespace($relativeNamespace)
    {
        $this->relativeNamespace = $relativeNamespace;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getClasses()
    {
        $classes = [];
        $relativePath = $this->convertNamespaceToPath($this->relativeNamespace);

        foreach ($this->classLoader->getPrefixesPsr4() as $baseNamespace => $directories) {
            $directories = array_filter(array_map(function ($directory) use ($relativePath) {
                return $directory . $relativePath;
            }, $directories), 'is_dir');

            if ($directories) {
                foreach ($this->search($directories, $this->searchPattern) as $file) {
                    $relativePathName = $file->getRelativePathname();
                    $classes[] = $baseNamespace . $this->convertPathToNamespace($relativePath . '/' . $relativePathName);
                }
            }
        }

        return $classes;
    }

    /**
     * {@inheritdoc}
     */
    public function getFile($class)
    {
        return $this->classLoader->findFile($class);
    }

    /**
     * @param string|array $directories
     * @param string $pattern
     *
     * @return \Symfony\Component\Finder\Finder
     */
    protected function search($directories, $pattern)
    {
        $finder = new Finder();
        $finder->files()
          ->name($pattern)
          ->in($directories);

        return $finder;
    }

    /**
     * @param string $path
     *
     * @return string
     */
    protected function convertPathToNamespace($path)
    {
        return str_replace(['/', '.php'], ['\\', ''], trim($path, '/'));
    }

    /**
     * @param string $namespace
     *
     * @return string
     */
    public function convertNamespaceToPath($namespace)
    {
        return '/' . str_replace("\\", '/', trim($namespace, '\\'));
    }
}
