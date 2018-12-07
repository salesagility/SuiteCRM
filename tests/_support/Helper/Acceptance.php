<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Codeception\Test\Metadata;
use Codeception\TestInterface;

class Acceptance extends \Codeception\Module
{
    public function seePageHas($text, $selector = null)
    {
        try {
            $this->getModule('\SuiteCRM\Test\Driver\WebDriver')->see($text, $selector);
        } catch (\PHPUnit_Framework_AssertionFailedError $f) {
            return false;
        }
        return true;
    }
}
