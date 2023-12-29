<?php
namespace Consolidation\AnnotatedCommand;

use Symfony\Component\Finder\Finder;

/**
 * Do discovery presuming that the namespace of the command will
 * contain the last component of the path.  This is the convention
 * that should be used when searching for command files that are
 * bundled with the modules of a framework.  The convention used
 * is that the namespace for a module in a framework should start with
 * the framework name followed by the module name.
 *
 * For example, if base namespace is "Drupal", then a command file in
 * modules/default_content/src/CliTools/ExampleCommands.cpp
 * will be in the namespace Drupal\default_content\CliTools.
 *
 * For global locations, the middle component of the namespace is
 * omitted.  For example, if the base namespace is "Drupal", then
 * a command file in __DRUPAL_ROOT__/CliTools/ExampleCommands.cpp
 * will be in the namespace Drupal\CliTools.
 *
 * To discover namespaced commands in modules:
 *
 * $commandFiles = $discovery->discoverNamespaced($moduleList, '\Drupal');
 *
 * To discover global commands:
 *
 * $commandFiles = $discovery->discover($drupalRoot, '\Drupal');
 *
 * WARNING:
 *
 * This class is deprecated. Commandfile discovery is complicated, and does
 * not work from within phar files. It is recommended to instead use a static
 * list of command classes as shown in https://github.com/g1a/starter/blob/master/example
 *
 * For a better alternative when implementing a plugin mechanism, see
 * https://robo.li/extending/#register-command-files-via-psr-4-autoloading
 */
class CommandFileDiscovery
{
    /** @var string[] */
    protected $excludeList;
    /** @var string[] */
    protected $searchLocations;
    /** @var string */
    protected $searchPattern = '*Commands.php';
    /** @var boolean */
    protected $includeFilesAtBase = true;
    /** @var integer */
    protected $searchDepth = 2;
    /** @var bool */
    protected $followLinks = false;
    /** @var string[] */
    protected $strippedNamespaces;

    public function __construct()
    {
        $this->excludeList = ['Exclude'];
        $this->searchLocations = [
            'Command',
            'CliTools', // TODO: Maybe remove
        ];
    }

    /**
     * Specify whether to search for files at the base directory
     * ($directoryList parameter to discover and discoverNamespaced
     * methods), or only in the directories listed in the search paths.
     *
     * @param boolean $includeFilesAtBase
     */
    public function setIncludeFilesAtBase($includeFilesAtBase)
    {
        $this->includeFilesAtBase = $includeFilesAtBase;
        return $this;
    }

    /**
     * Set the list of excludes to add to the finder, replacing
     * whatever was there before.
     *
     * @param array $excludeList The list of directory names to skip when
     *   searching for command files.
     */
    public function setExcludeList($excludeList)
    {
        $this->excludeList = $excludeList;
        return $this;
    }

    /**
     * Add one more location to the exclude list.
     *
     * @param string $exclude One directory name to skip when searching
     *   for command files.
     */
    public function addExclude($exclude)
    {
        $this->excludeList[] = $exclude;
        return $this;
    }

    /**
     * Set the search depth.  By default, fills immediately in the
     * base directory are searched, plus all of the search locations
     * to this specified depth.  If the search locations is set to
     * an empty array, then the base directory is searched to this
     * depth.
     */
    public function setSearchDepth($searchDepth)
    {
        $this->searchDepth = $searchDepth;
        return $this;
    }

    /**
     * Specify that the discovery object should follow symlinks. By
     * default, symlinks are not followed.
     */
    public function followLinks($followLinks = true)
    {
        $this->followLinks = $followLinks;
        return $this;
    }

    /**
     * Set the list of search locations to examine in each directory where
     * command files may be found.  This replaces whatever was there before.
     *
     * @param array $searchLocations The list of locations to search for command files.
     */
    public function setSearchLocations($searchLocations)
    {
        $this->searchLocations = $searchLocations;
        return $this;
    }

