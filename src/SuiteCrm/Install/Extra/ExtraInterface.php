<?php
/**
 * Created by Adam Jakab.
 * Date: 26/04/16
 * Time: 9.57
 */

namespace SuiteCrm\Install\Extra;

/**
 * Interface ExtraInterface
 * @package SuiteCrm\Install\Extra
 */
interface ExtraInterface
{
    /**
     * @param array $config
     */
    public function execute($config);
}