<?php

/**
 * SCSSPHP
 *
 * @copyright 2012-2020 Leaf Corcoran
 *
 * @license http://opensource.org/licenses/MIT MIT
 *
 * @link http://scssphp.github.io/scssphp
 */

namespace ScssPhp\ScssPhp\SourceMap;

/**
 * Source Map Generator
 *
 * {@internal Derivative of oyejorge/less.php's lib/SourceMap/Generator.php, relicensed with permission. }}
 *
 * @author Josh Schmidt <oyejorge@gmail.com>
 * @author Nicolas FRANÇOIS <nicolas.francois@frog-labs.com>
 *
 * @internal
 */
final class SourceMapGenerator
{
    /**
     * What version of source map does the generator generate?
     */
    const VERSION = 3;

    /**
     * Array of default options
     *
     * @var array
     * @phpstan-var array{sourceRoot: string, sourceMapFilename: string|null, sourceMapURL: string|null, sourceMapWriteTo: string|null, outputSourceFiles: bool, sourceMapRootpath: string, sourceMapBasepath: string}
     */
    private $defaultOptions = [
        // an optional source root, useful for relocating source files
        // on a server or removing repeated values in the 'sources' entry.
        // This value is prepended to the individual entries in the 'source' field.
        'sourceRoot' => '',

        // an optional name of the generated code that this source map is associated with.
        'sourceMapFilename' => null,

        // url of the map
        'sourceMapURL' => null,

        // absolute path to a file to write the map to
        'sourceMapWriteTo' => null,

        // output source contents?
        'outputSourceFiles' => false,

        // base path for filename normalization
        'sourceMapRootpath' => '',

        // base path for filename normalization
        'sourceMapBasepath' => ''
    ];

    /**
     * The base64 VLQ encoder
     *
     * @var \ScssPhp\ScssPhp\SourceMap\Base64VLQ
     */
    private $encoder;

    /**
     * Array of mappings
     *
     * @var array
     * @phpstan-var list<array{generated_line: int, generated_column: int, original_line: int, original_column: int, source_file: string}>
     */
    private $mappings = [];

    /**
     * File to content map
     *
     * @var array<string, string>
     */
    private $sources = [];

    /**
     * @var array<string, int>
     */
    private $sourceKeys = [];

    /**
     * @var array
     * @phpstan-var array{sourceRoot: string, sourceMapFilename: string|null, sourceMapURL: string|null, sourceMapWriteTo: string|null, outputSourceFiles: bool, sourceMapRootpath: string, sourceMapBasepath: string}
     */
    private $options;

    /**
     * @phpstan-param array{sourceRoot?: string, sourceMapFilename?: string|null, sourceMapURL?: string|null, sourceMapWriteTo?: string|null, outputSourceFiles?: bool, sourceMapRootpath?: string, sourceMapBasepath?: string} $options
     */
    public function __construct(array $options = [])
    {
        $this->options = array_replace($this->defaultOptions, $options);
        $this->encoder = new Base64VLQ();
    }

    /**
     * Adds a mapping
     *
     * @param int    $generatedLine   The line number in generated file
     * @param int    $generatedColumn The column number in generated file
     * @param int    $originalLine    The line number in original file
     * @param int    $originalColumn  The column number in original file
     * @param string $sourceFile      The original source file
     *
     * @return void
     */
    public function addMapping($generatedLine, $generatedColumn, $originalLine, $originalColumn, $sourceFile)
    {
        $this->mappings[] = [
            'generated_line'   => $generatedLine,
            'generated_column' => $generatedColumn,
            'original_line'    => $originalLine,
            'original_column'  => $originalColumn,
            'source_file'      => $sourceFile
        ];

        $this->sources[$sourceFile] = $sourceFile;
    }

    /**
     * Generates the JSON source map
     *
     * @param string $prefix A prefix added in the output file, which needs to shift mappings
     *
     * @return string
     *
     * @see https://docs.google.com/document/d/1U1RGAehQwRypUTovF1KRlpiOFze0b-_2gc6fAH0KY0k/edit#
     */
    public function generateJson(string $prefix = ''): string
    {
        $sourceMap = [];
        $mappings  = $this->generateMappings($prefix);

        // File version (always the first entry in the object) and must be a positive integer.
        $sourceMap['version'] = self::VERSION;

        // An optional name of the generated code that this source map is associated with.
        $file = $this->options['sourceMapFilename'];

        if ($file) {
            $sourceMap['file'] = $file;
        }

        // An optional source root, useful for relocating source files on a server or removing repeated values in the
        // 'sources' entry. This value is prepended to the individual entries in the 'source' field.
        $root = $this->options['sourceRoot'];

        if ($root) {
            $sourceMap['sourceRoot'] = $root;
        }

        // A list of original sources used by the 'mappings' entry.
        $sourceMap['sources'] = [];

        foreach ($this->sources as $sourceFilename) {
            $sourceMap['sources'][] = $this->normalizeFilename($sourceFilename);
        }

        // A list of symbol names used by the 'mappings' entry.
        $sourceMap['names'] = [];

        // A string with the encoded mapping data.
        $sourceMap['mappings'] = $mappings;

        if ($this->options['outputSourceFiles']) {
            // An optional list of source content, useful when the 'source' can't be hosted.
            // The contents are listed in the same order as the sources above.
            // 'null' may be used if some original sources should be retrieved by name.
            $sourceMap['sourcesContent'] = $this->getSourcesContent();
        }

        // less.js compat fixes
        if (\count($sourceMap['sources']) && empty($sourceMap['sourceRoot'])) {
            unset($sourceMap['sourceRoot']);
        }

        $jsonSourceMap = json_encode($sourceMap, JSON_UNESCAPED_SLASHES);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException(json_last_error_msg());
        }

