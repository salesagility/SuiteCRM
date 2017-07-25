<?php

namespace Page;

use \AcceptanceTester as Tester;
use SuiteCRM\Enumerator\DesignBreakPoint;

class ListView
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
}