    /**
     * Set a particular namespace part to ignore. This is useful in plugin
     * mechanisms where the plugin is placed by Composer.
     *
     * For example, Drush extensions are placed in `./drush/Commands`.
     * If the Composer installer path is `"drush/Commands/contrib/{$name}": ["type:drupal-drush"]`,
     * then Composer will place the command files in `drush/Commands/contrib`.
     * The namespace should not be any different in this instance than if
     * the extension were placed in `drush/Commands`, though, so Drush therefore
     * calls `ignoreNamespacePart('contrib', 'Commands')`. This causes the
     * `contrib` component to be removed from the namespace if it follows
     * the namespace `Commands`. If the '$base' parameter is not specified, then
     * the ignored portion of the namespace may appear anywhere in the path.
     */
    public function ignoreNamespacePart($ignore, $base = '')
    {
        $replacementPart = '\\';
        if (!empty($base)) {
            $replacementPart .= $base . '\\';
        }
        $ignoredPart = $replacementPart . $ignore . '\\';
        $this->strippedNamespaces[$ignoredPart] = $replacementPart;

        return $this;
    }

    /**
     * Add one more location to the search location list.
     *
     * @param string $location One more relative path to search
     *   for command files.
     */
    public function addSearchLocation($location)
    {
        $this->searchLocations[] = $location;
        return $this;
    }

    /**
     * Specify the pattern / regex used by the finder to search for
     * command files.
     */
    public function setSearchPattern($searchPattern)
    {
        $this->searchPattern = $searchPattern;
        return $this;
    }

    /**
     * Given a list of directories, e.g. Drupal modules like:
     *
     *    core/modules/block
     *    core/modules/dblog
     *    modules/default_content
     *
     * Discover command files in any of these locations.
     *
     * @param string|string[] $directoryList Places to search for commands.
     *
     * @return array
     */
    public function discoverNamespaced($directoryList, $baseNamespace = '')
    {
        return $this->discover($this->convertToNamespacedList((array)$directoryList), $baseNamespace);
    }

    /**
     * Given a simple list containing paths to directories, where
     * the last component of the path should appear in the namespace,
     * after the base namespace, this function will return an
     * associative array mapping the path's basename (e.g. the module
     * name) to the directory path.
     *
     * Module names must be unique.
     *
     * @param string[] $directoryList A list of module locations
     *
     * @return array
     */
    public function convertToNamespacedList($directoryList)
    {
        $namespacedArray = [];
        foreach ((array)$directoryList as $directory) {
            $namespacedArray[basename($directory)] = $directory;
        }
        return $namespacedArray;
    }

    /**
     * Search for command files in the specified locations. This is the function that
     * should be used for all locations that are NOT modules of a framework.
     *
     * @param string|string[] $directoryList Places to search for commands.
     * @return array
     */
    public function discover($directoryList, $baseNamespace = '')
    {
        $commandFiles = [];
        foreach ((array)$directoryList as $key => $directory) {
            $itemsNamespace = $this->joinNamespace([$baseNamespace, $key]);
            $commandFiles = array_merge(
                $commandFiles,
                $this->discoverCommandFiles($directory, $itemsNamespace),
                $this->discoverCommandFiles("$directory/src", $itemsNamespace)
            );
        }
        return $this->fixNamespaces($commandFiles);
    }

    /**
     * fixNamespaces will alter the namespaces in the commandFiles
     * result to remove the Composer placement directory, if any.
     */
    protected function fixNamespaces($commandFiles)
    {
        // Do nothing unless the client told us to remove some namespace components.
        if (empty($this->strippedNamespaces)) {
            return $commandFiles;
        }

        // Strip out any part of the namespace the client did not want.
        // @see CommandFileDiscovery::ignoreNamespacePart
        return array_map(
            function ($fqcn) {
                return str_replace(
                    array_keys($this->strippedNamespaces),
                    array_values($this->strippedNamespaces),
                    $fqcn
                );
            },
            $commandFiles
        );
    }

    /**
     * Search for command files in specific locations within a single directory.
     *
     * In each location, we will accept only a few places where command files
     * can be found. This will reduce the need to search through many unrelated
     * files.
     *
     * The default search locations include:
     *
     *    .
     *    CliTools
     *    src/CliTools
     *
     * The pattern we will look for is any file whose name ends in 'Commands.php'.
     * A list of paths to found files will be returned.
     */
    protected function discoverCommandFiles($directory, $baseNamespace)
    {
        $commandFiles = [];
        // In the search location itself, we will search for command files
        // immediately inside the directory only.
        if ($this->includeFilesAtBase) {
            $commandFiles = $this->discoverCommandFilesInLocation(
                $directory,
                $this->getBaseDirectorySearchDepth(),
                $baseNamespace
            );
        }

        // In the other search locations,
        foreach ($this->searchLocations as $location) {
            $itemsNamespace = $this->joinNamespace([$baseNamespace, $location]);
            $commandFiles = array_merge(
                $commandFiles,
                $this->discoverCommandFilesInLocation(
                    "$directory/$location",
                    $this->getSearchDepth(),
                    $itemsNamespace
                )
            );
        }
        return $commandFiles;
    }

