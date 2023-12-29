<?php

namespace Consolidation\OutputFormatters\StructuredData\Xml;

class XmlSchema implements XmlSchemaInterface
{
    protected $elementList;

    public function __construct($elementList = [])
    {
        $defaultElementList =
        [
            '*' => ['description'],
        ];
        $this->elementList = array_merge_recursive($elementList, $defaultElementList);
    }

    public function arrayToXML($structuredData)
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $topLevelElement = $this->getTopLevelElementName($structuredData);
        $this->addXmlData($dom, $dom, $topLevelElement, $structuredData);
        return $dom;
    }

    protected function addXmlData(\DOMDocument $dom, $xmlParent, $elementName, $structuredData)
    {
        $element = $dom->createElement($elementName);
        $xmlParent->appendChild($element);
        if (is_string($structuredData)) {
            $element->appendChild($dom->createTextNode($structuredData));
            return;
        }
        $this->addXmlChildren($dom, $element, $elementName, $structuredData);
    }

    protected function addXmlChildren(\DOMDocument $dom, $xmlParent, $elementName, $structuredData)
    {
        foreach ($structuredData as $key => $value) {
            $this->addXmlDataOrAttribute($dom, $xmlParent, $elementName, $key, $value);
        }
    }

    protected function addXmlDataOrAttribute(\DOMDocument $dom, $xmlParent, $elementName, $key, $value)
    {
        $childElementName = $this->getDefaultElementName($elementName);
        $elementName = $this->determineElementName($key, $childElementName, $value);
        if (($elementName != $childElementName) && $this->isAttribute($elementName, $key, $value)) {
            $xmlParent->setAttribute($key, $value);
            return;
        }
        $this->addXmlData($dom, $xmlParent, $elementName, $value);
    }

    protected function determineElementName($key, $childElementName, $value)
    {
        if (is_numeric($key)) {
            return $childElementName;
        }
        if (is_object($value)) {
            $value = (array)$value;
        }
        if (!is_array($value)) {
            return $key;
        }
        if (array_key_exists('id', $value) && ($value['id'] == $key)) {
            return $childElementName;
        }
        if (array_key_exists('name', $value) && ($value['name'] == $key)) {
            return $childElementName;
        }
        return $key;
    }

    protected function getTopLevelElementName($structuredData)
    {
        return 'document';
    }

    protected function getDefaultElementName($parentElementName)
    {
        $singularName = $this->singularForm($parentElementName);
        if (isset($singularName)) {
            return $singularName;
        }
        return 'item';
    }

    protected function isAttribute($parentElementName, $elementName, $value)
    {
        if (!is_string($value)) {
            return false;
        }
        return !$this->inElementList($parentElementName, $elementName) && !$this->inElementList('*', $elementName);
    }

    protected function inElementList($parentElementName, $elementName)
    {
        if (!array_key_exists($parentElementName, $this->elementList)) {
            return false;
        }
        return in_array($elementName, $this->elementList[$parentElementName]);
    }

    protected function singularForm($name)
    {
        if (substr($name, strlen($name) - 1) == "s") {
            return substr($name, 0, strlen($name) - 1);
        }
    }

    protected function isAssoc($data)
    {
        return array_keys($data) == range(0, count($data));
    }
}
