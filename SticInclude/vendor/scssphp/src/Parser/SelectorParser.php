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

use ScssPhp\ScssPhp\Ast\Selector\AttributeOperator;
use ScssPhp\ScssPhp\Ast\Selector\AttributeSelector;
use ScssPhp\ScssPhp\Ast\Selector\ClassSelector;
use ScssPhp\ScssPhp\Ast\Selector\Combinator;
use ScssPhp\ScssPhp\Ast\Selector\ComplexSelector;
use ScssPhp\ScssPhp\Ast\Selector\CompoundSelector;
use ScssPhp\ScssPhp\Ast\Selector\IDSelector;
use ScssPhp\ScssPhp\Ast\Selector\ParentSelector;
use ScssPhp\ScssPhp\Ast\Selector\PlaceholderSelector;
use ScssPhp\ScssPhp\Ast\Selector\PseudoSelector;
use ScssPhp\ScssPhp\Ast\Selector\QualifiedName;
use ScssPhp\ScssPhp\Ast\Selector\SelectorList;
use ScssPhp\ScssPhp\Ast\Selector\SimpleSelector;
use ScssPhp\ScssPhp\Ast\Selector\TypeSelector;
use ScssPhp\ScssPhp\Ast\Selector\UniversalSelector;
use ScssPhp\ScssPhp\Logger\LoggerInterface;
use ScssPhp\ScssPhp\Util;
use ScssPhp\ScssPhp\Util\Character;

/**
 * A parser for selectors.
 *
 * @internal
 */
final class SelectorParser extends Parser
{
    /**
     * Pseudo-class selectors that take unadorned selectors as arguments.
     */
    private const SELECTOR_PSEUDO_CLASSES = ['not', 'is', 'matches', 'current', 'any', 'has', 'host', 'host-context'];

    /**
     * Pseudo-element selectors that take unadorned selectors as arguments.
     */
    private const SELECTOR_PSEUDO_ELEMENTS = ['slotted'];

    /**
     * @var bool
     * @readonly
     */
    private $allowParent;

    /**
     * @var bool
     * @readonly
     */
    private $allowPlaceholder;

    public function __construct(string $contents, ?LoggerInterface $logger = null, ?string $url = null, bool $allowParent = true, bool $allowPlaceholder = true)
    {
        $this->allowParent = $allowParent;
        $this->allowPlaceholder = $allowPlaceholder;
        parent::__construct($contents, $logger, $url);
    }

    public function parse(): SelectorList
    {
        try {
            $selector = $this->selectorList();

            if (!$this->scanner->isDone()) {
                $this->scanner->error('expected selector.');
            }

            return $selector;
        } catch (FormatException $e) {
            throw $this->wrapException($e);
        }
    }

    public function parseCompoundSelector(): CompoundSelector
    {
        try {
            $compound = $this->compoundSelector();

            if (!$this->scanner->isDone()) {
                $this->scanner->error('expected selector.');
            }

            return $compound;
        } catch (FormatException $e) {
            throw $this->wrapException($e);
        }
    }

    public function parseSimpleSelector(): SimpleSelector
    {
        try {
            $simple = $this->simpleSelector();

            if (!$this->scanner->isDone()) {
                $this->scanner->error('unexpected token.');
            }

            return $simple;
        } catch (FormatException $e) {
            throw $this->wrapException($e);
        }
    }

    /**
     * Consumes a selector list.
     */
    private function selectorList(): SelectorList
    {
        $previousLine = $this->scanner->getLine();
        $components = [$this->complexSelector()];

        $this->whitespace();
        while ($this->scanner->scanChar(',')) {
            $this->whitespace();
            $next = $this->scanner->peekChar();

            if ($next === ',') {
                continue;
            }

            if ($this->scanner->isDone()) {
                break;
            }

            $lineBreak = $this->scanner->getLine() !== $previousLine;

            if ($lineBreak) {
                $previousLine = $this->scanner->getLine();
            }

            $components[] = $this->complexSelector($lineBreak);
        }

        return new SelectorList($components);
    }

