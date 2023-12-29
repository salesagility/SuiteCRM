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

use ScssPhp\ScssPhp\Ast\Sass\ArgumentInvocation;
use ScssPhp\ScssPhp\Ast\Sass\Expression;
use ScssPhp\ScssPhp\Ast\Sass\Expression\InterpolatedFunctionExpression;
use ScssPhp\ScssPhp\Ast\Sass\Expression\StringExpression;
use ScssPhp\ScssPhp\Ast\Sass\Import\StaticImport;
use ScssPhp\ScssPhp\Ast\Sass\Interpolation;
use ScssPhp\ScssPhp\Ast\Sass\Statement;
use ScssPhp\ScssPhp\Ast\Sass\Statement\ImportRule;
use ScssPhp\ScssPhp\Compiler;

/**
 * A parser for imported CSS files.
 *
 * @internal
 */
final class CssParser extends ScssParser
{
    /**
     * Sass global functions which are shadowing a CSS function are allowed in CSS files.
     */
    private const CSS_ALLOWED_FUNCTIONS = [
        'rgb' => true, 'rgba' => true, 'hsl' => true, 'hsla' => true, 'grayscale' => true,
        'invert' => true, 'alpha' => true, 'opacity' => true, 'saturate' => true,
    ];

    protected function isPlainCss(): bool
    {
        return true;
    }

    protected function silentComment(): void
    {
        $start = $this->scanner->getPosition();
        parent::silentComment();
        $this->error("Silent comments aren't allowed in plain CSS.", $this->scanner->spanFrom($start));
    }

    protected function atRule(callable $child, bool $root = false): Statement
    {
        $start = $this->scanner->getPosition();

        $this->scanner->expectChar('@');
        $name = $this->interpolatedIdentifier();
        $this->whitespace();

        switch ($name->getAsPlain()) {
            case 'at-root':
            case 'content':
            case 'debug':
            case 'each':
            case 'error':
            case 'extend':
            case 'for':
            case 'function':
            case 'if':
            case 'include':
            case 'mixin':
            case 'return':
            case 'warn':
            case 'while':
                $this->almostAnyValue();
                $this->error("This at-rule isn't allowed in plain CSS.", $this->scanner->spanFrom($start));

            case 'import':
                return $this->cssImportRule($start);

            case 'media':
                return $this->mediaRule($start);

            case '-moz-document':
                return $this->mozDocumentRule($start, $name);

            case 'supports':
                return $this->supportsRule($start);

            default:
                return $this->unknownAtRule($start, $name);

        }
    }

    private function cssImportRule(int $start): ImportRule
    {
        $urlStart = $this->scanner->getPosition();
        $next = $this->scanner->peekChar();

        if ($next === 'u' || $next === 'U') {
            $url = $this->dynamicUrl();
        } else {
            $url = new StringExpression($this->interpolatedString()->asInterpolation(true));
        }
        $urlSpan = $this->scanner->spanFrom($urlStart);

        $this->whitespace();
        list($supports, $media) = $this->tryImportQueries();
        $this->expectStatementSeparator('@import rule');

        return new ImportRule([
            new StaticImport(new Interpolation([$url], $urlSpan), $this->scanner->spanFrom($start), $supports, $media)
        ], $this->scanner->spanFrom($start));
    }

    protected function identifierLike(): Expression
    {
        $start = $this->scanner->getPosition();
        $identifier = $this->interpolatedIdentifier();
        $plain = $identifier->getAsPlain();
        assert($plain !== null); // CSS doesn't allow non-plain identifiers

        $specialFunction = $this->trySpecialFunction(strtolower($plain), $start);

        if ($specialFunction !== null) {
            return $specialFunction;
        }

        $beforeArguments = $this->scanner->getPosition();
        if (!$this->scanner->scanChar('(')) {
            return new StringExpression($identifier);
        }

        $arguments = [];

        if (!$this->scanner->scanChar(')')) {
            do {
                $this->whitespace();
                $arguments[] = $this->expression(null, true);
                $this->whitespace();
            } while ($this->scanner->scanChar(','));
            $this->scanner->expectChar(')');
        }

        if ($plain === 'if' || (!isset(self::CSS_ALLOWED_FUNCTIONS[$plain]) && Compiler::isNativeFunction($plain))) {
            $this->error("This function isn't allowed in plain CSS.", $this->scanner->spanFrom($start));
        }

        return new InterpolatedFunctionExpression(
            // Create a fake interpolation to force the function to be interpreted
            // as plain CSS, rather than calling a user-defined function.
            new Interpolation([new StringExpression($identifier)], $identifier->getSpan()),
            new ArgumentInvocation($arguments, [], $this->scanner->spanFrom($beforeArguments)),
            $this->scanner->spanFrom($start)
        );
    }

    protected function namespacedExpression(string $namespace, int $start): Expression
    {
        $expression = parent::namespacedExpression($namespace, $start);

        $this->error("Module namespaces aren't allowed in plain CSS.", $expression->getSpan());
    }
}
