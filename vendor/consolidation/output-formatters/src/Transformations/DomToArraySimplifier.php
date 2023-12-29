<?php

namespace Consolidation\OutputFormatters\Transformations;

use Consolidation\OutputFormatters\Options\FormatterOptions;
use Consolidation\OutputFormatters\StructuredData\Xml\DomDataInterface;
use Consolidation\OutputFormatters\StructuredData\Xml\XmlSchema;

/**
 * Simplify a DOMDocument to an array.
 */
class DomToArraySimplifier implements SimplifyToArrayInterface
{
    public function __construct()
    {
    }

    /**
     * @param ReflectionClass $dataType
     */
    public function canSimplify(\ReflectionClass $dataType)
    {
        return
            $dataType->isSubclassOf('\Consolidation\OutputFormatters\StructuredData\Xml\DomDataInterface') ||
            $dataType->isSubclassOf('DOMDocument') ||
            ($dataType->getName() == 'DOMDocument');
    }

    public function simplifyToArray($structuredData, FormatterOptions $options)
    {
        if ($structuredData instanceof DomDataInterface) {
            $structuredData = $structuredData->getDomData();
        }
        if ($structuredData instanceof \DOMDocument) {
            // $schema = $options->getXmlSchema();
            $simplified = $this->elementToArray($structuredData);
            $structuredData = array_shift($simplified);
        }
        return $structuredData;
    }

    /**
     * Recursively convert the provided DOM element into a php array.
     *
     * @param \DOMNode $element
     * @return array
     */
    protected function elementToArray(\DOMNode $element)
    {
        if ($element->nodeType == XML_TEXT_NODE) {
            return $element->nodeValue;
        }
        $attributes = $this->getNodeAttributes($element);
        $children = $this->getNodeChildren($element);

        return array_merge($attributes, $children);
    }

    /**
     * Get all of the attributes of the provided element.
     *
     * @param \DOMNode $element
     * @return array
     */
    protected function getNodeAttributes($element)
    {
        if (empty($element->attributes)) {
            return [];
        }
        $attributes = [];
        foreach ($element->attributes as $key => $attribute) {
            $attributes[$key] = $attribute->nodeValue;
        }
        return $attributes;
    }

    /**
     * Get all of the children of the provided element, with simplification.
     *
     * @param \DOMNode $element
     * @return array
     */
    protected function getNodeChildren($element)
    {
        if (empty($element->childNodes)) {
            return [];
        }
        $uniformChildrenName = $this->hasUniformChildren($element);
        // Check for plurals.
        if (in_array($element->nodeName, ["{$uniformChildrenName}s", "{$uniformChildrenName}es"])) {
            $result = $this->getUniformChildren($element->nodeName, $element);
        } else {
            $result = $this->getUniqueChildren($element->nodeName, $element);
        }
        return array_filter($result);
    }

    /**
     * Get the data from the children of the provided node in preliminary
     * form.
     *
     * @param \DOMNode $element
     * @return array
     */
    protected function getNodeChildrenData($element)
    {
        $children = [];
        foreach ($element->childNodes as $key => $value) {
            $children[$key] = $this->elementToArray($value);
        }
        return $children;
    }

    /**
     * Determine whether the children of the provided element are uniform.
     * @see getUniformChildren(), below.
     *
     * @param \DOMNode $element
     * @return boolean
     */
    protected function hasUniformChildren($element)
    {
        $last = false;
        foreach ($element->childNodes as $key => $value) {
            $name = $value->nodeName;
            if (!$name) {
                return false;
            }
            if ($last && ($name != $last)) {
                return false;
            }
            $last = $name;
        }
        return $last;
    }

    /**
     * Convert the children of the provided DOM element into an array.
     * Here, 'uniform' means that all of the element names of the children
     * are identical, and further, the element name of the parent is the
     * plural form of the child names.  When the children are uniform in
     * this way, then the parent element name will be used as the key to
     * store the children in, and the child list will be returned as a
     * simple list with their (duplicate) element names omitted.
     *
     * @param string $parentKey
     * @param \DOMNode $element
     * @return array
     */
    protected function getUniformChildren($parentKey, $element)
    {
        $children = $this->getNodeChildrenData($element);
        $simplifiedChildren = [];
        foreach ($children as $key => $value) {
            if ($this->valueCanBeSimplified($value)) {
                $value = array_shift($value);
            }
            $id = $this->getIdOfValue($value);
            if ($id) {
                $simplifiedChildren[$parentKey][$id] = $value;
            } else {
                $simplifiedChildren[$parentKey][] = $value;
            }
        }
        return $simplifiedChildren;
    }

    /**
     * Determine whether the provided value has additional unnecessary
     * nesting.  {"color": "red"} is converted to "red". No other
     * simplification is done.
     *
     * @param \DOMNode $value
     * @return boolean
     */
    protected function valueCanBeSimplified($value)
    {
        if (!is_array($value)) {
            return false;
        }
        if (count($value) != 1) {
            return false;
        }
        $data = array_shift($value);
        return is_string($data);
    }

    /**
     * If the object has an 'id' or 'name' element, then use that
     * as the array key when storing this value in its parent.
     * @param mixed $value
     * @return string
     */
    protected function getIdOfValue($value)
    {
        if (!is_array($value)) {
            return false;
        }
        if (array_key_exists('id', $value)) {
            return trim($value['id'], '-');
        }
        if (array_key_exists('name', $value)) {
            return trim($value['name'], '-');
        }
    }

    /**
     * Convert the children of the provided DOM element into an array.
     * Here, 'unique' means that all of the element names of the children are
     * different.  Since the element names will become the key of the
     * associative array that is returned, so duplicates are not supported.
     * If there are any duplicates, then an exception will be thrown.
     *
     * @param string $parentKey
     * @param \DOMNode $element
     * @return array
     */
    protected function getUniqueChildren($parentKey, $element)
    {
        $children = $this->getNodeChildrenData($element);
        if ((count($children) == 1) && (is_string($children[0]))) {
            return [$element->nodeName => $children[0]];
        }
        $simplifiedChildren = [];
        foreach ($children as $key => $value) {
            if (is_numeric($key) && is_array($value) && (count($value) == 1)) {
                $valueKeys = array_keys($value);
                $key = $valueKeys[0];
                $value = array_shift($value);
            }
            if (array_key_exists($key, $simplifiedChildren)) {
                throw new \Exception("Cannot convert data from a DOM document to an array, because <$key> appears more than once, and is not wrapped in a <{$key}s> element.");
            }
            $simplifiedChildren[$key] = $value;
        }
        return $simplifiedChildren;
    }
}
