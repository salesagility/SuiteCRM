<?php

namespace SuiteCRM\Search;

use Mockery;
use ReflectionClass;
use ReflectionException;
use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

abstract class SearchTestAbstract extends SuitePHPUnitFrameworkTestCase
{
    /**
     * Call protected/private method of a class.
     *
     * @param object &$object Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     * @throws ReflectionException
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $method = (new ReflectionClass(get_class($object)))->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     * Sets the value of a private property.
     *
     * @param object $object Instantiated object to set the value of.
     * @param string $property name of the property.
     * @param mixed $value value of the property.
     * @throws ReflectionException
     */
    public function setValue(&$object, $property, $value)
    {
        $property = (new ReflectionClass(get_class($object)))->getProperty($property);
        $property->setAccessible(true);
        $property->setValue($object, $value);
    }

    /** @inheritdoc */
    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }
}
