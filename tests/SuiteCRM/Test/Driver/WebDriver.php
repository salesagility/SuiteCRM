<?php

namespace SuiteCRM\Test\Driver;

use Helper\WebDriverHelper;
use SuiteCRM\Test\BrowserStack\Local;

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

        return (!empty($webDriverHelper->getBrowserStackUsername()) || !empty($webDriverHelper->getBrowserStackAccessKey()));
    }

    /**
     * @return bool
     */
    protected function isBrowserStackLocalEnabled()
    {
        return
            array_key_exists('browserstack.local', $this->config['capabilities']) &&
            $this->config['capabilities']['browserstack.local'];
    }

    protected function configureBrowserStack()
    {
        $webDriverHelper = new WebDriverHelper($this->moduleContainer, $this->_getConfig());
        $this->config['capabilities']['browserstack.user'] = $webDriverHelper->getBrowserStackUsername();
        $this->config['capabilities']['browserstack.key'] = $webDriverHelper->getBrowserStackAccessKey();

        if($this->isBrowserStackLocalEnabled()) {
            $bs_local_args = array(
                "key" => $this->config["capabilities"]["browserstack.key"],
                "v" => true,
                "force" => true,
                "forcelocal" => true,
            );

            $this->browserStackLocal = new Local();
            try {
                $this->browserStackLocal->start($bs_local_args);
            } catch (\BrowserStack\LocalException $exception) {
                echo $exception->getMessage();
            }
            if($this->browserStackLocal->isRunning()) {
                echo "Browser stack binary is running";
            }

        }
    }

    protected function initialWindowSize()
    {
        $config = $this->_getConfig();
        // Don't resize window for browser stack instead maximize
        if($this->isBrowserStackEnabled()) {
            $this->maximizeWindow();
        }  else {
            $width =  isset($config['width']) ? $config['width'] : 1920;
            $height = isset($config['height']) ? $config['height'] : 1080;
            $this->resizeWindow($width, $height);
        }
    }

    public function _afterSuite() {
        parent::_afterSuite();
        if ($this->isBrowserStackLocalEnabled()) {
            $this->browserStackLocal->stop();
        }
    }
}