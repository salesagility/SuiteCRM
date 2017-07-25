<?php

namespace Page;

use \AcceptanceTester as Tester;
use SuiteCRM\Enumerator\DesignBreakPoint;

class SideBar
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

    public function clickSideBarAction($link)
    {
        $I = $this->tester;
        $I->click($link, '#actionMenuSidebar');
    }

    public function clickSideBarRecentlyViewed($link)
    {
        $I = $this->tester;
        $I->click($link, '#recentlyViewedSidebar');
    }

    public function clickSideBarFavorite($link)
    {
        $I = $this->tester;
        $I->click($link, '#favoritesSidebar');
    }

    public function clickToggleSideBar()
    {
        $I = $this->tester;
        $I->click('#buttontoggle', '#sidebar_container');
    }
}