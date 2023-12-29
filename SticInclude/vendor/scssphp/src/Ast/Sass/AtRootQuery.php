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

namespace ScssPhp\ScssPhp\Ast\Sass;

use ScssPhp\ScssPhp\Exception\SassFormatException;
use ScssPhp\ScssPhp\Logger\LoggerInterface;
use ScssPhp\ScssPhp\Parser\AtRootQueryParser;

/**
 * A query for the `@at-root` rule.
 *
 * @internal
 */
class AtRootQuery
{
    /**
     * Whether the query includes or excludes rules with the specified names.
     *
     * @var bool
     * @readonly
     */
    private $include;

    /**
     * The names of the rules included or excluded by this query.
     *
     * There are two special names. "all" indicates that all rules are included
     * or excluded, and "rule" indicates style rules are included or excluded.
     *
     * @var string[]
     * @readonly
     */
    private $names;

    /**
     * Whether this includes or excludes *all* rules.
     *
     * @var bool
     * @readonly
     */
    private $all;

    /**
     * Whether this includes or excludes style rules.
     *
     * @var bool
     * @readonly
     */
    private $rule;

    /**
     * Parses an at-root query from $contents.
     *
     * If passed, $url is the name of the file from which $contents comes.
     *
     * @throws SassFormatException if parsing fails
     */
    public static function parse(string $contents, ?LoggerInterface $logger = null, ?string $url = null): AtRootQuery
    {
        return (new AtRootQueryParser($contents, $logger, $url))->parse();
    }

    /**
     * @param string[] $names
     * @param bool     $include
     */
    public static function create(array $names, bool $include): AtRootQuery
    {
        return new AtRootQuery($names, $include, \in_array('all', $names, true), \in_array('rule', $names, true));
    }

    /**
     * The default at-root query
     */
    public static function getDefault(): AtRootQuery
    {
        return new AtRootQuery([], false, false, true);
    }

    /**
     * @param string[] $names
     * @param bool     $include
     * @param bool     $all
     * @param bool     $rule
     */
    private function __construct(array $names, bool $include, bool $all, bool $rule)
    {
        $this->include = $include;
        $this->names = $names;
        $this->all = $all;
        $this->rule = $rule;
    }

    public function getInclude(): bool
    {
        return $this->include;
    }

    /**
     * @return string[]
     */
    public function getNames(): array
    {
        return $this->names;
    }

    /**
     * Whether this excludes style rules.
     *
     * Note that this takes {@see include} into account.
     */
    public function excludesStyleRules(): bool
    {
        return ($this->all || $this->rule) !== $this->include;
    }

    /**
     * Returns whether $this excludes an at-rule with the given $name.
     */
    public function excludesName(string $name): bool
    {
        return ($this->all || \in_array($name, $this->names, true)) !== $this->include;
    }
}
