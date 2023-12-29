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

namespace ScssPhp\ScssPhp\Parser;

use ScssPhp\ScssPhp\SourceSpan\FileSpan;

/**
 * @internal
 */
final class FormatException extends \Exception
{
    /**
     * @var FileSpan
     * @readonly
     */
    private $span;

    public function __construct(string $message, FileSpan $span)
    {
        $this->span = $span;
        parent::__construct($message);
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }
}
