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

use ScssPhp\ScssPhp\SourceSpan\FileSpan;

/**
 * An argument declaration, as for a function or mixin definition.
 *
 * @internal
 */
final class ArgumentDeclaration implements SassNode
{
    /**
     * @var list<Argument>
     * @readonly
     */
    private $arguments;

    /**
     * @var string|null
     * @readonly
     */
    private $restArgument;

    /**
     * @var FileSpan
     * @readonly
     */
    private $span;

    /**
     * @param list<Argument> $arguments
     * @param FileSpan      $span
     * @param string|null $restArgument
     */
    public function __construct(array $arguments, FileSpan $span, ?string $restArgument = null)
    {
        $this->arguments = $arguments;
        $this->restArgument = $restArgument;
        $this->span = $span;
    }

    public static function createEmpty(FileSpan $span): ArgumentDeclaration
    {
        return new self([], $span);
    }

    public function isEmpty(): bool
    {
        return \count($this->arguments) === 0 && $this->restArgument === null;
    }

    /**
     * @return list<Argument>
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function getRestArgument(): ?string
    {
        return $this->restArgument;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }
}
