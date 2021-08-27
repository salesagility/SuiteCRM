<?php
/**
 * SuiteCRM is a customer relationship management program developed by SalesAgility Ltd.
 * Copyright (C) 2021 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SALESAGILITY, SALESAGILITY DISCLAIMS THE
 * WARRANTY OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see http://www.gnu.org/licenses.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License
 * version 3, these Appropriate Legal Notices must retain the display of the
 * "Supercharged by SuiteCRM" logo. If the display of the logos is not reasonably
 * feasible for technical reasons, the Appropriate Legal Notices must display
 * the words "Supercharged by SuiteCRM".
 */

namespace SuiteCRM\Tests\Unit\lib\SuiteCRM\Search;

use Mockery;
use ReflectionClass;
use ReflectionException;
use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

/**
 * Class SearchTestAbstract
 * @package SuiteCRM\Tests\Unit\lib\SuiteCRM\Search
 */
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
    public function invokeMethod(object $object, string $methodName, array $parameters = [])
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
    public function setValue(object $object, string $property, $value): void
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
