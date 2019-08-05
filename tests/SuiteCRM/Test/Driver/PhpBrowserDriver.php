<?php

namespace SuiteCRM\Test\Driver;

use Helper\WebDriverHelper;

class PhpBrowserDriver extends \Codeception\Module\PhpBrowser
{
    public function _initialize()
    {
        $config = $this->_getConfig();
        parent::_initialize();
    }
}
