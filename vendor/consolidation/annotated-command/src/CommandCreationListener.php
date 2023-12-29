<?php
namespace Consolidation\AnnotatedCommand;

/**
 * Command cration listeners can be added to the annotation
 * command factory.  These will be notified whenever a new
 * commandfile is provided to the factory.  This is useful for
 * initializing new commandfile objects.
 *
 * @see AnnotatedCommandFactory::addListener()
 */
class CommandCreationListener implements CommandCreationListenerInterface
{
    protected $listener;

    public function __construct($listener)
    {
        $this->listener = $listener;
    }

    public function notifyCommandFileAdded($command)
    {
        call_user_func($this->listener, $command);
    }
}
