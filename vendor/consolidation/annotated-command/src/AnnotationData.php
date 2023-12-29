<?php
namespace Consolidation\AnnotatedCommand;

use Consolidation\AnnotatedCommand\Parser\Internal\CsvUtils;

class AnnotationData extends \ArrayObject
{
    public function get($key, $default = '')
    {
        return $this->has($key) ? CsvUtils::toString($this[$key]) : $default;
    }

    public function getList($key, $default = [])
    {
        return $this->has($key) ? CsvUtils::toList($this[$key]) : $default;
    }

    public function has($key)
    {
        return isset($this[$key]);
    }

    public function keys()
    {
        return array_keys($this->getArrayCopy());
    }

    public function set($key, $value = '')
    {
        $this->offsetSet($key, $value);
        return $this;
    }

    #[\ReturnTypeWillChange]
    public function append($key, $value = '')
    {
        $data = $this->offsetGet($key);
        if (is_array($data)) {
            $this->offsetSet($key, array_merge($data, $value));
        } elseif (is_scalar($data)) {
            $this->offsetSet($key, $data . $value);
        }
        return $this;
    }
}
