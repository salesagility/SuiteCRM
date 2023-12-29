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

namespace ScssPhp\ScssPhp\Ast\Css;

use ScssPhp\ScssPhp\Exception\SassFormatException;
use ScssPhp\ScssPhp\Logger\LoggerInterface;
use ScssPhp\ScssPhp\Parser\MediaQueryParser;

/**
 * A plain CSS media query, as used in `@media` and `@import`.
 *
 * @internal
 */
final class CssMediaQuery
{
    public const MERGE_RESULT_EMPTY = 'empty';
    public const MERGE_RESULT_UNREPRESENTABLE = 'unrepresentable';

    /**
     * The modifier, probably either "not" or "only".
     *
     * This may be `null` if no modifier is in use.
     *
     * @var string|null
     * @readonly
     */
    private $modifier;

    /**
     * The media type, for example "screen" or "print".
     *
     * This may be `null`. If so, {@see $features} will not be empty.
     *
     * @var string|null
     * @readonly
     */
    private $type;

    /**
     * Feature queries, including parentheses.
     *
     * @var string[]
     * @readonly
     */
    private $features;

    /**
     * Parses a media query from $contents.
     *
     * If passed, $url is the name of the file from which $contents comes.
     *
     * @return list<CssMediaQuery>
     *
     * @throws SassFormatException if parsing fails
     */
    public static function parseList(string $contents, ?LoggerInterface $logger = null, ?string $url = null): array
    {
        return (new MediaQueryParser($contents, $logger, $url))->parse();
    }

    /**
     * @param string|null $type
     * @param string|null $modifier
     * @param string[]    $features
     */
    public function __construct(?string $type, ?string $modifier = null, array $features = [])
    {
        $this->modifier = $modifier;
        $this->type = $type;
        $this->features = $features;
    }

    /**
     * Creates a media query that only specifies features.
     *
     * @param string[] $features
     *
     * @return CssMediaQuery
     */
    public static function condition(array $features): CssMediaQuery
    {
        return new CssMediaQuery(null, null, $features);
    }

    public function getModifier(): ?string
    {
        return $this->modifier;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return string[]
     */
    public function getFeatures(): array
    {
        return $this->features;
    }

    /**
     * Whether this media query only specifies features.
     */
    public function isCondition(): bool
    {
        return $this->modifier === null && $this->type === null;
    }

    /**
     * Whether this media query matches all media types.
     */
    public function matchesAllTypes(): bool
    {
        return $this->type === null || strtolower($this->type) === 'all';
    }

    /**
     * Merges this with $other to return a query that matches the intersection
     * of both inputs.
     *
     * @return CssMediaQuery|string
     * @phpstan-return CssMediaQuery|CssMediaQuery::*
     */
    public function merge(CssMediaQuery $other)
    {
        $ourModifier = $this->modifier !== null ? strtolower($this->modifier) : null;
        $ourType = $this->type !== null ? strtolower($this->type) : null;
        $theirModifier = $other->modifier !== null ? strtolower($other->modifier) : null;
        $theirType = $other->type !== null ? strtolower($other->type) : null;

        if ($ourType === null && $theirType === null) {
            return self::condition(array_merge($this->features, $other->features));
        }

        if (($ourModifier === 'not') !== ($theirModifier === 'not')) {
            if ($ourType === $theirType) {
                $negativeFeatures = $ourModifier === 'not' ? $this->features : $other->features;
                $positiveFeatures = $ourModifier === 'not' ? $other->features : $this->features;

                // If the negative features are a subset of the positive features, the
                // query is empty. For example, `not screen and (color)` has no
                // intersection with `screen and (color) and (grid)`.
                //
                // However, `not screen and (color)` *does* intersect with `screen and
                // (grid)`, because it means `not (screen and (color))` and so it allows
                // a screen with no color but with a grid.
                if (empty(array_diff($negativeFeatures, $positiveFeatures))) {
                    return self::MERGE_RESULT_EMPTY;
                }

                return self::MERGE_RESULT_UNREPRESENTABLE;
            }

            if ($this->matchesAllTypes() || $other->matchesAllTypes()) {
                return self::MERGE_RESULT_UNREPRESENTABLE;
            }

            if ($ourModifier === 'not') {
                $modifier = $theirModifier;
                $type = $theirType;
                $features = $other->features;
            } else {
                $modifier = $ourModifier;
                $type = $ourType;
                $features = $this->features;
            }
        } elseif ($ourModifier === 'not') {
            // CSS has no way of representing "neither screen nor print".
            if ($ourType !== $theirType) {
                return self::MERGE_RESULT_UNREPRESENTABLE;
            }

            $moreFeatures = \count($this->features) > \count($other->features) ? $this->features : $other->features;
            $fewerFeatures = \count($this->features) > \count($other->features) ? $other->features : $this->features;

            // If one set of features is a superset of the other, use those features
            // because they're strictly narrower.
            if (empty(array_diff($fewerFeatures, $moreFeatures))) {
                $modifier = $ourModifier; // "not"
                $type = $ourType;
                $features = $moreFeatures;
            } else {
                // Otherwise, there's no way to represent the intersection.
                return self::MERGE_RESULT_UNREPRESENTABLE;
            }
        } elseif ($this->matchesAllTypes()) {
            $modifier = $theirModifier;
            // Omit the type if either input query did, since that indicates that they
            // aren't targeting a browser that requires "all and".
            $type = $other->matchesAllTypes() && $ourType === null ? null : $theirType;
            $features = array_merge($this->features, $other->features);
        } elseif ($other->matchesAllTypes()) {
            $modifier = $ourModifier;
            $type = $ourType;
            $features = array_merge($this->features, $other->features);
        } elseif ($ourType !== $theirType) {
            return self::MERGE_RESULT_EMPTY;
        } else {
            $modifier = $ourModifier ?? $theirModifier;
            $type = $ourType;
            $features = array_merge($this->features, $other->features);
        }

        return new CssMediaQuery(
            $type === $ourType ? $this->type : $other->type,
            $modifier === $ourModifier ? $this->modifier : $other->modifier,
            $features
        );
    }
}
