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

namespace ScssPhp\ScssPhp;

final class Syntax
{
    /**
     * The CSS-superset SCSS syntax.
     */
    const SCSS = 'scss';

    /**
     * The whitespace-sensitive indented syntax.
     */
    const SASS = 'sass';

    /**
     * The plain CSS syntax, which disallows special Sass features.
     */
    const CSS = 'css';

    /**
     * @return Syntax::*
     */
    public static function forPath(string $path): string
    {
        if (substr($path, -5) === '.sass') {
            return self::SASS;
        }

        if (substr($path, -4) === '.css') {
            return self::CSS;
        }

        return self::SCSS;
    }
}