        assert($jsonSourceMap !== false);

        return $jsonSourceMap;
    }

    /**
     * Returns the sources contents
     *
     * @return string[]|null
     */
    private function getSourcesContent(): ?array
    {
        if (empty($this->sources)) {
            return null;
        }

        $content = [];

        foreach ($this->sources as $sourceFile) {
            $content[] = file_get_contents($sourceFile);
        }

        return $content;
    }

    /**
     * Generates the mappings string
     *
     * @param string $prefix A prefix added in the output file, which needs to shift mappings
     *
     * @return string
     */
    public function generateMappings(string $prefix = ''): string
    {
        if (! \count($this->mappings)) {
            return '';
        }

        $prefixLines = substr_count($prefix, "\n");
        $lastPrefixNewLine = strrpos($prefix, "\n");
        $lastPrefixLineStart = false === $lastPrefixNewLine ? 0 : $lastPrefixNewLine + 1;
        $prefixColumn = strlen($prefix) - $lastPrefixLineStart;

        $this->sourceKeys = array_flip(array_keys($this->sources));

        // group mappings by generated line number.
        $groupedMap = $groupedMapEncoded = [];

        foreach ($this->mappings as $m) {
            $groupedMap[$m['generated_line']][] = $m;
        }

        ksort($groupedMap);

        $lastGeneratedLine = $lastOriginalIndex = $lastOriginalLine = $lastOriginalColumn = 0;

        foreach ($groupedMap as $lineNumber => $lineMap) {
            if ($lineNumber > 1) {
                // The prefix only impacts the column for the first line of the original output
                $prefixColumn = 0;
            }
            $lineNumber += $prefixLines;

            while (++$lastGeneratedLine < $lineNumber) {
                $groupedMapEncoded[] = ';';
            }

            $lineMapEncoded = [];
            $lastGeneratedColumn = 0;

            foreach ($lineMap as $m) {
                $generatedColumn = $m['generated_column'] + $prefixColumn;

                $mapEncoded = $this->encoder->encode($generatedColumn - $lastGeneratedColumn);
                $lastGeneratedColumn = $generatedColumn;

                // find the index
                if ($m['source_file']) {
                    $index = $this->findFileIndex($m['source_file']);

                    if ($index !== false) {
                        $mapEncoded .= $this->encoder->encode($index - $lastOriginalIndex);
                        $lastOriginalIndex = $index;
                        // lines are stored 0-based in SourceMap spec version 3
                        $mapEncoded .= $this->encoder->encode($m['original_line'] - 1 - $lastOriginalLine);
                        $lastOriginalLine = $m['original_line'] - 1;
                        $mapEncoded .= $this->encoder->encode($m['original_column'] - $lastOriginalColumn);
                        $lastOriginalColumn = $m['original_column'];
                    }
                }

                $lineMapEncoded[] = $mapEncoded;
            }

            $groupedMapEncoded[] = implode(',', $lineMapEncoded) . ';';
        }

        return rtrim(implode($groupedMapEncoded), ';');
    }

    /**
     * Finds the index for the filename
     *
     * @param string $filename
     *
     * @return int|false
     */
    private function findFileIndex(string $filename)
    {
        return $this->sourceKeys[$filename] ?? false;
    }

    /**
     * Normalize filename
     *
     * @param string $filename
     *
     * @return string
     */
    private function normalizeFilename(string $filename): string
    {
        $filename = $this->fixWindowsPath($filename);
        $rootpath = $this->options['sourceMapRootpath'];
        $basePath = $this->options['sourceMapBasepath'];

        // "Trim" the 'sourceMapBasepath' from the output filename.
        if (\strlen($basePath) && strpos($filename, $basePath) === 0) {
            $filename = substr($filename, \strlen($basePath));
        }

        // Remove extra leading path separators.
        if (strpos($filename, '\\') === 0 || strpos($filename, '/') === 0) {
            $filename = substr($filename, 1);
        }

        return $rootpath . $filename;
    }

    /**
     * Fix windows paths
     *
     * @param string $path
     * @param bool   $addEndSlash
     *
     * @return string
     */
    public function fixWindowsPath(string $path, bool $addEndSlash = false): string
    {
        $slash = ($addEndSlash) ? '/' : '';

        if (! empty($path)) {
            $path = str_replace('\\', '/', $path);
            $path = rtrim($path, '/') . $slash;
        }

        return $path;
    }
}