    /**
     * Consumes a complex selector.
     *
     * If $lineBreak is `true`, that indicates that there was a line break
     * before this selector.
     */
    private function complexSelector(bool $lineBreak = false): ComplexSelector
    {
        $components = [];

        while (true) {
            $this->whitespace();

            $next = $this->scanner->peekChar();

            switch ($next) {
                case '+':
                    $this->scanner->readChar();
                    $components[] = Combinator::NEXT_SIBLING;
                    break;

                case '>':
                    $this->scanner->readChar();
                    $components[] = Combinator::CHILD;
                    break;

                case '~':
                    $this->scanner->readChar();
                    $components[] = Combinator::FOLLOWING_SIBLING;
                    break;

                case '[':
                case '.':
                case '#':
                case '%':
                case ':':
                case '&':
                case '*':
                case '|':
                    $components[] = $this->compoundSelector();

                    if ($this->scanner->peekChar() === '&') {
                        $this->scanner->error('"&" may only used at the beginning of a compound selector.');
                    }
                    break;

                default:
                    if ($next === null || !$this->lookingAtIdentifier()) {
                        break 2;
                    }
                    $components[] = $this->compoundSelector();

                    if ($this->scanner->peekChar() === '&') {
                        $this->scanner->error('"&" may only used at the beginning of a compound selector.');
                    }
                    break;
            }
        }

        if (\count($components) === 0) {
            $this->scanner->error('expected selector.');
        }

        return new ComplexSelector($components, $lineBreak);
    }

    /**
     * Consumes a compound selector.
     */
    private function compoundSelector(): CompoundSelector
    {
        $components = [$this->simpleSelector()];

        while (Character::isSimpleSelectorStart($this->scanner->peekChar())) {
            $components[] = $this->simpleSelector(false);
        }

        return new CompoundSelector($components);
    }

    /**
     * Consumes a simple selector.
     *
     * If $allowParent is passed, it controls whether the parent selector `&` is
     * allowed. Otherwise, it defaults to {@see allowParent}.
     */
    private function simpleSelector(?bool $allowParent = null): SimpleSelector
    {
        $start = $this->scanner->getPosition();
        $allowParent = $allowParent ?? $this->allowParent;

        switch ($this->scanner->peekChar()) {
            case '[':
                return $this->attributeSelector();

            case '.':
                return $this->classSelector();

            case '#':
                return $this->idSelector();

            case '%':
                $selector = $this->placeholderSelector();
                if (!$this->allowPlaceholder) {
                    $this->error("Placeholder selectors aren't allowed here.", $this->scanner->spanFrom($start));
                }
                return $selector;

            case ':':
                return $this->pseudoSelector();

            case '&':
                $selector = $this->parentSelector();
                if (!$allowParent) {
                    $this->error("Parent selectors aren't allowed here.", $this->scanner->spanFrom($start));
                }
                return $selector;

            default:
                return $this->typeOrUniversalSelector();
        }
    }

    /**
     * Consumes an attribute selector.
     */
    private function attributeSelector(): AttributeSelector
    {
        $this->scanner->expectChar('[');
        $this->whitespace();

        $name = $this->attributeName();
        $this->whitespace();

        if ($this->scanner->scanChar(']')) {
            return AttributeSelector::create($name);
        }

        $operator = $this->attributeOperator();
        $this->whitespace();

        $next = $this->scanner->peekChar();
        $value = $next === "'" || $next === '"' ? $this->string() : $this->identifier();
        $this->whitespace();

        $next = $this->scanner->peekChar();
        $modifier = $next !== null && Character::isAlphabetic($next) ? $this->scanner->readChar() : null;

        $this->scanner->expectChar(']');

        return AttributeSelector::withOperator($name, $operator, $value, $modifier);
    }

    /**
     * Consumes a qualified name as part of an attribute selector.
     */
    private function attributeName(): QualifiedName
    {
        if ($this->scanner->scanChar('*')) {
            $this->scanner->expectChar('|');

            return new QualifiedName($this->identifier(), '*');
        }

        $nameOrNamespace = $this->identifier();

        if ($this->scanner->peekChar() !== '|' || $this->scanner->peekChar(1) === '=') {
            return new QualifiedName($nameOrNamespace);
        }

        $this->scanner->readChar();

        return new QualifiedName($this->identifier(), $nameOrNamespace);
    }

    /**
     * Consumes an attribute selector's operator.
     *
     * @phpstan-return AttributeOperator::*
     */
    private function attributeOperator(): string
    {
        $start = $this->scanner->getPosition();

        switch ($this->scanner->readChar()) {
            case '=':
                return AttributeOperator::EQUAL;

            case '~':
                $this->scanner->expectChar('=');
                return AttributeOperator::INCLUDE;

            case '|':
                $this->scanner->expectChar('=');
                return AttributeOperator::DASH;

            case '^':
                $this->scanner->expectChar('=');
                return AttributeOperator::PREFIX;

            case '$':
                $this->scanner->expectChar('=');
                return AttributeOperator::SUFFIX;

            case '*':
                $this->scanner->expectChar('=');
                return AttributeOperator::SUBSTRING;

            default:
                $this->scanner->error('Expected "]".', $start);
        }
    }

    /**
     * Consumes a class selector.
     */
    private function classSelector(): ClassSelector
    {
        $this->scanner->expectChar('.');
        $name = $this->identifier();

        return new ClassSelector($name);
    }

