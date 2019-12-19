<?php

namespace Kuai6\EventBus;

use Kuai6\EventBus\Driver\DriverConfig;

/**
 * Interface Driver
 * @package Kuai6\EventBus
 */
interface DriverInterface
{
    /**
     * Trigger message to bus
     *
     * @param string           $eventName
     * @param MessageInterface $message
     */
    public function trigger($eventName, MessageInterface $message);

    /**
     * Attach Bus and get message
     *
     * @param string   $messageName
     * @param callable $callback
     */
    public function attach($messageName, callable $callback);

    /**
     * Get driver config
     *
     * @return DriverConfig
     */
    public function getDriverConfig();

    /**
     * Init driver (create exchanges/topics/queues for RabbitMQ Driver, etc.)
     *
     * @return void
     */
    public function init();

    /**
     * Confirm message
     *
     * @param MessageInterface $message
     * @return void
     */
    public function confirm(MessageInterface $message);

    /**
     * Reject message
     *
     * @param MessageInterface $message
     * @return void
     */
    public function reject(MessageInterface $message);
}
