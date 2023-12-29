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

namespace ScssPhp\ScssPhp;

use ScssPhp\ScssPhp\Base\Range;
use ScssPhp\ScssPhp\Block\AtRootBlock;
use ScssPhp\ScssPhp\Block\CallableBlock;
use ScssPhp\ScssPhp\Block\DirectiveBlock;
use ScssPhp\ScssPhp\Block\EachBlock;
use ScssPhp\ScssPhp\Block\ElseBlock;
use ScssPhp\ScssPhp\Block\ElseifBlock;
use ScssPhp\ScssPhp\Block\ForBlock;
use ScssPhp\ScssPhp\Block\IfBlock;
use ScssPhp\ScssPhp\Block\MediaBlock;
use ScssPhp\ScssPhp\Block\NestedPropertyBlock;
use ScssPhp\ScssPhp\Block\WhileBlock;
use ScssPhp\ScssPhp\Compiler\CachedResult;
use ScssPhp\ScssPhp\Compiler\Environment;
use ScssPhp\ScssPhp\Exception\CompilerException;
use ScssPhp\ScssPhp\Exception\ParserException;
use ScssPhp\ScssPhp\Exception\SassException;
use ScssPhp\ScssPhp\Exception\SassScriptException;
use ScssPhp\ScssPhp\Formatter\Compressed;
use ScssPhp\ScssPhp\Formatter\Expanded;
use ScssPhp\ScssPhp\Formatter\OutputBlock;
use ScssPhp\ScssPhp\Logger\LoggerInterface;
use ScssPhp\ScssPhp\Logger\StreamLogger;
use ScssPhp\ScssPhp\Node\Number;
use ScssPhp\ScssPhp\SourceMap\SourceMapGenerator;
use ScssPhp\ScssPhp\Util\Path;

/**
 * The scss compiler and parser.
 *
 * Converting SCSS to CSS is a three stage process. The incoming file is parsed
 * by `Parser` into a syntax tree, then it is compiled into another tree
 * representing the CSS structure by `Compiler`. The CSS tree is fed into a
 * formatter, like `Formatter` which then outputs CSS as a string.
 *
 * During the first compile, all values are *reduced*, which means that their
 * types are brought to the lowest form before being dump as strings. This
 * handles math equations, variable dereferences, and the like.
 *
 * The `compile` function of `Compiler` is the entry point.
 *
 * In summary:
 *
 * The `Compiler` class creates an instance of the parser, feeds it SCSS code,
 * then transforms the resulting tree to a CSS tree. This class also holds the
 * evaluation context, such as all available mixins and variables at any given
 * time.
 *
 * The `Parser` class is only concerned with parsing its input.
 *
 * The `Formatter` takes a CSS tree, and dumps it to a formatted string,
 * handling things like indentation.
 */

/**
 * SCSS compiler
 *
 * @author Leaf Corcoran <leafot@gmail.com>
 */
final class Compiler
{
    const SOURCE_MAP_NONE   = 0;
    const SOURCE_MAP_INLINE = 1;
    const SOURCE_MAP_FILE   = 2;

    /**
     * @var array<string, string>
     */
    private static $operatorNames = [
        '+'   => 'add',
        '-'   => 'sub',
        '*'   => 'mul',
        '/'   => 'div',
        '%'   => 'mod',

        '=='  => 'eq',
        '!='  => 'neq',
        '<'   => 'lt',
        '>'   => 'gt',

        '<='  => 'lte',
        '>='  => 'gte',
    ];

    /**
     * @var array<string, string>
     */
    private static $namespaces = [
        'special'  => '%',
        'mixin'    => '@',
        'function' => '^',
    ];

    public static $true         = [Type::T_KEYWORD, 'true'];
    public static $false        = [Type::T_KEYWORD, 'false'];
    public static $null         = [Type::T_NULL];
    public static $nullString   = [Type::T_STRING, '', []];
    public static $defaultValue = [Type::T_KEYWORD, ''];
    public static $selfSelector = [Type::T_SELF];
    public static $emptyList    = [Type::T_LIST, '', []];
    public static $emptyMap     = [Type::T_MAP, [], []];
    public static $emptyString  = [Type::T_STRING, '"', []];
    public static $with         = [Type::T_KEYWORD, 'with'];
    public static $without      = [Type::T_KEYWORD, 'without'];
    private static $emptyArgumentList = [Type::T_LIST, '', [], []];

    /**
     * @var array<int, string|callable>
     */
    private $importPaths = [];
    /**
     * @var array<string, Block>
     */
    private $importCache = [];

    /**
     * @var array
     * @phpstan-var array<string, array{0: callable, 1: string[]|null}>
     */
    private $userFunctions = [];
    /**
     * @var array<string, mixed>
     */
    private $registeredVars = [];
    /**
     * @var array<string, bool>
     */
    private $registeredFeatures = [
        'extend-selector-pseudoclass' => false,
        'at-error'                    => true,
        'units-level-3'               => true,
        'global-variable-shadowing'   => false,
    ];

    /**
     * @var int
     * @phpstan-var self::SOURCE_MAP_*
     */
    private $sourceMap = self::SOURCE_MAP_NONE;

    /**
     * @var array
     * @phpstan-var array{sourceRoot?: string, sourceMapFilename?: string|null, sourceMapURL?: string|null, sourceMapWriteTo?: string|null, outputSourceFiles?: bool, sourceMapRootpath?: string, sourceMapBasepath?: string}
     */
    private $sourceMapOptions = [];

    /**
     * @var bool
     */
    private $charset = true;

    /**
     * @var string
     * @phpstan-var OutputStyle::*
     */
    private $outputStyle = OutputStyle::EXPANDED;

    /**
     * @var Formatter
     */
    private $formatter;

    /**
     * @var Environment
     */
    private $rootEnv;
    /**
     * @var OutputBlock|null
     */
    private $rootBlock;

    /**
     * @var Environment
     */
    private $env;
    /**
     * @var OutputBlock|null
     */
    private $scope;
    /**
     * @var Environment|null
     */
    private $storeEnv;
    /**
     * @var array<int, string|null>
     */
    private $sourceNames;

    /**
     * @var Cache|null
     */
    private $cache;

    /**
     * @var bool
     */
    private $cacheCheckImportResolutions = false;

    /**
     * @var int
     */
    private $indentLevel;
    /**
     * @var array[]
     */
    private $extends;
    /**
     * @var array<string, int[]>
     */
    private $extendsMap;

    /**
     * @var array<string, int>
     */
    private $parsedFiles = [];

    /**
     * @var Parser|null
     */
    private $parser;
    /**
     * @var int|null
     */
    private $sourceIndex;
    /**
     * @var int|null
     */
    private $sourceLine;
    /**
     * @var int|null
     */
    private $sourceColumn;
    /**
     * @var bool|null
     */
    private $shouldEvaluate;

    /**
     * @var array[]
     */
    private $callStack = [];

    /**
     * @var array
     * @phpstan-var list<array{currentDir: string|null, path: string, filePath: string}>
     */
    private $resolvedImports = [];

    /**
     * The directory of the currently processed file
     *
     * @var string|null
     */
    private $currentDirectory;

    /**
     * The directory of the input file
     *
     * @var string
     */
    private $rootDirectory;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Constructor
     *
     * @param array|null $cacheOptions
     * @phpstan-param array{cacheDir?: string, prefix?: string, forceRefresh?: string, checkImportResolutions?: bool}|null $cacheOptions
     */
    public function __construct(?array $cacheOptions = null)
    {
        $this->sourceNames = [];

        if ($cacheOptions) {
            $this->cache = new Cache($cacheOptions);
            if (!empty($cacheOptions['checkImportResolutions'])) {
                $this->cacheCheckImportResolutions = true;
            }
        }

        $this->logger = new StreamLogger(fopen('php://stderr', 'w'), true);
    }

    /**
     * Get compiler options
     *
     * @return array<string, mixed>
     */
    private function getCompileOptions(): array
    {
        $options = [
            'importPaths'        => $this->importPaths,
            'registeredVars'     => $this->registeredVars,
            'sourceMap'          => serialize($this->sourceMap),
            'sourceMapOptions'   => $this->sourceMapOptions,
            'outputStyle'        => $this->outputStyle,
        ];

        return $options;
    }

    /**
     * Sets an alternative logger.
     *
     * Changing the logger in the middle of the compilation is not
     * supported and will result in an undefined behavior.
     *
     * @param LoggerInterface $logger
     *
     * @return void
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    /**
     * Compile scss
     *
     * @param string      $source
     * @param string|null $path
     *
     * @return CompilationResult
     *
     * @throws SassException when the source fails to compile
     */
    public function compileString(string $source, ?string $path = null): CompilationResult
    {
        if ($this->cache) {
            $cacheKey       = ($path ? $path : '(stdin)') . ':' . md5($source);
            $compileOptions = $this->getCompileOptions();
            $cachedResult = $this->cache->getCache('compile', $cacheKey, $compileOptions);

            if ($cachedResult instanceof CachedResult && $this->isFreshCachedResult($cachedResult)) {
                return $cachedResult->getResult();
            }
        }

        $this->indentLevel    = -1;
        $this->extends        = [];
        $this->extendsMap     = [];
        $this->sourceIndex    = null;
        $this->sourceLine     = null;
        $this->sourceColumn   = null;
        $this->env            = null;
        $this->scope          = null;
        $this->storeEnv       = null;
        $this->shouldEvaluate = null;
        $this->parsedFiles = [];
        $this->resolvedImports = [];

        if (!\is_null($path) && is_file($path)) {
            $path = realpath($path) ?: $path;
            $this->currentDirectory = dirname($path);
            $this->rootDirectory = $this->currentDirectory;
        } else {
            $this->currentDirectory = null;
            $this->rootDirectory = getcwd();
        }

        try {
            $this->parser = $this->parserFactory($path);
            $tree         = $this->parser->parse($source);
            $this->parser = null;

            $this->formatter = $this->outputStyle === OutputStyle::COMPRESSED ? new Compressed() : new Expanded();
            $this->rootBlock = null;
            $this->rootEnv   = $this->pushEnv($tree);

            $warnCallback = function ($message, $deprecation) {
                $this->logger->warn($message, $deprecation);
            };
            $previousWarnCallback = Warn::setCallback($warnCallback);

            try {
                $this->injectVariables($this->registeredVars);
                $this->compileRoot($tree);
                $this->popEnv();
            } finally {
                Warn::setCallback($previousWarnCallback);
            }

            $sourceMapGenerator = null;

            if ($this->sourceMap !== self::SOURCE_MAP_NONE) {
                $sourceMapGenerator = new SourceMapGenerator($this->sourceMapOptions);
            }

            assert($this->scope !== null);

            $out = $this->formatter->format($this->scope, $sourceMapGenerator);

            $prefix = '';

            if ($this->charset && strlen($out) !== Util::mbStrlen($out)) {
                if ($this->outputStyle === OutputStyle::COMPRESSED) {
                    $prefix = "\u{FEFF}";
                } else {
                    $prefix = '@charset "UTF-8";' . "\n";
                }
                $out = $prefix . $out;
            }

            $sourceMap = null;

            if (! empty($out) && $this->sourceMap !== self::SOURCE_MAP_NONE) {
                assert($sourceMapGenerator !== null);
                $sourceMap = $sourceMapGenerator->generateJson($prefix);
                $sourceMapUrl = null;

                switch ($this->sourceMap) {
                    case self::SOURCE_MAP_INLINE:
                        $sourceMapUrl = sprintf('data:application/json,%s', Util::encodeURIComponent($sourceMap));
                        break;

                    case self::SOURCE_MAP_FILE:
                        if (isset($this->sourceMapOptions['sourceMapURL'])) {
                            $sourceMapUrl = $this->sourceMapOptions['sourceMapURL'];
                        }
                        break;
                }

                if ($sourceMapUrl !== null) {
                    $out .= sprintf('/*# sourceMappingURL=%s */', $sourceMapUrl);
                }
            }
        } catch (SassScriptException $e) {
            throw new CompilerException($this->addLocationToMessage($e->getMessage()), 0, $e);
        }

        $includedFiles = [];

        foreach ($this->resolvedImports as $resolvedImport) {
            $includedFiles[$resolvedImport['filePath']] = $resolvedImport['filePath'];
        }

        $result = new CompilationResult($out, $sourceMap, array_values($includedFiles));

        if ($this->cache && isset($cacheKey) && isset($compileOptions)) {
            $this->cache->setCache('compile', $cacheKey, new CachedResult($result, $this->parsedFiles, $this->resolvedImports), $compileOptions);
        }

        // Reset state to free memory
        $this->parsedFiles = [];
        $this->resolvedImports = [];

        return $result;
    }

