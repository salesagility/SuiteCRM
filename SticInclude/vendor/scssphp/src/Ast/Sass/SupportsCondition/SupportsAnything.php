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

namespace ScssPhp\ScssPhp\Ast\Sass\SupportsCondition;

use ScssPhp\ScssPhp\Ast\Sass\Interpolation;
use ScssPhp\ScssPhp\Ast\Sass\SupportsCondition;
use ScssPhp\ScssPhp\SourceSpan\FileSpan;

/**
 * A supports condition that represents the forwards-compatible
 * `<general-enclosed>` production.
 *
 * @internal
 */
final class SupportsAnything implements SupportsCondition
{
    /**
     * The contents of the condition.
     *
     * @var Interpolation
     * @readonly
     */
    private $contents;

    /**
     * @var FileSpan
     * @readonly
     */
    private $span;

    public function __construct(Interpolation $contents, FileSpan $span)
    {
        $this->contents = $contents;
        $this->span = $span;
    }

    public function getContents(): Interpolation
    {
        return $this->contents;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }
}
