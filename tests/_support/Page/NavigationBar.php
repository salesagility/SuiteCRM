<?php

namespace Page;

use \AcceptanceTester as Tester;
use SuiteCRM\Enumerator\DesignBreakPoints;

class NavigationBar
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

    public function clickUserMenuItem($link)
    {
        $config = $this->tester->getConfig();
        $breakpoint = Design::getBreakpointString($config['width']);
        switch ($breakpoint)
        {
            case DesignBreakPoints::lg:
                $this->tester->click('.desktop-bar #toolbar .globalLinks-desktop');
                $this->tester->click($link, '.desktop-bar #toolbar .globalLinks-desktop');
                break;
            case DesignBreakPoints::md:
                $this->tester->click('.tablet-bar #toolbar .globalLinks-mobile');
                $this->tester->click($link, '.tablet-bar #toolbar .globalLinks-mobile');
                break;
            case DesignBreakPoints::sm:
                $this->tester->click('.tablet-bar #toolbar .globalLinks-mobile');
                $this->tester->click($link, '.tablet-bar #toolbar .globalLinks-mobile');
                break;
            case DesignBreakPoints::xs:
                $this->tester->click('.mobile-bar #toolbar .globalLinks-mobile');
                $this->tester->click($link, '.mobile-bar #toolbar .globalLinks-mobile');
                break;
        }
    }
}