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

namespace ScssPhp\ScssPhp\Ast\Sass\Statement;

use ScssPhp\ScssPhp\Ast\Sass\Expression;
use ScssPhp\ScssPhp\Ast\Sass\Expression\StringExpression;
use ScssPhp\ScssPhp\Ast\Sass\Interpolation;
use ScssPhp\ScssPhp\Ast\Sass\Statement;
use ScssPhp\ScssPhp\SourceSpan\FileSpan;
use ScssPhp\ScssPhp\Visitor\StatementVisitor;

/**
 * A declaration (that is, a `name: value` pair).
 *
 * @extends ParentStatement<Statement[]|null>
 *
 * @internal
 */
final class Declaration extends ParentStatement
{
    /**
     * @var Interpolation
     * @readonly
     */
    private $name;

    /**
     * The value of this declaration.
     *
     * If {@see getChildren} is `null`, this is never `null`. Otherwise, it may or may
     * not be `null`.
     *
     * @var Expression|null
     * @readonly
     */
    private $value;

    /**
     * @var FileSpan
     * @readonly
     */
    private $span;

    /**
     * @param Statement[]|null $children
     */
    private function __construct(Interpolation $name, ?Expression $value, FileSpan $span, ?array $children = null)
    {
        $this->name = $name;
        $this->value = $value;
        $this->span = $span;
        parent::__construct($children);
    }

    public static function create(Interpolation $name, Expression $value, FileSpan $span): self
    {
        $declaration = new self($name, $value, $span);

        if ($declaration->isCustomProperty() && !$value instanceof StringExpression) {
            throw new \InvalidArgumentException(sprintf('Declarations whose names begin with "--" must have StringExpression values (got %s)', get_class($value)));
        }

        return $declaration;
    }

    /**
     * @param Statement[] $children
     */
    public static function nested(Interpolation $name, array $children, FileSpan $span, ?Expression $value = null): self
    {
        $declaration = new self($name, $value, $span, $children);

        if ($declaration->isCustomProperty() && !$value instanceof StringExpression) {
            throw new \InvalidArgumentException('Declarations whose names begin with "--" may not be nested.');
        }

        return $declaration;
    }

    public function getName(): Interpolation
    {
        return $this->name;
    }

    public function getValue(): ?Expression
    {
        return $this->value;
    }

    /**
     * Returns whether this is a CSS Custom Property declaration.
     *
     * Note that this can return `false` for declarations that will ultimately be
     * serialized as custom properties if they aren't *parsed as* custom
     * properties, such as `#{--foo}: ...`.
     *
     * If this is `true`, then `value` will be a {@see StringExpression}.
     */
    public function isCustomProperty(): bool
    {
        return 0 === strpos($this->name->getInitialPlain(), '--');
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accepts(StatementVisitor $visitor)
    {
        return $visitor->visitDeclaration($this);
    }
}
