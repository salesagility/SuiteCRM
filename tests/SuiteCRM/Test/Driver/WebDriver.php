<?php

namespace SuiteCRM\Test\Driver;
use Codeception\Command\Shared\Config;
use Codeception\Configuration as Configuration;
use Symfony\Component\Yaml\Yaml as Yaml;

class WebDriver extends \Codeception\Module\WebDriver
{
    public function _initialize()
    {
        // TODO: use environment variables to override configuration
        parent::_initialize();
    }
}