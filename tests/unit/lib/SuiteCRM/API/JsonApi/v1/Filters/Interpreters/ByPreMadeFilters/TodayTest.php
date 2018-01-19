<?php


class TodayTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var \SuiteCRM\API\JsonApi\v1\Filters\Interpreters\ByPreMadeFilters\Today $operator
     */
    private static $filter;

    protected function _before()
    {
        if(self::$filter === null) {
            self::$filter = new \SuiteCRM\API\JsonApi\v1\Filters\Interpreters\ByPreMadeFilters\Today();
        }
    }

    protected function _after()
    {
    }

    public function testHasByPreMadeFilter()
    {
        $this->assertTrue(self::$filter->hasByPreMadeFilter('Today'));
    }

    public function testGetByPreMadeFilter()
    {
        $today = new \DateTime();
        $today = $today->setTime(0,0,0);
        $expected = 'date_entered >= "'. $today->format(DATE_ATOM) . '"';
        $actual = self::$filter->getByPreMadeFilter();
        $this->assertEquals(
            $expected,
            $actual
        );
    }

}