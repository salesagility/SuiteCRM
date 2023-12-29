<?php
namespace Consolidation\AnnotatedCommand\Help;

use Consolidation\OutputFormatters\StructuredData\Xml\DomDataInterface;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Descriptor\XmlDescriptor;

class HelpDocument implements DomDataInterface
{
    /** var Command */
    protected $command;

    /** var \DOMDocument */
    protected $dom;

    /**
     * Create a help document from a Symfony Console command
     */
    public function __construct(Command $command)
    {
        $dom = $this->generateBaseHelpDom($command);
        $dom = $this->alterHelpDocument($command, $dom);

        $this->command = $command;
        $this->dom = $dom;
    }

    /**
     * Convert data into a \DomDocument.
     *
     * @return \DomDocument
     */
    public function getDomData()
    {
        return $this->dom;
    }

    /**
     * Create the base help DOM prior to alteration by the Command object.
     * @param Command $command
     * @return \DomDocument
     */
    protected function generateBaseHelpDom(Command $command)
    {
        // Use Symfony to generate xml text. If other formats are
        // requested, convert from xml to the desired form.
        $descriptor = new XmlDescriptor();
        return $descriptor->getCommandDocument($command);
    }

    /**
     * Alter the DOM document per the command object
     * @param Command $command
     * @param \DomDocument $dom
     * @return \DomDocument
     */
    protected function alterHelpDocument(Command $command, \DomDocument $dom)
    {
        if ($command instanceof HelpDocumentAlter) {
            $dom = $command->helpAlter($dom);
        }
        return $dom;
    }
}
