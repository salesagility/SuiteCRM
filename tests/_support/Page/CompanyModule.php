<?php

namespace Page;

use AcceptanceTester as Tester;

class CompanyModule
{
    /**
     * @var string include url of current page
     */
    public static $URL = 'index.php?module=Test_CompanyModule&action=index';

    /**
     * @var string
     */
    public static $PACKAGE_NAME = 'CompanyTestModule';

    /**
     * @var string
     */
    public static $NAME = 'CompanyTestModule';

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
