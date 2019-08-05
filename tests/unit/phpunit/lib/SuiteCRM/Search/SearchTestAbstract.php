<?php

namespace SuiteCRM\Search;

use Mockery;
use ReflectionClass;
use ReflectionException;
use SuiteCRM\StateCheckerPHPUnitTestCaseAbstract;

abstract class SearchTestAbstract extends StateCheckerPHPUnitTestCaseAbstract
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
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
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
        $reflection = new ReflectionClass(get_class($object));
        $property = $reflection->getProperty($property);
        $property->setAccessible(true);
        $property->setValue($object, $value);
    }

    /** @inheritdoc */
    protected function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}
