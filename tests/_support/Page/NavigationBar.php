<?php

namespace Page;

use \AcceptanceTester as Tester;
use SuiteCRM\Enumerator\DesignBreakPoint;

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
     * Click on the home buton / navbar brand
     */
    public function clickHome()
    {
        $I = $this->tester;
        $config = $I->getConfig();
        $breakpoint = Design::getBreakpointString($config['width']);
        switch ($breakpoint)
        {
            // The home button is only available on the large desktop
            // We need to select the home module from the all menu for tablet and mobile.
            case DesignBreakPoint::lg:
                $I->click('#navbar-brand');
                break;
            case DesignBreakPoint::md:
                $this->clickAllMenuItem('Home');
                break;
            case DesignBreakPoint::sm:
                $this->clickAllMenuItem('Home');
                break;
            case DesignBreakPoint::xs:
                $this->clickAllMenuItem('Home');
                break;
        }
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
        $I = $this->tester;
        $config = $I->getConfig();
        $breakpoint = Design::getBreakpointString($config['width']);
        switch ($breakpoint)
        {
            case DesignBreakPoint::lg:
                $I->click('.desktop-bar #toolbar .globalLinks-desktop');
                $I->click($link, '.desktop-bar #toolbar .globalLinks-desktop');
                break;
            case DesignBreakPoint::md:
                $I->click('.tablet-bar #toolbar .globalLinks-mobile');
                $I->click($link, '.tablet-bar #toolbar .globalLinks-mobile');
                break;
            case DesignBreakPoint::sm:
                $I->click('.tablet-bar #toolbar .globalLinks-mobile');
                $I->click($link, '.tablet-bar #toolbar .globalLinks-mobile');
                break;
            case DesignBreakPoint::xs:
                $I->click('.mobile-bar #toolbar .globalLinks-mobile');
                $I->click($link, '.mobile-bar #toolbar .globalLinks-mobile');
                break;
        }
    }

    /**
     * Navigates to module. Selects a menu item from the all menu (top nav)
     * @param $link
     *
     * <?php
     * $I->clickAllMenuItem('Accounts')
     *
     * Watch out - the mobile navigation employs a different structure with with tablet and desktop versions. It is
     * best to use just the module translations.
     *
     * Also:
     * the non filter navigation is not supported by this method
     */
    public function clickAllMenuItem($link)
    {
        $I = $this->tester;
        $config = $I->getConfig();
        $breakpoint = Design::getBreakpointString($config['width']);
        switch ($breakpoint)
        {
            case DesignBreakPoint::lg:
                $allMenuButton = '#toolbar.desktop-toolbar  > ul.nav.navbar-nav > li.topnav.all';
                $I->click('All', $allMenuButton);
                $allMenu = $allMenuButton . ' > span.notCurrentTab > ul.dropdown-menu';
                $I->waitForElementVisible($allMenu);
                $I->click($link, $allMenu);
                break;
            case DesignBreakPoint::md:
                $allMenuButton = 'div.navbar-header > button.navbar-toggle';
                $I->click($allMenuButton);
                $allMenu = 'div.navbar-header > #mobile_menu';
                $I->waitForElementVisible($allMenu);
                $I->click($link, $allMenu);
                break;
            case DesignBreakPoint::sm:
                $allMenuButton = 'div.navbar-header > button.navbar-toggle';
                $I->click($allMenuButton);
                $allMenu = 'div.navbar-header > #mobile_menu';
                $I->waitForElementVisible($allMenu);
                $I->click($link, $allMenu);
                break;
            case DesignBreakPoint::xs:
                $allMenuButton = 'div.navbar-header > button.navbar-toggle';
                $I->click($allMenuButton);
                $allMenu = 'div.navbar-header > #mobile_menu';
                $I->waitForElementVisible($allMenu);
                $I->click($link, $allMenu);
                break;
        }
    }

    // TODO: TASK: SCRM-660 - Create Test For Current Module Item Actions Menu
    /**
     * Selects a menu item from the current module menu (top nav)
     * @param $link
     *
     * <?php
     * $I->clickAllMenuItem('Accounts')
     *
     * Watch out - the mobile navigation employs a different structure with with tablet and desktop versions. It is
     * best to use just the module translations.
     *
     * Also:
     * the non filter navigation is not supported by this method
     */
    public function clickCurrentMenuItem($link)
    {
        $I = $this->tester;
        $config = $I->getConfig();
        $breakpoint = Design::getBreakpointString($config['width']);
        switch ($breakpoint)
        {
            case DesignBreakPoint::lg:
                $I->click('.currentTab > a');
                $I->waitForElementVisible('#toolbar.desktop-toolbar  > ul.nav.navbar-nav > li.topnav ul.dropdown-menu');
                $I->click($link);
                break;
            case DesignBreakPoint::md:
                $I->click('#modulelinks > .modulename > a');
                $I->waitForElementVisible('#modulelinks >ul.dropdown-menu');
                $I->click($link, '#modulelinks >ul.dropdown-menu');
                break;
            case DesignBreakPoint::sm:
                $I->click('#modulelinks > .modulename > a');
                $I->waitForElementVisible('#modulelinks >ul.dropdown-menu');
                $I->click($link, '#modulelinks >ul.dropdown-menu');
                break;
            case DesignBreakPoint::xs:
                $I->click('#modulelinks > .modulename > a');
                $I->waitForElementVisible('#modulelinks >ul.dropdown-menu');
                $I->click($link, '#modulelinks >ul.dropdown-menu');
                break;
        }
    }
}