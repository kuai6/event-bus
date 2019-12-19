<?php

namespace Kuai6\EventBus\Driver;

use Kuai6\EventBus\DriverInterface;
use Kuai6\EventBus\MessageInterface;
use SplObjectStorage;

/**
 * Class DriverChain
 * @package Kuai6\EventBus\Driver
 */
class DriverChain extends AbstractDriver
{
    /**
     * @var DriverInterface []|SplObjectStorage
     */
    protected $drivers;

    /**
     * @param array $config
     * @throws  \Kuai6\EventBus\Driver\Exception\InvalidArgumentException
     */
    public function __construct($config = null)
    {
        $this->drivers = new \SplObjectStorage();
    }

    /**
     * @param $eventName
     * @param MessageInterface $message
     */
    public function trigger($eventName, MessageInterface $message)
    {
        $drivers = $this->getDrivers();
        foreach ($drivers as $driver) {
            $driver->trigger($eventName, $message);
        }
    }

    /**
     * @param DriverInterface $driver
     * @return $this
     */
    public function addDriver($driver)
    {
        $this->drivers->attach($driver);
        return $this;
    }

    /**
     * @return DriverInterface[]|SplObjectStorage
     */
    public function getDrivers()
    {
        return $this->drivers;
    }

    /**
     * Init
     *
     * @return void
     */
    public function init()
    {
        $drivers = $this->getDrivers();
        foreach ($drivers as $driver) {
            $driver->init();
        }
    }

    /**
     * Attach Messages
     *
     * @param string   $messageName
     * @param callable $callback
     */
    public function attach($messageName, callable $callback)
    {
        //@TODO think about this...
        $drivers = $this->getDrivers();
        foreach ($drivers as $driver) {
            $driver->attach($messageName, $callback);
        }
    }

    /**
     * Confirm message
     *
     * @param MessageInterface $message
     * @return void
     */
    public function confirm(MessageInterface $message)
    {
        $drivers = $this->getDrivers();
        foreach ($drivers as $driver) {
            $driver->confirm($message);
        }
    }

    /**
     * Reject message
     *
     * @param MessageInterface $message
     * @return void
     */
    public function reject(MessageInterface $message)
    {
        $drivers = $this->getDrivers();
        foreach ($drivers as $driver) {
            $driver->reject($message);
        }
    }
}
