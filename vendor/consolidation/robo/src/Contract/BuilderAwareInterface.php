<?php

namespace Robo\Contract;

use Robo\Collection\CollectionBuilder;

interface BuilderAwareInterface
{
    /**
     * Set the builder reference
     *
     * @param \Robo\Collection\CollectionBuilder $builder
     */
    public function setBuilder(CollectionBuilder $builder);

    /**
     * Get the builder reference
     *
     * @return \Robo\Collection\CollectionBuilder
     */
    public function getBuilder();
}
