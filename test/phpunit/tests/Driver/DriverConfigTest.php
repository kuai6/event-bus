<?php

namespace Kuai6\EventBus\PhpUnit\Test\Driver;

use Kuai6\EventBus\Driver\DriverConfig;
use PHPUnit_Framework_TestCase;

/**
 * Class DriverConfigTest
 * @package Kuai6\EventBus\PhpUnit\Test\Driver
 */
class DriverConfigTest extends PHPUnit_Framework_TestCase
{
    /**
     * Создание DriverConfig
     */
    public function testCreateDriverConfig()
    {
        $options = [
            'name' => 'test'
        ];
        $driverConfig = new DriverConfig($options);

        static::assertInstanceOf(DriverConfig::class, $driverConfig);
    }

    /**
     * @expectedException  \Kuai6\EventBus\Driver\Exception\InvalidDriverConfigException
     * @expectedExceptionMessage Config section name not found
     *
     * Создание DriverConfig. Не указан pluginNmae
     */
    public function testCreateDriverConfigPluginNameNotSpecified()
    {
        new DriverConfig();
    }

    /**
     * Проверка работы getter/setter для свойтсва pluginName
     *
     */
    public function testGetterPluginName()
    {
        $expectedName = 'test';
        $options = [
            'name' => $expectedName
        ];
        $driverConfig = new DriverConfig($options);

        $actualName = $driverConfig->getName();

        static::assertEquals($expectedName, $actualName);
    }

    /**
     * Проверка генерации конфига
     *
     */
    public function testGetPluginConfig()
    {
        $options = [
            DriverConfig::NAME       => 'test',
            DriverConfig::DRIVERS           => [
                'test'
            ],
            DriverConfig::CONNECTION        => 'test-connection-name',
            DriverConfig::CONNECTION_CONFIG => [
                'param' => [
                    'test' => 'test'
                ]
            ],
            'example' => [
                'test' => 'test'
            ],
            DriverConfig::ADAPTER_NAME => 'testAdapterName',
            DriverConfig::ADAPTER_CONFIG => [],
            DriverConfig::METADATA_READER => 'test-metadata0reader',
            DriverConfig::METADATA_READER_CONFIG => [
                'paths' => [__DIR__]
            ],
            DriverConfig::METADATA_CLASS => '',
        ];
        $driverConfig = new DriverConfig($options);

        $actualPluginConfig = $driverConfig->getPluginConfig();
        $expectedPluginConfig = [
            DriverConfig::NAME       => 'test',
            DriverConfig::DRIVERS           => [
                'test'
            ],
            DriverConfig::CONNECTION        => 'test-connection-name',
            DriverConfig::CONNECTION_CONFIG => [
                'param' => [
                    'test' => 'test'
                ]
            ],
            DriverConfig::EXTRA_OPTIONS => [
                'example' => [
                    'test' => 'test'
                ]
            ],
            DriverConfig::ADAPTER_NAME => 'testAdapterName',
            DriverConfig::ADAPTER_CONFIG => [],
            DriverConfig::METADATA_READER => 'test-metadata0reader',
            DriverConfig::METADATA_READER_CONFIG => [
                'paths' => [__DIR__]
            ],
            DriverConfig::METADATA_CLASS => '',
        ];

        static::assertEquals($expectedPluginConfig, $actualPluginConfig);
    }

    /**
     * Test connetcion is not a string
     */
    public function testSetConnectionNotString()
    {
        $options = [
            DriverConfig::NAME       => 'test',
            DriverConfig::CONNECTION => []
        ];
        try {
            new DriverConfig($options);
        } catch (\Exception $e) {
            static::assertInstanceOf(\Kuai6\EventBus\Driver\Exception\InvalidArgumentException::class, $e);
        }
    }
}
