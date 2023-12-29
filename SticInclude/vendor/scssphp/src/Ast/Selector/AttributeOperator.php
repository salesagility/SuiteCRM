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

namespace ScssPhp\ScssPhp\Ast\Selector;

final class AttributeOperator
{
    /**
     * The attribute value exactly equals the given value.
     */
    public const EQUAL = '=';

    /**
     * The attribute value is a whitespace-separated list of words, one of which
     * is the given value.
     */
    public const INCLUDE = '~=';

    /**
     * The attribute value is either exactly the given value, or starts with the
     * given value followed by a dash.
     */
    public const DASH = '|=';

    /**
     * The attribute value begins with the given value.
     */
    public const PREFIX = '^=';

    /**
     * The attribute value ends with the given value.
     */
    public const SUFFIX = '$=';

    /**
     * The attribute value contains the given value.
     */
    public const SUBSTRING = '*=';
}
