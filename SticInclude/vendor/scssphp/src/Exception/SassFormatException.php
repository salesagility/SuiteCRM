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

namespace ScssPhp\ScssPhp\Exception;

use ScssPhp\ScssPhp\SourceSpan\FileSpan;

/**
 * @internal
 */
final class SassFormatException extends \Exception implements SassException
{
    /**
     * @var string
     * @readonly
     */
    private $originalMessage;

    /**
     * @var FileSpan
     * @readonly
     */
    private $span;

    public function __construct(string $message, FileSpan $span, \Throwable $previous = null)
    {
        $this->originalMessage = $message;
        $this->span = $span;

        parent::__construct($span->message($message), 0, $previous);
    }

    /**
     * Gets the original message without the location info in it.
     */
    public function getOriginalMessage(): string
    {
        return $this->originalMessage;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }
}
