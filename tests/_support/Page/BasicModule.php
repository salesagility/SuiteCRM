<?php
namespace Page;

use \AcceptanceTester as Tester;
use Faker\Generator;

class BasicModule
{
    /**
     * @var string $URL include url of current page
     */
    public static $URL = 'index.php?module=Test_BasicModule&action=index';

    /**
     * @var string $NAME
     */
    public static $PACKAGE_NAME = 'BasicTestModule';

    /**
     * @var string $NAME
     */
    public static $NAME = 'BasicTestModule';

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
}
