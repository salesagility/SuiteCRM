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

use ScssPhp\ScssPhp\Ast\Sass\Import\DynamicImport;
use ScssPhp\ScssPhp\Ast\Sass\Statement;

/**
 * The superclass of `@if` and `@else` clauses.
 *
 * @internal
 */
abstract class IfRuleClause
{
    /**
     * @var Statement[]
     * @readonly
     */
    private $children;

    /**
     * @var bool
     * @readonly
     */
    private $declarations = false;

    /**
     * @param Statement[] $children
     */
    public function __construct(array $children)
    {
        $this->children = $children;

        foreach ($children as $child) {
            if ($child instanceof VariableDeclaration || $child instanceof FunctionRule || $child instanceof MixinRule) {
                $this->declarations = true;
                break;
            }

            if ($child instanceof ImportRule) {
                foreach ($child->getImports() as $import) {
                    if ($import instanceof DynamicImport) {
                        $this->declarations = true;
                        break 2;
                    }
                }
            }
        }
    }

    /**
     * @return Statement[]
     */
    final public function getChildren(): array
    {
        return $this->children;
    }

    final public function hasDeclarations(): bool
    {
        return $this->declarations;
    }
}
