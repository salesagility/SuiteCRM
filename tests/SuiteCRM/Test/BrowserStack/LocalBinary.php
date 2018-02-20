<?php

namespace SuiteCRM\Test\BrowserStack;

/**
 * Class LocalBinary
 * @package SuiteCRM\Test\BrowserStack
 *
 * Extends the browser stack binary
 */
class LocalBinary extends  \BrowserStack\LocalBinary
{
    public function __construct() {
        $this->possible_binary_paths = array(
            getcwd(),
            sys_get_temp_dir()
        );
    }
}