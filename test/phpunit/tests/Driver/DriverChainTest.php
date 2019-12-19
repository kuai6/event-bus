<?php

namespace Kuai6\EventBus\PhpUnit\Test\Driver;

use Kuai6\EventBus\Driver\DriverChain;
use Kuai6\EventBus\DriverInterface;
use Kuai6\EventBus\MessageInterface;

/**
 * Class DriverChainTest
 * @package Kuai6\EventBus\PhpUnit\Test\Driver
 */
class DriverChainTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test Creation with omitted options
     */
    public function testCreate()
    {
        $chain = new DriverChain();
        static::assertInstanceOf(\SplObjectStorage::class, $chain->getDrivers());
        static::assertCount(0, $chain->getDrivers());

        $chain = new DriverChain([]);
        static::assertInstanceOf(\SplObjectStorage::class, $chain->getDrivers());
        static::assertCount(0, $chain->getDrivers());

        $chain = new DriverChain(new \stdClass());
        static::assertInstanceOf(\SplObjectStorage::class, $chain->getDrivers());
        static::assertCount(0, $chain->getDrivers());
    }

    /**
     *  Test trigger
     */
    public function testInit()
    {
        $chain = new DriverChain();
        $mockDriver = $this->getMockBuilder(DriverInterface::class)
                            ->setMethods(['trigger', 'attach', 'getDriverConfig', 'init', 'confirm', 'reject'])
                            ->getMock();
        $mockDriver->expects($this->once())->method('init');
        $chain->addDriver($mockDriver);
        $chain->init();
    }

    /**
     * Test add driver
     */
    public function testAddDriver()
    {
        $chain = new DriverChain();

        /** @var DriverInterface $mockDriver */
        $mockDriver = $this->getMockBuilder(DriverInterface::class)->getMock();
        $chain->addDriver($mockDriver);

        static::assertInstanceOf(\SplObjectStorage::class, $chain->getDrivers());
        static::assertCount(1, $chain->getDrivers());
    }

    /**
     *  Test trigger
     */
    public function testTrigger()
    {
        $chain = new DriverChain();
        /** @var MessageInterface $mockMessage */
        $mockMessage = $this->getMockBuilder(MessageInterface::class)->getMock();

        $mockDriver = $this->getMockBuilder(DriverInterface::class)
                            ->setMethods(['trigger', 'attach', 'getDriverConfig', 'init', 'confirm', 'reject'])
                            ->getMock();
        $mockDriver->expects($this->once())
                    ->method('trigger')
                    ->with($this->equalTo('event-name'), $mockMessage);
        $chain->addDriver($mockDriver);
        $chain->trigger('event-name', $mockMessage);
    }

    /**
     * Test attach
     */
    public function testAttach()
    {
        $chain = new DriverChain();

        $callback = function () {
            return true;
        };
        $mockDriver = $this->getMockBuilder(DriverInterface::class)
                            ->setMethods(['trigger', 'attach', 'getDriverConfig', 'init', 'confirm', 'reject'])
                            ->getMock();
        $mockDriver->expects($this->once())
                    ->method('attach')
                    ->with($this->equalTo('message-name'), $this->callback($callback));

        $chain->addDriver($mockDriver);
        $chain->attach('message-name', $callback);
    }

    /**
     *  Test confirm
     */
    public function testConfirm()
    {
        $chain = new DriverChain();
        /** @var MessageInterface $mockMessage */
        $mockMessage = $this->getMockBuilder(MessageInterface::class)->getMock();

        $mockDriver = $this->getMockBuilder(DriverInterface::class)
                            ->setMethods(['trigger', 'attach', 'getDriverConfig', 'init', 'confirm', 'reject'])
                            ->getMock();
        $mockDriver->expects($this->once())->method('confirm')->with($mockMessage);
        $chain->addDriver($mockDriver);
        $chain->confirm($mockMessage);
    }

    /**
     *  Test confirm
     */
    public function testReject()
    {
        $chain = new DriverChain();
        /** @var MessageInterface $mockMessage */
        $mockMessage = $this->getMockBuilder(MessageInterface::class)->getMock();

        $mockDriver = $this->getMockBuilder(DriverInterface::class)
            ->setMethods(['trigger', 'attach', 'getDriverConfig', 'init', 'confirm', 'reject'])
            ->getMock();
        $mockDriver->expects($this->once())->method('reject')->with($mockMessage);
        $chain->addDriver($mockDriver);
        $chain->reject($mockMessage);
    }
}
