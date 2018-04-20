<?php


class SugarBeanRelationshipType extends SuiteCRM\StateCheckerUnitAbstract
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var \SuiteCRM\API\JsonApi\v1\Enumerator\SugarBeanRelationshipType() $sugarBeanRelationShipType
     */
    private static $sugarBeanRelationShipType;

    public function _before()
    {
        parent::_before();
        if(self::$sugarBeanRelationShipType === null) {
            self::$sugarBeanRelationShipType = new \SuiteCRM\API\JsonApi\v1\Enumerator\SugarBeanRelationshipType();
        }
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