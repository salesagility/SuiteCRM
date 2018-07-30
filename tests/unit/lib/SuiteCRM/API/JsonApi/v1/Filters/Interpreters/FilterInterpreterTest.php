<?php


class FilterInterpreterTest extends SuiteCRM\StateCheckerUnitAbstract
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var \SuiteCRM\API\JsonApi\v1\Filters\Interpreters\FilterInterpreter $operator
     */
    private static $interpreter;

    public function _before()
    {
        parent::_before();
        if (self::$interpreter === null) {

            // load PSR 11 interface
            $container = $this->tester->getContainerInterface();
            self::$interpreter = new \SuiteCRM\API\JsonApi\v1\Filters\Interpreters\FilterInterpreter($container);
        }
    }


    public function testIsFilterByPreMadeWithByPreMadeFilterCase()
    {
        $filter = array('Today');
        $this->assertTrue(self::$interpreter->isFilterByPreMadeName($filter));
    }

    public function testIsFilterByPreMadeWithByIdCaseCase()
    {
        $filter = array('[id]' => array('1', '2', '3'));
        $this->assertFalse(self::$interpreter->isFilterByPreMadeName($filter));
    }

    public function testIsFilterByPreMadeWithByAttributeCase()
    {
        $filter = array('[name]' => array('[[eq]]', 'foo'));
        $this->assertFalse(self::$interpreter->isFilterByPreMadeName($filter));
    }

    public function testIsFilterByIdWithByPreMadeNameCase()
    {
        $filter = array('Today');
        $this->assertFalse(self::$interpreter->isFilterById($filter));
    }

    public function testIsFilterByIdWithByIdCase()
    {
        $filter = array('[id]' => array('1', '2', '3'));
        $this->assertTrue(self::$interpreter->isFilterById($filter));
    }

    public function testIsFilterByIdWithByAttributeCase()
    {
        $filter = array('[name]' => array('[[eq]]', 'foo'));
        $this->assertFalse(self::$interpreter->isFilterById($filter));
    }

    public function testIsFilterByAttributesWithByPreMadeNameCase()
    {
        $filter = array('Today');
        $this->assertFalse(self::$interpreter->isFilterByAttributes($filter));
    }

    public function testIsFilterByAttributesWithByIdCase()
    {
        $filter = array('[id]' => array('1', '2', '3'));
        $this->assertFalse(self::$interpreter->isFilterByAttributes($filter));
    }

    public function testIsFilterByAttributesWithByAttributeCase()
    {
        $filter = array('[name]' => array('[[eq]]', 'foo'));
        $this->assertTrue(self::$interpreter->isFilterByAttributes($filter));
    }

    public function testGetFilterByPreMadeName()
    {
        $filter = array('Today');
        self::$interpreter->getFilterByPreMadeName($filter);
    }

    public function testGetFilterByPreMadeNameWithNoFilter()
    {
        $this->tester->expectException(
            new \SuiteCRM\Exception\Exception('[JsonApi][v1][Filters][Interpreters][getFilterByPreMadeName][cannot find filter]'),
            function () {
                $filter = array('InvalidFilterThatIsNotFound');
                self::$interpreter->getFilterByPreMadeName($filter);
            }
        );
    }

    public function testGetFilterById()
    {
        $filter = array(
            '[id]' => array(
                '3',
                '2',
                '1',
            )
        );
        $expected = 'id IN ("3","2","1")';
        $actual = self::$interpreter->getFilterById($filter);
        $this->assertEquals($expected, $actual);
    }

    public function testGetFilterByAttributes()
    {
        $filter = array(
            '[Accounts]' => array(
                '[date_modified]' => array(
                    '[[gte]]',
                    '2017-11-17T11:40:00+00:00'
                ),
            )
        );
        $expected = 'accounts.date_modified >= "2017-11-17T11:40:00+00:00"';
        $actual = self::$interpreter->getFilterByAttributes($filter, array());
        $this->assertEquals($expected, $actual);
    }

    public function testGetFilterByAttributesIn()
    {
        $filter = array(
            '[Accounts]' => array(
                '[name]' => array(
                    '[[in]]',
                    'a',
                    'b',
                    'c',
                    'd',
                    'e',
                ),
            )
        );
        $expected = 'accounts.name IN ("a","b","c","d","e")';
        $actual = self::$interpreter->getFilterByAttributes($filter, array());
        $this->assertEquals($expected, $actual);
    }
}
