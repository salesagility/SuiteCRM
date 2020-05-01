<?php

namespace Page;

use AcceptanceTester as Tester;

class FileModule
{
    /**
     * @var string include url of current page
     */
    public static $URL = 'index.php?module=Test_FileModule&action=index';

    /**
     * @var string
     */
    public static $PACKAGE_NAME = 'FileTestModule';

    /**
     * @var string
     */
    public static $NAME = 'FileTestModule';

    /**
     * @var Tester;
     */
    protected $tester;

    /**
     * FileModule constructor.
     *
     * @param Tester $I
     */
    public function __construct(Tester $I)
    {
        $this->tester = $I;
    }
}
