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

use ScssPhp\ScssPhp\Ast\Css\CssMediaQuery;
use ScssPhp\ScssPhp\Exception\SassFormatException;

/**
 * A parser for `@media` queries.
 *
 * @internal
 */
class MediaQueryParser extends Parser
{
    /**
     * @return list<CssMediaQuery>
     *
     * @throws SassFormatException when parsing fails
     */
    public function parse(): array
    {
        try {
            $queries = [];

            do {
                $this->whitespace();
                $queries[] = $this->mediaQuery();
            } while ($this->scanner->scanChar(','));
            $this->scanner->expectDone();

            return $queries;
        } catch (FormatException $e) {
            throw $this->wrapException($e);
        }
    }

    /**
     * Consumes a single media query.
     */
    private function mediaQuery(): CssMediaQuery
    {
        $modifier = null;
        $type = null;

        if ($this->scanner->peekChar() !== '(') {
            $identifier1 = $this->identifier();
            $this->whitespace();

            if (!$this->lookingAtIdentifier()) {
                // For example, "@media screen {"
                return new CssMediaQuery($identifier1);
            }

            $identifier2 = $this->identifier();
            $this->whitespace();

            if (strtolower($identifier2) === 'and') {
                // For example, "@media screen and ..."
                $type = $identifier1;
            } else {
                $modifier = $identifier1;
                $type = $identifier2;

                if ($this->scanIdentifier('and')) {
                    // For example, "@media only screen and ..."
                    $this->whitespace();
                } else {
                    // For example, "@media only screen {"
                    return new CssMediaQuery($type, $modifier);
                }
            }
        }

        // We've consumed either `IDENTIFIER "and"`, `IDENTIFIER IDENTIFIER "and"`,
        // or no text.

        $features = [];

        do {
            $this->whitespace();
            $this->scanner->expectChar('(');
            $feature = $this->declarationValue();
            $features[] = "($feature)";
            $this->scanner->expectChar(')');
            $this->whitespace();
        } while ($this->scanIdentifier('and'));

        if ($type === null) {
            return CssMediaQuery::condition($features);
        }

        return new CssMediaQuery($type, $modifier, $features);
    }
}
