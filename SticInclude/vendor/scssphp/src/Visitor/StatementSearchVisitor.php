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

namespace ScssPhp\ScssPhp\Visitor;

use ScssPhp\ScssPhp\Ast\Sass\Argument;
use ScssPhp\ScssPhp\Ast\Sass\ArgumentInvocation;
use ScssPhp\ScssPhp\Ast\Sass\Expression;
use ScssPhp\ScssPhp\Ast\Sass\Import;
use ScssPhp\ScssPhp\Ast\Sass\Import\StaticImport;
use ScssPhp\ScssPhp\Ast\Sass\Interpolation;
use ScssPhp\ScssPhp\Ast\Sass\Statement;
use ScssPhp\ScssPhp\Ast\Sass\Statement\AtRootRule;
use ScssPhp\ScssPhp\Ast\Sass\Statement\AtRule;
use ScssPhp\ScssPhp\Ast\Sass\Statement\CallableDeclaration;
use ScssPhp\ScssPhp\Ast\Sass\Statement\ContentBlock;
use ScssPhp\ScssPhp\Ast\Sass\Statement\ContentRule;
use ScssPhp\ScssPhp\Ast\Sass\Statement\DebugRule;
use ScssPhp\ScssPhp\Ast\Sass\Statement\Declaration;
use ScssPhp\ScssPhp\Ast\Sass\Statement\EachRule;
use ScssPhp\ScssPhp\Ast\Sass\Statement\ErrorRule;
use ScssPhp\ScssPhp\Ast\Sass\Statement\ExtendRule;
use ScssPhp\ScssPhp\Ast\Sass\Statement\ForRule;
use ScssPhp\ScssPhp\Ast\Sass\Statement\FunctionRule;
use ScssPhp\ScssPhp\Ast\Sass\Statement\IfClause;
use ScssPhp\ScssPhp\Ast\Sass\Statement\IfRule;
use ScssPhp\ScssPhp\Ast\Sass\Statement\ImportRule;
use ScssPhp\ScssPhp\Ast\Sass\Statement\IncludeRule;
use ScssPhp\ScssPhp\Ast\Sass\Statement\LoudComment;
use ScssPhp\ScssPhp\Ast\Sass\Statement\MediaRule;
use ScssPhp\ScssPhp\Ast\Sass\Statement\MixinRule;
use ScssPhp\ScssPhp\Ast\Sass\Statement\ParentStatement;
use ScssPhp\ScssPhp\Ast\Sass\Statement\ReturnRule;
use ScssPhp\ScssPhp\Ast\Sass\Statement\SilentComment;
use ScssPhp\ScssPhp\Ast\Sass\Statement\StyleRule;
use ScssPhp\ScssPhp\Ast\Sass\Statement\Stylesheet;
use ScssPhp\ScssPhp\Ast\Sass\Statement\SupportsRule;
use ScssPhp\ScssPhp\Ast\Sass\Statement\VariableDeclaration;
use ScssPhp\ScssPhp\Ast\Sass\Statement\WarnRule;
use ScssPhp\ScssPhp\Ast\Sass\Statement\WhileRule;
use ScssPhp\ScssPhp\Ast\Sass\SupportsCondition;
use ScssPhp\ScssPhp\Ast\Sass\SupportsCondition\SupportsDeclaration;
use ScssPhp\ScssPhp\Ast\Sass\SupportsCondition\SupportsInterpolation;
use ScssPhp\ScssPhp\Ast\Sass\SupportsCondition\SupportsNegation;
use ScssPhp\ScssPhp\Ast\Sass\SupportsCondition\SupportsOperation;

/**
 * A StatementVisitor whose `visit*` methods default to returning `null`, but
 * which returns the first non-`null` value returned by any method.
 *
 * This can be extended to find the first instance of particular nodes in the
 * AST.
 *
 * @internal
 *
 * @template T
 * @template-implements StatementVisitor<T|null>
 */
abstract class StatementSearchVisitor implements StatementVisitor
{
    public function visitAtRootRule(AtRootRule $node)
    {
        if ($node->getQuery() !== null) {
            $result = $this->visitInterpolation($node->getQuery());

            if ($result !== null) {
                return $result;
            }
        }

        return $this->visitChildren($node->getChildren());
    }