    /**
     * Return a Finder search depth appropriate for our selected search depth.
     *
     * @return string
     */
    protected function getSearchDepth()
    {
        return $this->searchDepth <= 0 ? '== 0' : '<= ' . $this->searchDepth;
    }

    /**
     * Return a Finder search depth for the base directory.  If the
     * searchLocations array has been populated, then we will only search
     * for files immediately inside the base directory; no traversal into
     * deeper directories will be done, as that would conflict with the
     * specification provided by the search locations.  If there is no
     * search location, then we will search to whatever depth was specified
     * by the client.
     *
     * @return string
     */
    protected function getBaseDirectorySearchDepth()
    {
        if (!empty($this->searchLocations)) {
            return '== 0';
        }
        return $this->getSearchDepth();
    }

    /**
     * Search for command files in just one particular location.  Returns
     * an associative array mapping from the pathname of the file to the
     * classname that it contains.  The pathname may be ignored if the search
     * location is included in the autoloader.
     *
     * @param string $directory The location to search
     * @param string $depth How deep to search (e.g. '== 0' or '< 2')
     * @param string $baseNamespace Namespace to prepend to each classname
     *
     * @return array
     */
    protected function discoverCommandFilesInLocation($directory, $depth, $baseNamespace)
    {
        if (!is_dir($directory)) {
            return [];
        }
        $finder = $this->createFinder($directory, $depth);

        $commands = [];
        foreach ($finder as $file) {
            $relativePathName = $file->getRelativePathname();
            $relativeNamespaceAndClassname = str_replace(
                ['/', '-', '.php'],
                ['\\', '_', ''],
                $relativePathName
            );
            $classname = $this->joinNamespace([$baseNamespace, $relativeNamespaceAndClassname]);
            $commandFilePath = $this->joinPaths([$directory, $relativePathName]);
            $commands[$commandFilePath] = $classname;
        }

        return $commands;
    }

    /**
     * Create a Finder object for use in searching a particular directory
     * location.
     *
     * @param string $directory The location to search
     * @param string $depth The depth limitation
     *
     * @return Finder
     */
    protected function createFinder($directory, $depth)
    {
        $finder = new Finder();
        $finder->files()
            ->name($this->searchPattern)
            ->in($directory)
            ->depth($depth);

        foreach ($this->excludeList as $item) {
            $finder->exclude($item);
        }

        if ($this->followLinks) {
            $finder->followLinks();
        }

        return $finder;
    }

    /**
     * Combine the items of the provied array into a backslash-separated
     * namespace string.  Empty and numeric items are omitted.
     *
     * @param array $namespaceParts List of components of a namespace
     *
     * @return string
     */
    protected function joinNamespace(array $namespaceParts)
    {
        return $this->joinParts(
            '\\',
            $namespaceParts,
            function ($item) {
                return !is_numeric($item) && !empty($item);
            }
        );
    }

    /**
     * Combine the items of the provied array into a slash-separated
     * pathname.  Empty items are omitted.
     *
     * @param array $pathParts List of components of a path
     *
     * @return string
     */
    protected function joinPaths(array $pathParts)
    {
        $path = $this->joinParts(
            '/',
            $pathParts,
            function ($item) {
                return !empty($item);
            }
        );
        return str_replace(DIRECTORY_SEPARATOR, '/', $path);
    }

    /**
     * Simple wrapper around implode and array_filter.
     *
     * @param string $delimiter
     * @param array $parts
     * @param callable $filterFunction
     */
    protected function joinParts($delimiter, $parts, $filterFunction)
    {
        $parts = array_map(
            function ($item) use ($delimiter) {
                return rtrim($item, $delimiter);
            },
            $parts
        );
        return implode(
            $delimiter,
            array_filter($parts, $filterFunction)
        );
    }
}
