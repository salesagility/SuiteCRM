<?php

namespace Robo\Collection;

interface NestedCollectionInterface
{
    /**
     * @param \Robo\Collection\NestedCollectionInterface $parentCollection
     *
     * @return $this
     */
    public function setParentCollection(NestedCollectionInterface $parentCollection);
}
