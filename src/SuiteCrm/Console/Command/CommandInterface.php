<?php
/**
 * Created by Adam Jakab.
 * Date: 07/10/15
 * Time: 14.29
 */

namespace SuiteCrm\Console\Command;

/**
 * This interface is used to identify console commands inside the /src directory
 * All console commands need to implement this interface to be picked up automatically
 *
 * Interface CommandInterface
 * @package SuiteCrm\Console\Command
 */
interface CommandInterface
{
    /**
     * Constructor
     */
    function __construct();
}