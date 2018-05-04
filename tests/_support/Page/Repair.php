<?php

namespace Page;

use \AcceptanceTester as Tester;

use Codeception\Module;
use Helper\WebDriverHelper;
use SuiteCRM\Enumerator\DesignBreakPoint;

class Repair extends Module
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
     * @return bool
     */
    public function executeSqlButtonExists()
    {
        return $this->tester->executeJS('return document.getElementsByName("RepairDatabaseForm").length > 0;');
    }
}