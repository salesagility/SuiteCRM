<?php

namespace Step\Acceptance;

use \AcceptanceTester as Tester;
use Page\Design;
use SuiteCRM\Enumerator\DesignBreakPoint;

class NavigationBar extends  Tester
{
    /**
     * Click on the home buton / navbar brand
     */
    public function clickHome()
    {
        $I = $this;
        $design = new Design($I);
        $breakpoint = $design->getBreakpointString();
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
        $I = $this;
        $design = new Design($I);
        $breakpoint = $design->getBreakpointString();
        switch ($breakpoint)
        {
            case DesignBreakPoint::lg:
                $I->moveMouseOver('.desktop-bar #toolbar .globalLinks-desktop');
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
        $I = $this;
        $design = new Design($I);
        $breakpoint = $design->getBreakpointString();
        switch ($breakpoint)
        {
            case DesignBreakPoint::lg:
                $allMenuButton = '#toolbar.desktop-toolbar  > ul.nav.navbar-nav > li.topnav.all';
                $I->waitForElementVisible($allMenuButton, 30);
                $I->wait(1);
                $I->click('All', $allMenuButton);
                $allMenu = $allMenuButton . ' > span.notCurrentTab > ul.dropdown-menu';
                $I->waitForElementVisible($allMenu, 120);
                $I->click($link, $allMenu);
                break;
            case DesignBreakPoint::md:
                $allMenuButton = 'div.navbar-header > button.navbar-toggle';
                $I->waitForElementVisible($allMenuButton, 30);
                $I->wait(1);
                $I->click($allMenuButton);
                $allMenu = 'div.navbar-header > #mobile_menu';
                $I->waitForElementVisible($allMenu,  120);
                $I->click($link, $allMenu);
                break;
            case DesignBreakPoint::sm:
                $allMenuButton = 'div.navbar-header > button.navbar-toggle';
                $I->waitForElementVisible($allMenuButton, 30);
                $I->wait(1);
                $I->click($allMenuButton);
                $allMenu = 'div.navbar-header > #mobile_menu';
                $I->waitForElementVisible($allMenu, 120);
                $I->click($link, $allMenu);
                break;
            case DesignBreakPoint::xs:
                $allMenuButton = 'div.navbar-header > button.navbar-toggle';
                $I->waitForElementVisible($allMenuButton, 30);
                $I->wait(1);
                $I->click($allMenuButton);
                $allMenu = 'div.navbar-header > #mobile_menu';
                $I->waitForElementVisible($allMenu, 120);
                $I->click($link, $allMenu);
                break;
        }
    }

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
        $I = $this;
        $design = new Design($I);
        $breakpoint = $design->getBreakpointString();
        switch ($breakpoint)
        {
            case DesignBreakPoint::lg:
                $I->moveMouseOver('//*[@id="toolbar"]/ul/li[2]/span[2]/a');
                $I->waitForElementVisible('#toolbar.desktop-toolbar  > ul.nav.navbar-nav > li.topnav ul.dropdown-menu > li.current-module-action-links > ul', 30);
                $I->waitForText($link, 30, '#toolbar.desktop-toolbar  > ul.nav.navbar-nav > li.topnav > ul.dropdown-menu > li.current-module-action-links');
                $I->click($link, '#toolbar.desktop-toolbar  > ul.nav.navbar-nav > li.topnav > ul.dropdown-menu > li.current-module-action-links');
                break;
            case DesignBreakPoint::md:
                $I->click('div#mobileheader > div#modulelinks > .modulename > a');
                $I->waitForElementVisible('div#mobileheader > div#modulelinks > ul.dropdown-menu > li.mobile-current-actions > ul.mobileCurrentTab', 30);
                $I->waitForText($link, 30, 'div#mobileheader > div#modulelinks > ul.dropdown-menu > li.mobile-current-actions > ul.mobileCurrentTab');
                $I->click($link, 'div#mobileheader > div#modulelinks > ul.dropdown-menu > li.mobile-current-actions > ul.mobileCurrentTab');
                break;
            case DesignBreakPoint::sm:
                $I->click('div#mobileheader > div#modulelinks > .modulename > a');
                $I->waitForElementVisible('#modulelinks > ul.dropdown-menu');
                $I->waitForText($link, 30, 'div#mobileheader > div#modulelinks > ul.dropdown-menu > li.mobile-current-actions > ul.mobileCurrentTab', 30);
                $I->click($link, 'div#mobileheader > div#modulelinks > ul.dropdown-menu > li.mobile-current-actions > ul.mobileCurrentTab');
                break;
            case DesignBreakPoint::xs:
                $I->click('div#mobileheader > div#modulelinks > .modulename > a');
                $I->waitForElementVisible('div#mobileheader > div#modulelinks > ul.dropdown-menu > li.mobile-current-actions > ul.mobileCurrentTab', 30);
                $I->waitForText($link, 30, 'div#mobileheader > div#modulelinks > ul.dropdown-menu > li.mobile-current-actions > ul.mobileCurrentTab');
                $I->click($link, 'div#mobileheader > div#modulelinks > ul.dropdown-menu > li.mobile-current-actions > ul.mobileCurrentTab');
                break;
        }
    }
}