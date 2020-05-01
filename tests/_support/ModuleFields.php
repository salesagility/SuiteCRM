<?php

namespace Page;

use AcceptanceTester as Tester;

class ModuleFields
{
    /**
     * @var string include url of current page
     */
    public static $URL = 'index.php?module=Test_ModuleFields&action=index';

    /**
     * @var string
     */
    public static $PACKAGE_NAME = 'TestModuleFields';

    /**
     * @var string
     */
    public static $NAME = 'TestModuleFields';

    /**
     * @var Tester;
     */
    protected $tester;

    /**
     * BasicModule constructor.
     *
     * @param Tester $I
     */
    public function __construct(Tester $I)
    {
        $this->tester = $I;
    }
}