    public function visitAtRule(AtRule $node)
    {
        $value = $this->visitInterpolation($node->getName());

        if ($node->getValue() !== null) {
            $value = $value ?? $this->visitInterpolation($node->getValue());
        }

        if ($node->getChildren() !== null) {
            $value = $value ?? $this->visitChildren($node->getChildren());
        }

        return $value;
    }

    public function visitContentBlock(ContentBlock $node)
    {
        return $this->visitCallableDeclaration($node);
    }

    public function visitContentRule(ContentRule $node)
    {
        return $this->visitArgumentInvocation($node->getArguments());
    }

    public function visitDebugRule(DebugRule $node)
    {
        return $this->visitExpression($node->getExpression());
    }

    public function visitDeclaration(Declaration $node)
    {
        $value = $this->visitInterpolation($node->getName());

        if ($node->getValue() !== null) {
            $value = $value ?? $this->visitExpression($node->getValue());
        }

        if ($node->getChildren() !== null) {
            $value = $value ?? $this->visitChildren($node->getChildren());
        }

        return $value;
    }

    public function visitEachRule(EachRule $node)
    {
        return $this->visitExpression($node->getList()) ?? $this->visitChildren($node->getChildren());
    }

    public function visitErrorRule(ErrorRule $node)
    {
        return $this->visitExpression($node->getExpression());
    }

    public function visitExtendRule(ExtendRule $node)
    {
        return $this->visitInterpolation($node->getSelector());
    }

    public function visitForRule(ForRule $node)
    {
        return $this->visitExpression($node->getFrom()) ?? $this->visitExpression($node->getTo()) ?? $this->visitChildren($node->getChildren());
    }

    public function visitFunctionRule(FunctionRule $node)
    {
        return $this->visitCallableDeclaration($node);
    }

    public function visitIfRule(IfRule $node)
    {
        $value = $this->searchIterable($node->getClauses(), function (IfClause $clause) {
            return $this->visitExpression($clause->getExpression()) ?? $this->visitChildren($clause->getChildren());
        });

        if ($node->getLastClause() !== null) {
            $value = $value ?? $this->visitChildren($node->getLastClause()->getChildren());
        }

        return $value;
    }

    public function visitImportRule(ImportRule $node)
    {
        return $this->searchIterable($node->getImports(), function (Import $import) {
            if ($import instanceof StaticImport) {
                $value = $this->visitInterpolation($import->getUrl());

                if ($import->getSupports() !== null) {
                    $value = $value ?? $this->visitSupportsCondition($import->getSupports());
                }

                if ($import->getMedia() !== null) {
                    $value = $value ?? $this->visitInterpolation($import->getMedia());
                }

                return $value;
            }

            return null;
        });
    }

    public function visitIncludeRule(IncludeRule $node)
    {
        $value = $this->visitArgumentInvocation($node->getArguments());

        if ($value !== null) {
            return $value;
        }

        if ($node->getContent() !== null) {
            return $this->visitContentBlock($node->getContent());
        }

        return null;
    }

    public function visitLoudComment(LoudComment $node)
    {
        return $this->visitInterpolation($node->getText());
    }

    public function visitMediaRule(MediaRule $node)
    {
        return $this->visitInterpolation($node->getQuery()) ?? $this->visitChildren($node->getChildren());
    }

    public function visitMixinRule(MixinRule $node)
    {
        return $this->visitCallableDeclaration($node);
    }

    public function visitReturnRule(ReturnRule $node)
    {
        return $this->visitExpression($node->getExpression());
    }

    public function visitSilentComment(SilentComment $node)
    {
        return null;
    }

    public function visitStyleRule(StyleRule $node)
    {
        return $this->visitInterpolation($node->getSelector()) ?? $this->visitChildren($node->getChildren());
    }

    public function visitStylesheet(Stylesheet $node)
    {
        return $this->visitChildren($node->getChildren());
    }

    public function visitSupportsRule(SupportsRule $node)
    {
        return $this->visitSupportsCondition($node->getCondition()) ?? $this->visitChildren($node->getChildren());
    }