    /**
     * Consumes an ID selector.
     */
    private function idSelector(): IDSelector
    {
        $this->scanner->expectChar('#');
        $name = $this->identifier();

        return new IDSelector($name);
    }

    /**
     * Consumes a placeholder selector.
     */
    private function placeholderSelector(): PlaceholderSelector
    {
        $this->scanner->expectChar('%');
        $name = $this->identifier();

        return new PlaceholderSelector($name);
    }

    /**
     * Consumes a parent selector.
     */
    private function parentSelector(): ParentSelector
    {
        $this->scanner->expectChar('&');
        $suffix = $this->lookingAtIdentifierBody() ? $this->identifierBody() : null;

        return new ParentSelector($suffix);
    }

    /**
     * Consumes a pseudo selector.
     */
    private function pseudoSelector(): PseudoSelector
    {
        $this->scanner->expectChar(':');
        $element = $this->scanner->scanChar(':');
        $name = $this->identifier();

        if (!$this->scanner->scanChar('(')) {
            return new PseudoSelector($name, $element);
        }
        $this->whitespace();

        $unvendored = Util::unvendor($name);
        $argument = null;
        $selector = null;

        if ($element) {
            if (\in_array($unvendored, self::SELECTOR_PSEUDO_ELEMENTS, true)) {
                $selector = $this->selectorList();
            } else {
                $argument = $this->declarationValue(true);
            }
        } elseif (\in_array($unvendored, self::SELECTOR_PSEUDO_CLASSES, true)) {
            $selector = $this->selectorList();
        } elseif ($unvendored === 'nth-child' || $unvendored === 'nth-last-child') {
            $argument = $this->aNPlusB();
            $this->whitespace();

            if (Character::isWhitespace($this->scanner->peekChar(-1)) && $this->scanner->peekChar() !== ')') {
                $this->expectIdentifier('of');
                $argument .= ' of';
                $this->whitespace();

                $selector = $this->selectorList();
            }
        } else {
            $argument = rtrim($this->declarationValue(true));
        }

        $this->scanner->expectChar(')');

        return new PseudoSelector($name, $element, $argument, $selector);
    }

    /**
     * Consumes an [`An+B` production][An+B] and returns its text.
     *
     * [An+B]: https://drafts.csswg.org/css-syntax-3/#anb-microsyntax
     */
    private function aNPlusB(): string
    {
        $buffer = '';

        switch ($this->scanner->peekChar()) {
            case 'e':
            case 'E':
                $this->expectIdentifier('even');
                return 'even';

            case 'o':
            case 'O':
                $this->expectIdentifier('odd');
                return 'odd';

            case '+':
            case '-':
                $buffer .= $this->scanner->readChar();
                break;
        }

        $first = $this->scanner->peekChar();

        if ($first !== null && Character::isDigit($first)) {
            while (Character::isDigit($this->scanner->peekChar())) {
                $buffer .= $this->scanner->readChar();
            }
            $this->whitespace();

            if (!$this->scanIdentChar('n')) {
                return $buffer;
            }
        } else {
            $this->expectIdentChar('n');
        }
        $buffer .= 'n';
        $this->whitespace();

        $next = $this->scanner->peekChar();
        if ($next !== '+' && $next !== '-') {
            return $buffer;
        }
        $buffer .= $this->scanner->readChar();
        $this->whitespace();

        $last = $this->scanner->peekChar();
        if ($last === null || !Character::isDigit($last)) {
            $this->scanner->error('Expected a number.');
        }
        while (Character::isDigit($this->scanner->peekChar())) {
            $buffer .= $this->scanner->readChar();
        }

        return $buffer;
    }

    /**
     * Consumes a type selector or a universal selector.
     *
     * These are combined because either one could start with `*`.
     */
    private function typeOrUniversalSelector(): SimpleSelector
    {
        $first = $this->scanner->peekChar();

        if ($first === '*') {
            $this->scanner->readChar();

            if (!$this->scanner->scanChar('|')) {
                return new UniversalSelector();
            }

            if ($this->scanner->scanChar('*')) {
                return new UniversalSelector('*');
            }

            return new TypeSelector(new QualifiedName($this->identifier(), '*'));
        }

        if ($first === '|') {
            $this->scanner->readChar();

            if ($this->scanner->scanChar('*')) {
                return new UniversalSelector('');
            }

            return new TypeSelector(new QualifiedName($this->identifier(), ''));
        }

        $nameOrNamespace = $this->identifier();

        if (!$this->scanner->scanChar('|')) {
            return new TypeSelector(new QualifiedName($nameOrNamespace));
        }

        if ($this->scanner->scanChar('*')) {
            return new UniversalSelector($nameOrNamespace);
        }

        return new TypeSelector(new QualifiedName($this->identifier(), $nameOrNamespace));
    }
}
