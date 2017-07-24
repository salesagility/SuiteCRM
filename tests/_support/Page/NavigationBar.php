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


    /**
     * Selects a menu item from the users menu (global links)
     * @param $link
     *
     * <?php
     * $I->clickUserMenuItem('Admin')
     * $I->clickUserMenuItem('#admin_link')
     */
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

    /**
     * Selects a menu item from the all menu (top nav)
     * @param $link
     *
     * <?php
     * $I->clickAllModuleItem('Accounts')
     *
     * Watch out - the mobile navigation employs a different structure with with tablet and desktop versions. It is
     * best to use just the module translations.
     *
     * Also:
     * the non filter navigation is not supported by this method
     */
    public function clickAllModuleItem($link)
    {
        $config = $this->tester->getConfig();
        $breakpoint = Design::getBreakpointString($config['width']);
        switch ($breakpoint)
        {
            case DesignBreakPoints::lg:
                $allMenuButton = '#toolbar.desktop-toolbar  > ul.nav.navbar-nav > li.topnav.all';
                $this->tester->click('All', $allMenuButton);
                $allMenu = $allMenuButton . ' > span.notCurrentTab > ul.dropdown-menu';
                $this->tester->waitForElementVisible($allMenu);
                $this->tester->click($link, $allMenu);
                break;
            case DesignBreakPoints::md:
                $allMenuButton = 'div.navbar-header > button.navbar-toggle';
                $this->tester->click($allMenuButton);
                $allMenu = 'div.navbar-header > #mobile_menu';
                $this->tester->waitForElementVisible($allMenu);
                $this->tester->click($link, $allMenu);
                break;
            case DesignBreakPoints::sm:
                $allMenuButton = 'div.navbar-header > button.navbar-toggle';
                $this->tester->click($allMenuButton);
                $allMenu = 'div.navbar-header > #mobile_menu';
                $this->tester->waitForElementVisible($allMenu);
                $this->tester->click($link, $allMenu);
                break;
            case DesignBreakPoints::xs:
                $allMenuButton = 'div.navbar-header > button.navbar-toggle';
                $this->tester->click($allMenuButton);
                $allMenu = 'div.navbar-header > #mobile_menu';
                $this->tester->waitForElementVisible($allMenu);
                $this->tester->click($link, $allMenu);
                break;
        }
    }
}