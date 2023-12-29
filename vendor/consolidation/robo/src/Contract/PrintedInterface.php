<?php

namespace Robo\Contract;

/**
 * If task prints anything to console
 *
 * Interface PrintedInterface
 * @package Robo\Contract
 */
interface PrintedInterface
{
    /**
     * @return bool
     */
    public function getPrinted();
}
