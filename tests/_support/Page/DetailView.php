<?php

namespace Page;

use \AcceptanceTester as Tester;
use SuiteCRM\Enumerator\DesignBreakPoint;

class DetailView
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

    // TODO: TASK: SCRM-660 - Create Test For List View

    /**
     * Click on a menu item from the action menu
     * @param string $link
     */
    public function clickActionMenuItem($link)
    {
        $I = $this->tester;

        $I->click('ACTIONS', '#tab-actions');
        $I->waitForElementVisible('#tab-actions > .dropdown-menu');

        $I->click($link, '#tab-actions > .dropdown-menu');
    }
}