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

namespace ScssPhp\ScssPhp\Value;

final class SassArgumentList extends SassList
{
    /**
     * @var array<string, Value>
     */
    private $keywords;

    /**
     * @var bool
     */
    private $keywordAccessed = false;

    /**
     * SassArgumentList constructor.
     *
     * @param list<Value>          $contents
     * @param array<string, Value> $keywords
     * @param string               $separator
     *
     * @phpstan-param ListSeparator::* $separator
     */
    public function __construct(array $contents, array $keywords, string $separator)
    {
        parent::__construct($contents, $separator);
        $this->keywords = $keywords;
    }

    /**
     * @return array<string, Value>
     */
    public function getKeywords(): array
    {
        $this->keywordAccessed = true;

        return $this->keywords;
    }

    /**
     * @return bool
     *
     * @internal
     */
    public function wereKeywordAccessed(): bool
    {
        return $this->keywordAccessed;
    }
}
