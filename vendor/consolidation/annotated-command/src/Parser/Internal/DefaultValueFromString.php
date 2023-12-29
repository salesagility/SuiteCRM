<?php
namespace Consolidation\AnnotatedCommand\Parser\Internal;

/**
 * Hold a default value.
 */
class DefaultValueFromString
{
    protected $value;

    protected function __construct($value)
    {
        $this->value = $value;
    }

    public static function fromString($defaultValue)
    {
        $defaults = [
            'null' => null,
            'true' => true,
            'false' => false,
            "''" => '',
            '[]' => [],
        ];
        if (array_key_exists($defaultValue, $defaults)) {
            $defaultValue = $defaults[$defaultValue];
        }
        return new self($defaultValue);
    }

    public function value()
    {
        return $this->value;
    }
}