    public function visitVariableDeclaration(VariableDeclaration $node)
    {
        return $this->visitExpression($node->getExpression());
    }

    public function visitWarnRule(WarnRule $node)
    {
        return $this->visitExpression($node->getExpression());
    }

    public function visitWhileRule(WhileRule $node)
    {
        return $this->visitExpression($node->getCondition()) ?? $this->visitChildren($node->getChildren());
    }

    /**
     * Visits each of $node's expressions and children.
     *
     * The default implementations of {@see visitFunctionRule} and {@see visitMixinRule}
     * call this.
     *
     * @return T|null
     */
    protected function visitCallableDeclaration(CallableDeclaration $node)
    {
        return $this->searchIterable($node->getArguments()->getArguments(), function (Argument $argument) {
            if ($argument->getDefaultValue() === null) {
                return null;
            }

            return $this->visitExpression($argument->getDefaultValue());
        }) ?? $this->visitChildren($node->getChildren());
    }

    /**
     * Visits each expression in an invocation.
     *
     * The default implementation of the visit methods calls this to visit any
     * argument invocation in a statement.
     *
     * @return T|null
     */
    protected function visitArgumentInvocation(ArgumentInvocation $invocation)
    {
        $value = $this->searchIterable($invocation->getPositional(), [$this, 'visitExpression'])
            ?? $this->searchIterable($invocation->getNamed(), [$this, 'visitExpression']);

        if ($value !== null) {
            return $value;
        }

        if ($invocation->getRest() !== null) {
            $value = $this->visitExpression($invocation->getRest());

            if ($value !== null) {
                return $value;
            }
        }

        if ($invocation->getKeywordRest() !== null) {
            return $this->visitExpression($invocation->getKeywordRest());
        }

        return null;
    }

    /**
     * Visits each expression in $condition.
     *
     * The default implementation of the visit methods call this to visit any
     * {@see SupportsCondition} they encounter.
     *
     * @return T|null
     */
    protected function visitSupportsCondition(SupportsCondition $condition)
    {
        if ($condition instanceof SupportsOperation) {
            return $this->visitSupportsCondition($condition->getLeft()) ?? $this->visitSupportsCondition($condition->getRight());
        }

        if ($condition instanceof SupportsNegation) {
            return $this->visitSupportsCondition($condition->getCondition());
        }

        if ($condition instanceof SupportsInterpolation) {
            return $this->visitExpression($condition->getExpression());
        }

        if ($condition instanceof SupportsDeclaration) {
            return $this->visitExpression($condition->getName()) ?? $this->visitExpression($condition->getValue());
        }

        return null;
    }

    /**
     * Visits each child in $children.
     *
     * The default implementation of the visit methods for all {@see ParentStatement}s
     * call this.
     *
     * @param Statement[] $children
     *
     * @return T|null
     */
    protected function visitChildren(array $children)
    {
        foreach ($children as $child) {
            $result = $child->accepts($this);

            if ($result !== null) {
                return $result;
            }
        }

        return null;
    }

    /**
     * Visits each expression in an interpolation.
     *
     * The default implementation of the visit methods call this to visit any
     * interpolation in a statement.
     *
     * @return T|null
     */
    protected function visitInterpolation(Interpolation $interpolation)
    {
        foreach ($interpolation->getContents() as $node) {
            if ($node instanceof Expression) {
                $result = $this->visitExpression($node);

                if ($result !== null) {
                    return $result;
                }
            }
        }

        return null;
    }

    /**
     * Visits an expression
     *
     * @return T|null
     */
    protected function visitExpression(Expression $expression)
    {
        return null;
    }

    /**
     * Returns the first `T` returned by $callback for an element of $iterable,
     * or `null` if it returns `null` for every element.
     *
     * @template E
     * @param iterable<E> $iterable
     * @param callable(E): (T|null) $callback
     *
     * @return T|null
     */
    private function searchIterable(iterable $iterable, callable $callback)
    {
        foreach ($iterable as $element) {
            $value = $callback($element);

            if ($value !== null) {
                return $value;
            }
        }

        return null;
    }
}
