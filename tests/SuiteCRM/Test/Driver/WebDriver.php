<?php

namespace SuiteCRM\Test\Driver;

use Helper\WebDriverHelper;

class WebDriver extends \Codeception\Module\WebDriver
{
    private $browserStackLocal;

    public function _initialize()
    {
        $config = $this->_getConfig();
        $this->config['host'] = $config['host'];
        $this->config['port'] = $config['port'];

        if($this->isBrowserStackEnabled()) {
            $this->configureBrowserStack();
        }

        parent::_initialize();

    }

    /**
     * @return bool
     */
    protected function isBrowserStackEnabled()
    {
        $webDriverHelper = new WebDriverHelper($this->moduleContainer, $this->_getConfig());
        if(empty($webDriverHelper->getBrowserStackUsername()) ||empty($webDriverHelper->getBrowserStackAccessKey())) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @return bool
     */
    protected function isBrowserStackLocalEnabled()
    {
        if(
            array_key_exists('browserstack.local', $this->config['capabilities']) &&
            $this->config['capabilities']['browserstack.local']
        ) {
            return true;
        } else {
            return false;
        }
    }

    protected function configureBrowserStack()
    {
        $webDriverHelper = new WebDriverHelper($this->moduleContainer, $this->_getConfig());
        $this->config['capabilities']['browserstack.user'] = $webDriverHelper->getBrowserStackUsername();
        $this->config['capabilities']['browserstack.key'] = $webDriverHelper->getBrowserStackAccessKey();

        if($this->isBrowserStackLocalEnabled()) {
            $bs_local_args = array("key" => $this->config["capabilities"]["browserstack.key"]);
            $this->browserStackLocal = new \BrowserStack\Local();
            $this->browserStackLocal->start($bs_local_args);
        }
    }


    protected function initialWindowSize()
    {
        $config = $this->_getConfig();
        $width =  $config['width'];
        $height = $config['height'];
        $this->resizeWindow($width, $height);
    }

    public function _afterSuite() {
        parent::_afterSuite();
        if ($this->browserStackLocal) {
            $this->browserStackLocal->stop();
        }
    }
}