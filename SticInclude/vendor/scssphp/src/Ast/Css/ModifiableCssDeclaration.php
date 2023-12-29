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

namespace ScssPhp\ScssPhp\Ast\Css;

use ScssPhp\ScssPhp\SourceSpan\FileSpan;
use ScssPhp\ScssPhp\Value\SassString;
use ScssPhp\ScssPhp\Value\Value;

/**
 * A modifiable version of {@see CssDeclaration} for use in the evaluation step.
 *
 * @internal
 */
final class ModifiableCssDeclaration extends ModifiableCssNode implements CssDeclaration
{
    /**
     * @var CssValue<string>
     * @readonly
     */
    private $name;

    /**
     * @var CssValue<Value>
     * @readonly
     */
    private $value;

    /**
     * @var bool
     * @readonly
     */
    private $parsedAsCustomProperty;

    /**
     * @var FileSpan
     * @readonly
     */
    private $valueSpanForMap;

    /**
     * @var FileSpan
     * @readonly
     */
    private $span;

    /**
     * @param CssValue<string> $name
     * @param CssValue<Value>  $value
     * @param bool             $parsedAsCustomProperty
     * @param FileSpan         $valueSpanForMap
     * @param FileSpan         $span
     */
    public function __construct(CssValue $name, CssValue $value, FileSpan $span, bool $parsedAsCustomProperty, ?FileSpan $valueSpanForMap = null) {
        $this->name = $name;
        $this->value = $value;
        $this->parsedAsCustomProperty = $parsedAsCustomProperty;
        $this->valueSpanForMap = $valueSpanForMap ?? $value->getSpan();
        $this->span = $span;

        if ($parsedAsCustomProperty) {
            if (!$this->isCustomProperty()) {
                throw new \InvalidArgumentException('parsedAsCustomProperty must be false if name doesn\'t begin with "--".');
            }

            if (!$value->getValue() instanceof SassString) {
                throw new \InvalidArgumentException(sprintf('If parsedAsCustomProperty is true, value must contain a SassString (was %s).', get_class($value->getValue())));
            }
        }
    }

    public function getName(): CssValue
    {
        return $this->name;
    }

    public function getValue(): CssValue
    {
        return $this->value;
    }

    public function isParsedAsCustomProperty(): bool
    {
        return $this->parsedAsCustomProperty;
    }

    public function getValueSpanForMap(): FileSpan
    {
        return $this->valueSpanForMap;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function isCustomProperty(): bool
    {
        return 0 === strpos($this->name->getValue(), '--');
    }

    public function accept($visitor)
    {
        return $visitor->visitCssDeclaration($this);
    }
}
