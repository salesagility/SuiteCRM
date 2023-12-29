<?php
namespace Consolidation\AnnotatedCommand\Help;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Descriptor\XmlDescriptor;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Consolidation\AnnotatedCommand\AnnotatedCommand;

class HelpDocumentBuilder
{
    public static function alter(\DomDocument $originalDom, AnnotatedCommand $command)
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->appendChild($commandXML = $dom->createElement('command'));
        $commandXML->setAttribute('id', $command->getName());
        $commandXML->setAttribute('name', $command->getName());

        // Get the original <command> element and its top-level elements.
        $originalCommandXML = static::getSingleElementByTagName($dom, $originalDom, 'command');
        $originalUsagesXML = static::getSingleElementByTagName($dom, $originalCommandXML, 'usages');
        $originalDescriptionXML = static::getSingleElementByTagName($dom, $originalCommandXML, 'description');
        $originalHelpXML = static::getSingleElementByTagName($dom, $originalCommandXML, 'help');
        $originalArgumentsXML = static::getSingleElementByTagName($dom, $originalCommandXML, 'arguments');
        $originalOptionsXML = static::getSingleElementByTagName($dom, $originalCommandXML, 'options');

        // Keep only the first of the <usage> elements
        $newUsagesXML = $dom->createElement('usages');
        $firstUsageXML = static::getSingleElementByTagName($dom, $originalUsagesXML, 'usage');
        $newUsagesXML->appendChild($firstUsageXML);

        // Create our own <example> elements
        $newExamplesXML = $dom->createElement('examples');
        foreach ($command->getExampleUsages() as $usage => $description) {
            $newExamplesXML->appendChild($exampleXML = $dom->createElement('example'));
            $exampleXML->appendChild($usageXML = $dom->createElement('usage', $usage));
            $exampleXML->appendChild($descriptionXML = $dom->createElement('description', $description));
        }

        // Create our own <alias> elements
        $newAliasesXML = $dom->createElement('aliases');
        foreach ($command->getAliases() as $alias) {
            $newAliasesXML->appendChild($dom->createElement('alias', $alias));
        }

        // Create our own <topic> elements
        $newTopicsXML = $dom->createElement('topics');
        foreach ($command->getTopics() as $topic) {
            $newTopicsXML->appendChild($topicXML = $dom->createElement('topic', $topic));
        }

        // Place the different elements into the <command> element in the desired order
        $commandXML->appendChild($newUsagesXML);
        $commandXML->appendChild($newExamplesXML);
        $commandXML->appendChild($originalDescriptionXML);
        $commandXML->appendChild($originalArgumentsXML);
        $commandXML->appendChild($originalOptionsXML);
        $commandXML->appendChild($originalHelpXML);
        $commandXML->appendChild($newAliasesXML);
        $commandXML->appendChild($newTopicsXML);

        return $dom;
    }


    protected static function getSingleElementByTagName($dom, $parent, $tagName)
    {
        // There should always be exactly one '<command>' element.
        $elements = $parent->getElementsByTagName($tagName);
        $result = $elements->item(0);

        $result = $dom->importNode($result, true);

        return $result;
    }
}