    /**
     * @param CachedResult $result
     *
     * @return bool
     */
    private function isFreshCachedResult(CachedResult $result): bool
    {
        // check if any dependency file changed since the result was compiled
        foreach ($result->getParsedFiles() as $file => $mtime) {
            if (! is_file($file) || filemtime($file) !== $mtime) {
                return false;
            }
        }

        if ($this->cacheCheckImportResolutions) {
            $resolvedImports = [];

            foreach ($result->getResolvedImports() as $import) {
                $currentDir = $import['currentDir'];
                $path = $import['path'];
                // store the check across all the results in memory to avoid multiple findImport() on the same path
                // with same context.
                // this is happening in a same hit with multiple compilations (especially with big frameworks)
                if (empty($resolvedImports[$currentDir][$path])) {
                    $resolvedImports[$currentDir][$path] = $this->findImport($path, $currentDir);
                }

                if ($resolvedImports[$currentDir][$path] !== $import['filePath']) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Instantiate parser
     *
     * @param string|null $path
     *
     * @return Parser
     */
    private function parserFactory(?string $path): Parser
    {
        // https://sass-lang.com/documentation/at-rules/import
        // CSS files imported by Sass don’t allow any special Sass features.
        // In order to make sure authors don’t accidentally write Sass in their CSS,
        // all Sass features that aren’t also valid CSS will produce errors.
        // Otherwise, the CSS will be rendered as-is. It can even be extended!
        $cssOnly = false;

        if ($path !== null && substr($path, -4) === '.css') {
            $cssOnly = true;
        }

        $parser = new Parser($path, \count($this->sourceNames), $this->cache, $cssOnly, $this->logger);

        $this->sourceNames[] = $path;
        $this->addParsedFile($path);

        return $parser;
    }

    /**
     * Is self extend?
     *
     * @param array $target
     * @param array $origin
     *
     * @return bool
     */
    private function isSelfExtend(array $target, array $origin): bool
    {
        foreach ($origin as $sel) {
            if (\in_array($target, $sel)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Push extends
     *
     * @param string[]   $target
     * @param array      $origin
     * @param array|null $block
     *
     * @return void
     */
    private function pushExtends(array $target, array $origin, ?array $block): void
    {
        $i = \count($this->extends);
        $this->extends[] = [$target, $origin, $block];

        foreach ($target as $part) {
            if (isset($this->extendsMap[$part])) {
                $this->extendsMap[$part][] = $i;
            } else {
                $this->extendsMap[$part] = [$i];
            }
        }
    }

    /**
     * Make output block
     *
     * @param string|null   $type
     * @param string[]|null $selectors
     *
     * @return OutputBlock
     */
    private function makeOutputBlock(?string $type, ?array $selectors = null): OutputBlock
    {
        $out = new OutputBlock();
        $out->type      = $type;
        $out->lines     = [];
        $out->children  = [];
        $out->parent    = $this->scope;
        $out->selectors = $selectors;
        $out->depth     = $this->env->depth;

        if ($this->env->block instanceof Block) {
            $out->sourceName   = $this->env->block->sourceName;
            $out->sourceLine   = $this->env->block->sourceLine;
            $out->sourceColumn = $this->env->block->sourceColumn;
        } else {
            $out->sourceName = isset($this->sourceNames[$this->sourceIndex]) ? $this->sourceNames[$this->sourceIndex] : '(stdin)';
            $out->sourceLine = $this->sourceLine;
            $out->sourceColumn = $this->sourceColumn;
        }

        return $out;
    }

    /**
     * Compile root
     *
     * @param Block $rootBlock
     *
     * @return void
     */
    private function compileRoot(Block $rootBlock): void
    {
        $this->rootBlock = $this->scope = $this->makeOutputBlock(Type::T_ROOT);

        $this->compileChildrenNoReturn($rootBlock->children, $this->scope);
        assert($this->scope !== null);
        $this->flattenSelectors($this->scope);
        $this->missingSelectors();
    }

    /**
     * Report missing selectors
     *
     * @return void
     */
    private function missingSelectors(): void
    {
        foreach ($this->extends as $extend) {
            if (isset($extend[3])) {
                continue;
            }

            list($target, $origin, $block) = $extend;

            // ignore if !optional
            if ($block[2]) {
                continue;
            }

            $target = implode(' ', $target);
            $origin = $this->collapseSelectors($origin);

            $this->sourceLine = $block[Parser::SOURCE_LINE];
            throw $this->error("\"$origin\" failed to @extend \"$target\". The selector \"$target\" was not found.");
        }
    }

    /**
     * Flatten selectors
     *
     * @param OutputBlock     $block
     * @param string|int|null $parentKey
     *
     * @return void
     */
    private function flattenSelectors(OutputBlock $block, $parentKey = null): void
    {
        if ($block->selectors) {
            $selectors = [];

            foreach ($block->selectors as $s) {
                $selectors[] = $s;

                if (! \is_array($s)) {
                    continue;
                }

                // check extends
                if (! empty($this->extendsMap)) {
                    $this->matchExtends($s, $selectors);

                    // remove duplicates
                    array_walk($selectors, function (&$value) {
                        $value = serialize($value);
                    });

                    $selectors = array_unique($selectors);

                    array_walk($selectors, function (&$value) {
                        $value = unserialize($value);
                    });
                }
            }

            $block->selectors = [];
            $placeholderSelector = false;

            foreach ($selectors as $selector) {
                if ($this->hasSelectorPlaceholder($selector)) {
                    $placeholderSelector = true;
                    continue;
                }

                $block->selectors[] = $this->compileSelector($selector);
            }

            if ($placeholderSelector && 0 === \count($block->selectors) && null !== $parentKey) {
                assert($block->parent !== null);
                unset($block->parent->children[$parentKey]);

                return;
            }
        }

        foreach ($block->children as $key => $child) {
            $this->flattenSelectors($child, $key);
        }
    }

    /**
     * Glue parts of :not( or :nth-child( ... that are in general split in selectors parts
     *
     * @param array $parts
     *
     * @return array
     */
    private function glueFunctionSelectors(array $parts): array
    {
        $new = [];

        foreach ($parts as $part) {
            if (\is_array($part)) {
                $part = $this->glueFunctionSelectors($part);
                $new[] = $part;
            } else {
                // a selector part finishing with a ) is the last part of a :not( or :nth-child(
                // and need to be joined to this
                if (
                    \count($new) && \is_string($new[\count($new) - 1]) &&
                    \strlen($part) && substr($part, -1) === ')' && strpos($part, '(') === false
                ) {
                    while (\count($new) > 1 && substr($new[\count($new) - 1], -1) !== '(') {
                        $part = array_pop($new) . $part;
                    }
                    $new[\count($new) - 1] .= $part;
                } else {
                    $new[] = $part;
                }
            }
        }

        return $new;
    }

    /**
     * Match extends
     *
     * @param array $selector
     * @param array $out
     * @param int   $from
     * @param bool  $initial
     *
     * @return void
     */
    private function matchExtends(array $selector, &$out, int $from = 0, bool $initial = true): void
    {
        static $partsPile = [];
        $selector = $this->glueFunctionSelectors($selector);

        if (\count($selector) == 1 && \in_array(reset($selector), $partsPile)) {
            return;
        }

        $outRecurs = [];

        foreach ($selector as $i => $part) {
            if ($i < $from) {
                continue;
            }

            // check that we are not building an infinite loop of extensions
            // if the new part is just including a previous part don't try to extend anymore
            if (\count($part) > 1) {
                foreach ($partsPile as $previousPart) {
                    if (! \count(array_diff($previousPart, $part))) {
                        continue 2;
                    }
                }
            }

            $partsPile[] = $part;

            if ($this->matchExtendsSingle($part, $origin, $initial)) {
                $after       = \array_slice($selector, $i + 1);
                $before      = \array_slice($selector, 0, $i);
                list($before, $nonBreakableBefore) = $this->extractRelationshipFromFragment($before);

                foreach ($origin as $new) {
                    $k = 0;

                    // remove shared parts
                    if (\count($new) > 1) {
                        while ($k < $i && isset($new[$k]) && $selector[$k] === $new[$k]) {
                            $k++;
                        }
                    }

                    if (\count($nonBreakableBefore) && $k === \count($new)) {
                        $k--;
                    }

                    $replacement = [];
                    $tempReplacement = $k > 0 ? \array_slice($new, $k) : $new;

                    for ($l = \count($tempReplacement) - 1; $l >= 0; $l--) {
                        $slice = [];

                        foreach ($tempReplacement[$l] as $chunk) {
                            if (! \in_array($chunk, $slice)) {
                                $slice[] = $chunk;
                            }
                        }

                        array_unshift($replacement, $slice);

                        if (! $this->isImmediateRelationshipCombinator(end($slice))) {
                            break;
                        }
                    }

                    $afterBefore = $l != 0 ? \array_slice($tempReplacement, 0, $l) : [];

                    // Merge shared direct relationships.
                    $mergedBefore = $this->mergeDirectRelationships($afterBefore, $nonBreakableBefore);

                    $result = array_merge(
                        $before,
                        $mergedBefore,
                        $replacement,
                        $after
                    );

                    if ($result === $selector) {
                        continue;
                    }

                    $this->pushOrMergeExtentedSelector($out, $result);

                    // recursively check for more matches
                    $startRecurseFrom = \count($before) + min(\count($nonBreakableBefore), \count($mergedBefore));

                    if (\count($origin) > 1) {
                        $this->matchExtends($result, $out, $startRecurseFrom, false);
                    } else {
                        $this->matchExtends($result, $outRecurs, $startRecurseFrom, false);
                    }

                    // selector sequence merging
                    if (! empty($before) && \count($new) > 1) {
                        $preSharedParts = $k > 0 ? \array_slice($before, 0, $k) : [];
                        $postSharedParts = $k > 0 ? \array_slice($before, $k) : $before;

                        list($betweenSharedParts, $nonBreakabl2) = $this->extractRelationshipFromFragment($afterBefore);

                        $result2 = array_merge(
                            $preSharedParts,
                            $betweenSharedParts,
                            $postSharedParts,
                            $nonBreakabl2,
                            $nonBreakableBefore,
                            $replacement,
                            $after
                        );

                        $this->pushOrMergeExtentedSelector($out, $result2);
                    }
                }
            }
            array_pop($partsPile);
        }

        while (\count($outRecurs)) {
            $result = array_shift($outRecurs);
            $this->pushOrMergeExtentedSelector($out, $result);
        }
    }

    /**
     * Test a part for being a pseudo selector
     *
     * @param string $part
     * @param array  $matches
     *
     * @return bool
     */
    private function isPseudoSelector(string $part, &$matches): bool
    {
        if (
            strpos($part, ':') === 0 &&
            preg_match(",^::?([\w-]+)\((.+)\)$,", $part, $matches)
        ) {
            return true;
        }

        return false;
    }

    /**
     * Push extended selector except if
     *  - this is a pseudo selector
     *  - same as previous
     *  - in a white list
     * in this case we merge the pseudo selector content
     *
     * @param array $out
     * @param array $extended
     *
     * @return void
     */
    private function pushOrMergeExtentedSelector(&$out, array $extended): void
    {
        if (\count($out) && \count($extended) === 1 && \count(reset($extended)) === 1) {
            $single = reset($extended);
            $part = reset($single);

            if (
                $this->isPseudoSelector($part, $matchesExtended) &&
                \in_array($matchesExtended[1], [ 'slotted' ])
            ) {
                $prev = end($out);
                $prev = $this->glueFunctionSelectors($prev);

                if (\count($prev) === 1 && \count(reset($prev)) === 1) {
                    $single = reset($prev);
                    $part = reset($single);

                    if (
                        $this->isPseudoSelector($part, $matchesPrev) &&
                        $matchesPrev[1] === $matchesExtended[1]
                    ) {
                        $extended = explode($matchesExtended[1] . '(', $matchesExtended[0], 2);
                        $extended[1] = $matchesPrev[2] . ', ' . $extended[1];
                        $extended = implode($matchesExtended[1] . '(', $extended);
                        $extended = [ [ $extended ]];
                        array_pop($out);
                    }
                }
            }
        }
        $out[] = $extended;
    }

    /**
     * Match extends single
     *
     * @param array $rawSingle
     * @param array $outOrigin
     * @param bool  $initial
     *
     * @return bool
     */
    private function matchExtendsSingle(array $rawSingle, &$outOrigin, bool $initial = true): bool
    {
        $counts = [];
        $single = [];

        // simple usual cases, no need to do the whole trick
        if (\in_array($rawSingle, [['>'],['+'],['~']])) {
            return false;
        }

        foreach ($rawSingle as $part) {
            // matches Number
            if (! \is_string($part)) {
                return false;
            }

            if (! preg_match('/^[\[.:#%]/', $part) && \count($single)) {
                $single[\count($single) - 1] .= $part;
            } else {
                $single[] = $part;
            }
        }

        $extendingDecoratedTag = false;

        if (\count($single) > 1) {
            $matches = null;
            $extendingDecoratedTag = preg_match('/^[a-z0-9]+$/i', $single[0], $matches) ? $matches[0] : false;
        }

        $outOrigin = [];
        $found = false;

        foreach ($single as $k => $part) {
            if (isset($this->extendsMap[$part])) {
                foreach ($this->extendsMap[$part] as $idx) {
                    $counts[$idx] = isset($counts[$idx]) ? $counts[$idx] + 1 : 1;
                }
            }

            if (
                $initial &&
                $this->isPseudoSelector($part, $matches) &&
                ! \in_array($matches[1], [ 'not' ])
            ) {
                $buffer    = $matches[2];
                $parser    = $this->parserFactory(__METHOD__);

                if ($parser->parseSelector($buffer, $subSelectors, false)) {
                    foreach ($subSelectors as $ksub => $subSelector) {
                        $subExtended = [];
                        $this->matchExtends($subSelector, $subExtended, 0, false);

                        if ($subExtended) {
                            $subSelectorsExtended = $subSelectors;
                            $subSelectorsExtended[$ksub] = $subExtended;

                            foreach ($subSelectorsExtended as $ksse => $sse) {
                                $subSelectorsExtended[$ksse] = $this->collapseSelectors($sse);
                            }

                            $subSelectorsExtended = implode(', ', $subSelectorsExtended);
                            $singleExtended = $single;
                            $singleExtended[$k] = str_replace('(' . $buffer . ')', "($subSelectorsExtended)", $part);
                            $outOrigin[] = [ $singleExtended ];
                            $found = true;
                        }
                    }
                }
            }
        }

        foreach ($counts as $idx => $count) {
            list($target, $origin, /* $block */) = $this->extends[$idx];

            $origin = $this->glueFunctionSelectors($origin);

            // check count
            if ($count !== \count($target)) {
                continue;
            }

            $this->extends[$idx][3] = true;

            $rem = array_diff($single, $target);

            foreach ($origin as $j => $new) {
                // prevent infinite loop when target extends itself
                if ($this->isSelfExtend($single, $origin) && ! $initial) {
                    return false;
                }

                $replacement = end($new);

                // Extending a decorated tag with another tag is not possible.
                if (
                    $extendingDecoratedTag && $replacement[0] != $extendingDecoratedTag &&
                    preg_match('/^[a-z0-9]+$/i', $replacement[0])
                ) {
                    unset($origin[$j]);
                    continue;
                }

                $combined = $this->combineSelectorSingle($replacement, $rem);

                if (\count(array_diff($combined, $origin[$j][\count($origin[$j]) - 1]))) {
                    $origin[$j][\count($origin[$j]) - 1] = $combined;
                }
            }

            $outOrigin = array_merge($outOrigin, $origin);

            $found = true;
        }

        return $found;
    }

    /**
     * Extract a relationship from the fragment.
     *
     * When extracting the last portion of a selector we will be left with a
     * fragment which may end with a direction relationship combinator. This
     * method will extract the relationship fragment and return it along side
     * the rest.
     *
     * @param array $fragment The selector fragment maybe ending with a direction relationship combinator.
     *
     * @return array The selector without the relationship fragment if any, the relationship fragment.
     */
    private function extractRelationshipFromFragment(array $fragment): array
    {
        $parents = [];
        $children = [];

        $j = $i = \count($fragment);

        for (;;) {
            $children = $j != $i ? \array_slice($fragment, $j, $i - $j) : [];
            $parents  = \array_slice($fragment, 0, $j);
            $slice    = end($parents);

            if (empty($slice) || ! $this->isImmediateRelationshipCombinator($slice[0])) {
                break;
            }

            $j -= 2;
        }

        return [$parents, $children];
    }

    /**
     * Combine selector single
     *
     * @param array $base
     * @param array $other
     *
     * @return array
     */
    private function combineSelectorSingle(array $base, array $other): array
    {
        $tag    = [];
        $out    = [];
        $wasTag = false;
        $pseudo = [];

        while (\count($other) && strpos(end($other), ':') === 0) {
            array_unshift($pseudo, array_pop($other));
        }

        foreach ([array_reverse($base), array_reverse($other)] as $single) {
            $rang = count($single);

            foreach ($single as $part) {
                if (preg_match('/^[\[:]/', $part)) {
                    $out[] = $part;
                    $wasTag = false;
                } elseif (preg_match('/^[\.#]/', $part)) {
                    array_unshift($out, $part);
                    $wasTag = false;
                } elseif (preg_match('/^[^_-]/', $part) && $rang === 1) {
                    $tag[] = $part;
                    $wasTag = true;
                } elseif ($wasTag) {
                    $tag[\count($tag) - 1] .= $part;
                } else {
                    array_unshift($out, $part);
                }
                $rang--;
            }
        }

        if (\count($tag)) {
            array_unshift($out, $tag[0]);
        }

        while (\count($pseudo)) {
            $out[] = array_shift($pseudo);
        }

        return $out;
    }

    /**
     * Compile media
     *
     * @param Block $media
     *
     * @return void
     */
    private function compileMedia(Block $media): void
    {
        assert($media instanceof MediaBlock);
        $this->pushEnv($media);

        $mediaQueries = $this->compileMediaQuery($this->multiplyMedia($this->env));

        if (! empty($mediaQueries)) {
            assert($this->scope !== null);
            $previousScope = $this->scope;
            $parentScope = $this->mediaParent($this->scope);

            foreach ($mediaQueries as $mediaQuery) {
                $this->scope = $this->makeOutputBlock(Type::T_MEDIA, [$mediaQuery]);

                $parentScope->children[] = $this->scope;
                $parentScope = $this->scope;
            }

            // top level properties in a media cause it to be wrapped
            $needsWrap = false;

            foreach ($media->children as $child) {
                $type = $child[0];

                if (
                    $type !== Type::T_BLOCK &&
                    $type !== Type::T_MEDIA &&
                    $type !== Type::T_DIRECTIVE &&
                    $type !== Type::T_IMPORT
                ) {
                    $needsWrap = true;
                    break;
                }
            }

            if ($needsWrap) {
                $wrapped = new Block();
                $wrapped->sourceName   = $media->sourceName;
                $wrapped->sourceIndex  = $media->sourceIndex;
                $wrapped->sourceLine   = $media->sourceLine;
                $wrapped->sourceColumn = $media->sourceColumn;
                $wrapped->selectors    = [];
                $wrapped->comments     = [];
                $wrapped->parent       = $media;
                $wrapped->children     = $media->children;

                $media->children = [[Type::T_BLOCK, $wrapped]];
            }

            $this->compileChildrenNoReturn($media->children, $this->scope);

            $this->scope = $previousScope;
        }

        $this->popEnv();
    }

    /**
     * Media parent
     *
     * @param OutputBlock $scope
     *
     * @return OutputBlock
     */
    private function mediaParent(OutputBlock $scope): OutputBlock
    {
        while (! empty($scope->parent)) {
            if (! empty($scope->type) && $scope->type !== Type::T_MEDIA) {
                break;
            }

            $scope = $scope->parent;
        }

        return $scope;
    }

    /**
     * Compile directive
     *
     * @param DirectiveBlock|array $directive
     * @param OutputBlock          $out
     *
     * @return void
     */
    private function compileDirective($directive, OutputBlock $out): void
    {
        if (\is_array($directive)) {
            $directiveName = $this->compileDirectiveName($directive[0]);
            $s = '@' . $directiveName;

            if (! empty($directive[1])) {
                $s .= ' ' . $this->compileValue($directive[1]);
            }
            // sass-spec compliance on newline after directives, a bit tricky :/
            $appendNewLine = (! empty($directive[2]) || strpos($s, "\n")) ? "\n" : "";
            if (\is_array($directive[0]) && empty($directive[1])) {
                $appendNewLine = "\n";
            }

            if (empty($directive[3])) {
                $this->appendRootDirective($s . ';' . $appendNewLine, $out, [Type::T_COMMENT, Type::T_DIRECTIVE]);
            } else {
                $this->appendOutputLine($out, Type::T_DIRECTIVE, $s . ';');
            }
        } else {
            $directive->name = $this->compileDirectiveName($directive->name);
            $s = '@' . $directive->name;

            if (! empty($directive->value)) {
                $s .= ' ' . $this->compileValue($directive->value);
            }

            if ($directive->name === 'keyframes' || substr($directive->name, -10) === '-keyframes') {
                $this->compileKeyframeBlock($directive, [$s]);
            } else {
                $this->compileNestedBlock($directive, [$s]);
            }
        }
    }

    /**
     * directive names can include some interpolation
     *
     * @param string|array $directiveName
     * @return string
     * @throws CompilerException
     */
    private function compileDirectiveName($directiveName): string
    {
        if (is_string($directiveName)) {
            return $directiveName;
        }

        return $this->compileValue($directiveName);
    }

    /**
     * Compile at-root
     *
     * @param Block $block
     *
     * @return void
     */
    private function compileAtRoot(Block $block): void
    {
        assert($block instanceof AtRootBlock);
        $env     = $this->pushEnv($block);
        $envs    = $this->compactEnv($env);
        list($with, $without) = $this->compileWith(isset($block->with) ? $block->with : null);

        // wrap inline selector
        if ($block->selector) {
            $wrapped = new Block();
            $wrapped->sourceName   = $block->sourceName;
            $wrapped->sourceIndex  = $block->sourceIndex;
            $wrapped->sourceLine   = $block->sourceLine;
            $wrapped->sourceColumn = $block->sourceColumn;
            $wrapped->selectors    = $block->selector;
            $wrapped->comments     = [];
            $wrapped->parent       = $block;
            $wrapped->children     = $block->children;
            $wrapped->selfParent   = $block->selfParent;

            $block->children = [[Type::T_BLOCK, $wrapped]];
            $block->selector = null;
        }

        $selfParent = $block->selfParent;
        assert($selfParent !== null, 'at-root blocks must have a selfParent set.');

        if (
            ! $selfParent->selectors &&
            isset($block->parent) &&
            isset($block->parent->selectors) && $block->parent->selectors
        ) {
            $selfParent = $block->parent;
        }

        $this->env = $this->filterWithWithout($envs, $with, $without);

        assert($this->scope !== null);
        $saveScope   = $this->scope;
        $this->scope = $this->filterScopeWithWithout($saveScope, $with, $without);

        // propagate selfParent to the children where they still can be useful
        $this->compileChildrenNoReturn($block->children, $this->scope, $selfParent);

        assert($this->scope !== null);
        $this->completeScope($this->scope, $saveScope);
        $this->scope = $saveScope;
        $this->env   = $this->extractEnv($envs);

        $this->popEnv();
    }

    /**
     * Filter at-root scope depending on with/without option
     *
     * @param OutputBlock $scope
     * @param array       $with
     * @param array       $without
     *
     * @return OutputBlock
     */
    private function filterScopeWithWithout(OutputBlock $scope, array $with, array $without): OutputBlock
    {
        $filteredScopes = [];
        $childStash = [];

        if ($scope->type === Type::T_ROOT) {
            return $scope;
        }
        assert($this->rootBlock !== null);

        // start from the root
        while ($scope->parent && $scope->parent->type !== Type::T_ROOT) {
            array_unshift($childStash, $scope);
            $scope = $scope->parent;
        }

        for (;;) {
            if (! $scope) {
                break;
            }

            if ($this->isWith($scope, $with, $without)) {
                $s = clone $scope;
                $s->children = [];
                $s->lines    = [];
                $s->parent   = null;

                if ($s->type !== Type::T_MEDIA && $s->type !== Type::T_DIRECTIVE) {
                    $s->selectors = [];
                }

                $filteredScopes[] = $s;
            }

            if (\count($childStash)) {
                $scope = array_shift($childStash);
            } elseif ($scope->children) {
                $scope = end($scope->children);
            } else {
                $scope = null;
            }
        }

        if (! \count($filteredScopes)) {
            return $this->rootBlock;
        }

        $newScope = array_shift($filteredScopes);
        $newScope->parent = $this->rootBlock;

        $this->rootBlock->children[] = $newScope;

        $p = &$newScope;

        while (\count($filteredScopes)) {
            $s = array_shift($filteredScopes);
            $s->parent = $p;
            $p->children[] = $s;
            $newScope = &$p->children[0];
            $p = &$p->children[0];
        }

        return $newScope;
    }

    /**
     * found missing selector from a at-root compilation in the previous scope
     * (if at-root is just enclosing a property, the selector is in the parent tree)
     *
     * @param OutputBlock $scope
     * @param OutputBlock $previousScope
     *
     * @return OutputBlock
     */
    private function completeScope(OutputBlock $scope, OutputBlock $previousScope): OutputBlock
    {
        if (! $scope->type && ! $scope->selectors && \count($scope->lines)) {
            $scope->selectors = $this->findScopeSelectors($previousScope, $scope->depth);
        }

        if ($scope->children) {
            foreach ($scope->children as $k => $c) {
                $scope->children[$k] = $this->completeScope($c, $previousScope);
            }
        }

        return $scope;
    }

    /**
     * Find a selector by the depth node in the scope
     *
     * @param OutputBlock $scope
     * @param int     $depth
     *
     * @return array
     */
    private function findScopeSelectors(OutputBlock $scope, int $depth): array
    {
        if ($scope->depth === $depth && $scope->selectors) {
            return $scope->selectors;
        }

        if ($scope->children) {
            foreach (array_reverse($scope->children) as $c) {
                if ($s = $this->findScopeSelectors($c, $depth)) {
                    return $s;
                }
            }
        }

        return [];
    }

    /**
     * Compile @at-root's with: inclusion / without: exclusion into 2 lists uses to filter scope/env later
     *
     * @param array|null $withCondition
     *
     * @return array
     *
     * @phpstan-return array{array<string, bool>, array<string, bool>}
     */
    private function compileWith(?array $withCondition): array
    {
        // just compile what we have in 2 lists
        $with = [];
        $without = ['rule' => true];

        if ($withCondition) {
            if ($withCondition[0] === Type::T_INTERPOLATE) {
                $w = $this->compileValue($withCondition);

                $buffer = "($w)";
                $parser = $this->parserFactory(__METHOD__);

                if ($parser->parseValue($buffer, $reParsedWith)) {
                    $withCondition = $reParsedWith;
                }
            }

            $withConfig = $this->mapGet($withCondition, self::$with);
            if ($withConfig !== null) {
                $without = []; // cancel the default
                $list = $this->coerceList($withConfig);

                foreach ($list[2] as $item) {
                    $keyword = $this->compileStringContent($this->coerceString($item));

                    $with[$keyword] = true;
                }
            }

            $withoutConfig = $this->mapGet($withCondition, self::$without);
            if ($withoutConfig !== null) {
                $without = []; // cancel the default
                $list = $this->coerceList($withoutConfig);

                foreach ($list[2] as $item) {
                    $keyword = $this->compileStringContent($this->coerceString($item));

                    $without[$keyword] = true;
                }
            }
        }

        return [$with, $without];
    }

    /**
     * Filter env stack
     *
     * @param Environment[] $envs
     * @param array $with
     * @param array $without
     *
     * @return Environment
     *
     * @phpstan-param  non-empty-array<Environment> $envs
     */
    private function filterWithWithout(array $envs, array $with, array $without): Environment
    {
        $filtered = [];

        foreach ($envs as $e) {
            if ($e->block && ! $this->isWith($e->block, $with, $without)) {
                $ec = clone $e;
                $ec->block     = null;
                $ec->selectors = [];

                $filtered[] = $ec;
            } else {
                $filtered[] = $e;
            }
        }

        return $this->extractEnv($filtered);
    }

    /**
     * Filter WITH rules
     *
     * @param Block|OutputBlock $block
     * @param array             $with
     * @param array             $without
     *
     * @return bool
     */
    private function isWith($block, array $with, array $without): bool
    {
        if (isset($block->type)) {
            if ($block->type === Type::T_MEDIA) {
                return $this->testWithWithout('media', $with, $without);
            }

            if ($block->type === Type::T_DIRECTIVE) {
                assert($block instanceof DirectiveBlock || $block instanceof OutputBlock);
                if (isset($block->name)) {
                    return $this->testWithWithout($this->compileDirectiveName($block->name), $with, $without);
                } elseif (isset($block->selectors) && preg_match(',@(\w+),ims', json_encode($block->selectors), $m)) {
                    return $this->testWithWithout($m[1], $with, $without);
                } else {
                    return $this->testWithWithout('???', $with, $without);
                }
            }
        } elseif (isset($block->selectors)) {
            // a selector starting with number is a keyframe rule
            if (\count($block->selectors)) {
                $s = reset($block->selectors);

                while (\is_array($s)) {
                    $s = reset($s);
                }

                if (\is_object($s) && $s instanceof Number) {
                    return $this->testWithWithout('keyframes', $with, $without);
                }
            }

            return $this->testWithWithout('rule', $with, $without);
        }

        return true;
    }

    /**
     * Test a single type of block against with/without lists
     *
     * @param string $what
     * @param array  $with
     * @param array  $without
     *
     * @return bool
     *   true if the block should be kept, false to reject
     */
    private function testWithWithout(string $what, array $with, array $without): bool
    {
        // if without, reject only if in the list (or 'all' is in the list)
        if (\count($without)) {
            return (isset($without[$what]) || isset($without['all'])) ? false : true;
        }

        // otherwise reject all what is not in the with list
        return (isset($with[$what]) || isset($with['all'])) ? true : false;
    }


    /**
     * Compile keyframe block
     *
     * @param Block    $block
     * @param string[] $selectors
     *
     * @return void
     */
    private function compileKeyframeBlock(Block $block, array $selectors): void
    {
        $env = $this->pushEnv($block);

        $envs = $this->compactEnv($env);

        $this->env = $this->extractEnv(array_filter($envs, function (Environment $e) {
            return ! isset($e->block->selectors);
        }));

        $this->scope = $this->makeOutputBlock($block->type, $selectors);
        $this->scope->depth = 1;
        assert($this->scope->parent !== null);
        $this->scope->parent->children[] = $this->scope;

        $this->compileChildrenNoReturn($block->children, $this->scope);

        assert($this->scope !== null);
        $this->scope = $this->scope->parent;
        $this->env   = $this->extractEnv($envs);

        $this->popEnv();
    }

    /**
     * Compile nested properties lines
     *
     * @param Block       $block
     * @param OutputBlock $out
     *
     * @return void
     */
    private function compileNestedPropertiesBlock(Block $block, OutputBlock $out): void
    {
        assert($block instanceof NestedPropertyBlock);
        $prefix = $this->compileValue($block->prefix) . '-';

        $nested = $this->makeOutputBlock($block->type);
        $nested->parent = $out;

        if ($block->hasValue) {
            $nested->depth = $out->depth + 1;
        }

        $out->children[] = $nested;

        foreach ($block->children as $child) {
            switch ($child[0]) {
                case Type::T_ASSIGN:
                    array_unshift($child[1][2], $prefix);
                    break;

                case Type::T_NESTED_PROPERTY:
                    assert($child[1] instanceof NestedPropertyBlock);
                    array_unshift($child[1]->prefix[2], $prefix);
                    break;
            }

            $this->compileChild($child, $nested);
        }
    }

    /**
     * Compile nested block
     *
     * @param Block    $block
     * @param string[] $selectors
     *
     * @return void
     */
    private function compileNestedBlock(Block $block, array $selectors): void
    {
        $this->pushEnv($block);

        $this->scope = $this->makeOutputBlock($block->type, $selectors);
        assert($this->scope->parent !== null);
        $this->scope->parent->children[] = $this->scope;

        // wrap assign children in a block
        // except for @font-face
        if (!$block instanceof DirectiveBlock || $this->compileDirectiveName($block->name) !== 'font-face') {
            // need wrapping?
            $needWrapping = false;

            foreach ($block->children as $child) {
                if ($child[0] === Type::T_ASSIGN) {
                    $needWrapping = true;
                    break;
                }
            }

            if ($needWrapping) {
                $wrapped = new Block();
                $wrapped->sourceName   = $block->sourceName;
                $wrapped->sourceIndex  = $block->sourceIndex;
                $wrapped->sourceLine   = $block->sourceLine;
                $wrapped->sourceColumn = $block->sourceColumn;
                $wrapped->selectors    = [];
                $wrapped->comments     = [];
                $wrapped->parent       = $block;
                $wrapped->children     = $block->children;
                $wrapped->selfParent   = $block->selfParent;

                $block->children = [[Type::T_BLOCK, $wrapped]];
            }
        }

        $this->compileChildrenNoReturn($block->children, $this->scope);

        assert($this->scope !== null);
        $this->scope = $this->scope->parent;

        $this->popEnv();
    }

    /**
     * Recursively compiles a block.
     *
     * A block is analogous to a CSS block in most cases. A single SCSS document
     * is encapsulated in a block when parsed, but it does not have parent tags
     * so all of its children appear on the root level when compiled.
     *
     * Blocks are made up of selectors and children.
     *
     * The children of a block are just all the blocks that are defined within.
     *
     * Compiling the block involves pushing a fresh environment on the stack,
     * and iterating through the props, compiling each one.
     *
     * @see Compiler::compileChild()
     *
     * @param Block $block
     *
     * @return void
     */
    private function compileBlock(Block $block): void
    {
        $env = $this->pushEnv($block);
        assert($block->selectors !== null);
        $env->selectors = $this->evalSelectors($block->selectors);

        $out = $this->makeOutputBlock(null);

        assert($this->scope !== null);
        $this->scope->children[] = $out;

        if (\count($block->children)) {
            $out->selectors = $this->multiplySelectors($env, $block->selfParent);

            // propagate selfParent to the children where they still can be useful
            $selfParentSelectors = null;

            if (isset($block->selfParent->selectors)) {
                $selfParentSelectors = $block->selfParent->selectors;
                $block->selfParent->selectors = $out->selectors;
            }

            $this->compileChildrenNoReturn($block->children, $out, $block->selfParent);

            // and revert for the following children of the same block
            if ($selfParentSelectors) {
                assert($block->selfParent !== null);
                $block->selfParent->selectors = $selfParentSelectors;
            }
        }

        $this->popEnv();
    }


    /**
     * Compile the value of a comment that can have interpolation
     *
     * @param array $value
     * @param bool  $pushEnv
     *
     * @return string
     */
    private function compileCommentValue(array $value, bool $pushEnv = false)
    {
        $c = $value[1];

        if (isset($value[2])) {
            if ($pushEnv) {
                $this->pushEnv();
            }

            $c = $this->compileValue($value[2]);

            if ($pushEnv) {
                $this->popEnv();
            }
        }

        return $c;
    }

    /**
     * Compile root level comment
     *
     * @param array $block
     *
     * @return void
     */
    private function compileComment(array $block): void
    {
        $out = $this->makeOutputBlock(Type::T_COMMENT);
        $out->lines[] = $this->compileCommentValue($block, true);

        assert($this->scope !== null);
        $this->scope->children[] = $out;
    }

    /**
     * Evaluate selectors
     *
     * @param array $selectors
     *
     * @return array
     */
    private function evalSelectors(array $selectors): array
    {
        $this->shouldEvaluate = false;

        $evaluatedSelectors = [];
        foreach ($selectors as $selector) {
            $evaluatedSelectors[] = $this->evalSelector($selector);
        }
        $selectors = $evaluatedSelectors;

        // after evaluating interpolates, we might need a second pass
        if ($this->shouldEvaluate) {
            $selectors = $this->replaceSelfSelector($selectors, '&');
            $buffer    = $this->collapseSelectors($selectors);
            $parser    = $this->parserFactory(__METHOD__);

            try {
                $isValid = $parser->parseSelector($buffer, $newSelectors, true);
            } catch (ParserException $e) {
                throw $this->error($e->getMessage());
            }

            if ($isValid) {
                $selectors = array_map([$this, 'evalSelector'], $newSelectors);
            }
        }

        return $selectors;
    }

    /**
     * Evaluate selector
     *
     * @param array $selector
     *
     * @return array
     *
     * @phpstan-impure
     */
    private function evalSelector(array $selector): array
    {
        return array_map([$this, 'evalSelectorPart'], $selector);
    }

    /**
     * Evaluate selector part; replaces all the interpolates, stripping quotes
     *
     * @param array $part
     *
     * @return array
     *
     * @phpstan-impure
     */
    private function evalSelectorPart(array $part): array
    {
        foreach ($part as &$p) {
            if (\is_array($p) && ($p[0] === Type::T_INTERPOLATE || $p[0] === Type::T_STRING)) {
                $p = $this->compileValue($p);

                // force re-evaluation if self char or non standard char
                if (preg_match(',[^\w-],', $p)) {
                    $this->shouldEvaluate = true;
                }
            } elseif (
                \is_string($p) && \strlen($p) >= 2 &&
                ($p[0] === '"' || $p[0] === "'") &&
                substr($p, -1) === $p[0]
            ) {
                $p = substr($p, 1, -1);
            }
        }

        return $this->flattenSelectorSingle($part);
    }

    /**
     * Collapse selectors
     *
     * @param array $selectors
     *
     * @return string
     */
    private function collapseSelectors(array $selectors): string
    {
        $parts = [];

        foreach ($selectors as $selector) {
            $output = [];

            foreach ($selector as $node) {
                $compound = '';

                array_walk_recursive(
                    $node,
                    function ($value, $key) use (&$compound) {
                        $compound .= $value;
                    }
                );

                $output[] = $compound;
            }

            $parts[] = implode(' ', $output);
        }

        return implode(', ', $parts);
    }

    /**
     * Collapse selectors
     *
     * @param array $selectors
     *
     * @return array
     */
    private function collapseSelectorsAsList(array $selectors): array
    {
        $parts = [];

        foreach ($selectors as $selector) {
            $output = [];
            $glueNext = false;

            foreach ($selector as $node) {
                $compound = '';

                array_walk_recursive(
                    $node,
                    function ($value, $key) use (&$compound) {
                        $compound .= $value;
                    }
                );

                if ($this->isImmediateRelationshipCombinator($compound)) {
                    if (\count($output)) {
                        $output[\count($output) - 1] .= ' ' . $compound;
                    } else {
                        $output[] = $compound;
                    }

                    $glueNext = true;
                } elseif ($glueNext) {
                    $output[\count($output) - 1] .= ' ' . $compound;
                    $glueNext = false;
                } else {
                    $output[] = $compound;
                }
            }

            foreach ($output as &$o) {
                $o = [Type::T_STRING, '', [$o]];
            }

            $parts[] = [Type::T_LIST, ' ', $output];
        }

        return [Type::T_LIST, ',', $parts];
    }

    /**
     * Parse down the selector and revert [self] to "&" before a reparsing
     *
     * @param array       $selectors
     * @param string|null $replace
     *
     * @return array
     */
    private function replaceSelfSelector(array $selectors, ?string $replace = null): array
    {
        foreach ($selectors as &$part) {
            if (\is_array($part)) {
                if ($part === [Type::T_SELF]) {
                    if (\is_null($replace)) {
                        $replace = $this->reduce([Type::T_SELF]);
                        $replace = $this->compileValue($replace);
                    }
                    $part = $replace;
                } else {
                    $part = $this->replaceSelfSelector($part, $replace);
                }
            }
        }

        return $selectors;
    }

    /**
     * Flatten selector single; joins together .classes and #ids
     *
     * @param array $single
     *
     * @return array
     */
    private function flattenSelectorSingle(array $single): array
    {
        $joined = [];

        foreach ($single as $part) {
            if (
                empty($joined) ||
                ! \is_string($part) ||
                preg_match('/[\[.:#%]/', $part)
            ) {
                $joined[] = $part;
                continue;
            }

            if (\is_array(end($joined))) {
                $joined[] = $part;
            } else {
                $joined[\count($joined) - 1] .= $part;
            }
        }

        return $joined;
    }

    /**
     * Compile selector to string; self(&) should have been replaced by now
     *
     * @param string|array $selector
     *
     * @return string
     */
    private function compileSelector($selector): string
    {
        if (! \is_array($selector)) {
            return $selector; // media and the like
        }

        return implode(
            ' ',
            array_map(
                [$this, 'compileSelectorPart'],
                $selector
            )
        );
    }

    /**
     * Compile selector part
     *
     * @param array $piece
     *
     * @return string
     */
    private function compileSelectorPart(array $piece): string
    {
        foreach ($piece as &$p) {
            if (! \is_array($p)) {
                continue;
            }

            switch ($p[0]) {
                case Type::T_SELF:
                    $p = '&';
                    break;

                default:
                    $p = $this->compileValue($p);
                    break;
            }
        }

        return implode($piece);
    }

    /**
     * Has selector placeholder?
     *
     * @param array $selector
     *
     * @return bool
     */
    private function hasSelectorPlaceholder($selector): bool
    {
        if (! \is_array($selector)) {
            return false;
        }

        foreach ($selector as $parts) {
            foreach ($parts as $part) {
                if (\strlen($part) && '%' === $part[0]) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param string $name
     *
     * @return void
     */
    private function pushCallStack(string $name = ''): void
    {
        $this->callStack[] = [
          'n' => $name,
          Parser::SOURCE_INDEX => $this->sourceIndex,
          Parser::SOURCE_LINE => $this->sourceLine,
          Parser::SOURCE_COLUMN => $this->sourceColumn
        ];

        // infinite calling loop
        if (\count($this->callStack) > 25000) {
            // not displayed but you can var_dump it to deep debug
            $msg = $this->callStackMessage(true, 100);
            $msg = 'Infinite calling loop';

            throw $this->error($msg);
        }
    }

    /**
     * @return void
     */
    private function popCallStack(): void
    {
        array_pop($this->callStack);
    }

    /**
     * Compile children and return result
     *
     * @param array       $stms
     * @param OutputBlock $out
     * @param string      $traceName
     *
     * @return array|Number|null
     */
    private function compileChildren(array $stms, OutputBlock $out, string $traceName = '')
    {
        $this->pushCallStack($traceName);

        foreach ($stms as $stm) {
            $ret = $this->compileChild($stm, $out);

            if (isset($ret)) {
                $this->popCallStack();

                return $ret;
            }
        }

        $this->popCallStack();

        return null;
    }

    /**
     * Compile children and throw exception if unexpected `@return`
     *
     * @param array       $stms
     * @param OutputBlock $out
     * @param Block       $selfParent
     * @param string      $traceName
     *
     * @return void
     *
     * @throws \Exception
     */
    private function compileChildrenNoReturn(array $stms, OutputBlock $out, $selfParent = null, string $traceName = ''): void
    {
        $this->pushCallStack($traceName);

        foreach ($stms as $stm) {
            if ($selfParent && isset($stm[1]) && \is_object($stm[1]) && $stm[1] instanceof Block) {
                $stm[1]->selfParent = $selfParent;
                $ret = $this->compileChild($stm, $out);
                $stm[1]->selfParent = null;
            } elseif ($selfParent && \in_array($stm[0], [Type::T_INCLUDE, Type::T_EXTEND])) {
                $stm['selfParent'] = $selfParent;
                $ret = $this->compileChild($stm, $out);
                unset($stm['selfParent']);
            } else {
                $ret = $this->compileChild($stm, $out);
            }

            if (isset($ret)) {
                throw $this->error('@return may only be used within a function');
            }
        }

        $this->popCallStack();
    }


    /**
     * evaluate media query : compile internal value keeping the structure unchanged
     *
     * @param array $queryList
     *
     * @return array
     */
    private function evaluateMediaQuery(array $queryList): array
    {
        static $parser = null;

        $outQueryList = [];

        foreach ($queryList as $kql => $query) {
            $shouldReparse = false;

            foreach ($query as $kq => $q) {
                for ($i = 1; $i < \count($q); $i++) {
                    $value = $this->compileValue($q[$i]);

                    // the parser had no mean to know if media type or expression if it was an interpolation
                    // so you need to reparse if the T_MEDIA_TYPE looks like anything else a media type
                    if (
                        $q[0] == Type::T_MEDIA_TYPE &&
                        (strpos($value, '(') !== false ||
                        strpos($value, ')') !== false ||
                        strpos($value, ':') !== false ||
                        strpos($value, ',') !== false)
                    ) {
                        $shouldReparse = true;
                    }

                    $queryList[$kql][$kq][$i] = [Type::T_KEYWORD, $value];
                }
            }

            if ($shouldReparse) {
                if (\is_null($parser)) {
                    $parser = $this->parserFactory(__METHOD__);
                }

                $queryString = $this->compileMediaQuery([$queryList[$kql]]);
                $queryString = reset($queryString);

                if ($queryString !== false && strpos($queryString, '@media ') === 0) {
                    $queryString = substr($queryString, 7);
                    $queries = [];

                    if ($parser->parseMediaQueryList($queryString, $queries)) {
                        $queries = $this->evaluateMediaQuery($queries[2]);

                        while (\count($queries)) {
                            $outQueryList[] = array_shift($queries);
                        }

                        continue;
                    }
                }
            }

            $outQueryList[] = $queryList[$kql];
        }

        return $outQueryList;
    }

    /**
     * Compile media query
     *
     * @param array $queryList
     *
     * @return string[]
     */
    private function compileMediaQuery(array $queryList): array
    {
        $start   = '@media ';
        $default = trim($start);
        $out     = [];
        $current = '';

        foreach ($queryList as $query) {
            $type = null;
            $parts = [];

            $mediaTypeOnly = true;

            foreach ($query as $q) {
                if ($q[0] !== Type::T_MEDIA_TYPE) {
                    $mediaTypeOnly = false;
                    break;
                }
            }

            foreach ($query as $q) {
                switch ($q[0]) {
                    case Type::T_MEDIA_TYPE:
                        $newType = array_map([$this, 'compileValue'], \array_slice($q, 1));

                        // combining not and anything else than media type is too risky and should be avoided
                        if (! $mediaTypeOnly) {
                            if (\in_array(Type::T_NOT, $newType) || ($type && \in_array(Type::T_NOT, $type) )) {
                                if ($type) {
                                    array_unshift($parts, implode(' ', array_filter($type)));
                                }

                                if (! empty($parts)) {
                                    if (\strlen($current)) {
                                        $current .= $this->formatter->tagSeparator;
                                    }

                                    $current .= implode(' and ', $parts);
                                }

                                if ($current) {
                                    $out[] = $start . $current;
                                }

                                $current = '';
                                $type    = null;
                                $parts   = [];
                            }
                        }

                        if ($newType === ['all'] && $default) {
                            $default = $start . 'all';
                        }

                        // all can be safely ignored and mixed with whatever else
                        if ($newType !== ['all']) {
                            if ($type) {
                                $type = $this->mergeMediaTypes($type, $newType);

                                if (empty($type)) {
                                    // merge failed : ignore this query that is not valid, skip to the next one
                                    $parts = [];
                                    $default = ''; // if everything fail, no @media at all
                                    continue 3;
                                }
                            } else {
                                $type = $newType;
                            }
                        }
                        break;

                    case Type::T_MEDIA_EXPRESSION:
                        if (isset($q[2])) {
                            $parts[] = '('
                                . $this->compileValue($q[1])
                                . $this->formatter->assignSeparator
                                . $this->compileValue($q[2])
                                . ')';
                        } else {
                            $parts[] = '('
                                . $this->compileValue($q[1])
                                . ')';
                        }
                        break;

                    case Type::T_MEDIA_VALUE:
                        $parts[] = $this->compileValue($q[1]);
                        break;
                }
            }

            if ($type) {
                array_unshift($parts, implode(' ', array_filter($type)));
            }

            if (! empty($parts)) {
                if (\strlen($current)) {
                    $current .= $this->formatter->tagSeparator;
                }

                $current .= implode(' and ', $parts);
            }
        }

        if ($current) {
            $out[] = $start . $current;
        }

        // no @media type except all, and no conflict?
        if (! $out && $default) {
            $out[] = $default;
        }

        return $out;
    }

    /**
     * Merge direct relationships between selectors
     *
     * @param array $selectors1
     * @param array $selectors2
     *
     * @return array
     */
    private function mergeDirectRelationships(array $selectors1, array $selectors2): array
    {
        if (empty($selectors1) || empty($selectors2)) {
            return array_merge($selectors1, $selectors2);
        }

        $part1 = end($selectors1);
        $part2 = end($selectors2);

        if (! $this->isImmediateRelationshipCombinator($part1[0]) && $part1 !== $part2) {
            return array_merge($selectors1, $selectors2);
        }

        $merged = [];

        do {
            $part1 = array_pop($selectors1);
            $part2 = array_pop($selectors2);

            if (! $this->isImmediateRelationshipCombinator($part1[0]) && $part1 !== $part2) {
                if ($this->isImmediateRelationshipCombinator(reset($merged)[0])) {
                    array_unshift($merged, [$part1[0] . $part2[0]]);
                    $merged = array_merge($selectors1, $selectors2, $merged);
                } else {
                    $merged = array_merge($selectors1, [$part1], $selectors2, [$part2], $merged);
                }

                break;
            }

            array_unshift($merged, $part1);
        } while (! empty($selectors1) && ! empty($selectors2));

        return $merged;
    }

    /**
     * Merge media types
     *
     * @param array $type1
     * @param array $type2
     *
     * @return array|null
     */
    private function mergeMediaTypes(array $type1, array $type2): ?array
    {
        if (empty($type1)) {
            return $type2;
        }

        if (empty($type2)) {
            return $type1;
        }

        if (\count($type1) > 1) {
            $m1 = strtolower($type1[0]);
            $t1 = strtolower($type1[1]);
        } else {
            $m1 = '';
            $t1 = strtolower($type1[0]);
        }

        if (\count($type2) > 1) {
            $m2 = strtolower($type2[0]);
            $t2 = strtolower($type2[1]);
        } else {
            $m2 = '';
            $t2 = strtolower($type2[0]);
        }

        if (($m1 === Type::T_NOT) ^ ($m2 === Type::T_NOT)) {
            if ($t1 === $t2) {
                return null;
            }

            return [
                $m1 === Type::T_NOT ? $m2 : $m1,
                $m1 === Type::T_NOT ? $t2 : $t1,
            ];
        }

        if ($m1 === Type::T_NOT && $m2 === Type::T_NOT) {
            // CSS has no way of representing "neither screen nor print"
            if ($t1 !== $t2) {
                return null;
            }

            return [Type::T_NOT, $t1];
        }

        if ($t1 !== $t2) {
            return null;
        }

        // t1 == t2, neither m1 nor m2 are "not"
        return [empty($m1) ? $m2 : $m1, $t1];
    }

    /**
     * Compile import; returns true if the value was something that could be imported
     *
     * @param array       $rawPath
     * @param OutputBlock $out
     *
     * @return bool
     */
    private function compileImport($rawPath, OutputBlock $out): bool
    {
        if ($rawPath[0] === Type::T_STRING) {
            $path = $this->compileStringContent($rawPath);

            if (strpos($path, 'url(') !== 0 && $filePath = $this->findImport($path, $this->currentDirectory)) {
                $this->registerImport($this->currentDirectory, $path, $filePath);

                $this->importFile($filePath, $out);

                return true;
            }

            $this->appendRootDirective('@import ' . $this->compileImportPath($rawPath) . ';', $out);

            return false;
        }

        if ($rawPath[0] === Type::T_LIST) {
            // handle a list of strings
            if (\count($rawPath[2]) === 0) {
                return false;
            }

            foreach ($rawPath[2] as $path) {
                if ($path[0] !== Type::T_STRING) {
                    $this->appendRootDirective('@import ' . $this->compileImportPath($rawPath) . ';', $out);

                    return false;
                }
            }

            foreach ($rawPath[2] as $path) {
                $this->compileImport($path, $out);
            }

            return true;
        }

        $this->appendRootDirective('@import ' . $this->compileImportPath($rawPath) . ';', $out);

        return false;
    }

    /**
     * @param array $rawPath
     * @return string
     * @throws CompilerException
     */
    private function compileImportPath($rawPath): string
    {
        $path = $this->compileValue($rawPath);

        // case url() without quotes : suppress \r \n remaining in the path
        // if this is a real string there can not be CR or LF char
        if (strpos($path, 'url(') === 0) {
            $path = str_replace(array("\r", "\n"), array('', ' '), $path);
        } else {
            // if this is a file name in a string, spaces should be escaped
            $path = $this->reduce($rawPath);
            $path = $this->escapeImportPathString($path);
            $path = $this->compileValue($path);
        }

        return $path;
    }

    /**
     * @param array $path
     * @return array
     * @throws CompilerException
     */
    private function escapeImportPathString($path)
    {
        switch ($path[0]) {
            case Type::T_LIST:
                foreach ($path[2] as $k => $v) {
                    $path[2][$k] = $this->escapeImportPathString($v);
                }
                break;
            case Type::T_STRING:
                if ($path[1]) {
                    $path = $this->compileValue($path);
                    $path = str_replace(' ', '\\ ', $path);
                    $path = [Type::T_KEYWORD, $path];
                }
                break;
        }

        return $path;
    }

    /**
     * Append a root directive like @import or @charset as near as the possible from the source code
     * (keeping before comments, @import and @charset coming before in the source code)
     *
     * @param string      $line
     * @param OutputBlock $out
     * @param string[]      $allowed
     *
     * @return void
     */
    private function appendRootDirective(string $line, OutputBlock $out, array $allowed = [Type::T_COMMENT]): void
    {
        $root = $out;

        while ($root->parent) {
            $root = $root->parent;
        }

        $i = 0;

        while ($i < \count($root->children)) {
            if (! isset($root->children[$i]->type) || ! \in_array($root->children[$i]->type, $allowed)) {
                break;
            }

            $i++;
        }

        // remove incompatible children from the bottom of the list
        $saveChildren = [];

        while ($i < \count($root->children)) {
            $saveChildren[] = array_pop($root->children);
        }

        // insert the directive as a comment
        $child = $this->makeOutputBlock(Type::T_COMMENT);
        $child->lines[]      = $line;
        $child->sourceName   = $this->sourceNames[$this->sourceIndex] ?: '(stdin)';
        $child->sourceLine   = $this->sourceLine;
        $child->sourceColumn = $this->sourceColumn;

        $root->children[] = $child;

        // repush children
        while (\count($saveChildren)) {
            $root->children[] = array_pop($saveChildren);
        }
    }

    /**
     * Append lines to the current output block:
     * directly to the block or through a child if necessary
     *
     * @param OutputBlock $out
     * @param string      $type
     * @param string      $line
     *
     * @return void
     */
    private function appendOutputLine(OutputBlock $out, string $type, string $line): void
    {
        $outWrite = &$out;

        // check if it's a flat output or not
        if (\count($out->children)) {
            $lastChild = &$out->children[\count($out->children) - 1];

            if (
                $lastChild->depth === $out->depth &&
                \is_null($lastChild->selectors) &&
                ! \count($lastChild->children)
            ) {
                $outWrite = $lastChild;
            } else {
                $nextLines = $this->makeOutputBlock($type);
                $nextLines->parent = $out;
                $nextLines->depth  = $out->depth;

                $out->children[] = $nextLines;
                $outWrite = &$nextLines;
            }
        }

        $outWrite->lines[] = $line;
    }

    /**
     * Compile child; returns a value to halt execution
     *
     * @param array       $child
     * @param OutputBlock $out
     *
     * @return array|Number|null
     */
    private function compileChild($child, OutputBlock $out)
    {
        if (isset($child[Parser::SOURCE_LINE])) {
            $this->sourceIndex  = isset($child[Parser::SOURCE_INDEX]) ? $child[Parser::SOURCE_INDEX] : null;
            $this->sourceLine   = isset($child[Parser::SOURCE_LINE]) ? $child[Parser::SOURCE_LINE] : -1;
            $this->sourceColumn = isset($child[Parser::SOURCE_COLUMN]) ? $child[Parser::SOURCE_COLUMN] : -1;
        } elseif (\is_array($child) && isset($child[1]->sourceLine) && $child[1] instanceof Block) {
            $this->sourceIndex  = $child[1]->sourceIndex;
            $this->sourceLine   = $child[1]->sourceLine;
            $this->sourceColumn = $child[1]->sourceColumn;
        } elseif (! empty($out->sourceLine) && ! empty($out->sourceName)) {
            $this->sourceLine   = $out->sourceLine;
            $sourceIndex  = array_search($out->sourceName, $this->sourceNames);
            $this->sourceColumn = $out->sourceColumn;

            if ($sourceIndex === false) {
                $sourceIndex = null;
            }
            $this->sourceIndex = $sourceIndex;
        }

        switch ($child[0]) {
            case Type::T_IMPORT:
                $rawPath = $this->reduce($child[1]);

                $this->compileImport($rawPath, $out);
                break;

            case Type::T_DIRECTIVE:
                $this->compileDirective($child[1], $out);
                break;

            case Type::T_AT_ROOT:
                $this->compileAtRoot($child[1]);
                break;

            case Type::T_MEDIA:
                $this->compileMedia($child[1]);
                break;

            case Type::T_BLOCK:
                $this->compileBlock($child[1]);
                break;

            case Type::T_CHARSET:
                break;

            case Type::T_CUSTOM_PROPERTY:
                list(, $name, $value) = $child;
                $compiledName = $this->compileValue($name);

                // if the value reduces to null from something else then
                // the property should be discarded
                if ($value[0] !== Type::T_NULL) {
                    $value = $this->reduce($value);

                    if ($value[0] === Type::T_NULL || $value === self::$nullString) {
                        break;
                    }
                }

                $compiledValue = $this->compileValue($value);

                $line = $this->formatter->customProperty(
                    $compiledName,
                    $compiledValue
                );

                $this->appendOutputLine($out, Type::T_ASSIGN, $line);
                break;

            case Type::T_ASSIGN:
                list(, $name, $value) = $child;

                if ($name[0] === Type::T_VARIABLE) {
                    $flags     = isset($child[3]) ? $child[3] : [];
                    $isDefault = \in_array('!default', $flags);
                    $isGlobal  = \in_array('!global', $flags);

                    if ($isGlobal) {
                        $this->set($name[1], $this->reduce($value), false, $this->rootEnv, $value);
                        break;
                    }

                    $shouldSet = $isDefault &&
                        (\is_null($result = $this->get($name[1], false)) ||
                        $result === self::$null);

                    if (! $isDefault || $shouldSet) {
                        $this->set($name[1], $this->reduce($value), true, null, $value);
                    }
                    break;
                }

                $compiledName = $this->compileValue($name);

                // handle shorthand syntaxes : size / line-height...
                if (\in_array($compiledName, ['font', 'grid-row', 'grid-column', 'border-radius'])) {
                    if ($value[0] === Type::T_VARIABLE) {
                        // if the font value comes from variable, the content is already reduced
                        // (i.e., formulas were already calculated), so we need the original unreduced value
                        $value = $this->get($value[1], true, null, true);
                    }

                    $shorthandValue=&$value;

                    $shorthandDividerNeedsUnit = false;
                    $maxListElements           = null;
                    $maxShorthandDividers      = 1;

                    switch ($compiledName) {
                        case 'border-radius':
                            $maxListElements = 4;
                            $shorthandDividerNeedsUnit = true;
                            break;
                    }

                    if ($compiledName === 'font' && $value[0] === Type::T_LIST && $value[1] === ',') {
                        // this is the case if more than one font is given: example: "font: 400 1em/1.3 arial,helvetica"
                        // we need to handle the first list element
                        $shorthandValue=&$value[2][0];
                    }

                    if ($shorthandValue[0] === Type::T_EXPRESSION && $shorthandValue[1] === '/') {
                        $revert = true;

                        if ($shorthandDividerNeedsUnit) {
                            $divider = $shorthandValue[3];

                            if (\is_array($divider)) {
                                $divider = $this->reduce($divider, true);
                            }

                            if ($divider instanceof Number && \intval($divider->getDimension()) && $divider->unitless()) {
                                $revert = false;
                            }
                        }

                        if ($revert) {
                            $shorthandValue = $this->expToString($shorthandValue);
                        }
                    } elseif ($shorthandValue[0] === Type::T_LIST) {
                        foreach ($shorthandValue[2] as &$item) {
                            if ($item[0] === Type::T_EXPRESSION && $item[1] === '/') {
                                if ($maxShorthandDividers > 0) {
                                    $revert = true;

                                    // if the list of values is too long, this has to be a shorthand,
                                    // otherwise it could be a real division
                                    if (\is_null($maxListElements) || \count($shorthandValue[2]) <= $maxListElements) {
                                        if ($shorthandDividerNeedsUnit) {
                                            $divider = $item[3];

                                            if (\is_array($divider)) {
                                                $divider = $this->reduce($divider, true);
                                            }

                                            if ($divider instanceof Number && \intval($divider->getDimension()) && $divider->unitless()) {
                                                $revert = false;
                                            }
                                        }
                                    }

                                    if ($revert) {
                                        $item = $this->expToString($item);
                                        $maxShorthandDividers--;
                                    }
                                }
                            }
                        }
                    }
                }

                // if the value reduces to null from something else then
                // the property should be discarded
                if ($value[0] !== Type::T_NULL) {
                    $value = $this->reduce($value);

                    if ($value[0] === Type::T_NULL || $value === self::$nullString) {
                        break;
                    }
                }

                $compiledValue = $this->compileValue($value);

                // ignore empty value
                if (\strlen($compiledValue)) {
                    $line = $this->formatter->property(
                        $compiledName,
                        $compiledValue
                    );
                    $this->appendOutputLine($out, Type::T_ASSIGN, $line);
                }
                break;

            case Type::T_COMMENT:
                if ($out->type === Type::T_ROOT) {
                    $this->compileComment($child);
                    break;
                }

                $line = $this->compileCommentValue($child, true);
                $this->appendOutputLine($out, Type::T_COMMENT, $line);
                break;

            case Type::T_MIXIN:
            case Type::T_FUNCTION:
                list(, $block) = $child;
                assert($block instanceof CallableBlock);
                // the block need to be able to go up to it's parent env to resolve vars
                $block->parentEnv = $this->getStoreEnv();
                $this->set(self::$namespaces[$block->type] . $block->name, $block, true);
                break;

            case Type::T_EXTEND:
                foreach ($child[1] as $sel) {
                    $replacedSel = $this->replaceSelfSelector($sel);

                    if ($replacedSel !== $sel) {
                        throw $this->error('Parent selectors aren\'t allowed here.');
                    }

                    $results = $this->evalSelectors([$sel]);

                    foreach ($results as $result) {
                        if (\count($result) !== 1) {
                            throw $this->error('complex selectors may not be extended.');
                        }

                        // only use the first one
                        $result = $result[0];
                        $selectors = $out->selectors;

                        if (! $selectors && isset($child['selfParent'])) {
                            $selectors = $this->multiplySelectors($this->env, $child['selfParent']);
                        }
                        assert($selectors !== null);

                        if (\count($result) > 1) {
                            $replacement = implode(', ', $result);
                            $fname = $this->getPrettyPath($this->sourceNames[$this->sourceIndex]);
                            $line = $this->sourceLine;

                            $message = <<<EOL
on line $line of $fname:
Compound selectors may no longer be extended.
Consider `@extend $replacement` instead.
See http://bit.ly/ExtendCompound for details.
EOL;

                            $this->logger->warn($message);
                        }

                        $this->pushExtends($result, $selectors, $child);
                    }
                }
                break;

            case Type::T_IF:
                list(, $if) = $child;
                assert($if instanceof IfBlock);

                if ($this->isTruthy($this->reduce($if->cond, true))) {
                    return $this->compileChildren($if->children, $out);
                }

                foreach ($if->cases as $case) {
                    if (
                        $case instanceof ElseBlock ||
                        $case instanceof ElseifBlock && $this->isTruthy($this->reduce($case->cond))
                    ) {
                        return $this->compileChildren($case->children, $out);
                    }
                }
                break;

            case Type::T_EACH:
                list(, $each) = $child;
                assert($each instanceof EachBlock);

                $list = $this->coerceList($this->reduce($each->list), ',', true);

                $this->pushEnv();

                foreach ($list[2] as $item) {
                    if (\count($each->vars) === 1) {
                        $this->set($each->vars[0], $item, true);
                    } else {
                        list(,, $values) = $this->coerceList($item);

                        foreach ($each->vars as $i => $var) {
                            $this->set($var, isset($values[$i]) ? $values[$i] : self::$null, true);
                        }
                    }

                    $ret = $this->compileChildren($each->children, $out);

                    if ($ret) {
                        $store = $this->env->store;
                        $this->popEnv();
                        $this->backPropagateEnv($store, $each->vars);

                        return $ret;
                    }
                }
                $store = $this->env->store;
                $this->popEnv();
                $this->backPropagateEnv($store, $each->vars);

                break;

            case Type::T_WHILE:
                list(, $while) = $child;
                assert($while instanceof WhileBlock);

                while ($this->isTruthy($this->reduce($while->cond, true))) {
                    $ret = $this->compileChildren($while->children, $out);

                    if ($ret) {
                        return $ret;
                    }
                }
                break;

            case Type::T_FOR:
                list(, $for) = $child;
                assert($for instanceof ForBlock);

                $startNumber = $this->assertNumber($this->reduce($for->start, true));
                $endNumber = $this->assertNumber($this->reduce($for->end, true));

                $start = $this->assertInteger($startNumber);

                $numeratorUnits = $startNumber->getNumeratorUnits();
                $denominatorUnits = $startNumber->getDenominatorUnits();

                $end = $this->assertInteger($endNumber->coerce($numeratorUnits, $denominatorUnits));

                $d = $start < $end ? 1 : -1;

                $this->pushEnv();

                for (;;) {
                    if (
                        (! $for->until && $start - $d == $end) ||
                        ($for->until && $start == $end)
                    ) {
                        break;
                    }

                    $this->set($for->var, new Number($start, $numeratorUnits, $denominatorUnits));
                    $start += $d;

                    $ret = $this->compileChildren($for->children, $out);

                    if ($ret) {
                        $store = $this->env->store;
                        $this->popEnv();
                        $this->backPropagateEnv($store, [$for->var]);

                        return $ret;
                    }
                }

                $store = $this->env->store;
                $this->popEnv();
                $this->backPropagateEnv($store, [$for->var]);

                break;

            case Type::T_RETURN:
                return $this->reduce($child[1], true);

            case Type::T_NESTED_PROPERTY:
                $this->compileNestedPropertiesBlock($child[1], $out);
                break;

            case Type::T_INCLUDE:
                // including a mixin
                list(, $name, $argValues, $content, $argUsing) = $child;

                $mixin = $this->get(self::$namespaces['mixin'] . $name, false);

                if (! $mixin) {
                    throw $this->error("Undefined mixin $name");
                }

                assert($mixin instanceof CallableBlock);

                $callingScope = $this->getStoreEnv();

                // push scope, apply args
                $this->pushEnv();
                $this->env->depth--;

                // Find the parent selectors in the env to be able to know what '&' refers to in the mixin
                // and assign this fake parent to childs
                $selfParent = null;

                if (isset($child['selfParent']) && $child['selfParent'] instanceof Block && isset($child['selfParent']->selectors)) {
                    $selfParent = $child['selfParent'];
                } else {
                    $parentSelectors = $this->multiplySelectors($this->env);

                    if ($parentSelectors) {
                        $parent = new Block();
                        $parent->selectors = $parentSelectors;

                        foreach ($mixin->children as $k => $child) {
                            if (isset($child[1]) && $child[1] instanceof Block) {
                                $mixin->children[$k][1]->parent = $parent;
                            }
                        }
                    }
                }

                // clone the stored content to not have its scope spoiled by a further call to the same mixin
                // i.e., recursive @include of the same mixin
                if (isset($content)) {
                    $copyContent = clone $content;
                    $copyContent->scope = clone $callingScope;

                    $this->setRaw(self::$namespaces['special'] . 'content', $copyContent, $this->env);
                } else {
                    $this->setRaw(self::$namespaces['special'] . 'content', null, $this->env);
                }

                // save the "using" argument list for applying it to when "@content" is invoked
                if (isset($argUsing)) {
                    $this->setRaw(self::$namespaces['special'] . 'using', $argUsing, $this->env);
                } else {
                    $this->setRaw(self::$namespaces['special'] . 'using', null, $this->env);
                }

                if (isset($mixin->args)) {
                    $this->applyArguments($mixin->args, $argValues);
                }

                $this->env->marker = 'mixin';

                if (! empty($mixin->parentEnv)) {
                    $this->env->declarationScopeParent = $mixin->parentEnv;
                } else {
                    throw $this->error("@mixin $name() without parentEnv");
                }

                $this->compileChildrenNoReturn($mixin->children, $out, $selfParent, $this->env->marker . ' ' . $name);

                $this->popEnv();
                break;

            case Type::T_MIXIN_CONTENT:
                $env        = isset($this->storeEnv) ? $this->storeEnv : $this->env;
                $content    = $this->get(self::$namespaces['special'] . 'content', false, $env);
                $argUsing   = $this->get(self::$namespaces['special'] . 'using', false, $env);
                $argContent = $child[1];

                if (! $content) {
                    break;
                }

                $storeEnv = $this->storeEnv;
                $varsUsing = [];

                if (isset($argUsing) && isset($argContent)) {
                    // Get the arguments provided for the content with the names provided in the "using" argument list
                    $this->storeEnv = null;
                    $varsUsing = $this->applyArguments($argUsing, $argContent, false);
                }

                // restore the scope from the @content
                $this->storeEnv = $content->scope;

                // append the vars from using if any
                foreach ($varsUsing as $name => $val) {
                    $this->set($name, $val, true, $this->storeEnv);
                }

                $this->compileChildrenNoReturn($content->children, $out);

                $this->storeEnv = $storeEnv;
                break;

            case Type::T_DEBUG:
                list(, $value) = $child;

                $fname = $this->getPrettyPath($this->sourceNames[$this->sourceIndex]);
                $line  = $this->sourceLine;
                $value = $this->compileDebugValue($value);

                $this->logger->debug("$fname:$line DEBUG: $value");
                break;

            case Type::T_WARN:
                list(, $value) = $child;

                $fname = $this->getPrettyPath($this->sourceNames[$this->sourceIndex]);
                $line  = $this->sourceLine;
                $value = $this->compileDebugValue($value);

                $this->logger->warn("$value\n         on line $line of $fname");
                break;

            case Type::T_ERROR:
                list(, $value) = $child;

                $fname = $this->getPrettyPath($this->sourceNames[$this->sourceIndex]);
                $line  = $this->sourceLine;
                $value = $this->compileValue($this->reduce($value, true));

                throw $this->error("File $fname on line $line ERROR: $value\n");

            default:
                throw $this->error("unknown child type: $child[0]");
        }

        return null;
    }

    /**
     * Reduce expression to string
     *
     * @param array $exp
     * @param bool $keepParens
     *
     * @return array
     */
    private function expToString(array $exp, bool $keepParens = false): array
    {
        list(, $op, $left, $right, $inParens, $whiteLeft, $whiteRight) = $exp;

        $content = [];

        if ($keepParens && $inParens) {
            $content[] = '(';
        }

        $content[] = $this->reduce($left);

        if ($whiteLeft) {
            $content[] = ' ';
        }

        $content[] = $op;

        if ($whiteRight) {
            $content[] = ' ';
        }

        $content[] = $this->reduce($right);

        if ($keepParens && $inParens) {
            $content[] = ')';
        }

        return [Type::T_STRING, '', $content];
    }

    /**
     * Is truthy?
     *
     * @param array|Number $value
     *
     * @return bool
     */
    public function isTruthy($value): bool
    {
        return $value !== self::$false && $value !== self::$null;
    }

    /**
     * Is the value a direct relationship combinator?
     *
     * @param string $value
     *
     * @return bool
     */
    private function isImmediateRelationshipCombinator(string $value): bool
    {
        return $value === '>' || $value === '+' || $value === '~';
    }

    /**
     * Should $value cause its operand to eval
     *
     * @param array $value
     *
     * @return bool
     */
    private function shouldEval($value): bool
    {
        switch ($value[0]) {
            case Type::T_EXPRESSION:
                if ($value[1] === '/') {
                    return $this->shouldEval($value[2]) || $this->shouldEval($value[3]);
                }

                // fall-thru
            case Type::T_VARIABLE:
            case Type::T_FUNCTION_CALL:
                return true;
        }

        return false;
    }

    /**
     * Reduce value
     *
     * @param array|Number $value
     * @param bool         $inExp
     *
     * @return array|Number
     */
    private function reduce($value, bool $inExp = false)
    {
        if ($value instanceof Number) {
            return $value;
        }

        switch ($value[0]) {
            case Type::T_EXPRESSION:
                list(, $op, $left, $right, $inParens) = $value;

                $opName = isset(self::$operatorNames[$op]) ? self::$operatorNames[$op] : $op;
                $inExp = $inExp || $this->shouldEval($left) || $this->shouldEval($right);

                $left = $this->reduce($left, true);

                if ($op !== 'and' && $op !== 'or') {
                    $right = $this->reduce($right, true);
                }

                // special case: looks like css shorthand
                if (
                    $opName == 'div' && ! $inParens && ! $inExp &&
                    (($right[0] !== Type::T_NUMBER && isset($right[2]) && $right[2] != '') ||
                    ($right[0] === Type::T_NUMBER && ! $right->unitless()))
                ) {
                    return $this->expToString($value);
                }

                $left  = $this->coerceForExpression($left);
                $right = $this->coerceForExpression($right);
                $ltype = $left[0];
                $rtype = $right[0];

                $ucOpName = ucfirst($opName);
                $ucLType  = ucfirst($ltype);
                $ucRType  = ucfirst($rtype);

                $shouldEval = $inParens || $inExp;

                // this tries:
                // 1. op[op name][left type][right type]
                // 2. op[left type][right type] (passing the op as first arg)
                // 3. op[op name]
                if (\is_callable([$this, $fn = "op${ucOpName}${ucLType}${ucRType}"])) {
                    $out = $this->$fn($left, $right, $shouldEval);
                } elseif (\is_callable([$this, $fn = "op${ucLType}${ucRType}"])) {
                    $out = $this->$fn($op, $left, $right, $shouldEval);
                } elseif (\is_callable([$this, $fn = "op${ucOpName}"])) {
                    $out = $this->$fn($left, $right, $shouldEval);
                } else {
                    $out = null;
                }

                if (isset($out)) {
                    return $out;
                }

                return $this->expToString($value);

            case Type::T_UNARY:
                list(, $op, $exp, $inParens) = $value;

                $inExp = $inExp || $this->shouldEval($exp);
                $exp = $this->reduce($exp);

                if ($exp instanceof Number) {
                    switch ($op) {
                        case '+':
                            return $exp;

                        case '-':
                            return $exp->unaryMinus();
                    }
                }

                if ($op === 'not') {
                    if ($inExp || $inParens) {
                        if ($exp === self::$false || $exp === self::$null) {
                            return self::$true;
                        }

                        return self::$false;
                    }

                    $op = $op . ' ';
                }

                return [Type::T_STRING, '', [$op, $exp]];

            case Type::T_VARIABLE:
                return $this->reduce($this->get($value[1]));

            case Type::T_LIST:
                foreach ($value[2] as &$item) {
                    $item = $this->reduce($item);
                }
                unset($item);

                if (isset($value[3]) && \is_array($value[3])) {
                    foreach ($value[3] as &$item) {
                        $item = $this->reduce($item);
                    }
                    unset($item);
                }

                return $value;

            case Type::T_MAP:
                foreach ($value[1] as &$item) {
                    $item = $this->reduce($item);
                }

                foreach ($value[2] as &$item) {
                    $item = $this->reduce($item);
                }

                return $value;

            case Type::T_STRING:
                foreach ($value[2] as &$item) {
                    if (\is_array($item) || $item instanceof Number) {
                        $item = $this->reduce($item);
                    }
                }

                return $value;

            case Type::T_INTERPOLATE:
                $value[1] = $this->reduce($value[1]);

                if ($inExp) {
                    return [Type::T_KEYWORD, $this->compileValue($value, false)];
                }

                return $value;

            case Type::T_FUNCTION_CALL:
                return $this->fncall($value[1], $value[2]);

            case Type::T_SELF:
                $selfParent = ! empty($this->env->block->selfParent) ? $this->env->block->selfParent : null;
                $selfSelector = $this->multiplySelectors($this->env, $selfParent);
                $selfSelector = $this->collapseSelectorsAsList($selfSelector);

                return $selfSelector;

            default:
                return $value;
        }
    }

    /**
     * Function caller
     *
     * @param string|array $functionReference
     * @param array        $argValues
     *
     * @return array|Number
     */
    private function fncall($functionReference, $argValues)
    {
        // a string means this is a static hard reference coming from the parsing
        if (is_string($functionReference)) {
            $name = $functionReference;

            $functionReference = $this->getFunctionReference($name);
            if ($functionReference === self::$null || $functionReference[0] !== Type::T_FUNCTION_REFERENCE) {
                $functionReference = [Type::T_FUNCTION, $name, [Type::T_LIST, ',', []]];
            }
        }

        // a function type means we just want a plain css function call
        if ($functionReference[0] === Type::T_FUNCTION) {
            // for CSS functions, simply flatten the arguments into a list
            $listArgs = [];

            foreach ((array) $argValues as $arg) {
                if (empty($arg[0]) || count($argValues) === 1) {
                    $listArgs[] = $this->reduce($this->stringifyFncallArgs($arg[1]));
                }
            }

            return [Type::T_FUNCTION, $functionReference[1], [Type::T_LIST, ',', $listArgs]];
        }

        if ($functionReference === self::$null || $functionReference[0] !== Type::T_FUNCTION_REFERENCE) {
            return self::$defaultValue;
        }


        switch ($functionReference[1]) {
            // SCSS @function
            case 'scss':
                return $this->callScssFunction($functionReference[3], $argValues);

            // native PHP functions
            case 'user':
            case 'native':
                list(,,$name, $fn, $prototype) = $functionReference;

                // special cases of css valid functions min/max
                $name = strtolower($name);
                if (\in_array($name, ['min', 'max']) && count($argValues) >= 1) {
                    $cssFunction = $this->cssValidArg(
                        [Type::T_FUNCTION_CALL, $name, $argValues],
                        ['min', 'max', 'calc', 'env', 'var']
                    );
                    if ($cssFunction !== false) {
                        return $cssFunction;
                    }
                }
                $returnValue = $this->callNativeFunction($name, $fn, $prototype, $argValues);

                if (! isset($returnValue)) {
                    return $this->fncall([Type::T_FUNCTION, $name, [Type::T_LIST, ',', []]], $argValues);
                }

                return $returnValue;

            default:
                return self::$defaultValue;
        }
    }

    /**
     * @param array|Number $arg
     * @param string[]     $allowed_function
     * @param string|bool  $inFunction
     *
     * @return array|Number|false
     */
    private function cssValidArg($arg, array $allowed_function = [], $inFunction = false)
    {
        if ($arg instanceof Number) {
            return $this->stringifyFncallArgs($arg);
        }

        switch ($arg[0]) {
            case Type::T_INTERPOLATE:
                return [Type::T_KEYWORD, $this->CompileValue($arg)];

            case Type::T_FUNCTION:
                if (! \in_array($arg[1], $allowed_function)) {
                    return false;
                }
                if ($arg[2][0] === Type::T_LIST) {
                    foreach ($arg[2][2] as $k => $subarg) {
                        $arg[2][2][$k] = $this->cssValidArg($subarg, $allowed_function, $arg[1]);
                        if ($arg[2][2][$k] === false) {
                            return false;
                        }
                    }
                }
                return $arg;

            case Type::T_FUNCTION_CALL:
                if (! \in_array($arg[1], $allowed_function)) {
                    return false;
                }
                $cssArgs = [];
                foreach ($arg[2] as $argValue) {
                    if ($argValue === self::$null) {
                        return false;
                    }
                    $cssArg = $this->cssValidArg($argValue[1], $allowed_function, $arg[1]);
                    if (empty($argValue[0]) && $cssArg !== false) {
                        $cssArgs[] = [$argValue[0], $cssArg];
                    } else {
                        return false;
                    }
                }

                return $this->fncall([Type::T_FUNCTION, $arg[1], [Type::T_LIST, ',', []]], $cssArgs);

            case Type::T_STRING:
            case Type::T_KEYWORD:
                if (!$inFunction or !\in_array($inFunction, ['calc', 'env', 'var'])) {
                    return false;
                }
                return $this->stringifyFncallArgs($arg);

            case Type::T_LIST:
                if (!$inFunction) {
                    return false;
                }
                if (empty($arg['enclosing']) and $arg[1] === '') {
                    foreach ($arg[2] as $k => $subarg) {
                        $arg[2][$k] = $this->cssValidArg($subarg, $allowed_function, $inFunction);
                        if ($arg[2][$k] === false) {
                            return false;
                        }
                    }
                    $arg[0] = Type::T_STRING;
                    return $arg;
                }
                return false;

            case Type::T_EXPRESSION:
                if (! \in_array($arg[1], ['+', '-', '/', '*'])) {
                    return false;
                }
                $arg[2] = $this->cssValidArg($arg[2], $allowed_function, $inFunction);
                $arg[3] = $this->cssValidArg($arg[3], $allowed_function, $inFunction);
                if ($arg[2] === false || $arg[3] === false) {
                    return false;
                }
                return $this->expToString($arg, true);

            case Type::T_VARIABLE:
            case Type::T_SELF:
            default:
                return false;
        }
    }


    /**
     * Reformat fncall arguments to proper css function output
     *
     * @param array|Number $arg
     *
     * @return array|Number
     */
    private function stringifyFncallArgs($arg)
    {
        if ($arg instanceof Number) {
            return $arg;
        }

        switch ($arg[0]) {
            case Type::T_LIST:
                foreach ($arg[2] as $k => $v) {
                    $arg[2][$k] = $this->stringifyFncallArgs($v);
                }
                break;

            case Type::T_EXPRESSION:
                if ($arg[1] === '/') {
                    $arg[2] = $this->stringifyFncallArgs($arg[2]);
                    $arg[3] = $this->stringifyFncallArgs($arg[3]);
                    $arg[5] = $arg[6] = false; // no space around /
                    $arg = $this->expToString($arg);
                }
                break;

            case Type::T_FUNCTION_CALL:
                $name = strtolower($arg[1]);

                if (in_array($name, ['max', 'min', 'calc'])) {
                    $args = $arg[2];
                    $arg = $this->fncall([Type::T_FUNCTION, $name, [Type::T_LIST, ',', []]], $args);
                }
                break;
        }

        return $arg;
    }

    /**
     * Find a function reference
     * @param string $name
     * @param bool $safeCopy
     * @return array
     */
    private function getFunctionReference(string $name, bool $safeCopy = false): array
    {
        // SCSS @function
        if ($func = $this->get(self::$namespaces['function'] . $name, false)) {
            if ($safeCopy) {
                $func = clone $func;
            }

            return [Type::T_FUNCTION_REFERENCE, 'scss', $name, $func];
        }

        // native PHP functions

        // try to find a native lib function
        $normalizedName = $this->normalizeName($name);

        if (isset($this->userFunctions[$normalizedName])) {
            // see if we can find a user function
            list($f, $prototype) = $this->userFunctions[$normalizedName];

            return [Type::T_FUNCTION_REFERENCE, 'user', $name, $f, $prototype];
        }

        $lowercasedName = strtolower($normalizedName);

        // Special functions overriding a CSS function are case-insensitive. We normalize them as lowercase
        // to avoid the deprecation warning about the wrong case being used.
        if ($lowercasedName === 'min' || $lowercasedName === 'max') {
            $normalizedName = $lowercasedName;
        }

        if (($f = $this->getBuiltinFunction($normalizedName)) && \is_callable($f)) {
            /** @var string $libName */
            $libName   = $f[1];
            $prototype = self::$$libName;

            return [Type::T_FUNCTION_REFERENCE, 'native', $name, $f, $prototype];
        }

        return self::$null;
    }


    /**
     * Normalize name
     *
     * @param string $name
     *
     * @return string
     */
    private function normalizeName(string $name): string
    {
        return str_replace('-', '_', $name);
    }

    /**
     * Normalize value
     *
     * @param array|Number $value
     *
     * @return array|Number
     */
    private function normalizeValue($value)
    {
        $value = $this->coerceForExpression($this->reduce($value));

        if ($value instanceof Number) {
            return $value;
        }

        switch ($value[0]) {
            case Type::T_LIST:
                $value = $this->extractInterpolation($value);

                if ($value[0] !== Type::T_LIST) {
                    return [Type::T_KEYWORD, $this->compileValue($value)];
                }

                foreach ($value[2] as $key => $item) {
                    $value[2][$key] = $this->normalizeValue($item);
                }

                if (! empty($value['enclosing'])) {
                    unset($value['enclosing']);
                }

                if ($value[1] === '' && count($value[2]) > 1) {
                    $value[1] = ' ';
                }

                return $value;

            case Type::T_STRING:
                return [$value[0], '"', [$this->compileStringContent($value)]];

            case Type::T_INTERPOLATE:
                return [Type::T_KEYWORD, $this->compileValue($value)];

            default:
                return $value;
        }
    }

    /**
     * Add numbers
     *
     * @param Number $left
     * @param Number $right
     *
     * @return Number
     */
    private function opAddNumberNumber(Number $left, Number $right): Number
    {
        return $left->plus($right);
    }

    /**
     * Multiply numbers
     *
     * @param Number $left
     * @param Number $right
     *
     * @return Number
     */
    private function opMulNumberNumber(Number $left, Number $right): Number
    {
        return $left->times($right);
    }

    /**
     * Subtract numbers
     *
     * @param Number $left
     * @param Number $right
     *
     * @return Number
     */
    private function opSubNumberNumber(Number $left, Number $right): Number
    {
        return $left->minus($right);
    }

    /**
     * Divide numbers
     *
     * @param Number $left
     * @param Number $right
     *
     * @return Number
     */
    private function opDivNumberNumber(Number $left, Number $right): Number
    {
        return $left->dividedBy($right);
    }

    /**
     * Mod numbers
     *
     * @param Number $left
     * @param Number $right
     *
     * @return Number
     */
    private function opModNumberNumber(Number $left, Number $right): Number
    {
        return $left->modulo($right);
    }

    /**
     * Add strings
     *
     * @param array|Number $left
     * @param array|Number $right
     *
     * @return array|null
     */
    private function opAdd($left, $right)
    {
        if ($strLeft = $this->coerceString($left)) {
            if ($right[0] === Type::T_STRING) {
                $right[1] = '';
            }

            $strLeft[2][] = $right;

            return $strLeft;
        }

        if ($strRight = $this->coerceString($right)) {
            if ($left[0] === Type::T_STRING) {
                $left[1] = '';
            }

            array_unshift($strRight[2], $left);

            return $strRight;
        }

        return null;
    }

    /**
     * Boolean and
     *
     * @param array|Number $left
     * @param array|Number $right
     * @param bool         $shouldEval
     *
     * @return array|Number|null
     */
    private function opAnd($left, $right, bool $shouldEval)
    {
        $truthy = ($left === self::$null || $right === self::$null) ||
                  ($left === self::$false || $left === self::$true) &&
                  ($right === self::$false || $right === self::$true);

        if (! $shouldEval) {
            if (! $truthy) {
                return null;
            }
        }

        if ($left !== self::$false && $left !== self::$null) {
            return $this->reduce($right, true);
        }

        return $left;
    }

    /**
     * Boolean or
     *
     * @param array|Number $left
     * @param array|Number $right
     * @param bool         $shouldEval
     *
     * @return array|Number|null
     */
    private function opOr($left, $right, bool $shouldEval)
    {
        $truthy = ($left === self::$null || $right === self::$null) ||
                  ($left === self::$false || $left === self::$true) &&
                  ($right === self::$false || $right === self::$true);

        if (! $shouldEval) {
            if (! $truthy) {
                return null;
            }
        }

        if ($left !== self::$false && $left !== self::$null) {
            return $left;
        }

        return $this->reduce($right, true);
    }

    /**
     * Compare colors
     *
     * @param string $op
     * @param array  $left
     * @param array  $right
     *
     * @return array
     */
    private function opColorColor(string $op, $left, $right)
    {
        switch ($op) {
            case '==':
                return $this->opEq($left, $right);

            case '!=':
                return $this->opNeq($left, $right);

            default:
                $leftValue = $this->compileValue($left);
                $rightValue = $this->compileValue($right);

                throw new SassScriptException("Unsupported operation \"$leftValue $op $rightValue\".");
        }
    }

    /**
     * Compare color and number
     *
     * @param string $op
     * @param array  $left
     * @param Number  $right
     *
     * @return array
     */
    private function opColorNumber(string $op, $left, Number $right)
    {
        if ($op === '==') {
            return self::$false;
        }

        if ($op === '!=') {
            return self::$true;
        }

        $leftValue = $this->compileValue($left);
        $rightValue = $this->compileValue($right);

        throw new SassScriptException("Unsupported operation \"$leftValue $op $rightValue\".");
    }

    /**
     * Compare number and color
     *
     * @param string $op
     * @param Number  $left
     * @param array  $right
     *
     * @return array
     */
    private function opNumberColor(string $op, Number $left, $right)
    {
        if ($op === '==') {
            return self::$false;
        }

        if ($op === '!=') {
            return self::$true;
        }

        $leftValue = $this->compileValue($left);
        $rightValue = $this->compileValue($right);

        throw new SassScriptException("Unsupported operation \"$leftValue $op $rightValue\".");
    }

    /**
     * Compare number1 == number2
     *
     * @param array|Number $left
     * @param array|Number $right
     *
     * @return array
     */
    private function opEq($left, $right)
    {
        if (($lStr = $this->coerceString($left)) && ($rStr = $this->coerceString($right))) {
            $lStr[1] = '';
            $rStr[1] = '';

            $left = $this->compileValue($lStr);
            $right = $this->compileValue($rStr);
        }

        return $this->toBool($left === $right);
    }

    /**
     * Compare number1 != number2
     *
     * @param array|Number $left
     * @param array|Number $right
     *
     * @return array
     */
    private function opNeq($left, $right)
    {
        if (($lStr = $this->coerceString($left)) && ($rStr = $this->coerceString($right))) {
            $lStr[1] = '';
            $rStr[1] = '';

            $left = $this->compileValue($lStr);
            $right = $this->compileValue($rStr);
        }

        return $this->toBool($left !== $right);
    }

    /**
     * Compare number1 == number2
     *
     * @param Number $left
     * @param Number $right
     *
     * @return array
     */
    private function opEqNumberNumber(Number $left, Number $right)
    {
        return $this->toBool($left->equals($right));
    }

    /**
     * Compare number1 != number2
     *
     * @param Number $left
     * @param Number $right
     *
     * @return array
     */
    private function opNeqNumberNumber(Number $left, Number $right)
    {
        return $this->toBool(!$left->equals($right));
    }

    /**
     * Compare number1 >= number2
     *
     * @param Number $left
     * @param Number $right
     *
     * @return array
     */
    private function opGteNumberNumber(Number $left, Number $right)
    {
        return $this->toBool($left->greaterThanOrEqual($right));
    }

    /**
     * Compare number1 > number2
     *
     * @param Number $left
     * @param Number $right
     *
     * @return array
     */
    private function opGtNumberNumber(Number $left, Number $right)
    {
        return $this->toBool($left->greaterThan($right));
    }

    /**
     * Compare number1 <= number2
     *
     * @param Number $left
     * @param Number $right
     *
     * @return array
     */
    private function opLteNumberNumber(Number $left, Number $right)
    {
        return $this->toBool($left->lessThanOrEqual($right));
    }

    /**
     * Compare number1 < number2
     *
     * @param Number $left
     * @param Number $right
     *
     * @return array
     */
    private function opLtNumberNumber(Number $left, Number $right)
    {
        return $this->toBool($left->lessThan($right));
    }

    /**
     * Cast to boolean
     *
     * @param bool $thing
     *
     * @return array
     */
    public function toBool(bool $thing)
    {
        return $thing ? self::$true : self::$false;
    }

    /**
     * Escape non printable chars in strings output as in dart-sass
     *
     * @param string $string
     * @param bool   $inKeyword
     *
     * @return string
     */
    private function escapeNonPrintableChars(string $string, bool $inKeyword = false): string
    {
        static $replacement = [];
        if (empty($replacement[$inKeyword])) {
            for ($i = 0; $i < 32; $i++) {
                if ($i !== 9 || $inKeyword) {
                    $replacement[$inKeyword][chr($i)] = '\\' . dechex($i) . ($inKeyword ? ' ' : chr(0));
                }
            }
        }
        $string = str_replace(array_keys($replacement[$inKeyword]), array_values($replacement[$inKeyword]), $string);
        // chr(0) is not a possible char from the input, so any chr(0) comes from our escaping replacement
        if (strpos($string, chr(0)) !== false) {
            if (substr($string, -1) === chr(0)) {
                $string = substr($string, 0, -1);
            }
            $string = str_replace(
                [chr(0) . '\\',chr(0) . ' '],
                [ '\\', ' '],
                $string
            );
            if (strpos($string, chr(0)) !== false) {
                $parts = explode(chr(0), $string);
                $string = array_shift($parts);
                while (count($parts)) {
                    $next = array_shift($parts);
                    if (strpos("0123456789abcdefABCDEF" . chr(9), $next[0]) !== false) {
                        $string .= " ";
                    }
                    $string .= $next;
                }
            }
        }

        return $string;
    }

    /**
     * Compiles a primitive value into a CSS property value.
     *
     * Values in scssphp are typed by being wrapped in arrays, their format is
     * typically:
     *
     *     array(type, contents [, additional_contents]*)
     *
     * The input is expected to be reduced. This function will not work on
     * things like expressions and variables.
     *
     * @param array|Number $value
     * @param bool         $quote
     *
     * @return string
     */
    public function compileValue($value, bool $quote = true): string
    {
        $value = $this->reduce($value);

        if ($value instanceof Number) {
            return $value->output($this);
        }

        switch ($value[0]) {
            case Type::T_KEYWORD:
                return $this->escapeNonPrintableChars($value[1], true);

            case Type::T_COLOR:
                // [1] - red component (either number for a %)
                // [2] - green component
                // [3] - blue component
                // [4] - optional alpha component
                list(, $r, $g, $b) = $value;

                $r = $this->compileRGBAValue($r);
                $g = $this->compileRGBAValue($g);
                $b = $this->compileRGBAValue($b);

                if (\count($value) === 5) {
                    $alpha = $this->compileRGBAValue($value[4], true);

                    if (! is_numeric($alpha) || $alpha < 1) {
                        $colorName = Colors::RGBaToColorName($r, $g, $b, $alpha);

                        if (! \is_null($colorName)) {
                            return $colorName;
                        }

                        if (is_numeric($alpha)) {
                            $a = new Number($alpha, '');
                        } else {
                            $a = $alpha;
                        }

                        return 'rgba(' . $r . ', ' . $g . ', ' . $b . ', ' . $a . ')';
                    }
                }

                if (! is_numeric($r) || ! is_numeric($g) || ! is_numeric($b)) {
                    return 'rgb(' . $r . ', ' . $g . ', ' . $b . ')';
                }

                $colorName = Colors::RGBaToColorName($r, $g, $b);

                if (! \is_null($colorName)) {
                    return $colorName;
                }

                $h = sprintf('#%02x%02x%02x', $r, $g, $b);

                // Converting hex color to short notation (e.g. #003399 to #039)
                if ($h[1] === $h[2] && $h[3] === $h[4] && $h[5] === $h[6]) {
                    $h = '#' . $h[1] . $h[3] . $h[5];
                }

                return $h;

            case Type::T_STRING:
                $content = $this->compileStringContent($value, $quote);

                if ($value[1] && $quote) {
                    $content = str_replace('\\', '\\\\', $content);

                    $content = $this->escapeNonPrintableChars($content);

                    // force double quote as string quote for the output in certain cases
                    if (
                        $value[1] === "'" &&
                        (strpos($content, '"') === false or strpos($content, "'") !== false)
                    ) {
                        $value[1] = '"';
                    } elseif (
                        $value[1] === '"' &&
                        (strpos($content, '"') !== false and strpos($content, "'") === false)
                    ) {
                        $value[1] = "'";
                    }

                    $content = str_replace($value[1], '\\' . $value[1], $content);
                }

                return $value[1] . $content . $value[1];

            case Type::T_FUNCTION:
                $args = ! empty($value[2]) ? $this->compileValue($value[2], $quote) : '';

                return "$value[1]($args)";

            case Type::T_FUNCTION_REFERENCE:
                $name = ! empty($value[2]) ? $value[2] : '';

                return "get-function(\"$name\")";

            case Type::T_LIST:
                $value = $this->extractInterpolation($value);

                if ($value[0] !== Type::T_LIST) {
                    return $this->compileValue($value, $quote);
                }

                list(, $delim, $items) = $value;
                $pre = $post = '';

                if (! empty($value['enclosing'])) {
                    switch ($value['enclosing']) {
                        case 'parent':
                            //$pre = '(';
                            //$post = ')';
                            break;
                        case 'forced_parent':
                            $pre = '(';
                            $post = ')';
                            break;
                        case 'bracket':
                        case 'forced_bracket':
                            $pre = '[';
                            $post = ']';
                            break;
                    }
                }

                $separator = $delim === '/' ? ' /' : $delim;

                $prefix_value = '';

                if ($delim !== ' ') {
                    $prefix_value = ' ';
                }

                $filtered = [];

                $same_string_quote = null;
                foreach ($items as $item) {
                    if (\is_null($same_string_quote)) {
                        $same_string_quote = false;
                        if ($item[0] === Type::T_STRING) {
                            $same_string_quote = $item[1];
                            foreach ($items as $ii) {
                                if ($ii[0] !== Type::T_STRING) {
                                    $same_string_quote = false;
                                    break;
                                }
                            }
                        }
                    }
                    if ($item[0] === Type::T_NULL) {
                        continue;
                    }
                    if ($same_string_quote === '"' && $item[0] === Type::T_STRING && $item[1]) {
                        $item[1] = $same_string_quote;
                    }

                    $compiled = $this->compileValue($item, $quote);

                    if ($prefix_value && \strlen($compiled)) {
                        $compiled = $prefix_value . $compiled;
                    }

                    $filtered[] = $compiled;
                }

                return $pre . substr(implode($separator, $filtered), \strlen($prefix_value)) . $post;

            case Type::T_MAP:
                $keys     = $value[1];
                $values   = $value[2];
                $filtered = [];

                for ($i = 0, $s = \count($keys); $i < $s; $i++) {
                    $filtered[$this->compileValue($keys[$i], $quote)] = $this->compileValue($values[$i], $quote);
                }

                array_walk($filtered, function (&$value, $key) {
                    $value = $key . ': ' . $value;
                });

                return '(' . implode(', ', $filtered) . ')';

            case Type::T_INTERPOLATED:
                // node created by extractInterpolation
                list(, $interpolate, $left, $right) = $value;
                list(,, $whiteLeft, $whiteRight) = $interpolate;

                $delim = $left[1];

                if ($delim && $delim !== ' ' && ! $whiteLeft) {
                    $delim .= ' ';
                }

                $left = \count($left[2]) > 0
                    ?  $this->compileValue($left, $quote) . $delim . $whiteLeft
                    : '';

                $delim = $right[1];

                if ($delim && $delim !== ' ') {
                    $delim .= ' ';
                }

                $right = \count($right[2]) > 0 ?
                    $whiteRight . $delim . $this->compileValue($right, $quote) : '';

                return $left . $this->compileValue($interpolate, $quote) . $right;

            case Type::T_INTERPOLATE:
                // strip quotes if it's a string
                $reduced = $this->reduce($value[1]);

                if ($reduced instanceof Number) {
                    return $this->compileValue($reduced, $quote);
                }

                switch ($reduced[0]) {
                    case Type::T_LIST:
                        $reduced = $this->extractInterpolation($reduced);

                        if ($reduced[0] !== Type::T_LIST) {
                            break;
                        }

                        list(, $delim, $items) = $reduced;

                        if ($delim !== ' ') {
                            $delim .= ' ';
                        }

                        $filtered = [];

                        foreach ($items as $item) {
                            if ($item[0] === Type::T_NULL) {
                                continue;
                            }

                            if ($item[0] === Type::T_STRING) {
                                $filtered[] = $this->compileStringContent($item, $quote);
                            } elseif ($item[0] === Type::T_KEYWORD) {
                                $filtered[] = $item[1];
                            } else {
                                $filtered[] = $this->compileValue($item, $quote);
                            }
                        }

                        $reduced = [Type::T_KEYWORD, implode("$delim", $filtered)];
                        break;

                    case Type::T_STRING:
                        $reduced = [Type::T_STRING, '', [$this->compileStringContent($reduced)]];
                        break;

                    case Type::T_NULL:
                        $reduced = [Type::T_KEYWORD, ''];
                }

                return $this->compileValue($reduced, $quote);

            case Type::T_NULL:
                return 'null';

            case Type::T_COMMENT:
                return $this->compileCommentValue($value);

            default:
                throw $this->error('unknown value type: ' . json_encode($value));
        }
    }

    /**
     * @param array|Number $value
     *
     * @return string
     */
    private function compileDebugValue($value): string
    {
        $value = $this->reduce($value, true);

        if ($value instanceof Number) {
            return $this->compileValue($value);
        }

        switch ($value[0]) {
            case Type::T_STRING:
                return $this->compileStringContent($value);

            default:
                return $this->compileValue($value);
        }
    }

    /**
     * Gets the text of a Sass string
     *
     * Calling this method on anything else than a SassString is unsupported. Use {@see assertString} first
     * to ensure that the value is indeed a string.
     *
     * @param array $value
     *
     * @return string
     */
    public function getStringText(array $value): string
    {
        if ($value[0] !== Type::T_STRING) {
            throw new \InvalidArgumentException('The argument is not a sass string. Did you forgot to use "assertString"?');
        }

        return $this->compileStringContent($value);
    }

    /**
     * Compile string content
     *
     * @param array $string
     * @param bool  $quote
     *
     * @return string
     */
    private function compileStringContent($string, bool $quote = true): string
    {
        $parts = [];

        foreach ($string[2] as $part) {
            if (\is_array($part) || $part instanceof Number) {
                $parts[] = $this->compileValue($part, $quote);
            } else {
                $parts[] = $part;
            }
        }

        return implode($parts);
    }

    /**
     * Extract interpolation; it doesn't need to be recursive, compileValue will handle that
     *
     * @param array $list
     *
     * @return array
     */
    private function extractInterpolation($list)
    {
        $items = $list[2];

        foreach ($items as $i => $item) {
            if ($item[0] === Type::T_INTERPOLATE) {
                $before = [Type::T_LIST, $list[1], \array_slice($items, 0, $i)];
                $after  = [Type::T_LIST, $list[1], \array_slice($items, $i + 1)];

                return [Type::T_INTERPOLATED, $item, $before, $after];
            }
        }

        return $list;
    }

    /**
     * Find the final set of selectors
     *
     * @param Environment $env
     * @param Block       $selfParent
     *
     * @return array
     */
    private function multiplySelectors(Environment $env, ?Block $selfParent = null): array
    {
        $envs            = $this->compactEnv($env);
        $selectors       = [];
        $parentSelectors = [[]];

        $selfParentSelectors = null;

        if (! \is_null($selfParent) && $selfParent->selectors) {
            $selfParentSelectors = $this->evalSelectors($selfParent->selectors);
        }

        while ($env = array_pop($envs)) {
            if (empty($env->selectors)) {
                continue;
            }

            $selectors = $env->selectors;

            do {
                $stillHasSelf  = false;
                $prevSelectors = $selectors;
                $selectors     = [];

                foreach ($parentSelectors as $parent) {
                    foreach ($prevSelectors as $selector) {
                        if ($selfParentSelectors) {
                            foreach ($selfParentSelectors as $selfParent) {
                                // if no '&' in the selector, each call will give same result, only add once
                                $s = $this->joinSelectors($parent, $selector, $stillHasSelf, $selfParent);
                                $selectors[serialize($s)] = $s;
                            }
                        } else {
                            $s = $this->joinSelectors($parent, $selector, $stillHasSelf);
                            $selectors[serialize($s)] = $s;
                        }
                    }
                }
            } while ($stillHasSelf);

            $parentSelectors = $selectors;
        }

        $selectors = array_values($selectors);

        // case we are just starting a at-root : nothing to multiply but parentSelectors
        if (! $selectors && $selfParentSelectors) {
            $selectors = $selfParentSelectors;
        }

        return $selectors;
    }

    /**
     * Join selectors; looks for & to replace, or append parent before child
     *
     * @param array $parent
     * @param array $child
     * @param bool  $stillHasSelf
     * @param array $selfParentSelectors

     * @return array
     */
    private function joinSelectors(array $parent, array $child, &$stillHasSelf, ?array $selfParentSelectors = null)
    {
        $setSelf = false;
        $out = [];

        foreach ($child as $part) {
            $newPart = [];

            foreach ($part as $p) {
                // only replace & once and should be recalled to be able to make combinations
                if ($p === self::$selfSelector && $setSelf) {
                    $stillHasSelf = true;
                }

                if ($p === self::$selfSelector && ! $setSelf) {
                    $setSelf = true;

                    if (\is_null($selfParentSelectors)) {
                        $selfParentSelectors = $parent;
                    }

                    foreach ($selfParentSelectors as $i => $parentPart) {
                        if ($i > 0) {
                            $out[] = $newPart;
                            $newPart = [];
                        }

                        foreach ($parentPart as $pp) {
                            if (\is_array($pp)) {
                                $flatten = [];

                                array_walk_recursive($pp, function ($a) use (&$flatten) {
                                    $flatten[] = $a;
                                });

                                $pp = implode($flatten);
                            }

                            $newPart[] = $pp;
                        }
                    }
                } else {
                    $newPart[] = $p;
                }
            }

            $out[] = $newPart;
        }

        return $setSelf ? $out : array_merge($parent, $child);
    }

    /**
     * Multiply media
     *
     * @param Environment $env
     * @param array|null  $childQueries
     *
     * @return array
     */
    private function multiplyMedia(Environment $env = null, ?array $childQueries = null): array
    {
        if (
            ! isset($env) ||
            ! empty($env->block->type) && $env->block->type !== Type::T_MEDIA
        ) {
            return $childQueries;
        }

        // plain old block, skip
        if (empty($env->block->type)) {
            return $this->multiplyMedia($env->parent, $childQueries);
        }

        assert($env->block instanceof MediaBlock);

        $parentQueries = isset($env->block->queryList)
            ? $env->block->queryList
            : [[[Type::T_MEDIA_VALUE, $env->block->value]]];

        $store = [$this->env, $this->storeEnv];

        $this->env      = $env;
        $this->storeEnv = null;
        $parentQueries  = $this->evaluateMediaQuery($parentQueries);

        list($this->env, $this->storeEnv) = $store;

        if (\is_null($childQueries)) {
            $childQueries = $parentQueries;
        } else {
            $originalQueries = $childQueries;
            $childQueries = [];

            foreach ($parentQueries as $parentQuery) {
                foreach ($originalQueries as $childQuery) {
                    $childQueries[] = array_merge(
                        $parentQuery,
                        [[Type::T_MEDIA_TYPE, [Type::T_KEYWORD, 'all']]],
                        $childQuery
                    );
                }
            }
        }

        return $this->multiplyMedia($env->parent, $childQueries);
    }

    /**
     * Convert env linked list to stack
     *
     * @param Environment $env
     *
     * @return Environment[]
     *
     * @phpstan-return non-empty-array<Environment>
     */
    private function compactEnv(Environment $env)
    {
        for ($envs = []; $env; $env = $env->parent) {
            $envs[] = $env;
        }

        return $envs;
    }

    /**
     * Convert env stack to singly linked list
     *
     * @param Environment[] $envs
     *
     * @return Environment
     *
     * @phpstan-param  non-empty-array<Environment> $envs
     */
    private function extractEnv(array $envs): Environment
    {
        for ($env = null; $e = array_pop($envs);) {
            $e->parent = $env;
            $env = $e;
        }

        return $env;
    }

    /**
     * Push environment
     *
     * @param Block $block
     *
     * @return Environment
     */
    private function pushEnv(Block $block = null): Environment
    {
        $env = new Environment();
        $env->parent = $this->env;
        $env->parentStore = $this->storeEnv;
        $env->store  = [];
        $env->block  = $block;
        $env->depth  = isset($this->env->depth) ? $this->env->depth + 1 : 0;

        $this->env = $env;
        $this->storeEnv = null;

        return $env;
    }

    /**
     * Pop environment
     *
     * @return void
     */
    private function popEnv(): void
    {
        $this->storeEnv = $this->env->parentStore;
        $this->env = $this->env->parent;
    }

    /**
     * Propagate vars from a just poped Env (used in @each and @for)
     *
     * @param array         $store
     * @param null|string[] $excludedVars
     *
     * @return void
     */
    private function backPropagateEnv(array $store, ?array $excludedVars = null): void
    {
        foreach ($store as $key => $value) {
            if (empty($excludedVars) || ! \in_array($key, $excludedVars)) {
                $this->set($key, $value, true);
            }
        }
    }

    /**
     * Get store environment
     *
     * @return Environment
     */
    private function getStoreEnv(): Environment
    {
        return isset($this->storeEnv) ? $this->storeEnv : $this->env;
    }

    /**
     * Set variable
     *
     * @param string                                $name
     * @param mixed                                 $value
     * @param bool                                  $shadow
     * @param Environment $env
     * @param mixed                                 $valueUnreduced
     *
     * @return void
     */
    private function set(string $name, $value, bool $shadow = false, Environment $env = null, $valueUnreduced = null): void
    {
        $name = $this->normalizeName($name);

        if (! isset($env)) {
            $env = $this->getStoreEnv();
        }

        if ($shadow) {
            $this->setRaw($name, $value, $env, $valueUnreduced);
        } else {
            $this->setExisting($name, $value, $env, $valueUnreduced);
        }
    }

    /**
     * Set existing variable
     *
     * @param string                                $name
     * @param mixed                                 $value
     * @param Environment $env
     * @param mixed                                 $valueUnreduced
     *
     * @return void
     */
    private function setExisting(string $name, $value, Environment $env, $valueUnreduced = null): void
    {
        $storeEnv = $env;
        $specialContentKey = self::$namespaces['special'] . 'content';

        $hasNamespace = $name[0] === '^' || $name[0] === '@' || $name[0] === '%';

        $maxDepth = 10000;

        for (;;) {
            if ($maxDepth-- <= 0) {
                break;
            }

            if (\array_key_exists($name, $env->store)) {
                break;
            }

            if (! $hasNamespace && isset($env->marker)) {
                if (! empty($env->store[$specialContentKey])) {
                    $env = $env->store[$specialContentKey]->scope;
                    continue;
                }

                if (! empty($env->declarationScopeParent)) {
                    $env = $env->declarationScopeParent;
                    continue;
                } else {
                    $env = $storeEnv;
                    break;
                }
            }

            if (isset($env->parentStore)) {
                $env = $env->parentStore;
            } elseif (isset($env->parent)) {
                $env = $env->parent;
            } else {
                $env = $storeEnv;
                break;
            }
        }

        $env->store[$name] = $value;

        if ($valueUnreduced) {
            $env->storeUnreduced[$name] = $valueUnreduced;
        }
    }

    /**
     * Set raw variable
     *
     * @param string      $name
     * @param mixed       $value
     * @param Environment $env
     * @param mixed       $valueUnreduced
     *
     * @return void
     */
    private function setRaw(string $name, $value, Environment $env, $valueUnreduced = null): void
    {
        $env->store[$name] = $value;

        if ($valueUnreduced) {
            $env->storeUnreduced[$name] = $valueUnreduced;
        }
    }

    /**
     * Get variable
     *
     * @param string           $name
     * @param bool             $shouldThrow
     * @param Environment|null $env
     * @param bool             $unreduced
     *
     * @return mixed|null
     */
    private function get(string $name, bool $shouldThrow = true, ?Environment $env = null, bool $unreduced = false)
    {
        $normalizedName = $this->normalizeName($name);
        $specialContentKey = self::$namespaces['special'] . 'content';

        if (! isset($env)) {
            $env = $this->getStoreEnv();
        }

        $hasNamespace = $normalizedName[0] === '^' || $normalizedName[0] === '@' || $normalizedName[0] === '%';

        $maxDepth = 10000;

        for (;;) {
            if ($maxDepth-- <= 0) {
                break;
            }

            if (\array_key_exists($normalizedName, $env->store)) {
                if ($unreduced && isset($env->storeUnreduced[$normalizedName])) {
                    return $env->storeUnreduced[$normalizedName];
                }

                return $env->store[$normalizedName];
            }

            if (! $hasNamespace && isset($env->marker)) {
                if (! empty($env->store[$specialContentKey])) {
                    $env = $env->store[$specialContentKey]->scope;
                    continue;
                }

                if (! empty($env->declarationScopeParent)) {
                    $env = $env->declarationScopeParent;
                } else {
                    $env = $this->rootEnv;
                }
                continue;
            }

            if (isset($env->parentStore)) {
                $env = $env->parentStore;
            } elseif (isset($env->parent)) {
                $env = $env->parent;
            } else {
                break;
            }
        }

        if ($shouldThrow) {
            throw $this->error("Undefined variable \$$name" . ($maxDepth <= 0 ? ' (infinite recursion)' : ''));
        }

        // found nothing
        return null;
    }

    /**
     * Has variable?
     *
     * @param string           $name
     * @param Environment|null $env
     *
     * @return bool
     */
    private function has(string $name, Environment $env = null): bool
    {
        return ! \is_null($this->get($name, false, $env));
    }

    /**
     * Inject variables
     *
     * @param array $args
     *
     * @return void
     */
    private function injectVariables(array $args): void
    {
        if (empty($args)) {
            return;
        }

        $parser = $this->parserFactory(__METHOD__);

        foreach ($args as $name => $strValue) {
            if ($name[0] === '$') {
                $name = substr($name, 1);
            }

            if (!\is_string($strValue) || ! $parser->parseValue($strValue, $value)) {
                $value = $this->coerceValue($strValue);
            }

            $this->set($name, $value);
        }
    }

    /**
     * Replaces variables.
     *
     * @param array<string, mixed> $variables
     *
     * @return void
     */
    public function replaceVariables(array $variables): void
    {
        $this->registeredVars = [];
        $this->addVariables($variables);
    }

    /**
     * Replaces variables.
     *
     * @param array<string, mixed> $variables
     *
     * @return void
     */
    public function addVariables(array $variables): void
    {
        foreach ($variables as $name => $value) {
            if (!$value instanceof Number && !\is_array($value)) {
                throw new \InvalidArgumentException('Passing raw values to as custom variables to the Compiler is not supported anymore. Use "\ScssPhp\ScssPhp\ValueConverter::parseValue" or "\ScssPhp\ScssPhp\ValueConverter::fromPhp" to convert them instead.');
            }

            $this->registeredVars[$name] = $value;
        }
    }

    /**
     * Unset variable
     *
     * @param string $name
     *
     * @return void
     */
    public function unsetVariable(string $name): void
    {
        unset($this->registeredVars[$name]);
    }

    /**
     * Returns list of variables
     *
     * @return array
     */
    public function getVariables(): array
    {
        return $this->registeredVars;
    }

    /**
     * Adds to list of parsed files
     *
     * @param string|null $path
     *
     * @return void
     */
    private function addParsedFile(?string $path): void
    {
        if (! \is_null($path) && is_file($path)) {
            $this->parsedFiles[realpath($path)] = filemtime($path);
        }
    }

    /**
     * Add import path
     *
     * @param string|callable $path
     *
     * @return void
     */
    public function addImportPath($path): void
    {
        if (! \in_array($path, $this->importPaths)) {
            $this->importPaths[] = $path;
        }
    }

    /**
     * Set import paths
     *
     * @param string|array<string|callable> $path
     *
     * @return void
     */
    public function setImportPaths($path): void
    {
        $paths = (array) $path;
        $actualImportPaths = array_filter($paths, function ($path) {
            return $path !== '';
        });

        if (\count($actualImportPaths) !== \count($paths)) {
            throw new \InvalidArgumentException('Passing an empty string in the import paths to refer to the current working directory is not supported anymore. If that\'s the intended behavior, the value of "getcwd()" should be used directly instead. If this was used for resolving relative imports of the input alongside "chdir" with the source directory, the path of the input file should be passed to "compileString()" instead.');
        }

        $this->importPaths = $actualImportPaths;
    }

    /**
     * Sets the output style.
     *
     * @param string $style One of the OutputStyle constants
     *
     * @return void
     *
     * @phpstan-param OutputStyle::* $style
     */
    public function setOutputStyle(string $style): void
    {
        switch ($style) {
            case OutputStyle::EXPANDED:
            case OutputStyle::COMPRESSED:
                $this->outputStyle = $style;
                break;

            default:
                throw new \InvalidArgumentException(sprintf('Invalid output style "%s".', $style));
        }
    }

    /**
     * Configures the handling of non-ASCII outputs.
     *
     * If $charset is `true`, this will include a `@charset` declaration or a
     * UTF-8 [byte-order mark][] if the stylesheet contains any non-ASCII
     * characters. Otherwise, it will never include a `@charset` declaration or a
     * byte-order mark.
     *
     * [byte-order mark]: https://en.wikipedia.org/wiki/Byte_order_mark#UTF-8
     */
    public function setCharset(bool $charset): void
    {
        $this->charset = $charset;
    }

    /**
     * Enable/disable source maps
     *
     * @param int $sourceMap
     *
     * @return void
     *
     * @phpstan-param self::SOURCE_MAP_* $sourceMap
     */
    public function setSourceMap(int $sourceMap): void
    {
        $this->sourceMap = $sourceMap;
    }

    /**
     * Set source map options
     *
     * @param array $sourceMapOptions
     *
     * @phpstan-param  array{sourceRoot?: string, sourceMapFilename?: string|null, sourceMapURL?: string|null, sourceMapWriteTo?: string|null, outputSourceFiles?: bool, sourceMapRootpath?: string, sourceMapBasepath?: string} $sourceMapOptions
     *
     * @return void
     */
    public function setSourceMapOptions(array $sourceMapOptions): void
    {
        $this->sourceMapOptions = $sourceMapOptions;
    }

    /**
     * Register function
     *
     * @param string   $name
     * @param callable $callback
     * @param string[] $argumentDeclaration
     *
     * @return void
     */
    public function registerFunction(string $name, callable $callback, array $argumentDeclaration): void
    {
        if (self::isNativeFunction($name)) {
            throw new \InvalidArgumentException(sprintf('The "%s" function is a core sass function. Overriding it with a custom implementation through "%s" is not supported .', $name, __METHOD__));
        }

        $this->userFunctions[$this->normalizeName($name)] = [$callback, $argumentDeclaration];
    }

    /**
     * Unregister function
     *
     * @param string $name
     *
     * @return void
     */
    public function unregisterFunction(string $name): void
    {
        unset($this->userFunctions[$this->normalizeName($name)]);
    }

    /**
     * Import file
     *
     * @param string      $path
     * @param OutputBlock $out
     *
     * @return void
     */
    private function importFile(string $path, OutputBlock $out): void
    {
        $this->pushCallStack('import ' . $this->getPrettyPath($path));
        // see if tree is cached
        $realPath = realpath($path);

        if ($realPath === false) {
            $realPath = $path;
        }

        if (substr($path, -5) === '.sass') {
            $this->sourceIndex = \count($this->sourceNames);
            $this->sourceNames[] = $path;
            $this->sourceLine = 1;
            $this->sourceColumn = 1;

            throw $this->error('The Sass indented syntax is not implemented.');
        }

        if (isset($this->importCache[$realPath])) {
            $this->handleImportLoop($realPath);

            $tree = $this->importCache[$realPath];
        } else {
            $code   = file_get_contents($path);
            $parser = $this->parserFactory($path);
            $tree   = $parser->parse($code);

            $this->importCache[$realPath] = $tree;
        }

        $currentDirectory = $this->currentDirectory;
        $this->currentDirectory = dirname($path);

        $this->compileChildrenNoReturn($tree->children, $out);
        $this->currentDirectory = $currentDirectory;
        $this->popCallStack();
    }

    /**
     * Save the imported files with their resolving path context
     *
     * @param string|null $currentDirectory
     * @param string      $path
     * @param string      $filePath
     *
     * @return void
     */
    private function registerImport(?string $currentDirectory, string $path, string $filePath): void
    {
        $this->resolvedImports[] = ['currentDir' => $currentDirectory, 'path' => $path, 'filePath' => $filePath];
    }

    /**
     * Detects whether the import is a CSS import.
     *
     * @param string $url
     *
     * @return bool
     */
    public static function isCssImport(string $url): bool
    {
        return 1 === preg_match('~\.css$|^https?://|^//~', $url);
    }

    /**
     * Return the file path for an import url if it exists
     *
     * @param string      $url
     * @param string|null $currentDir
     *
     * @return string|null
     */
    private function findImport(string $url, ?string $currentDir = null): ?string
    {
        // Vanilla css and external requests. These are not meant to be Sass imports.
        if (self::isCssImport($url)) {
            return null;
        }

        if (!\is_null($currentDir)) {
            $relativePath = $this->resolveImportPath($url, $currentDir);

            if (!\is_null($relativePath)) {
                return $relativePath;
            }
        }

        foreach ($this->importPaths as $dir) {
            if (\is_string($dir)) {
                $path = $this->resolveImportPath($url, $dir);

                if (!\is_null($path)) {
                    return $path;
                }
            } elseif (\is_callable($dir)) {
                // check custom callback for import path
                $file = \call_user_func($dir, $url);

                if (! \is_null($file)) {
                    return $file;
                }
            }
        }

        throw $this->error("`$url` file not found for @import");
    }

    /**
     * @param string $url
     * @param string $baseDir
     *
     * @return string|null
     */
    private function resolveImportPath(string $url, string $baseDir): ?string
    {
        $path = Path::join($baseDir, $url);

        $hasExtension = preg_match('/.s[ac]ss$/', $url);

        if ($hasExtension) {
            return $this->checkImportPathConflicts($this->tryImportPath($path));
        }

        $result = $this->checkImportPathConflicts($this->tryImportPathWithExtensions($path));

        if (!\is_null($result)) {
            return $result;
        }

        return $this->tryImportPathAsDirectory($path);
    }

    /**
     * @param string[] $paths
     *
     * @return string|null
     */
    private function checkImportPathConflicts(array $paths): ?string
    {
        if (\count($paths) === 0) {
            return null;
        }

        if (\count($paths) === 1) {
            return $paths[0];
        }

        $formattedPrettyPaths = [];

        foreach ($paths as $path) {
            $formattedPrettyPaths[] = '  ' . $this->getPrettyPath($path);
        }

        throw $this->error("It's not clear which file to import. Found:\n" . implode("\n", $formattedPrettyPaths));
    }

    /**
     * @param string $path
     *
     * @return string[]
     */
    private function tryImportPathWithExtensions(string $path): array
    {
        $result = array_merge(
            $this->tryImportPath($path.'.sass'),
            $this->tryImportPath($path.'.scss')
        );

        if ($result) {
            return $result;
        }

        return $this->tryImportPath($path.'.css');
    }

    /**
     * @param string $path
     *
     * @return string[]
     */
    private function tryImportPath(string $path): array
    {
        $partial = dirname($path).'/_'.basename($path);

        $candidates = [];

        if (is_file($partial)) {
            $candidates[] = $partial;
        }

        if (is_file($path)) {
            $candidates[] = $path;
        }

        return $candidates;
    }

    /**
     * @param string $path
     *
     * @return string|null
     */
    private function tryImportPathAsDirectory(string $path): ?string
    {
        if (!is_dir($path)) {
            return null;
        }

        return $this->checkImportPathConflicts($this->tryImportPathWithExtensions($path.'/index'));
    }

    /**
     * @param string|null $path
     *
     * @return string
     */
    private function getPrettyPath(?string $path): string
    {
        if ($path === null) {
            return '(unknown file)';
        }

        $normalizedPath = $path;
        $normalizedRootDirectory = $this->rootDirectory.'/';

        if (\DIRECTORY_SEPARATOR === '\\') {
            $normalizedRootDirectory = str_replace('\\', '/', $normalizedRootDirectory);
            $normalizedPath = str_replace('\\', '/', $path);
        }

        if (0 === strpos($normalizedPath, $normalizedRootDirectory)) {
            return substr($path, \strlen($normalizedRootDirectory));
        }

        return $path;
    }

    /**
     * Build an error (exception)
     *
     * @param string                     $msg Message with optional sprintf()-style vararg parameters
     * @param bool|float|int|string|null ...$args
     *
     * @return CompilerException
     */
    private function error(string $msg, ...$args): CompilerException
    {
        if ($args) {
            $msg = sprintf($msg, ...$args);
        }

        $msg = $this->addLocationToMessage($msg);

        return new CompilerException($msg);
    }

    /**
     * @param string $msg
     *
     * @return string
     */
    private function addLocationToMessage(string $msg): string
    {
        $line   = $this->sourceLine;
        $column = $this->sourceColumn;

        $loc = isset($this->sourceNames[$this->sourceIndex])
            ? $this->getPrettyPath($this->sourceNames[$this->sourceIndex]) . " on line $line, at column $column"
            : "line: $line, column: $column";

        $msg = "$msg: $loc";

        $callStackMsg = $this->callStackMessage();

        if ($callStackMsg) {
            $msg .= "\nCall Stack:\n" . $callStackMsg;
        }

        return $msg;
    }

    /**
     * Beautify call stack for output
     *
     * @param bool     $all
     * @param int|null $limit
     *
     * @return string
     */
    private function callStackMessage(bool $all = false, ?int $limit = null): string
    {
        $callStackMsg = [];
        $ncall = 0;

        if ($this->callStack) {
            foreach (array_reverse($this->callStack) as $call) {
                if ($all || (isset($call['n']) && $call['n'])) {
                    $msg = '#' . $ncall++ . ' ' . $call['n'] . ' ';
                    $msg .= (isset($this->sourceNames[$call[Parser::SOURCE_INDEX]])
                          ? $this->getPrettyPath($this->sourceNames[$call[Parser::SOURCE_INDEX]])
                          : '(unknown file)');
                    $msg .= ' on line ' . $call[Parser::SOURCE_LINE];

                    $callStackMsg[] = $msg;

                    if (! \is_null($limit) && $ncall > $limit) {
                        break;
                    }
                }
            }
        }

        return implode("\n", $callStackMsg);
    }

    /**
     * Handle import loop
     *
     * @param string $name
     *
     * @return void
     *
     * @throws \Exception
     */
    private function handleImportLoop($name): void
    {
        for ($env = $this->env; $env; $env = $env->parent) {
            if (! $env->block) {
                continue;
            }

            $file = $this->sourceNames[$env->block->sourceIndex];

            if ($file === null) {
                continue;
            }

            if (realpath($file) === $name) {
                throw $this->error('An @import loop has been found: %s imports %s', $file, basename($file));
            }
        }
    }

    /**
     * Call SCSS @function
     *
     * @param CallableBlock|null $func
     * @param array              $argValues
     *
     * @return array|Number
     */
    private function callScssFunction($func, $argValues)
    {
        if (! $func) {
            return self::$defaultValue;
        }
        $name = $func->name;

        $this->pushEnv();

        // set the args
        if (isset($func->args)) {
            $this->applyArguments($func->args, $argValues);
        }

        // throw away lines and children
        $tmp = new OutputBlock();
        $tmp->lines    = [];
        $tmp->children = [];

        $this->env->marker = 'function';

        if (! empty($func->parentEnv)) {
            $this->env->declarationScopeParent = $func->parentEnv;
        } else {
            throw $this->error("@function $name() without parentEnv");
        }

        $ret = $this->compileChildren($func->children, $tmp, $this->env->marker . ' ' . $name);

        $this->popEnv();

        return ! isset($ret) ? self::$defaultValue : $ret;
    }

    /**
     * Call built-in and registered (PHP) functions
     *
     * @param string   $name
     * @param callable $function
     * @param array    $prototype
     * @param array    $args
     *
     * @return array|Number|null
     */
    private function callNativeFunction(string $name, callable $function, array $prototype, array $args)
    {
        $libName = (is_array($function) ? end($function) : null);
        $sorted_kwargs = $this->sortNativeFunctionArgs($libName, $prototype, $args);

        list($sorted, $kwargs) = $sorted_kwargs;

        if ($name !== 'if') {
            foreach ($sorted as &$val) {
                if ($val !== null) {
                    $val = $this->reduce($val, true);
                }
            }
        }

        $returnValue = \call_user_func($function, $sorted, $kwargs);

        if (! isset($returnValue)) {
            return null;
        }

        if (\is_array($returnValue) || $returnValue instanceof Number) {
            return $returnValue;
        }

        throw new \UnexpectedValueException(sprintf('The custom function "%s" must return a sass value.', $name));
    }

    /**
     * Get built-in function
     *
     * @param string $name Normalized name
     *
     * @return array|null
     */
    private function getBuiltinFunction(string $name): ?array
    {
        // All core functions have lowercase names, and they are case-sensitive.
        if (strtolower($name) !== $name) {
            return null;
        }

        $libName = self::normalizeNativeFunctionName($name);

        // All core functions have a prototype defined. Not finding the
        // prototype can mean 2 things:
        // - the function does not exist at all (handled by the caller)
        // - the function exists with a different case, which relates to calling the
        //   wrong Sass function due to our camelCase usage (`fade-in()` vs `fadein()`),
        //   because PHP method names are case-insensitive while property names are
        //   case-sensitive.
        if (!isset(self::$$libName)) {
            return null;
        }

        return [$this, $libName];
    }

    /**
     * Normalize native function name
     *
     * @param string $name
     *
     * @return string
     */
    private static function normalizeNativeFunctionName(string $name): string
    {
        $name = str_replace("-", "_", $name);
        $libName = 'lib' . preg_replace_callback(
            '/_(.)/',
            function ($m) {
                return ucfirst($m[1]);
            },
            ucfirst($name)
        );
        return $libName;
    }

    /**
     * Check if a function is a native built-in scss function, for css parsing
     *
     * @internal
     *
     * @param string $name
     *
     * @return bool
     */
    public static function isNativeFunction(string $name): bool
    {
        if (strtolower($name) !== $name) {
            return false;
        }

        $libName = self::normalizeNativeFunctionName($name);

        return method_exists(Compiler::class, $libName) && isset(self::$$libName);
    }

    /**
     * Sorts keyword arguments
     *
     * @param string|null $functionName
     * @param array       $prototypes
     * @param array       $args
     *
     * @return array
     */
    private function sortNativeFunctionArgs(?string $functionName, array $prototypes, array $args): array
    {
        // specific cases ?
        if (\in_array($functionName, ['libRgb', 'libRgba', 'libHsl', 'libHsla'])) {
            // notation 100 127 255 / 0 is in fact a simple list of 4 values
            foreach ($args as $k => $arg) {
                if (!isset($arg[1])) {
                    continue; // This happens when using a trailing comma
                }
                if ($arg[1][0] === Type::T_LIST && \count($arg[1][2]) === 3) {
                    $args[$k][1][2] = $this->extractSlashAlphaInColorFunction($arg[1][2]);
                }
            }
        }

        list($positionalArgs, $namedArgs, $names, $separator, $hasSplat) = $this->evaluateArguments($args, false);

        if (! \is_array(reset($prototypes))) {
            $prototypes = [$prototypes];
        }

        $parsedPrototypes = array_map([$this, 'parseFunctionPrototype'], $prototypes);
        assert(!empty($parsedPrototypes));
        $matchedPrototype = $this->selectFunctionPrototype($parsedPrototypes, \count($positionalArgs), $names);

        $this->verifyPrototype($matchedPrototype, \count($positionalArgs), $names, $hasSplat);

        $vars = $this->applyArgumentsToDeclaration($matchedPrototype, $positionalArgs, $namedArgs, $separator);

        $finalArgs = [];
        $keyArgs = [];

        foreach ($matchedPrototype['arguments'] as $argument) {
            list($normalizedName, $originalName, $default) = $argument;

            if (isset($vars[$normalizedName])) {
                $value = $vars[$normalizedName];
            } else {
                $value = $default;
            }

            // special null value as default: translate to real null here
            if ($value === [Type::T_KEYWORD, 'null']) {
                $value = null;
            }

            $finalArgs[] = $value;
            $keyArgs[$originalName] = $value;
        }

        if ($matchedPrototype['rest_argument'] !== null) {
            $value = $vars[$matchedPrototype['rest_argument']];

            $finalArgs[] = $value;
            $keyArgs[$matchedPrototype['rest_argument']] = $value;
        }

        return [$finalArgs, $keyArgs];
    }

    /**
     * Parses a function prototype to the internal representation of arguments.
     *
     * The input is an array of strings describing each argument, as supported
     * in {@see registerFunction}. Argument names don't include the `$`.
     * The output contains the list of positional argument, with their normalized
     * name (underscores are replaced by dashes), their original name (to be used
     * in case of error reporting) and their default value. The output also contains
     * the normalized name of the rest argument, or null if the function prototype
     * is not variadic.
     *
     * @param string[] $prototype
     *
     * @return array
     * @phpstan-return array{arguments: list<array{0: string, 1: string, 2: array|Number|null}>, rest_argument: string|null}
     */
    private function parseFunctionPrototype(array $prototype): array
    {
        static $parser = null;

        $arguments = [];
        $restArgument = null;

        foreach ($prototype as $p) {
            if (null !== $restArgument) {
                throw new \InvalidArgumentException('The argument declaration is invalid. The rest argument must be the last one.');
            }

            $default = null;
            $p = explode(':', $p, 2);
            $name = str_replace('_', '-', $p[0]);

            if (isset($p[1])) {
                $defaultSource = trim($p[1]);

                if ($defaultSource === 'null') {
                    // differentiate this null from the self::$null
                    $default = [Type::T_KEYWORD, 'null'];
                } else {
                    if (\is_null($parser)) {
                        $parser = $this->parserFactory(__METHOD__);
                    }

                    $parser->parseValue($defaultSource, $default);
                }
            }

            if (substr($name, -3) === '...') {
                $restArgument = substr($name, 0, -3);
            } else {
                $arguments[] = [$name, $p[0], $default];
            }
        }

        return [
            'arguments' => $arguments,
            'rest_argument' => $restArgument,
        ];
    }

    /**
     * Returns the function prototype for the given positional and named arguments.
     *
     * If no exact match is found, finds the closest approximation. Note that this
     * doesn't guarantee that $positional and $names are valid for the returned
     * prototype.
     *
     * @param array[]               $prototypes
     * @param int                   $positional
     * @param array<string, string> $names A set of names, as both keys and values
     *
     * @return array
     *
     * @phpstan-param non-empty-list<array{arguments: list<array{0: string, 1: string, 2: array|Number|null}>, rest_argument: string|null}> $prototypes
     * @phpstan-return array{arguments: list<array{0: string, 1: string, 2: array|Number|null}>, rest_argument: string|null}
     */
    private function selectFunctionPrototype(array $prototypes, int $positional, array $names): array
    {
        $fuzzyMatch = null;
        $minMismatchDistance = null;

        foreach ($prototypes as $prototype) {
            // Ideally, find an exact match.
            if ($this->checkPrototypeMatches($prototype, $positional, $names)) {
                return $prototype;
            }

            $mismatchDistance = \count($prototype['arguments']) - $positional;

            if ($minMismatchDistance !== null) {
                if (abs($mismatchDistance) > abs($minMismatchDistance)) {
                    continue;
                }

                // If two overloads have the same mismatch distance, favor the overload
                // that has more arguments.
                if (abs($mismatchDistance) === abs($minMismatchDistance) && $mismatchDistance < 0) {
                    continue;
                }
            }

            $minMismatchDistance = $mismatchDistance;
            $fuzzyMatch = $prototype;
        }

        return $fuzzyMatch;
    }

    /**
     * Checks whether the argument invocation matches the callable prototype.
     *
     * The rules are similar to {@see verifyPrototype}. The boolean return value
     * avoids the overhead of building and catching exceptions when the reason of
     * not matching the prototype does not need to be known.
     *
     * @param array                 $prototype
     * @param int                   $positional
     * @param array<string, string> $names
     *
     * @return bool
     *
     * @phpstan-param array{arguments: list<array{0: string, 1: string, 2: array|Number|null}>, rest_argument: string|null} $prototype
     */
    private function checkPrototypeMatches(array $prototype, int $positional, array $names): bool
    {
        $nameUsed = 0;

        foreach ($prototype['arguments'] as $i => $argument) {
            list ($name, $originalName, $default) = $argument;

            if ($i < $positional) {
                if (isset($names[$name])) {
                    return false;
                }
            } elseif (isset($names[$name])) {
                $nameUsed++;
            } elseif ($default === null) {
                return false;
            }
        }

        if ($prototype['rest_argument'] !== null) {
            return true;
        }

        if ($positional > \count($prototype['arguments'])) {
            return false;
        }

        if ($nameUsed < \count($names)) {
            return false;
        }

        return true;
    }

    /**
     * Verifies that the argument invocation is valid for the callable prototype.
     *
     * @param array                 $prototype
     * @param int                   $positional
     * @param array<string, string> $names
     * @param bool                  $hasSplat
     *
     * @return void
     *
     * @throws SassScriptException
     *
     * @phpstan-param array{arguments: list<array{0: string, 1: string, 2: array|Number|null}>, rest_argument: string|null} $prototype
     */
    private function verifyPrototype(array $prototype, int $positional, array $names, bool $hasSplat): void
    {
        $nameUsed = 0;

        foreach ($prototype['arguments'] as $i => $argument) {
            list ($name, $originalName, $default) = $argument;

            if ($i < $positional) {
                if (isset($names[$name])) {
                    throw new SassScriptException(sprintf('Argument $%s was passed both by position and by name.', $originalName));
                }
            } elseif (isset($names[$name])) {
                $nameUsed++;
            } elseif ($default === null) {
                throw new SassScriptException(sprintf('Missing argument $%s', $originalName));
            }
        }

        if ($prototype['rest_argument'] !== null) {
            return;
        }

        if ($positional > \count($prototype['arguments'])) {
            $message = sprintf(
                'Only %d %sargument%s allowed, but %d %s passed.',
                \count($prototype['arguments']),
                empty($names) ? '' : 'positional ',
                \count($prototype['arguments']) === 1 ? '' : 's',
                $positional,
                $positional === 1 ? 'was' : 'were'
            );
            if (!$hasSplat) {
                throw new SassScriptException($message);
            }

            $message = $this->addLocationToMessage($message);
            $message .= "\nThis will be an error in future versions of Sass.";
            $this->logger->warn($message, true);
        }

        if ($nameUsed < \count($names)) {
            $unknownNames = array_values(array_diff($names, array_column($prototype['arguments'], 0)));
            $lastName = array_pop($unknownNames);
            $message = sprintf(
                'No argument%s named $%s%s.',
                $unknownNames ? 's' : '',
                $unknownNames ? implode(', $', $unknownNames) . ' or $' : '',
                $lastName
            );
            throw new SassScriptException($message);
        }
    }

    /**
     * Evaluates the argument from the invocation.
     *
     * This returns several things about this invocation:
     * - the list of positional arguments
     * - the map of named arguments, indexed by normalized names
     * - the set of names used in the arguments (that's an array using the normalized names as keys for O(1) access)
     * - the separator used by the list using the splat operator, if any
     * - a boolean indicator whether any splat argument (list or map) was used, to support the incomplete error reporting.
     *
     * @param array[] $args
     * @param bool    $reduce Whether arguments should be reduced to their value
     *
     * @return array
     *
     * @throws SassScriptException
     *
     * @phpstan-return array{0: list<array|Number>, 1: array<string, array|Number>, 2: array<string, string>, 3: string|null, 4: bool}
     */
    private function evaluateArguments(array $args, bool $reduce = true): array
    {
        // this represents trailing commas
        if (\count($args) && end($args) === self::$null) {
            array_pop($args);
        }

        $splatSeparator = null;
        $keywordArgs = [];
        $names = [];
        $positionalArgs = [];
        $hasKeywordArgument = false;
        $hasSplat = false;

        foreach ($args as $arg) {
            if (!empty($arg[0])) {
                $hasKeywordArgument = true;

                assert(\is_string($arg[0][1]));
                $name = str_replace('_', '-', $arg[0][1]);

                if (isset($keywordArgs[$name])) {
                    throw new SassScriptException(sprintf('Duplicate named argument $%s.', $arg[0][1]));
                }

                $keywordArgs[$name] = $this->maybeReduce($reduce, $arg[1]);
                $names[$name] = $name;
            } elseif (! empty($arg[2])) {
                // $arg[2] means a var followed by ... in the arg ($list... )
                $val = $this->reduce($arg[1], true);
                $hasSplat = true;

                if ($val[0] === Type::T_LIST) {
                    foreach ($val[2] as $item) {
                        if (\is_null($splatSeparator)) {
                            $splatSeparator = $val[1];
                        }

                        $positionalArgs[] = $this->maybeReduce($reduce, $item);
                    }

                    if (isset($val[3]) && \is_array($val[3])) {
                        foreach ($val[3] as $name => $item) {
                            assert(\is_string($name));

                            $normalizedName = str_replace('_', '-', $name);

                            if (isset($keywordArgs[$normalizedName])) {
                                throw new SassScriptException(sprintf('Duplicate named argument $%s.', $name));
                            }

                            $keywordArgs[$normalizedName] = $this->maybeReduce($reduce, $item);
                            $names[$normalizedName] = $normalizedName;
                            $hasKeywordArgument = true;
                        }
                    }
                } elseif ($val[0] === Type::T_MAP) {
                    foreach ($val[1] as $i => $name) {
                        $name = $this->compileStringContent($this->coerceString($name));
                        $item = $val[2][$i];

                        if (! is_numeric($name)) {
                            $normalizedName = str_replace('_', '-', $name);

                            if (isset($keywordArgs[$normalizedName])) {
                                throw new SassScriptException(sprintf('Duplicate named argument $%s.', $name));
                            }

                            $keywordArgs[$normalizedName] = $this->maybeReduce($reduce, $item);
                            $names[$normalizedName] = $normalizedName;
                            $hasKeywordArgument = true;
                        } else {
                            if (\is_null($splatSeparator)) {
                                $splatSeparator = $val[1];
                            }

                            $positionalArgs[] = $this->maybeReduce($reduce, $item);
                        }
                    }
                } elseif ($val[0] !== Type::T_NULL) { // values other than null are treated a single-element lists, while null is the empty list
                    $positionalArgs[] = $this->maybeReduce($reduce, $val);
                }
            } elseif ($hasKeywordArgument) {
                throw new SassScriptException('Positional arguments must come before keyword arguments.');
            } else {
                $positionalArgs[] = $this->maybeReduce($reduce, $arg[1]);
            }
        }

        return [$positionalArgs, $keywordArgs, $names, $splatSeparator, $hasSplat];
    }

    /**
     * @param bool         $reduce
     * @param array|Number $value
     *
     * @return array|Number
     */
    private function maybeReduce(bool $reduce, $value)
    {
        if ($reduce) {
            return $this->reduce($value, true);
        }

        return $value;
    }

    /**
     * Apply argument values per definition
     *
     * @param array[]    $argDef
     * @param array|null $argValues
     * @param bool       $storeInEnv
     * @param bool       $reduce     only used if $storeInEnv = false
     *
     * @return array<string, array|Number>
     *
     * @phpstan-param list<array{0: string, 1: array|Number|null, 2: bool}> $argDef
     *
     * @throws \Exception
     */
    private function applyArguments(array $argDef, ?array $argValues, bool $storeInEnv = true, bool $reduce = true)
    {
        $output = [];

        if (\is_null($argValues)) {
            $argValues = [];
        }

        if ($storeInEnv) {
            $storeEnv = $this->getStoreEnv();

            $env = new Environment();
            $env->store = $storeEnv->store;
        }

        $prototype = ['arguments' => [], 'rest_argument' => null];
        $originalRestArgumentName = null;

        foreach ($argDef as $arg) {
            list($name, $default, $isVariable) = $arg;
            $normalizedName = str_replace('_', '-', $name);

            if ($isVariable) {
                $originalRestArgumentName = $name;
                $prototype['rest_argument'] = $normalizedName;
            } else {
                $prototype['arguments'][] = [$normalizedName, $name, !empty($default) ? $default : null];
            }
        }

        list($positionalArgs, $namedArgs, $names, $splatSeparator, $hasSplat) = $this->evaluateArguments($argValues, $reduce);

        $this->verifyPrototype($prototype, \count($positionalArgs), $names, $hasSplat);

        $vars = $this->applyArgumentsToDeclaration($prototype, $positionalArgs, $namedArgs, $splatSeparator);

        foreach ($prototype['arguments'] as $argument) {
            list($normalizedName, $name) = $argument;

            if (!isset($vars[$normalizedName])) {
                continue;
            }

            $val = $vars[$normalizedName];

            if ($storeInEnv) {
                $this->set($name, $this->reduce($val, true), true, $env);
            } else {
                $output[$name] = ($reduce ? $this->reduce($val, true) : $val);
            }
        }

        if ($prototype['rest_argument'] !== null) {
            assert($originalRestArgumentName !== null);
            $name = $originalRestArgumentName;
            $val = $vars[$prototype['rest_argument']];

            if ($storeInEnv) {
                $this->set($name, $this->reduce($val, true), true, $env);
            } else {
                $output[$name] = ($reduce ? $this->reduce($val, true) : $val);
            }
        }

        if ($storeInEnv) {
            $storeEnv->store = $env->store;
        }

        foreach ($prototype['arguments'] as $argument) {
            list($normalizedName, $name, $default) = $argument;

            if (isset($vars[$normalizedName])) {
                continue;
            }
            assert($default !== null);

            if ($storeInEnv) {
                $this->set($name, $this->reduce($default, true), true);
            } else {
                $output[$name] = ($reduce ? $this->reduce($default, true) : $default);
            }
        }

        return $output;
    }

    /**
     * Apply argument values per definition.
     *
     * This method assumes that the arguments are valid for the provided prototype.
     * The validation with {@see verifyPrototype} must have been run before calling
     * it.
     * Arguments are returned as a map from the normalized argument names to the
     * value. Additional arguments are collected in a sass argument list available
     * under the name of the rest argument in the result.
     *
     * Defaults are not applied as they are resolved in a different environment.
     *
     * @param array                       $prototype
     * @param array<array|Number>         $positionalArgs
     * @param array<string, array|Number> $namedArgs
     * @param string|null                 $splatSeparator
     *
     * @return array<string, array|Number>
     *
     * @phpstan-param array{arguments: list<array{0: string, 1: string, 2: array|Number|null}>, rest_argument: string|null} $prototype
     */
    private function applyArgumentsToDeclaration(array $prototype, array $positionalArgs, array $namedArgs, ?string $splatSeparator): array
    {
        $output = [];
        $minLength = min(\count($positionalArgs), \count($prototype['arguments']));

        for ($i = 0; $i < $minLength; $i++) {
            list($name) = $prototype['arguments'][$i];
            $val = $positionalArgs[$i];

            $output[$name] = $val;
        }

        $restNamed = $namedArgs;

        for ($i = \count($positionalArgs); $i < \count($prototype['arguments']); $i++) {
            $argument = $prototype['arguments'][$i];
            list($name) = $argument;

            if (isset($namedArgs[$name])) {
                $val = $namedArgs[$name];
                unset($restNamed[$name]);
            } else {
                continue;
            }

            $output[$name] = $val;
        }

        if ($prototype['rest_argument'] !== null) {
            $name = $prototype['rest_argument'];
            $rest = array_values(array_slice($positionalArgs, \count($prototype['arguments'])));

            $val = [Type::T_LIST, \is_null($splatSeparator) ? ',' : $splatSeparator , $rest, $restNamed];

            $output[$name] = $val;
        }

        return $output;
    }

    /**
     * Coerce a php value into a scss one
     *
     * @param mixed $value
     *
     * @return array|Number
     */
    private function coerceValue($value)
    {
        if (\is_array($value) || $value instanceof Number) {
            return $value;
        }

        if (\is_bool($value)) {
            return $this->toBool($value);
        }

        if (\is_null($value)) {
            return self::$null;
        }

        if (is_numeric($value)) {
            return new Number($value, '');
        }

        if ($value === '') {
            return self::$emptyString;
        }

        $value = [Type::T_KEYWORD, $value];
        $color = $this->coerceColor($value);

        if ($color) {
            return $color;
        }

        return $value;
    }

    /**
     * Tries to convert an item to a Sass map
     *
     * @param Number|array $item
     *
     * @return array|null
     */
    private function tryMap($item)
    {
        if ($item instanceof Number) {
            return null;
        }

        if ($item[0] === Type::T_MAP) {
            return $item;
        }

        if (
            $item[0] === Type::T_LIST &&
            $item[2] === []
        ) {
            return self::$emptyMap;
        }

        return null;
    }

    /**
     * Coerce something to map
     *
     * @param array|Number $item
     *
     * @return array|Number
     */
    protected function coerceMap($item)
    {
        $map = $this->tryMap($item);

        if ($map !== null) {
            return $map;
        }

        return $item;
    }

    /**
     * Coerce something to list
     *
     * @param array|Number $item
     * @param string       $delim
     * @param bool         $removeTrailingNull
     *
     * @return array
     */
    private function coerceList($item, string $delim = ',', bool $removeTrailingNull = false): array
    {
        if ($item instanceof Number) {
            return [Type::T_LIST, '', [$item]];
        }

        if ($item[0] === Type::T_LIST) {
            // remove trailing null from the list
            if ($removeTrailingNull && end($item[2]) === self::$null) {
                array_pop($item[2]);
            }

            return $item;
        }

        if ($item[0] === Type::T_MAP) {
            $keys = $item[1];
            $values = $item[2];
            $list = [];

            for ($i = 0, $s = \count($keys); $i < $s; $i++) {
                $key = $keys[$i];
                $value = $values[$i];

                $list[] = [
                    Type::T_LIST,
                    ' ',
                    [$key, $value]
                ];
            }

            return [Type::T_LIST, $list ? ',' : '', $list];
        }

        return [Type::T_LIST, '', [$item]];
    }

    /**
     * Coerce color for expression
     *
     * @param array|Number $value
     *
     * @return array|Number
     */
    private function coerceForExpression($value)
    {
        if ($color = $this->coerceColor($value)) {
            return $color;
        }

        return $value;
    }

    /**
     * Coerce value to color
     *
     * @param array|Number $value
     * @param bool         $inRGBFunction
     *
     * @return array|null
     */
    private function coerceColor($value, bool $inRGBFunction = false)
    {
        if ($value instanceof Number) {
            return null;
        }

        switch ($value[0]) {
            case Type::T_COLOR:
                for ($i = 1; $i <= 3; $i++) {
                    if (! is_numeric($value[$i])) {
                        $cv = $this->compileRGBAValue($value[$i]);

                        if (! is_numeric($cv)) {
                            return null;
                        }

                        $value[$i] = $cv;
                    }

                    if (isset($value[4])) {
                        if (! is_numeric($value[4])) {
                            $cv = $this->compileRGBAValue($value[4], true);

                            if (! is_numeric($cv)) {
                                return null;
                            }

                            $value[4] = $cv;
                        }
                    }
                }

                return $value;

            case Type::T_LIST:
                if ($inRGBFunction) {
                    if (\count($value[2]) == 3 || \count($value[2]) == 4) {
                        $color = $value[2];
                        array_unshift($color, Type::T_COLOR);

                        return $this->coerceColor($color);
                    }
                }

                return null;

            case Type::T_KEYWORD:
                if (! \is_string($value[1])) {
                    return null;
                }

                $name = strtolower($value[1]);

                // hexa color?
                if (preg_match('/^#([0-9a-f]+)$/i', $name, $m)) {
                    $nofValues = \strlen($m[1]);

                    if (\in_array($nofValues, [3, 4, 6, 8])) {
                        $nbChannels = 3;
                        $color      = [];
                        $num        = hexdec($m[1]);

                        switch ($nofValues) {
                            case 4:
                                $nbChannels = 4;
                                // then continuing with the case 3:
                            case 3:
                                for ($i = 0; $i < $nbChannels; $i++) {
                                    $t = $num & 0xf;
                                    array_unshift($color, $t << 4 | $t);
                                    $num >>= 4;
                                }

                                break;

                            case 8:
                                $nbChannels = 4;
                                // then continuing with the case 6:
                            case 6:
                                for ($i = 0; $i < $nbChannels; $i++) {
                                    array_unshift($color, $num & 0xff);
                                    $num >>= 8;
                                }

                                break;
                        }

                        if ($nbChannels === 4) {
                            if ($color[3] === 255) {
                                $color[3] = 1; // fully opaque
                            } else {
                                $color[3] = round($color[3] / 255, Number::PRECISION);
                            }
                        }

                        array_unshift($color, Type::T_COLOR);

                        return $color;
                    }
                }

                if ($rgba = Colors::colorNameToRGBa($name)) {
                    return isset($rgba[3])
                        ? [Type::T_COLOR, $rgba[0], $rgba[1], $rgba[2], $rgba[3]]
                        : [Type::T_COLOR, $rgba[0], $rgba[1], $rgba[2]];
                }

                return null;
        }

        return null;
    }

    /**
     * @param int|Number $value
     * @param bool       $isAlpha
     *
     * @return int|mixed
     */
    private function compileRGBAValue($value, bool $isAlpha = false)
    {
        if ($isAlpha) {
            return $this->compileColorPartValue($value, 0, 1, false);
        }

        return $this->compileColorPartValue($value, 0, 255, true);
    }

    /**
     * @param mixed     $value
     * @param int|float $min
     * @param int|float $max
     * @param bool      $isInt
     *
     * @return int|mixed
     */
    private function compileColorPartValue($value, $min, $max, bool $isInt = true)
    {
        if (! is_numeric($value)) {
            if (\is_array($value)) {
                $reduced = $this->reduce($value);

                if ($reduced instanceof Number) {
                    $value = $reduced;
                }
            }

            if ($value instanceof Number) {
                if ($value->unitless()) {
                    $num = $value->getDimension();
                } elseif ($value->hasUnit('%')) {
                    $num = $max * $value->getDimension() / 100;
                } else {
                    throw $this->error('Expected %s to have no units or "%%".', $value);
                }

                $value = $num;
            } elseif (\is_array($value)) {
                $value = $this->compileValue($value);
            }
        }

        if (is_numeric($value)) {
            if ($isInt) {
                $value = round($value);
            }

            $value = min($max, max($min, $value));

            return $value;
        }

        return $value;
    }

    /**
     * Coerce value to string
     *
     * @param array|Number $value
     *
     * @return array
     */
    private function coerceString($value): array
    {
        if ($value[0] === Type::T_STRING) {
            assert(\is_array($value));

            return $value;
        }

        return [Type::T_STRING, '', [$this->compileValue($value)]];
    }

    /**
     * Assert value is a string
     *
     * This method deals with internal implementation details of the value
     * representation where unquoted strings can sometimes be stored under
     * other types.
     * The returned value is always using the T_STRING type.
     *
     * @param array|Number $value
     * @param string|null  $varName
     *
     * @return array
     *
     * @throws SassScriptException
     */
    public function assertString($value, ?string $varName = null)
    {
        // case of url(...) parsed a a function
        if ($value[0] === Type::T_FUNCTION) {
            $value = $this->coerceString($value);
        }

        if (! \in_array($value[0], [Type::T_STRING, Type::T_KEYWORD])) {
            $value = $this->compileValue($value);
            throw SassScriptException::forArgument("$value is not a string.", $varName);
        }

        return $this->coerceString($value);
    }

    /**
     * Assert value is a map
     *
     * @param array|Number $value
     * @param string|null  $varName
     *
     * @return array
     *
     * @throws SassScriptException
     */
    public function assertMap($value, ?string $varName = null)
    {
        $map = $this->tryMap($value);

        if ($map === null) {
            $value = $this->compileValue($value);

            throw SassScriptException::forArgument("$value is not a map.", $varName);
        }

        return $map;
    }

    /**
     * Assert value is a list
     *
     * @param array|Number $value
     *
     * @return array
     *
     * @throws \Exception
     */
    public function assertList($value)
    {
        if ($value[0] !== Type::T_LIST) {
            throw $this->error('expecting list, %s received', $value[0]);
        }
        assert(\is_array($value));

        return $value;
    }

    /**
     * Gets the keywords of an argument list.
     *
     * Keys in the returned array are normalized names (underscores are replaced with dashes)
     * without the leading `$`.
     * Calling this helper with anything that an argument list received for a rest argument
     * of the function argument declaration is not supported.
     *
     * @param array|Number $value
     *
     * @return array<string, array|Number>
     */
    public function getArgumentListKeywords($value): array
    {
        if ($value[0] !== Type::T_LIST || !isset($value[3]) || !\is_array($value[3])) {
            throw new \InvalidArgumentException('The argument is not a sass argument list.');
        }

        return $value[3];
    }

    /**
     * Assert value is a color
     *
     * @param array|Number $value
     * @param string|null  $varName
     *
     * @return array
     *
     * @throws SassScriptException
     */
    public function assertColor($value, ?string $varName = null)
    {
        if ($color = $this->coerceColor($value)) {
            return $color;
        }

        $value = $this->compileValue($value);

        throw SassScriptException::forArgument("$value is not a color.", $varName);
    }

    /**
     * Assert value is a number
     *
     * @param array|Number $value
     * @param string|null  $varName
     *
     * @return Number
     *
     * @throws SassScriptException
     */
    public function assertNumber($value, ?string $varName = null): Number
    {
        if (!$value instanceof Number) {
            $value = $this->compileValue($value);
            throw SassScriptException::forArgument("$value is not a number.", $varName);
        }

        return $value;
    }

    /**
     * Assert value is a integer
     *
     * @param array|Number $value
     * @param string|null  $varName
     *
     * @return int
     *
     * @throws SassScriptException
     */
    public function assertInteger($value, ?string $varName = null): int
    {
        $value = $this->assertNumber($value, $varName)->getDimension();
        if (round($value - \intval($value), Number::PRECISION) > 0) {
            throw SassScriptException::forArgument("$value is not an integer.", $varName);
        }

        return intval($value);
    }

    /**
     * Extract the  ... / alpha on the last argument of channel arg
     * in color functions
     *
     * @param array $args
     * @return array
     */
    private function extractSlashAlphaInColorFunction(array $args): array
    {
        $last = end($args);
        if (\count($args) === 3 && $last[0] === Type::T_EXPRESSION && $last[1] === '/') {
            array_pop($args);
            $args[] = $last[2];
            $args[] = $last[3];
        }
        return $args;
    }


    /**
     * Make sure a color's components don't go out of bounds
     *
     * @param array $c
     *
     * @return array
     */
    private function fixColor(array $c): array
    {
        foreach ([1, 2, 3] as $i) {
            if ($c[$i] < 0) {
                $c[$i] = 0;
            }

            if ($c[$i] > 255) {
                $c[$i] = 255;
            }

            if (!\is_int($c[$i])) {
                $c[$i] = round($c[$i]);
            }
        }

        return $c;
    }

    /**
     * Convert RGB to HSL
     *
     * @param int $red
     * @param int $green
     * @param int $blue
     *
     * @return array
     */
    private function toHSL($red, $green, $blue): array
    {
        $min = min($red, $green, $blue);
        $max = max($red, $green, $blue);

        $l = $min + $max;
        $d = $max - $min;

        if ((int) $d === 0) {
            $h = $s = 0;
        } else {
            if ($l < 255) {
                $s = $d / $l;
            } else {
                $s = $d / (510 - $l);
            }

            if ($red == $max) {
                $h = 60 * ($green - $blue) / $d;
            } elseif ($green == $max) {
                $h = 60 * ($blue - $red) / $d + 120;
            } else {
                $h = 60 * ($red - $green) / $d + 240;
            }
        }

        return [Type::T_HSL, fmod($h + 360, 360), $s * 100, $l / 5.1];
    }

    /**
     * Hue to RGB helper
     *
     * @param float $m1
     * @param float $m2
     * @param float $h
     *
     * @return float
     */
    private function hueToRGB($m1, $m2, $h)
    {
        if ($h < 0) {
            $h += 1;
        } elseif ($h > 1) {
            $h -= 1;
        }

        if ($h * 6 < 1) {
            return $m1 + ($m2 - $m1) * $h * 6;
        }

        if ($h * 2 < 1) {
            return $m2;
        }

        if ($h * 3 < 2) {
            return $m1 + ($m2 - $m1) * (2 / 3 - $h) * 6;
        }

        return $m1;
    }

    /**
     * Convert HSL to RGB
     *
     * @param int|float $hue        H from 0 to 360
     * @param int|float $saturation S from 0 to 100
     * @param int|float $lightness  L from 0 to 100
     *
     * @return array
     */
    private function toRGB($hue, $saturation, $lightness)
    {
        if ($hue < 0) {
            $hue += 360;
        }

        $h = $hue / 360;
        $s = min(100, max(0, $saturation)) / 100;
        $l = min(100, max(0, $lightness)) / 100;

        $m2 = $l <= 0.5 ? $l * ($s + 1) : $l + $s - $l * $s;
        $m1 = $l * 2 - $m2;

        $r = $this->hueToRGB($m1, $m2, $h + 1 / 3) * 255;
        $g = $this->hueToRGB($m1, $m2, $h) * 255;
        $b = $this->hueToRGB($m1, $m2, $h - 1 / 3) * 255;

        $out = [Type::T_COLOR, $r, $g, $b];

        return $out;
    }

    /**
     * Convert HWB to RGB
     * https://www.w3.org/TR/css-color-4/#hwb-to-rgb
     *
     * @param int|float $hue        H from 0 to 360
     * @param int|float $whiteness  W from 0 to 100
     * @param int|float $blackness  B from 0 to 100
     *
     * @return array
     */
    private function HWBtoRGB($hue, $whiteness, $blackness)
    {
        $w = min(100, max(0, $whiteness)) / 100;
        $b = min(100, max(0, $blackness)) / 100;

        $sum = $w + $b;
        if ($sum > 1.0) {
            $w = $w / $sum;
            $b = $b / $sum;
        }
        $b = min(1.0 - $w, $b);

        $rgb = $this->toRGB($hue, 100, 50);
        for($i = 1; $i < 4; $i++) {
          $rgb[$i] *= (1.0 - $w - $b);
          $rgb[$i] = round($rgb[$i] + 255 * $w + 0.0001);
        }

        return $rgb;
    }

    /**
     * Convert RGB to HWB
     *
     * @param int $red
     * @param int $green
     * @param int $blue
     *
     * @return array
     */
    private function RGBtoHWB($red, $green, $blue)
    {
        $min = min($red, $green, $blue);
        $max = max($red, $green, $blue);

        $d = $max - $min;

        if ((int) $d === 0) {
            $h = 0;
        } else {

            if ($red == $max) {
                $h = 60 * ($green - $blue) / $d;
            } elseif ($green == $max) {
                $h = 60 * ($blue - $red) / $d + 120;
            } else {
                $h = 60 * ($red - $green) / $d + 240;
            }
        }

        return [Type::T_HWB, fmod($h, 360), $min / 255 * 100, 100 - $max / 255 *100];
    }


    // Built in functions

    private static $libCall = ['function', 'args...'];
    private function libCall($args)
    {
        $functionReference = $args[0];

        if (in_array($functionReference[0], [Type::T_STRING, Type::T_KEYWORD])) {
            $name = $this->compileStringContent($this->coerceString($functionReference));
            $warning = "Passing a string to call() is deprecated and will be illegal\n"
                . "in Sass 4.0. Use call(function-reference($name)) instead.";
            Warn::deprecation($warning);
            $functionReference = $this->libGetFunction([$this->assertString($functionReference, 'function')]);
        }

        if ($functionReference === self::$null) {
            return self::$null;
        }

        if (! in_array($functionReference[0], [Type::T_FUNCTION_REFERENCE, Type::T_FUNCTION])) {
            throw $this->error('Function reference expected, got ' . $functionReference[0]);
        }

        $callArgs = [
            [null, $args[1], true]
        ];

        return $this->reduce([Type::T_FUNCTION_CALL, $functionReference, $callArgs]);
    }


    private static $libGetFunction = [
        ['name'],
        ['name', 'css']
    ];
    private function libGetFunction($args)
    {
        $name = $this->compileStringContent($this->assertString(array_shift($args), 'name'));
        $isCss = false;

        if (count($args)) {
            $isCss = array_shift($args);
            $isCss = (($isCss === self::$true) ? true : false);
        }

        if ($isCss) {
            return [Type::T_FUNCTION, $name, [Type::T_LIST, ',', []]];
        }

        return $this->getFunctionReference($name, true);
    }

    private static $libIf = ['condition', 'if-true', 'if-false:'];
    private function libIf($args)
    {
        list($cond, $t, $f) = $args;

        if (! $this->isTruthy($this->reduce($cond, true))) {
            return $this->reduce($f, true);
        }

        return $this->reduce($t, true);
    }

    private static $libIndex = ['list', 'value'];
    private function libIndex($args)
    {
        list($list, $value) = $args;

        if (
            $list[0] === Type::T_MAP ||
            $list[0] === Type::T_STRING ||
            $list[0] === Type::T_KEYWORD ||
            $list[0] === Type::T_INTERPOLATE
        ) {
            $list = $this->coerceList($list, ' ');
        }

        if ($list[0] !== Type::T_LIST) {
            return self::$null;
        }

        // Numbers are represented with value objects, for which the PHP equality operator does not
        // match the Sass rules (and we cannot overload it). As they are the only type of values
        // represented with a value object for now, they require a special case.
        if ($value instanceof Number) {
            $key = 0;
            foreach ($list[2] as $item) {
                $key++;
                $itemValue = $this->normalizeValue($item);

                if ($itemValue instanceof Number && $value->equals($itemValue)) {
                    return new Number($key, '');
                }
            }
            return self::$null;
        }

        $values = [];

        foreach ($list[2] as $item) {
            $values[] = $this->normalizeValue($item);
        }

        $key = array_search($this->normalizeValue($value), $values);

        return false === $key ? self::$null : new Number($key + 1, '');
    }

    private static $libRgb = [
        ['color'],
        ['color', 'alpha'],
        ['channels'],
        ['red', 'green', 'blue'],
        ['red', 'green', 'blue', 'alpha'] ];

    /**
     * @param array $args
     * @param array $kwargs
     * @param string $funcName
     *
     * @return array
     */
    private function libRgb($args, $kwargs, $funcName = 'rgb')
    {
        switch (\count($args)) {
            case 1:
                if (! $color = $this->coerceColor($args[0], true)) {
                    $color = [Type::T_STRING, '', [$funcName . '(', $args[0], ')']];
                }
                break;

            case 3:
                $color = [Type::T_COLOR, $args[0], $args[1], $args[2]];

                if (! $color = $this->coerceColor($color)) {
                    $color = [Type::T_STRING, '', [$funcName . '(', $args[0], ', ', $args[1], ', ', $args[2], ')']];
                }

                return $color;

            case 2:
                if ($color = $this->coerceColor($args[0], true)) {
                    $alpha = $this->compileRGBAValue($args[1], true);

                    if (is_numeric($alpha)) {
                        $color[4] = $alpha;
                    } else {
                        $color = [Type::T_STRING, '',
                            [$funcName . '(', $color[1], ', ', $color[2], ', ', $color[3], ', ', $alpha, ')']];
                    }
                } else {
                    $color = [Type::T_STRING, '', [$funcName . '(', $args[0], ', ', $args[1], ')']];
                }
                break;

            case 4:
            default:
                $color = [Type::T_COLOR, $args[0], $args[1], $args[2], $args[3]];

                if (! $color = $this->coerceColor($color)) {
                    $color = [Type::T_STRING, '',
                        [$funcName . '(', $args[0], ', ', $args[1], ', ', $args[2], ', ', $args[3], ')']];
                }
                break;
        }

        return $color;
    }

    private static $libRgba = [
        ['color'],
        ['color', 'alpha'],
        ['channels'],
        ['red', 'green', 'blue'],
        ['red', 'green', 'blue', 'alpha'] ];
    private function libRgba($args, $kwargs)
    {
        return $this->libRgb($args, $kwargs, 'rgba');
    }

    /**
     * Helper function for adjust_color, change_color, and scale_color
     *
     * @param array<array|Number> $args
     * @param string $operation
     * @param callable $fn
     *
     * @return array
     *
     * @phpstan-param callable(float|int, float|int|null, float|int): (float|int) $fn
     */
    private function alterColor(array $args, string $operation, callable $fn): array
    {
        $color = $this->assertColor($args[0], 'color');

        if ($args[1][2]) {
            throw new SassScriptException('Only one positional argument is allowed. All other arguments must be passed by name.');
        }

        $kwargs = $this->getArgumentListKeywords($args[1]);

        $scale = $operation === 'scale';
        $change = $operation === 'change';

        /** @phpstan-var callable(string, float|int, bool=, bool=): (float|int|null) $getParam */
        $getParam = function ($name, $max, $checkPercent = false, $assertPercent = false) use (&$kwargs, $scale, $change) {
            if (!isset($kwargs[$name])) {
                return null;
            }

            $number = $this->assertNumber($kwargs[$name], $name);
            unset($kwargs[$name]);

            if (!$scale && $checkPercent) {
                if (!$number->hasUnit('%')) {
                    $warning = $this->error("{$name} Passing a number `$number` without unit % is deprecated.");
                    $this->logger->warn($warning->getMessage(), true);
                }
            }

            if ($scale || $assertPercent) {
                $number->assertUnit('%', $name);
            }

            if ($scale) {
                $max = 100;
            }

            return $number->valueInRange($change ? 0 : -$max, $max, $name);
        };

        $alpha = $getParam('alpha', 1);
        $red = $getParam('red', 255);
        $green = $getParam('green', 255);
        $blue = $getParam('blue', 255);

        if ($scale || !isset($kwargs['hue'])) {
            $hue = null;
        } else {
            $hueNumber = $this->assertNumber($kwargs['hue'], 'hue');
            unset($kwargs['hue']);
            $hue = $hueNumber->getDimension();
        }
        $saturation = $getParam('saturation', 100, true);
        $lightness = $getParam('lightness', 100, true);
        $whiteness = $getParam('whiteness', 100, false, true);
        $blackness = $getParam('blackness', 100, false, true);

        if (!empty($kwargs)) {
            $unknownNames = array_keys($kwargs);
            $lastName = array_pop($unknownNames);
            $message = sprintf(
                'No argument%s named $%s%s.',
                $unknownNames ? 's' : '',
                $unknownNames ? implode(', $', $unknownNames) . ' or $' : '',
                $lastName
            );
            throw new SassScriptException($message);
        }

        $hasRgb = $red !== null || $green !== null || $blue !== null;
        $hasSL = $saturation !== null || $lightness !== null;
        $hasWB = $whiteness !== null || $blackness !== null;

        if ($hasRgb && ($hasSL || $hasWB || $hue !== null)) {
            throw new SassScriptException(sprintf('RGB parameters may not be passed along with %s parameters.', $hasWB ? 'HWB' : 'HSL'));
        }

        if ($hasWB && $hasSL) {
            throw new SassScriptException('HSL parameters may not be passed along with HWB parameters.');
        }

        if ($hasRgb) {
            $color[1] = round($fn($color[1], $red, 255));
            $color[2] = round($fn($color[2], $green, 255));
            $color[3] = round($fn($color[3], $blue, 255));
        } elseif ($hasWB) {
            $hwb = $this->RGBtoHWB($color[1], $color[2], $color[3]);
            if ($hue !== null) {
                $hwb[1] = $change ? $hue : $hwb[1] + $hue;
            }
            $hwb[2] = $fn($hwb[2], $whiteness, 100);
            $hwb[3] = $fn($hwb[3], $blackness, 100);

            $rgb = $this->HWBtoRGB($hwb[1], $hwb[2], $hwb[3]);

            if (isset($color[4])) {
                $rgb[4] = $color[4];
            }

            $color = $rgb;
        } elseif ($hue !== null || $hasSL) {
            $hsl = $this->toHSL($color[1], $color[2], $color[3]);

            if ($hue !== null) {
                $hsl[1] = $change ? $hue : $hsl[1] + $hue;
            }
            $hsl[2] = $fn($hsl[2], $saturation, 100);
            $hsl[3] = $fn($hsl[3], $lightness, 100);

            $rgb = $this->toRGB($hsl[1], $hsl[2], $hsl[3]);

            if (isset($color[4])) {
                $rgb[4] = $color[4];
            }

            $color = $rgb;
        }

        if ($alpha !== null) {
            $existingAlpha = isset($color[4]) ? $color[4] : 1;
            $color[4] = $fn($existingAlpha, $alpha, 1);
        }

        return $color;
    }

    private static $libAdjustColor = ['color', 'kwargs...'];
    private function libAdjustColor($args)
    {
        return $this->alterColor($args, 'adjust', function ($base, $alter, $max) {
            if ($alter === null) {
                return $base;
            }

            $new = $base + $alter;

            if ($new < 0) {
                return 0;
            }

            if ($new > $max) {
                return $max;
            }

            return $new;
        });
    }

    private static $libChangeColor = ['color', 'kwargs...'];
    private function libChangeColor($args)
    {
        return $this->alterColor($args,'change', function ($base, $alter, $max) {
            if ($alter === null) {
                return $base;
            }

            return $alter;
        });
    }

    private static $libScaleColor = ['color', 'kwargs...'];
    private function libScaleColor($args)
    {
        return $this->alterColor($args, 'scale', function ($base, $scale, $max) {
            if ($scale === null) {
                return $base;
            }

            $scale = $scale / 100;

            if ($scale < 0) {
                return $base * $scale + $base;
            }

            return ($max - $base) * $scale + $base;
        });
    }

    private static $libIeHexStr = ['color'];
    private function libIeHexStr($args)
    {
        $color = $this->coerceColor($args[0]);

        if (\is_null($color)) {
            throw $this->error('Error: argument `$color` of `ie-hex-str($color)` must be a color');
        }

        $color[4] = isset($color[4]) ? round(255 * $color[4]) : 255;

        return [Type::T_STRING, '', [sprintf('#%02X%02X%02X%02X', $color[4], $color[1], $color[2], $color[3])]];
    }

    private static $libRed = ['color'];
    private function libRed($args)
    {
        $color = $this->coerceColor($args[0]);

        if (\is_null($color)) {
            throw $this->error('Error: argument `$color` of `red($color)` must be a color');
        }

        return new Number((int) $color[1], '');
    }

    private static $libGreen = ['color'];
    private function libGreen($args)
    {
        $color = $this->coerceColor($args[0]);

        if (\is_null($color)) {
            throw $this->error('Error: argument `$color` of `green($color)` must be a color');
        }

        return new Number((int) $color[2], '');
    }

    private static $libBlue = ['color'];
    private function libBlue($args)
    {
        $color = $this->coerceColor($args[0]);

        if (\is_null($color)) {
            throw $this->error('Error: argument `$color` of `blue($color)` must be a color');
        }

        return new Number((int) $color[3], '');
    }

    private static $libAlpha = ['color'];
    private function libAlpha($args)
    {
        if ($color = $this->coerceColor($args[0])) {
            return new Number(isset($color[4]) ? $color[4] : 1, '');
        }

        // this might be the IE function, so return value unchanged
        return null;
    }

    private static $libOpacity = ['color'];
    private function libOpacity($args)
    {
        $value = $args[0];

        if ($value instanceof Number) {
            return null;
        }

        return $this->libAlpha($args);
    }

    // mix two colors
    private static $libMix = [
        ['color1', 'color2', 'weight:50%'],
        ['color-1', 'color-2', 'weight:50%']
        ];
    private function libMix($args)
    {
        list($first, $second, $weight) = $args;

        $first = $this->assertColor($first, 'color1');
        $second = $this->assertColor($second, 'color2');
        $weightScale = $this->assertNumber($weight, 'weight')->valueInRange(0, 100, 'weight') / 100;

        $firstAlpha = isset($first[4]) ? $first[4] : 1;
        $secondAlpha = isset($second[4]) ? $second[4] : 1;

        $normalizedWeight = $weightScale * 2 - 1;
        $alphaDistance = $firstAlpha - $secondAlpha;

        $combinedWeight = $normalizedWeight * $alphaDistance == -1 ? $normalizedWeight : ($normalizedWeight + $alphaDistance) / (1 + $normalizedWeight * $alphaDistance);
        $weight1 = ($combinedWeight + 1) / 2.0;
        $weight2 = 1.0 - $weight1;

        $new = [Type::T_COLOR,
            $weight1 * $first[1] + $weight2 * $second[1],
            $weight1 * $first[2] + $weight2 * $second[2],
            $weight1 * $first[3] + $weight2 * $second[3],
        ];

        if ($firstAlpha != 1.0 || $secondAlpha != 1.0) {
            $new[] = $firstAlpha * $weightScale + $secondAlpha * (1 - $weightScale);
        }

        return $this->fixColor($new);
    }

    private static $libHsl = [
        ['channels'],
        ['hue', 'saturation'],
        ['hue', 'saturation', 'lightness'],
        ['hue', 'saturation', 'lightness', 'alpha'] ];

    /**
     * @param array $args
     * @param array $kwargs
     * @param string $funcName
     *
     * @return array|null
     */
    private function libHsl($args, $kwargs, $funcName = 'hsl')
    {
        $args_to_check = $args;

        if (\count($args) == 1) {
            if ($args[0][0] !== Type::T_LIST || \count($args[0][2]) < 3 || \count($args[0][2]) > 4) {
                return [Type::T_STRING, '', [$funcName . '(', $args[0], ')']];
            }

            $args = $args[0][2];
            $args_to_check = $kwargs['channels'][2];
        }

        if (\count($args) === 2) {
            // if var() is used as an argument, return as a css function
            foreach ($args as $arg) {
                if ($arg[0] === Type::T_FUNCTION && in_array($arg[1], ['var'])) {
                    return null;
                }
            }

            throw new SassScriptException('Missing argument $lightness.');
        }

        foreach ($kwargs as $arg) {
            if (in_array($arg[0], [Type::T_FUNCTION_CALL, Type::T_FUNCTION]) && in_array($arg[1], ['min', 'max'])) {
                return null;
            }
        }

        foreach ($args_to_check as $k => $arg) {
            if (in_array($arg[0], [Type::T_FUNCTION_CALL, Type::T_FUNCTION]) && in_array($arg[1], ['min', 'max'])) {
                if (count($kwargs) > 1 || ($k >= 2 && count($args) === 4)) {
                    return null;
                }

                $args[$k] = $this->stringifyFncallArgs($arg);
            }

            if (
                $k >= 2 && count($args) === 4 &&
                in_array($arg[0], [Type::T_FUNCTION_CALL, Type::T_FUNCTION]) &&
                in_array($arg[1], ['calc','env'])
            ) {
                return null;
            }
        }

        $hue = $this->reduce($args[0]);
        $saturation = $this->reduce($args[1]);
        $lightness = $this->reduce($args[2]);
        $alpha = null;

        if (\count($args) === 4) {
            $alpha = $this->compileColorPartValue($args[3], 0, 100, false);

            if (!$hue instanceof Number || !$saturation instanceof Number || ! $lightness instanceof Number || ! is_numeric($alpha)) {
                return [Type::T_STRING, '',
                    [$funcName . '(', $args[0], ', ', $args[1], ', ', $args[2], ', ', $args[3], ')']];
            }
        } else {
            if (!$hue instanceof Number || !$saturation instanceof Number || ! $lightness instanceof Number) {
                return [Type::T_STRING, '', [$funcName . '(', $args[0], ', ', $args[1], ', ', $args[2], ')']];
            }
        }

        $hueValue = fmod($hue->getDimension(), 360);

        while ($hueValue < 0) {
            $hueValue += 360;
        }

        $color = $this->toRGB($hueValue, max(0, min($saturation->getDimension(), 100)), max(0, min($lightness->getDimension(), 100)));

        if (! \is_null($alpha)) {
            $color[4] = $alpha;
        }

        return $color;
    }

    private static $libHsla = [
            ['channels'],
            ['hue', 'saturation'],
            ['hue', 'saturation', 'lightness'],
            ['hue', 'saturation', 'lightness', 'alpha']];
    private function libHsla($args, $kwargs)
    {
        return $this->libHsl($args, $kwargs, 'hsla');
    }

    private static $libHue = ['color'];
    private function libHue($args)
    {
        $color = $this->assertColor($args[0], 'color');
        $hsl = $this->toHSL($color[1], $color[2], $color[3]);

        return new Number($hsl[1], 'deg');
    }

    private static $libSaturation = ['color'];
    private function libSaturation($args)
    {
        $color = $this->assertColor($args[0], 'color');
        $hsl = $this->toHSL($color[1], $color[2], $color[3]);

        return new Number($hsl[2], '%');
    }

    private static $libLightness = ['color'];
    private function libLightness($args)
    {
        $color = $this->assertColor($args[0], 'color');
        $hsl = $this->toHSL($color[1], $color[2], $color[3]);

        return new Number($hsl[3], '%');
    }

    /*
     * Todo : a integrer dans le futur module color
    private static $libHwb = [
        ['channels'],
        ['hue', 'whiteness', 'blackness'],
        ['hue', 'whiteness', 'blackness', 'alpha'] ];
    private function libHwb($args, $kwargs, $funcName = 'hwb')
    {
        $args_to_check = $args;

        if (\count($args) == 1) {
            if ($args[0][0] !== Type::T_LIST) {
                throw $this->error("Missing elements \$whiteness and \$blackness");
            }

            if (\trim($args[0][1])) {
                throw $this->error("\$channels must be a space-separated list.");
            }

            if (! empty($args[0]['enclosing'])) {
                throw $this->error("\$channels must be an unbracketed list.");
            }

            $args = $args[0][2];
            if (\count($args) > 3) {
                throw $this->error("hwb() : Only 3 elements are allowed but ". \count($args) . "were passed");
            }

            $args_to_check = $this->extractSlashAlphaInColorFunction($kwargs['channels'][2]);
            if (\count($args_to_check) !== \count($kwargs['channels'][2])) {
                $args = $args_to_check;
            }
        }

        if (\count($args_to_check) < 2) {
            throw $this->error("Missing elements \$whiteness and \$blackness");
        }
        if (\count($args_to_check) < 3) {
            throw $this->error("Missing element \$blackness");
        }
        if (\count($args_to_check) > 4) {
            throw $this->error("hwb() : Only 4 elements are allowed but ". \count($args) . "were passed");
        }

        foreach ($kwargs as $k => $arg) {
            if (in_array($arg[0], [Type::T_FUNCTION_CALL]) && in_array($arg[1], ['min', 'max'])) {
                return null;
            }
        }

        foreach ($args_to_check as $k => $arg) {
            if (in_array($arg[0], [Type::T_FUNCTION_CALL]) && in_array($arg[1], ['min', 'max'])) {
                if (count($kwargs) > 1 || ($k >= 2 && count($args) === 4)) {
                    return null;
                }

                $args[$k] = $this->stringifyFncallArgs($arg);
            }

            if (
                $k >= 2 && count($args) === 4 &&
                in_array($arg[0], [Type::T_FUNCTION_CALL, Type::T_FUNCTION]) &&
                in_array($arg[1], ['calc','env'])
            ) {
                return null;
            }
        }

        $hue = $this->reduce($args[0]);
        $whiteness = $this->reduce($args[1]);
        $blackness = $this->reduce($args[2]);
        $alpha = null;

        if (\count($args) === 4) {
            $alpha = $this->compileColorPartValue($args[3], 0, 1, false);

            if (! \is_numeric($alpha)) {
                $val = $this->compileValue($args[3]);
                throw $this->error("\$alpha: $val is not a number");
            }
        }

        $this->assertNumber($hue, 'hue');
        $this->assertUnit($whiteness, ['%'], 'whiteness');
        $this->assertUnit($blackness, ['%'], 'blackness');

        $this->assertRange($whiteness, 0, 100, "0% and 100%", "whiteness");
        $this->assertRange($blackness, 0, 100, "0% and 100%", "blackness");

        $w = $whiteness->getDimension();
        $b = $blackness->getDimension();

        $hueValue = $hue->getDimension() % 360;

        while ($hueValue < 0) {
            $hueValue += 360;
        }

        $color = $this->HWBtoRGB($hueValue, $w, $b);

        if (! \is_null($alpha)) {
            $color[4] = $alpha;
        }

        return $color;
    }

    private static $libWhiteness = ['color'];
    private function libWhiteness($args, $kwargs, $funcName = 'whiteness') {

        $color = $this->assertColor($args[0]);
        $hwb = $this->RGBtoHWB($color[1], $color[2], $color[3]);

        return new Number($hwb[2], '%');
    }

    private static $libBlackness = ['color'];
    private function libBlackness($args, $kwargs, $funcName = 'blackness') {

        $color = $this->assertColor($args[0]);
        $hwb = $this->RGBtoHWB($color[1], $color[2], $color[3]);

        return new Number($hwb[3], '%');
    }
    */

    /**
     * @param array     $color
     * @param int       $idx
     * @param int|float $amount
     *
     * @return array
     */
    private function adjustHsl(array $color, int $idx, $amount): array
    {
        $hsl = $this->toHSL($color[1], $color[2], $color[3]);
        $hsl[$idx] += $amount;

        if ($idx !== 1) {
            // Clamp the saturation and lightness
            $hsl[$idx] = min(max(0, $hsl[$idx]), 100);
        }

        $out = $this->toRGB($hsl[1], $hsl[2], $hsl[3]);

        if (isset($color[4])) {
            $out[4] = $color[4];
        }

        return $out;
    }

    private static $libAdjustHue = ['color', 'degrees'];
    private function libAdjustHue($args)
    {
        $color = $this->assertColor($args[0], 'color');
        $degrees = $this->assertNumber($args[1], 'degrees')->getDimension();

        return $this->adjustHsl($color, 1, $degrees);
    }

    private static $libLighten = ['color', 'amount'];
    private function libLighten($args)
    {
        $color = $this->assertColor($args[0], 'color');
        $amount = Util::checkRange('amount', new Range(0, 100), $args[1], '%');

        return $this->adjustHsl($color, 3, $amount);
    }

    private static $libDarken = ['color', 'amount'];
    private function libDarken($args)
    {
        $color = $this->assertColor($args[0], 'color');
        $amount = Util::checkRange('amount', new Range(0, 100), $args[1], '%');

        return $this->adjustHsl($color, 3, -$amount);
    }

    private static $libSaturate = [['color', 'amount'], ['amount']];
    private function libSaturate($args)
    {
        $value = $args[0];

        if (count($args) === 1) {
            $this->assertNumber($args[0], 'amount');

            return null;
        }

        $color = $this->assertColor($args[0], 'color');
        $amount = $this->assertNumber($args[1], 'amount');

        return $this->adjustHsl($color, 2, $amount->valueInRange(0, 100, 'amount'));
    }

    private static $libDesaturate = ['color', 'amount'];
    private function libDesaturate($args)
    {
        $color = $this->assertColor($args[0], 'color');
        $amount = $this->assertNumber($args[1], 'amount');

        return $this->adjustHsl($color, 2, -$amount->valueInRange(0, 100, 'amount'));
    }

    private static $libGrayscale = ['color'];
    private function libGrayscale($args)
    {
        $value = $args[0];

        if ($value instanceof Number) {
            return null;
        }

        return $this->adjustHsl($this->assertColor($value, 'color'), 2, -100);
    }

    private static $libComplement = ['color'];
    private function libComplement($args)
    {
        return $this->adjustHsl($this->assertColor($args[0], 'color'), 1, 180);
    }

    private static $libInvert = ['color', 'weight:100%'];
    private function libInvert($args)
    {
        $value = $args[0];

        $weight = $this->assertNumber($args[1], 'weight');

        if ($value instanceof Number) {
            if ($weight->getDimension() != 100 || !$weight->hasUnit('%')) {
                throw new SassScriptException('Only one argument may be passed to the plain-CSS invert() function.');
            }

            return null;
        }

        $color = $this->assertColor($value, 'color');
        $inverted = $color;
        $inverted[1] = 255 - $inverted[1];
        $inverted[2] = 255 - $inverted[2];
        $inverted[3] = 255 - $inverted[3];

        return $this->libMix([$inverted, $color, $weight]);
    }

    // increases opacity by amount
    private static $libOpacify = ['color', 'amount'];
    private function libOpacify($args)
    {
        $color = $this->assertColor($args[0], 'color');
        $amount = $this->assertNumber($args[1], 'amount');

        $color[4] = (isset($color[4]) ? $color[4] : 1) + $amount->valueInRange(0, 1, 'amount');
        $color[4] = min(1, max(0, $color[4]));

        return $color;
    }

    private static $libFadeIn = ['color', 'amount'];
    private function libFadeIn($args)
    {
        return $this->libOpacify($args);
    }

    // decreases opacity by amount
    private static $libTransparentize = ['color', 'amount'];
    private function libTransparentize($args)
    {
        $color = $this->assertColor($args[0], 'color');
        $amount = $this->assertNumber($args[1], 'amount');

        $color[4] = (isset($color[4]) ? $color[4] : 1) - $amount->valueInRange(0, 1, 'amount');
        $color[4] = min(1, max(0, $color[4]));

        return $color;
    }

    private static $libFadeOut = ['color', 'amount'];
    private function libFadeOut($args)
    {
        return $this->libTransparentize($args);
    }

    private static $libUnquote = ['string'];
    private function libUnquote($args)
    {
        try {
            $str = $this->assertString($args[0], 'string');
        } catch (SassScriptException $e) {
            $value = $this->compileValue($args[0]);
            $fname = $this->getPrettyPath($this->sourceNames[$this->sourceIndex]);
            $line  = $this->sourceLine;

            $message = "Passing $value, a non-string value, to unquote()
will be an error in future versions of Sass.\n         on line $line of $fname";

            $this->logger->warn($message, true);

            return $args[0];
        }

        $str[1] = '';

        return $str;
    }

    private static $libQuote = ['string'];
    private function libQuote($args)
    {
        $value = $this->assertString($args[0], 'string');

        $value[1] = '"';

        return $value;
    }

    private static $libPercentage = ['number'];
    private function libPercentage($args)
    {
        $num = $this->assertNumber($args[0], 'number');
        $num->assertNoUnits('number');

        return new Number($num->getDimension() * 100, '%');
    }

    private static $libRound = ['number'];
    private function libRound($args)
    {
        $num = $this->assertNumber($args[0], 'number');

        return new Number(round($num->getDimension()), $num->getNumeratorUnits(), $num->getDenominatorUnits());
    }

    private static $libFloor = ['number'];
    private function libFloor($args)
    {
        $num = $this->assertNumber($args[0], 'number');

        return new Number(floor($num->getDimension()), $num->getNumeratorUnits(), $num->getDenominatorUnits());
    }

    private static $libCeil = ['number'];
    private function libCeil($args)
    {
        $num = $this->assertNumber($args[0], 'number');

        return new Number(ceil($num->getDimension()), $num->getNumeratorUnits(), $num->getDenominatorUnits());
    }

    private static $libAbs = ['number'];
    private function libAbs($args)
    {
        $num = $this->assertNumber($args[0], 'number');

        return new Number(abs($num->getDimension()), $num->getNumeratorUnits(), $num->getDenominatorUnits());
    }

    private static $libMin = ['numbers...'];
    private function libMin($args)
    {
        /**
         * @var Number|null
         */
        $min = null;

        foreach ($args[0][2] as $arg) {
            $number = $this->assertNumber($arg);

            if (\is_null($min) || $min->greaterThan($number)) {
                $min = $number;
            }
        }

        if (!\is_null($min)) {
            return $min;
        }

        throw $this->error('At least one argument must be passed.');
    }

    private static $libMax = ['numbers...'];
    private function libMax($args)
    {
        /**
         * @var Number|null
         */
        $max = null;

        foreach ($args[0][2] as $arg) {
            $number = $this->assertNumber($arg);

            if (\is_null($max) || $max->lessThan($number)) {
                $max = $number;
            }
        }

        if (!\is_null($max)) {
            return $max;
        }

        throw $this->error('At least one argument must be passed.');
    }

    private static $libLength = ['list'];
    private function libLength($args)
    {
        $list = $this->coerceList($args[0], ',', true);

        return new Number(\count($list[2]), '');
    }

    private static $libListSeparator = ['list'];
    private function libListSeparator($args)
    {
        if (! \in_array($args[0][0], [Type::T_LIST, Type::T_MAP])) {
            return [Type::T_KEYWORD, 'space'];
        }

        $list = $this->coerceList($args[0]);

        if ($list[1] === '' && \count($list[2]) <= 1 && empty($list['enclosing'])) {
            return [Type::T_KEYWORD, 'space'];
        }

        if ($list[1] === ',') {
            return [Type::T_KEYWORD, 'comma'];
        }

        if ($list[1] === '/') {
            return [Type::T_KEYWORD, 'slash'];
        }

        return [Type::T_KEYWORD, 'space'];
    }

    private static $libNth = ['list', 'n'];
    private function libNth($args)
    {
        $list = $this->coerceList($args[0], ',', false);
        $n = $this->assertNumber($args[1])->getDimension();

        if ($n > 0) {
            $n--;
        } elseif ($n < 0) {
            $n += \count($list[2]);
        }

        return isset($list[2][$n]) ? $list[2][$n] : self::$defaultValue;
    }

    private static $libSetNth = ['list', 'n', 'value'];
    private function libSetNth($args)
    {
        $list = $this->coerceList($args[0]);
        $n = $this->assertNumber($args[1])->getDimension();

        if ($n > 0) {
            $n--;
        } elseif ($n < 0) {
            $n += \count($list[2]);
        }

        if (! isset($list[2][$n])) {
            throw $this->error('Invalid argument for "n"');
        }

        $list[2][$n] = $args[2];

        return $list;
    }

    private static $libMapGet = ['map', 'key', 'keys...'];
    private function libMapGet($args)
    {
        $map = $this->assertMap($args[0], 'map');
        if (!isset($args[2])) {
            // BC layer for usages of the function from PHP code rather than from the Sass function
            $args[2] = self::$emptyArgumentList;
        }
        $keys = array_merge([$args[1]], $args[2][2]);
        $value = self::$null;

        foreach ($keys as $key) {
            if (!\is_array($map) || $map[0] !== Type::T_MAP) {
                return self::$null;
            }

            $map = $this->mapGet($map, $key);

            if ($map === null) {
                return self::$null;
            }

            $value = $map;
        }

        return $value;
    }

    /**
     * Gets the value corresponding to that key in the map
     *
     * @param array        $map
     * @param Number|array $key
     *
     * @return Number|array|null
     */
    private function mapGet(array $map, $key)
    {
        $index = $this->mapGetEntryIndex($map, $key);

        if ($index !== null) {
            return $map[2][$index];
        }

        return null;
    }

    /**
     * Gets the index corresponding to that key in the map entries
     *
     * @param array        $map
     * @param Number|array $key
     *
     * @return int|null
     */
    private function mapGetEntryIndex(array $map, $key)
    {
        $key = $this->compileStringContent($this->coerceString($key));

        for ($i = \count($map[1]) - 1; $i >= 0; $i--) {
            if ($key === $this->compileStringContent($this->coerceString($map[1][$i]))) {
                return $i;
            }
        }

        return null;
    }

    private static $libMapKeys = ['map'];
    private function libMapKeys($args)
    {
        $map = $this->assertMap($args[0], 'map');
        $keys = $map[1];

        return [Type::T_LIST, ',', $keys];
    }

    private static $libMapValues = ['map'];
    private function libMapValues($args)
    {
        $map = $this->assertMap($args[0], 'map');
        $values = $map[2];

        return [Type::T_LIST, ',', $values];
    }

    private static $libMapRemove = [
        ['map'],
        ['map', 'key', 'keys...'],
    ];
    private function libMapRemove($args)
    {
        $map = $this->assertMap($args[0], 'map');

        if (\count($args) === 1) {
            return $map;
        }

        $keys = [];
        $keys[] = $this->compileStringContent($this->coerceString($args[1]));

        foreach ($args[2][2] as $key) {
            $keys[] = $this->compileStringContent($this->coerceString($key));
        }

        for ($i = \count($map[1]) - 1; $i >= 0; $i--) {
            if (in_array($this->compileStringContent($this->coerceString($map[1][$i])), $keys)) {
                array_splice($map[1], $i, 1);
                array_splice($map[2], $i, 1);
            }
        }

        return $map;
    }

    private static $libMapHasKey = ['map', 'key', 'keys...'];
    private function libMapHasKey($args)
    {
        $map = $this->assertMap($args[0], 'map');
        if (!isset($args[2])) {
            // BC layer for usages of the function from PHP code rather than from the Sass function
            $args[2] = self::$emptyArgumentList;
        }
        $keys = array_merge([$args[1]], $args[2][2]);
        $lastKey = array_pop($keys);

        foreach ($keys as $key) {
            $value = $this->mapGet($map, $key);

            if ($value === null || $value instanceof Number || $value[0] !== Type::T_MAP) {
                return self::$false;
            }

            $map = $value;
        }

        return $this->toBool($this->mapHasKey($map, $lastKey));
    }

    /**
     * @param array|Number $keyValue
     *
     * @return bool
     */
    private function mapHasKey(array $map, $keyValue)
    {
        $key = $this->compileStringContent($this->coerceString($keyValue));

        for ($i = \count($map[1]) - 1; $i >= 0; $i--) {
            if ($key === $this->compileStringContent($this->coerceString($map[1][$i]))) {
                return true;
            }
        }

        return false;
    }

    private static $libMapMerge = [
        ['map1', 'map2'],
        ['map-1', 'map-2'],
        ['map1', 'args...']
    ];
    private function libMapMerge($args)
    {
        $map1 = $this->assertMap($args[0], 'map1');
        $map2 = $args[1];
        $keys = [];
        if ($map2[0] === Type::T_LIST && isset($map2[3]) && \is_array($map2[3])) {
            // This is an argument list for the variadic signature
            if (\count($map2[2]) === 0) {
                throw new SassScriptException('Expected $args to contain a key.');
            }
            if (\count($map2[2]) === 1) {
                throw new SassScriptException('Expected $args to contain a value.');
            }
            $keys = $map2[2];
            $map2 = array_pop($keys);
        }
        $map2 = $this->assertMap($map2, 'map2');

        return $this->modifyMap($map1, $keys, function ($oldValue) use ($map2) {
            $nestedMap = $this->tryMap($oldValue);

            if ($nestedMap === null) {
                return $map2;
            }

            return $this->mergeMaps($nestedMap, $map2);
        });
    }

    /**
     * @param array    $map
     * @param array    $keys
     * @param callable $modify
     * @param bool     $addNesting
     *
     * @return Number|array
     *
     * @phpstan-param array<Number|array> $keys
     * @phpstan-param callable(Number|array): (Number|array) $modify
     */
    private function modifyMap(array $map, array $keys, callable $modify, $addNesting = true)
    {
        if ($keys === []) {
            return $modify($map);
        }

        return $this->modifyNestedMap($map, $keys, $modify, $addNesting);
    }

    /**
     * @param array    $map
     * @param array    $keys
     * @param callable $modify
     * @param bool     $addNesting
     *
     * @return array
     *
     * @phpstan-param non-empty-array<Number|array> $keys
     * @phpstan-param callable(Number|array): (Number|array) $modify
     */
    private function modifyNestedMap(array $map, array $keys, callable $modify, $addNesting)
    {
        $key = array_shift($keys);

        $nestedValueIndex = $this->mapGetEntryIndex($map, $key);

        if ($keys === []) {
            if ($nestedValueIndex !== null) {
                $map[2][$nestedValueIndex] = $modify($map[2][$nestedValueIndex]);
            } else {
                $map[1][] = $key;
                $map[2][] = $modify(self::$null);
            }

            return $map;
        }

        $nestedMap = $nestedValueIndex !== null ? $this->tryMap($map[2][$nestedValueIndex]) : null;

        if ($nestedMap === null && !$addNesting) {
            return $map;
        }

        if ($nestedMap === null) {
            $nestedMap = self::$emptyMap;
        }

        $newNestedMap = $this->modifyNestedMap($nestedMap, $keys, $modify, $addNesting);

        if ($nestedValueIndex !== null) {
            $map[2][$nestedValueIndex] = $newNestedMap;
        } else {
            $map[1][] = $key;
            $map[2][] = $newNestedMap;
        }

        return $map;
    }

    /**
     * Merges 2 Sass maps together
     *
     * @param array $map1
     * @param array $map2
     *
     * @return array
     */
    private function mergeMaps(array $map1, array $map2)
    {
        foreach ($map2[1] as $i2 => $key2) {
            $map1EntryIndex = $this->mapGetEntryIndex($map1, $key2);

            if ($map1EntryIndex !== null) {
                $map1[2][$map1EntryIndex] = $map2[2][$i2];
                continue;
            }

            $map1[1][] = $key2;
            $map1[2][] = $map2[2][$i2];
        }

        return $map1;
    }

    private static $libKeywords = ['args'];
    private function libKeywords($args)
    {
        $value = $args[0];

        if ($value[0] !== Type::T_LIST || !isset($value[3]) || !\is_array($value[3])) {
            $compiledValue = $this->compileValue($value);

            throw SassScriptException::forArgument($compiledValue . ' is not an argument list.', 'args');
        }

        $keys = [];
        $values = [];

        foreach ($this->getArgumentListKeywords($value) as $name => $arg) {
            $keys[] = [Type::T_KEYWORD, $name];
            $values[] = $arg;
        }

        return [Type::T_MAP, $keys, $values];
    }

    private static $libIsBracketed = ['list'];
    private function libIsBracketed($args)
    {
        $list = $args[0];
        $this->coerceList($list, ' ');

        if (! empty($list['enclosing']) && $list['enclosing'] === 'bracket') {
            return self::$true;
        }

        return self::$false;
    }

    /**
     * @param array $list1
     * @param array|Number|null $sep
     *
     * @return string
     * @throws CompilerException
     *
     * @deprecated
     */
    private function listSeparatorForJoin(array $list1, $sep): string
    {
        @trigger_error(sprintf('The "%s" method is deprecated.', __METHOD__), E_USER_DEPRECATED);

        if (! isset($sep)) {
            return $list1[1];
        }

        switch ($this->compileValue($sep)) {
            case 'comma':
                return ',';

            case 'space':
                return ' ';

            default:
                return $list1[1];
        }
    }

    private static $libJoin = ['list1', 'list2', 'separator:auto', 'bracketed:auto'];
    private function libJoin($args)
    {
        list($list1, $list2, $sep, $bracketed) = $args;

        $list1 = $this->coerceList($list1, ' ', true);
        $list2 = $this->coerceList($list2, ' ', true);

        switch ($this->compileStringContent($this->assertString($sep, 'separator'))) {
            case 'comma':
                $separator = ',';
                break;

            case 'space':
                $separator = ' ';
                break;

            case 'slash':
                $separator = '/';
                break;

            case 'auto':
                if ($list1[1] !== '' || count($list1[2]) > 1 || !empty($list1['enclosing']) && $list1['enclosing'] !== 'parent') {
                    $separator = $list1[1] ?: ' ';
                } elseif ($list2[1] !== '' || count($list2[2]) > 1 || !empty($list2['enclosing']) && $list2['enclosing'] !== 'parent') {
                    $separator = $list2[1] ?: ' ';
                } else {
                    $separator = ' ';
                }
                break;

            default:
                throw SassScriptException::forArgument('Must be "space", "comma", "slash", or "auto".', 'separator');
        }

        if ($bracketed === self::$true) {
            $bracketed = true;
        } elseif ($bracketed === self::$false) {
            $bracketed = false;
        } elseif ($bracketed === [Type::T_KEYWORD, 'auto']) {
            $bracketed = 'auto';
        } elseif ($bracketed === self::$null) {
            $bracketed = false;
        } else {
            $bracketed = $this->compileValue($bracketed);
            $bracketed = ! ! $bracketed;

            if ($bracketed === true) {
                $bracketed = true;
            }
        }

        if ($bracketed === 'auto') {
            $bracketed = false;

            if (! empty($list1['enclosing']) && $list1['enclosing'] === 'bracket') {
                $bracketed = true;
            }
        }

        $res = [Type::T_LIST, $separator, array_merge($list1[2], $list2[2])];

        if ($bracketed) {
            $res['enclosing'] = 'bracket';
        }

        return $res;
    }

    private static $libAppend = ['list', 'val', 'separator:auto'];
    private function libAppend($args)
    {
        list($list1, $value, $sep) = $args;

        $list1 = $this->coerceList($list1, ' ', true);

        switch ($this->compileStringContent($this->assertString($sep, 'separator'))) {
            case 'comma':
                $separator = ',';
                break;

            case 'space':
                $separator = ' ';
                break;

            case 'slash':
                $separator = '/';
                break;

            case 'auto':
                $separator = $list1[1] === '' && \count($list1[2]) <= 1 && (empty($list1['enclosing']) || $list1['enclosing'] === 'parent') ? ' ' : $list1[1];
                break;

            default:
                throw SassScriptException::forArgument('Must be "space", "comma", "slash", or "auto".', 'separator');
        }

        $res = [Type::T_LIST, $separator, array_merge($list1[2], [$value])];

        if (isset($list1['enclosing'])) {
            $res['enclosing'] = $list1['enclosing'];
        }

        return $res;
    }

    private static $libZip = ['lists...'];
    private function libZip($args)
    {
        $argLists = [];
        foreach ($args[0][2] as $arg) {
            $argLists[] = $this->coerceList($arg);
        }

        $lists = [];
        $firstList = array_shift($argLists);

        $result = [Type::T_LIST, ',', $lists];
        if (! \is_null($firstList)) {
            foreach ($firstList[2] as $key => $item) {
                $list = [Type::T_LIST, ' ', [$item]];

                foreach ($argLists as $arg) {
                    if (isset($arg[2][$key])) {
                        $list[2][] = $arg[2][$key];
                    } else {
                        break 2;
                    }
                }

                $lists[] = $list;
            }

            $result[2] = $lists;
        } else {
            $result['enclosing'] = 'parent';
        }

        return $result;
    }

    private static $libTypeOf = ['value'];
    private function libTypeOf($args)
    {
        $value = $args[0];

        return [Type::T_KEYWORD, $this->getTypeOf($value)];
    }

    /**
     * @param array|Number $value
     *
     * @return string
     */
    private function getTypeOf($value)
    {
        switch ($value[0]) {
            case Type::T_KEYWORD:
                if ($value === self::$true || $value === self::$false) {
                    return 'bool';
                }

                if ($this->coerceColor($value)) {
                    return 'color';
                }

                // fall-thru
            case Type::T_FUNCTION:
                return 'string';

            case Type::T_FUNCTION_REFERENCE:
                return 'function';

            case Type::T_LIST:
                if (isset($value[3]) && \is_array($value[3])) {
                    return 'arglist';
                }

                // fall-thru
            default:
                return $value[0];
        }
    }

    private static $libUnit = ['number'];
    private function libUnit($args)
    {
        $num = $this->assertNumber($args[0], 'number');

        return [Type::T_STRING, '"', [$num->unitStr()]];
    }

    private static $libUnitless = ['number'];
    private function libUnitless($args)
    {
        $value = $this->assertNumber($args[0], 'number');

        return $this->toBool($value->unitless());
    }

    private static $libComparable = [
        ['number1', 'number2'],
        ['number-1', 'number-2']
    ];
    private function libComparable($args)
    {
        list($number1, $number2) = $args;

        if (
            ! $number1 instanceof Number ||
            ! $number2 instanceof Number
        ) {
            throw $this->error('Invalid argument(s) for "comparable"');
        }

        return $this->toBool($number1->isComparableTo($number2));
    }

    private static $libStrIndex = ['string', 'substring'];
    private function libStrIndex($args)
    {
        $string = $this->assertString($args[0], 'string');
        $stringContent = $this->compileStringContent($string);

        $substring = $this->assertString($args[1], 'substring');
        $substringContent = $this->compileStringContent($substring);

        if (! \strlen($substringContent)) {
            $result = 0;
        } else {
            $result = Util::mbStrpos($stringContent, $substringContent);
        }

        return $result === false ? self::$null : new Number($result + 1, '');
    }

    private static $libStrInsert = ['string', 'insert', 'index'];
    private function libStrInsert($args)
    {
        $string = $this->assertString($args[0], 'string');
        $stringContent = $this->compileStringContent($string);

        $insert = $this->assertString($args[1], 'insert');
        $insertContent = $this->compileStringContent($insert);

        $index = $this->assertInteger($args[2], 'index');
        if ($index > 0) {
            $index = $index - 1;
        }
        if ($index < 0) {
            $index = max(Util::mbStrlen($stringContent) + 1 + $index, 0);
        }

        $string[2] = [
            Util::mbSubstr($stringContent, 0, $index),
            $insertContent,
            Util::mbSubstr($stringContent, $index)
        ];

        return $string;
    }

    private static $libStrLength = ['string'];
    private function libStrLength($args)
    {
        $string = $this->assertString($args[0], 'string');
        $stringContent = $this->compileStringContent($string);

        return new Number(Util::mbStrlen($stringContent), '');
    }

    private static $libStrSlice = ['string', 'start-at', 'end-at:-1'];
    private function libStrSlice($args)
    {
        $string = $this->assertString($args[0], 'string');
        $stringContent = $this->compileStringContent($string);

        $start = $this->assertNumber($args[1], 'start-at');
        $start->assertNoUnits('start-at');
        $startInt = $this->assertInteger($start, 'start-at');
        $end = $this->assertNumber($args[2], 'end-at');
        $end->assertNoUnits('end-at');
        $endInt = $this->assertInteger($end, 'end-at');

        if ($endInt === 0) {
            return [Type::T_STRING, $string[1], []];
        }

        if ($startInt > 0) {
            $startInt--;
        }

        if ($endInt < 0) {
            $endInt = Util::mbStrlen($stringContent) + $endInt;
        } else {
            $endInt--;
        }

        if ($endInt < $startInt) {
            return [Type::T_STRING, $string[1], []];
        }

        $length = $endInt - $startInt + 1; // The end of the slice is inclusive

        $string[2] = [Util::mbSubstr($stringContent, $startInt, $length)];

        return $string;
    }

    private static $libToLowerCase = ['string'];
    private function libToLowerCase($args)
    {
        $string = $this->assertString($args[0], 'string');
        $stringContent = $this->compileStringContent($string);

        $string[2] = [$this->stringTransformAsciiOnly($stringContent, 'strtolower')];

        return $string;
    }

    private static $libToUpperCase = ['string'];
    private function libToUpperCase($args)
    {
        $string = $this->assertString($args[0], 'string');
        $stringContent = $this->compileStringContent($string);

        $string[2] = [$this->stringTransformAsciiOnly($stringContent, 'strtoupper')];

        return $string;
    }

    /**
     * Apply a filter on a string content, only on ascii chars
     * let extended chars untouched
     *
     * @param string $stringContent
     * @param callable $filter
     * @return string
     */
    private function stringTransformAsciiOnly(string $stringContent, callable $filter): string
    {
        $mblength = Util::mbStrlen($stringContent);
        if ($mblength === strlen($stringContent)) {
            return $filter($stringContent);
        }
        $filteredString = "";
        for ($i = 0; $i < $mblength; $i++) {
            $char = Util::mbSubstr($stringContent, $i, 1);
            if (strlen($char) > 1) {
                $filteredString .= $char;
            } else {
                $filteredString .= $filter($char);
            }
        }

        return $filteredString;
    }

    private static $libFeatureExists = ['feature'];
    private function libFeatureExists($args)
    {
        $string = $this->assertString($args[0], 'feature');
        $name = $this->compileStringContent($string);

        return $this->toBool(
            \array_key_exists($name, $this->registeredFeatures) ? $this->registeredFeatures[$name] : false
        );
    }

    private static $libFunctionExists = ['name'];
    private function libFunctionExists($args)
    {
        $string = $this->assertString($args[0], 'name');
        $name = $this->compileStringContent($string);

        // user defined functions
        if ($this->has(self::$namespaces['function'] . $name)) {
            return self::$true;
        }

        $name = $this->normalizeName($name);

        if (isset($this->userFunctions[$name])) {
            return self::$true;
        }

        // built-in functions
        $f = $this->getBuiltinFunction($name);

        return $this->toBool($f !== null && \is_callable($f));
    }

    private static $libGlobalVariableExists = ['name'];
    private function libGlobalVariableExists($args)
    {
        $string = $this->assertString($args[0], 'name');
        $name = $this->compileStringContent($string);

        return $this->toBool($this->has($name, $this->rootEnv));
    }

    private static $libMixinExists = ['name'];
    private function libMixinExists($args)
    {
        $string = $this->assertString($args[0], 'name');
        $name = $this->compileStringContent($string);

        return $this->toBool($this->has(self::$namespaces['mixin'] . $name));
    }

    private static $libVariableExists = ['name'];
    private function libVariableExists($args)
    {
        $string = $this->assertString($args[0], 'name');
        $name = $this->compileStringContent($string);

        return $this->toBool($this->has($name));
    }

    private static $libRandom = ['limit:null'];
    private function libRandom($args)
    {
        if (isset($args[0]) && $args[0] !== self::$null) {
            $n = $this->assertInteger($args[0], 'limit');

            if ($n < 1) {
                throw new SassScriptException("\$limit: Must be greater than 0, was $n.");
            }

            return new Number(mt_rand(1, $n), '');
        }

        $max = mt_getrandmax();
        return new Number(mt_rand(0, $max - 1) / $max, '');
    }

    private static $libUniqueId = [];
    private function libUniqueId()
    {
        static $id;

        if (! isset($id)) {
            $id = PHP_INT_SIZE === 4
                ? mt_rand(0, pow(36, 5)) . str_pad(mt_rand(0, pow(36, 5)) % 10000000, 7, '0', STR_PAD_LEFT)
                : mt_rand(0, pow(36, 8));
        }

        $id += mt_rand(0, 10) + 1;

        return [Type::T_STRING, '', ['u' . str_pad(base_convert($id, 10, 36), 8, '0', STR_PAD_LEFT)]];
    }

    /**
     * @param array|Number $value
     * @param bool         $force_enclosing_display
     *
     * @return array
     */
    private function inspectFormatValue($value, $force_enclosing_display = false)
    {
        if ($value === self::$null) {
            $value = [Type::T_KEYWORD, 'null'];
        }

        $stringValue = [$value];

        if ($value instanceof Number) {
            return [Type::T_STRING, '', $stringValue];
        }

        if ($value[0] === Type::T_LIST) {
            if (end($value[2]) === self::$null) {
                array_pop($value[2]);
                $value[2][] = [Type::T_STRING, '', ['']];
                $force_enclosing_display = true;
            }

            if (
                ! empty($value['enclosing']) &&
                ($force_enclosing_display ||
                    ($value['enclosing'] === 'bracket') ||
                    ! \count($value[2]))
            ) {
                $value['enclosing'] = 'forced_' . $value['enclosing'];
                $force_enclosing_display = true;
            } elseif (! \count($value[2])) {
                $value['enclosing'] = 'forced_parent';
            }

            foreach ($value[2] as $k => $listelement) {
                $value[2][$k] = $this->inspectFormatValue($listelement, $force_enclosing_display);
            }

            $stringValue = [$value];
        }

        return [Type::T_STRING, '', $stringValue];
    }

    private static $libInspect = ['value'];
    private function libInspect($args)
    {
        $value = $args[0];

        return $this->inspectFormatValue($value);
    }

    /**
     * Preprocess selector args
     *
     * @param array       $arg
     * @param string|null $varname
     * @param bool        $allowParent
     *
     * @return array
     */
    private function getSelectorArg($arg, ?string $varname = null, bool $allowParent = false)
    {
        static $parser = null;

        if (\is_null($parser)) {
            $parser = $this->parserFactory(__METHOD__);
        }

        if (! $this->checkSelectorArgType($arg)) {
            $var_value = $this->compileValue($arg);
            throw SassScriptException::forArgument("$var_value is not a valid selector: it must be a string, a list of strings, or a list of lists of strings", $varname);
        }


        if ($arg[0] === Type::T_STRING) {
            $arg[1] = '';
        }
        $arg = $this->compileValue($arg);

        $parsedSelector = [];

        if ($parser->parseSelector($arg, $parsedSelector, true)) {
            $selector = $this->evalSelectors($parsedSelector);
            $gluedSelector = $this->glueFunctionSelectors($selector);

            if (! $allowParent) {
                foreach ($gluedSelector as $selector) {
                    foreach ($selector as $s) {
                        if (in_array(self::$selfSelector, $s)) {
                            throw SassScriptException::forArgument("Parent selectors aren't allowed here.", $varname);
                        }
                    }
                }
            }

            return $gluedSelector;
        }

        throw SassScriptException::forArgument("expected more input, invalid selector.", $varname);
    }

    /**
     * Check variable type for getSelectorArg() function
     * @param array $arg
     * @param int $maxDepth
     * @return bool
     */
    private function checkSelectorArgType($arg, int $maxDepth = 2): bool
    {
        if ($arg[0] === Type::T_LIST && $maxDepth > 0) {
            foreach ($arg[2] as $elt) {
                if (! $this->checkSelectorArgType($elt, $maxDepth - 1)) {
                    return false;
                }
            }
            return true;
        }
        if (!in_array($arg[0], [Type::T_STRING, Type::T_KEYWORD])) {
            return false;
        }
        return true;
    }

    /**
     * Postprocess selector to output in right format
     *
     * @param array $selectors
     *
     * @return array
     */
    private function formatOutputSelector(array $selectors): array
    {
        $selectors = $this->collapseSelectorsAsList($selectors);

        return $selectors;
    }

    private static $libIsSuperselector = ['super', 'sub'];
    private function libIsSuperselector($args)
    {
        list($super, $sub) = $args;

        $super = $this->getSelectorArg($super, 'super');
        $sub = $this->getSelectorArg($sub, 'sub');

        return $this->toBool($this->isSuperSelector($super, $sub));
    }

    /**
     * Test a $super selector again $sub
     *
     * @param array $super
     * @param array $sub
     *
     * @return bool
     */
    private function isSuperSelector(array $super, array $sub): bool
    {
        // one and only one selector for each arg
        if (! $super) {
            throw $this->error('Invalid super selector for isSuperSelector()');
        }

        if (! $sub) {
            throw $this->error('Invalid sub selector for isSuperSelector()');
        }

        if (count($sub) > 1) {
            foreach ($sub as $s) {
                if (! $this->isSuperSelector($super, [$s])) {
                    return false;
                }
            }
            return true;
        }

        if (count($super) > 1) {
            foreach ($super as $s) {
                if ($this->isSuperSelector([$s], $sub)) {
                    return true;
                }
            }
            return false;
        }

        $super = reset($super);
        $sub = reset($sub);

        $i = 0;
        $nextMustMatch = false;

        foreach ($super as $node) {
            $compound = '';

            array_walk_recursive(
                $node,
                function ($value, $key) use (&$compound) {
                    $compound .= $value;
                }
            );

            if ($this->isImmediateRelationshipCombinator($compound)) {
                if ($node !== $sub[$i]) {
                    return false;
                }

                $nextMustMatch = true;
                $i++;
            } else {
                while ($i < \count($sub) && ! $this->isSuperPart($node, $sub[$i])) {
                    if ($nextMustMatch) {
                        return false;
                    }

                    $i++;
                }

                if ($i >= \count($sub)) {
                    return false;
                }

                $nextMustMatch = false;
                $i++;
            }
        }

        return true;
    }

    /**
     * Test a part of super selector again a part of sub selector
     *
     * @param array $superParts
     * @param array $subParts
     *
     * @return bool
     */
    private function isSuperPart(array $superParts, array $subParts): bool
    {
        $i = 0;

        foreach ($superParts as $superPart) {
            while ($i < \count($subParts) && $subParts[$i] !== $superPart) {
                $i++;
            }

            if ($i >= \count($subParts)) {
                return false;
            }

            $i++;
        }

        return true;
    }

    private static $libSelectorAppend = ['selector...'];
    private function libSelectorAppend($args)
    {
        // get the selector... list
        $args = reset($args);
        $args = $args[2];

        if (\count($args) < 1) {
            throw $this->error('selector-append() needs at least 1 argument');
        }

        $selectors = [];
        foreach ($args as $arg) {
            $selectors[] = $this->getSelectorArg($arg, 'selector');
        }

        return $this->formatOutputSelector($this->selectorAppend($selectors));
    }

    /**
     * Append parts of the last selector in the list to the previous, recursively
     *
     * @param array $selectors
     *
     * @return array
     *
     * @throws \ScssPhp\ScssPhp\Exception\CompilerException
     */
    private function selectorAppend(array $selectors): array
    {
        $lastSelectors = array_pop($selectors);

        if (! $lastSelectors) {
            throw $this->error('Invalid selector list in selector-append()');
        }

        while (\count($selectors)) {
            $previousSelectors = array_pop($selectors);

            if (! $previousSelectors) {
                throw $this->error('Invalid selector list in selector-append()');
            }

            // do the trick, happening $lastSelector to $previousSelector
            $appended = [];

            foreach ($previousSelectors as $previousSelector) {
                foreach ($lastSelectors as $lastSelector) {
                    $previous = $previousSelector;
                    foreach ($previousSelector as $j => $previousSelectorParts) {
                        foreach ($lastSelector as $lastSelectorParts) {
                            foreach ($lastSelectorParts as $lastSelectorPart) {
                                $previous[$j][] = $lastSelectorPart;
                            }
                        }
                    }

                    $appended[] = $previous;
                }
            }

            $lastSelectors = $appended;
        }

        return $lastSelectors;
    }

    private static $libSelectorExtend = [
        ['selector', 'extendee', 'extender'],
        ['selectors', 'extendee', 'extender']
    ];
    private function libSelectorExtend($args)
    {
        list($selectors, $extendee, $extender) = $args;

        $selectors = $this->getSelectorArg($selectors, 'selector');
        $extendee  = $this->getSelectorArg($extendee, 'extendee');
        $extender  = $this->getSelectorArg($extender, 'extender');

        if (! $selectors || ! $extendee || ! $extender) {
            throw $this->error('selector-extend() invalid arguments');
        }

        $extended = $this->extendOrReplaceSelectors($selectors, $extendee, $extender);

        return $this->formatOutputSelector($extended);
    }

    private static $libSelectorReplace = [
        ['selector', 'original', 'replacement'],
        ['selectors', 'original', 'replacement']
    ];
    private function libSelectorReplace($args)
    {
        list($selectors, $original, $replacement) = $args;

        $selectors   = $this->getSelectorArg($selectors, 'selector');
        $original    = $this->getSelectorArg($original, 'original');
        $replacement = $this->getSelectorArg($replacement, 'replacement');

        if (! $selectors || ! $original || ! $replacement) {
            throw $this->error('selector-replace() invalid arguments');
        }

        $replaced = $this->extendOrReplaceSelectors($selectors, $original, $replacement, true);

        return $this->formatOutputSelector($replaced);
    }

    /**
     * Extend/replace in selectors
     * used by selector-extend and selector-replace that use the same logic
     *
     * @param array $selectors
     * @param array $extendee
     * @param array $extender
     * @param bool  $replace
     *
     * @return array
     */
    private function extendOrReplaceSelectors(array $selectors, array $extendee, array $extender, bool $replace = false): array
    {
        $saveExtends = $this->extends;
        $saveExtendsMap = $this->extendsMap;

        $this->extends = [];
        $this->extendsMap = [];

        foreach ($extendee as $es) {
            if (\count($es) !== 1) {
                throw $this->error('Can\'t extend complex selector.');
            }

            // only use the first one
            $this->pushExtends(reset($es), $extender, null);
        }

        $extended = [];

        foreach ($selectors as $selector) {
            if (! $replace) {
                $extended[] = $selector;
            }

            $n = \count($extended);

            $this->matchExtends($selector, $extended);

            // if didnt match, keep the original selector if we are in a replace operation
            if ($replace && \count($extended) === $n) {
                $extended[] = $selector;
            }
        }

        $this->extends = $saveExtends;
        $this->extendsMap = $saveExtendsMap;

        return $extended;
    }

    private static $libSelectorNest = ['selector...'];
    private function libSelectorNest($args)
    {
        // get the selector... list
        $args = reset($args);
        $args = $args[2];

        if (\count($args) < 1) {
            throw $this->error('selector-nest() needs at least 1 argument');
        }

        $selectorsMap = [];
        foreach ($args as $arg) {
            $selectorsMap[] = $this->getSelectorArg($arg, 'selector', true);
        }

        assert(!empty($selectorsMap));

        $envs = [];

        foreach ($selectorsMap as $selectors) {
            $env = new Environment();
            $env->selectors = $selectors;

            $envs[] = $env;
        }

        $envs            = array_reverse($envs);
        $env             = $this->extractEnv($envs);
        $outputSelectors = $this->multiplySelectors($env);

        return $this->formatOutputSelector($outputSelectors);
    }

    private static $libSelectorParse = [
        ['selector'],
        ['selectors']
    ];
    private function libSelectorParse($args)
    {
        $selectors = reset($args);
        $selectors = $this->getSelectorArg($selectors, 'selector');

        return $this->formatOutputSelector($selectors);
    }

    private static $libSelectorUnify = ['selectors1', 'selectors2'];
    private function libSelectorUnify($args)
    {
        list($selectors1, $selectors2) = $args;

        $selectors1 = $this->getSelectorArg($selectors1, 'selectors1');
        $selectors2 = $this->getSelectorArg($selectors2, 'selectors2');

        if (! $selectors1 || ! $selectors2) {
            throw $this->error('selector-unify() invalid arguments');
        }

        // only consider the first compound of each
        $compound1 = reset($selectors1);
        $compound2 = reset($selectors2);

        // unify them and that's it
        $unified = $this->unifyCompoundSelectors($compound1, $compound2);

        return $this->formatOutputSelector($unified);
    }

    /**
     * The selector-unify magic as its best
     * (at least works as expected on test cases)
     *
     * @param array $compound1
     * @param array $compound2
     *
     * @return array
     */
    private function unifyCompoundSelectors(array $compound1, array $compound2): array
    {
        if (! \count($compound1)) {
            return $compound2;
        }

        if (! \count($compound2)) {
            return $compound1;
        }

        // check that last part are compatible
        $lastPart1 = array_pop($compound1);
        $lastPart2 = array_pop($compound2);
        $last      = $this->mergeParts($lastPart1, $lastPart2);

        if (! $last) {
            return [[]];
        }

        $unifiedCompound = [$last];
        $unifiedSelectors = [$unifiedCompound];

        // do the rest
        while (\count($compound1) || \count($compound2)) {
            $part1 = end($compound1);
            $part2 = end($compound2);

            if ($part1 && ($match2 = $this->matchPartInCompound($part1, $compound2))) {
                list($compound2, $part2, $after2) = $match2;

                if ($after2) {
                    $unifiedSelectors = $this->prependSelectors($unifiedSelectors, $after2);
                }

                $c = $this->mergeParts($part1, $part2);
                $unifiedSelectors = $this->prependSelectors($unifiedSelectors, [$c]);

                $part1 = $part2 = null;

                array_pop($compound1);
            }

            if ($part2 && ($match1 = $this->matchPartInCompound($part2, $compound1))) {
                list($compound1, $part1, $after1) = $match1;

                if ($after1) {
                    $unifiedSelectors = $this->prependSelectors($unifiedSelectors, $after1);
                }

                $c = $this->mergeParts($part2, $part1);
                $unifiedSelectors = $this->prependSelectors($unifiedSelectors, [$c]);

                $part1 = $part2 = null;

                array_pop($compound2);
            }

            $new = [];

            if ($part1 && $part2) {
                array_pop($compound1);
                array_pop($compound2);

                $s   = $this->prependSelectors($unifiedSelectors, [$part2]);
                $new = array_merge($new, $this->prependSelectors($s, [$part1]));
                $s   = $this->prependSelectors($unifiedSelectors, [$part1]);
                $new = array_merge($new, $this->prependSelectors($s, [$part2]));
            } elseif ($part1) {
                array_pop($compound1);

                $new = array_merge($new, $this->prependSelectors($unifiedSelectors, [$part1]));
            } elseif ($part2) {
                array_pop($compound2);

                $new = array_merge($new, $this->prependSelectors($unifiedSelectors, [$part2]));
            }

            if ($new) {
                $unifiedSelectors = $new;
            }
        }

        return $unifiedSelectors;
    }

    /**
     * Prepend each selector from $selectors with $parts
     *
     * @param array $selectors
     * @param array $parts
     *
     * @return array
     */
    private function prependSelectors(array $selectors, array $parts): array
    {
        $new = [];

        foreach ($selectors as $compoundSelector) {
            array_unshift($compoundSelector, $parts);

            $new[] = $compoundSelector;
        }

        return $new;
    }

    /**
     * Try to find a matching part in a compound:
     * - with same html tag name
     * - with some class or id or something in common
     *
     * @param array $part
     * @param array $compound
     *
     * @return array|false
     */
    private function matchPartInCompound(array $part, array $compound)
    {
        $partTag = $this->findTagName($part);
        $before  = $compound;
        $after   = [];

        // try to find a match by tag name first
        while (\count($before)) {
            $p = array_pop($before);

            if ($partTag && $partTag !== '*' && $partTag == $this->findTagName($p)) {
                return [$before, $p, $after];
            }

            $after[] = $p;
        }

        // try again matching a non empty intersection and a compatible tagname
        $before = $compound;
        $after = [];

        while (\count($before)) {
            $p = array_pop($before);

            if ($this->checkCompatibleTags($partTag, $this->findTagName($p))) {
                if (\count(array_intersect($part, $p))) {
                    return [$before, $p, $after];
                }
            }

            $after[] = $p;
        }

        return false;
    }

    /**
     * Merge two part list taking care that
     * - the html tag is coming first - if any
     * - the :something are coming last
     *
     * @param array $parts1
     * @param array $parts2
     *
     * @return array
     */
    private function mergeParts(array $parts1, array $parts2): array
    {
        $tag1 = $this->findTagName($parts1);
        $tag2 = $this->findTagName($parts2);
        $tag  = $this->checkCompatibleTags($tag1, $tag2);

        // not compatible tags
        if ($tag === false) {
            return [];
        }

        if ($tag) {
            if ($tag1) {
                $parts1 = array_diff($parts1, [$tag1]);
            }

            if ($tag2) {
                $parts2 = array_diff($parts2, [$tag2]);
            }
        }

        $mergedParts = array_merge($parts1, $parts2);
        $mergedOrderedParts = [];

        foreach ($mergedParts as $part) {
            if (strpos($part, ':') === 0) {
                $mergedOrderedParts[] = $part;
            }
        }

        $mergedParts = array_diff($mergedParts, $mergedOrderedParts);
        $mergedParts = array_merge($mergedParts, $mergedOrderedParts);

        if ($tag) {
            array_unshift($mergedParts, $tag);
        }

        return $mergedParts;
    }

    /**
     * Check the compatibility between two tag names:
     * if both are defined they should be identical or one has to be '*'
     *
     * @param string $tag1
     * @param string $tag2
     *
     * @return array|false
     */
    private function checkCompatibleTags(string $tag1, string $tag2)
    {
        $tags = [$tag1, $tag2];
        $tags = array_unique($tags);
        $tags = array_filter($tags);

        if (\count($tags) > 1) {
            $tags = array_diff($tags, ['*']);
        }

        // not compatible nodes
        if (\count($tags) > 1) {
            return false;
        }

        return $tags;
    }

    /**
     * Find the html tag name in a selector parts list
     *
     * @param string[] $parts
     *
     * @return string
     */
    private function findTagName(array $parts): string
    {
        foreach ($parts as $part) {
            if (! preg_match('/^[\[.:#%_-]/', $part)) {
                return $part;
            }
        }

        return '';
    }

    private static $libSimpleSelectors = ['selector'];
    private function libSimpleSelectors($args)
    {
        $selector = reset($args);
        $selector = $this->getSelectorArg($selector, 'selector');

        // remove selectors list layer, keeping the first one
        $selector = reset($selector);

        // remove parts list layer, keeping the first part
        $part = reset($selector);

        $listParts = [];

        foreach ($part as $p) {
            $listParts[] = [Type::T_STRING, '', [$p]];
        }

        return [Type::T_LIST, ',', $listParts];
    }
}
