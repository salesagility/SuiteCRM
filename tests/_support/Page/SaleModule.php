<?php

namespace Page;

use AcceptanceTester as Tester;

class SaleModule
{
    /**
     * @var string include url of current page
     */
    public static $URL = 'index.php?module=Test_SaleModule&action=index';

    /**
     * @var string
     */
    public static $PACKAGE_NAME = 'SaleTestModule';

    /**
     * @var string
     */
    public static $NAME = 'SaleTestModule';

    /**
     * @var Tester;
     */
    protected $tester;

    /**
     * SaleModule constructor.
     *
     * @param Tester $I
     */
    public function __construct(Tester $I)
    {
        $this->tester = $I;
    }
}
