<?php

namespace Page;

use \AcceptanceTester as Tester;

use Codeception\Module;
use Helper\WebDriverHelper;
use SuiteCRM\Enumerator\DesignBreakPoint;

class Design extends Module
{

    /**
     * @var Tester;
     */
    protected $tester;

    /**
     * BasicModule constructor.
     * @param Tester $I
     */
    public function __construct(Tester $I)
    {
        $this->tester = $I;
    }

    /**
     * @param integer $browserWidth in pixels
     * @return string
     * @see \SuiteCRM\Enumerator\DesignBreakPoint
     */
    public function getBreakpointString()
    {
        $browserWidth = $this->getBrowserWidth();
        $breakpoint = null;
        if ($browserWidth >= 1201) {
            $breakpoint = DesignBreakPoint::lg;
        } elseif ($browserWidth >= 1024 && $browserWidth <= 1200) {
            $breakpoint = DesignBreakPoint::md;
        } elseif ($browserWidth >= 750 && $browserWidth < 1024) {
            $breakpoint = DesignBreakPoint::sm;
        } elseif ($browserWidth < 750) {
            $breakpoint = DesignBreakPoint::xs;
        }
        return $breakpoint;
    }

    protected function getBrowserWidth()
    {
        return $this->tester->executeJS('return Math.max(document.documentElement.clientWidth, window.innerWidth || 0);');
    }

    protected function getBrowserHeight()
    {
        return $this->tester->executeJS('return Math.max(document.documentElement.clientHeight, window.innerHeight || 0);');
    }
}
