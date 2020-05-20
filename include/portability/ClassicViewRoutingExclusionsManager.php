<?php

class ClassicViewRoutingExclusionsManager
{
    /**
     * @var array
     */
    private $exclusions;

    /**
     * ClassicViewRoutingExclusionsManager constructor.
     */
    public function __construct()
    {
        $classicview_routing_exclusions = [];
        require 'classicview_routing_exclusions.php';

        $this->exclusions = $classicview_routing_exclusions;
    }

    /**
     * @return array
     */
    public function getExclusions(): array
    {
        return $this->exclusions;
    }
}
