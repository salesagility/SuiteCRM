<?php

namespace SuiteCRM\Test\Driver;

use Helper\WebDriverHelper;

class WebDriver extends \Codeception\Module\WebDriver
{
    public function _initialize()
    {
        $config = $this->_getConfig();
        $this->config['host'] = $config['host'];
        $this->config['port'] = $config['port'];

        parent::_initialize();
    }

    protected function initialWindowSize()
    {
        $config = $this->_getConfig();
        $width =  isset($config['width']) ? $config['width'] : 1920;
        $height = isset($config['height']) ? $config['height'] : 1080;
        $this->resizeWindow($width, $height);
    }

    public function _afterSuite()
    {
        parent::_afterSuite();
    }
}
