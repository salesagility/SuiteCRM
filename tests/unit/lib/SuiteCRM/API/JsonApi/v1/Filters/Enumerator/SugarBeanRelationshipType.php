<?php


class SugarBeanRelationshipType extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var \SuiteCRM\API\JsonApi\v1\Enumerator\SugarBeanRelationshipType() $sugarBeanRelationShipType
     */
    private static $sugarBeanRelationShipType;

    protected function _before()
    {
        if(self::$sugarBeanRelationShipType === null) {
            self::$sugarBeanRelationShipType = new \SuiteCRM\API\JsonApi\v1\Enumerator\SugarBeanRelationshipType();
        }
    }

    protected function _after()
    {
    }

    public function testFromSugarBeanLinkToOne()
    {
        $obj = new \stdClass();
        $obj->getType = function() {
          return "one";
        };

        $expected = self::$sugarBeanRelationShipType::TO_ONE;
        $actual = self::$sugarBeanRelationShipType::fromSugarBeanLink($obj);

        $this->assertEquals($expected, $actual);
    }

    public function testFromSugarBeanLinkToMany()
    {
        $obj = new \stdClass();
        $obj->getType = function() {
            return "one";
        };

        $expected = self::$sugarBeanRelationShipType::TO_ONE;
        $actual = self::$sugarBeanRelationShipType::fromSugarBeanLink($obj);

        $this->assertEquals($expected, $actual);
    }
}