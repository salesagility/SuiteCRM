<?php

namespace Page;

use \AcceptanceTester as Tester;

use Codeception\Module;
use SuiteCRM\Enumerator\DesignBreakPoint;

class Design extends Module
{
    /**
     * @param integer $browserWidth in pixels
     * @return string
     * @see \SuiteCRM\Enumerator\DesignBreakPoint
     */
    public static function getBreakpointString($browserWidth)
    {
        $breakpoint = null;
        if ($browserWidth >= 1201) {
            $breakpoint = DesignBreakPoint::lg;
        } else if ($browserWidth >= 1024 && $browserWidth <= 1200) {
            $breakpoint = DesignBreakPoint::md;
        } else if ($browserWidth >= 750 && $browserWidth < 1024) {
            $breakpoint = DesignBreakPoint::sm;
        }  else if ($browserWidth < 750) {
            $breakpoint = DesignBreakPoint::xs;
        }
        return $breakpoint;
    }

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
}