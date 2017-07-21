<?php
namespace Page;

use \AcceptanceTester as Tester;
use Faker\Factory;
use Faker\Generator;


class BasicModule
{
    /**
     * @var string $URL include url of current page
     */
    public static $URL = 'index.php?module=BasicModule&action=index';

    /**
     * @var string $NAME
     */
    public static $NAME = 'BasicTestModule';

    /**
     * @var Generator
     */
    public static $fakeData ;

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
        if(!self::$fakeData) {
            self::$fakeData = Factory::create()->unique();
        }
    }
}
