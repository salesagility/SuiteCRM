<?php

namespace Page;

use AcceptanceTester as Tester;

class PersonModule
{
    /**
     * @var string include url of current page
     */
    public static $URL = 'index.php?module=Test_PersonModule&action=index';

    /**
     * @var string
     */
    public static $PACKAGE_NAME = 'PersonTestModule';

    /**
     * @var string
     */
    public static $NAME = 'PersonTestModule';

    /**
     * @var Tester;
     */
    protected $tester;

    /**
     * PersonModule constructor.
     *
     * @param Tester $I
     */
    public function __construct(Tester $I)
    {
        $this->tester = $I;
    }
}
