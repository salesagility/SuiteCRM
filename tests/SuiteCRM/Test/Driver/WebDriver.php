<?php

namespace SuiteCRM\Test\Driver;

use Helper\WebDriverHelper;

class WebDriver extends \Codeception\Module\WebDriver
{
    public function _initialize()
    {
        parent::_initialize();
        $config = $this->_getConfig();
        $this->config['host'] = $config['host'];
        $this->config['port'] = $config['port'];
    }

    protected function initialWindowSize()
    {
        $config = $this->_getConfig();
        $width =  $config['width'];
        $height = $config['height'];
        $this->resizeWindow($width, $height);
    }
}