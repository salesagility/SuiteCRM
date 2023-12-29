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

namespace ScssPhp\ScssPhp\Ast;

use ScssPhp\ScssPhp\SourceSpan\FileSpan;

/**
 * A node in an abstract syntax tree.
 *
 * @internal
 */
interface AstNode
{
    public function getSpan(): FileSpan;
}
