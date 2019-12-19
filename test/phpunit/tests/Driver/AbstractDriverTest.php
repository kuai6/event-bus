<?php

namespace Kuai6\EventBus\PhpUnit\Test\Driver;

use Kuai6\EventBus\Driver\AbstractDriver;
use PHPUnit_Framework_TestCase;

/**
 * Class AbstractDriverTest
 * @package Kuai6\EventBus\PhpUnit\Test\Driver
 */
class AbstractDriverTest extends PHPUnit_Framework_TestCase
{
    /**
     * Create driver with empty options
     * @expectedException  \Kuai6\EventBus\Driver\Exception\InvalidDriverConfigException
     */
    public function testEmptyOptions()
    {
        $this->getMockForAbstractClass(AbstractDriver::class);
    }

    /**
     * Create driver with array options
     *
     */
    public function testTraversableOptions()
    {
        $expected = [
            'name' => 'testValue1',
            'testKey1' => 'testValue1',
        ];

        $arg = [
            'options' => $expected
        ];
        /** @var AbstractDriver $driver */
        $driver = $this->getMockForAbstractClass(AbstractDriver::class, $arg);

        $actual = $driver->getDriverConfig();

        static::assertEquals($expected['name'], $actual->getName());
        unset($expected['name']);
        static::assertEquals($expected, $actual->getExtraOptions());
    }


    /**
     * Create driver with invalid options
     * @expectedException  \Kuai6\EventBus\Driver\Exception\InvalidArgumentException
     * @expectedExceptionMessage Config must be an array, Kuai6\EventBus\Driver\DriverConfig or null, string given
     *
     */
    public function testInvalidOptions()
    {
        $arg = [
            'options' => 'invalid-options'
        ];
        $this->getMockForAbstractClass(AbstractDriver::class, $arg);
    }
}
