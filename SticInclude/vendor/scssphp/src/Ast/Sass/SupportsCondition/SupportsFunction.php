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
 * A function-syntax condition.
 *
 * @internal
 */
final class SupportsFunction implements SupportsCondition
{
    /**
     * The name of the function.
     *
     * @var Interpolation
     * @readonly
     */
    private $name;

    /**
     * The arguments of the function.
     *
     * @var Interpolation
     * @readonly
     */
    private $arguments;

    /**
     * @var FileSpan
     * @readonly
     */
    private $span;

    public function __construct(Interpolation $name, Interpolation $arguments, FileSpan $span)
    {
        $this->name = $name;
        $this->arguments = $arguments;
        $this->span = $span;
    }

    public function getName(): Interpolation
    {
        return $this->name;
    }

    public function getArguments(): Interpolation
    {
        return $this->arguments;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }
}
