<?php
namespace Consolidation\AnnotatedCommand\Help;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Descriptor\XmlDescriptor;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HelpCommand
{
    /** var Application */
    protected $application;

    /**
     * Create a help document from a Symfony Console command
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function getApplication()
    {
        return $this->application;
    }

    /**
     * Run the help command
     *
     * @command my-help
     * @return \Consolidation\AnnotatedCommand\Help\HelpDocument
     */
    public function help($commandName = 'help')
    {
        $command = $this->getApplication()->find($commandName);

        $helpDocument = $this->getHelpDocument($command);
        return $helpDocument;
    }

    /**
     * Create a help document.
     */
    protected function getHelpDocument($command)
    {
        return new HelpDocument($command);
    }
}
