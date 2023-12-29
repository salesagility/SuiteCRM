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

namespace ScssPhp\ScssPhp\Ast\Sass\Expression;

use ScssPhp\ScssPhp\Ast\Sass\ArgumentInvocation;
use ScssPhp\ScssPhp\Ast\Sass\CallableInvocation;
use ScssPhp\ScssPhp\Ast\Sass\Expression;
use ScssPhp\ScssPhp\Ast\Sass\Interpolation;
use ScssPhp\ScssPhp\SourceSpan\FileSpan;
use ScssPhp\ScssPhp\Visitor\ExpressionVisitor;

/**
 * An interpolated function invocation.
 *
 * This is always a plain CSS function.
 *
 * @internal
 */
final class InterpolatedFunctionExpression implements Expression, CallableInvocation
{
    /**
     * The name of the function being invoked.
     *
     * @var Interpolation
     * @readonly
     */
    private $name;

    /**
     * The arguments to pass to the function.
     *
     * @var ArgumentInvocation
     * @readonly
     */
    private $arguments;

    /**
     * @var FileSpan
     * @readonly
     */
    private $span;

    public function __construct(Interpolation $name, ArgumentInvocation $arguments, FileSpan $span)
    {
        $this->span = $span;
        $this->name = $name;
        $this->arguments = $arguments;
    }

    public function getName(): Interpolation
    {
        return $this->name;
    }

    public function getArguments(): ArgumentInvocation
    {
        return $this->arguments;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accepts(ExpressionVisitor $visitor)
    {
        return $visitor->visitInterpolatedFunctionExpression($this);
    }
}
