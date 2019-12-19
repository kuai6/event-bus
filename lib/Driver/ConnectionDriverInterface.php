<?php

namespace Kuai6\EventBus\Driver;

/**
 * Interface ConnectionDriverInterface
 * @package Kuai6\EventBus\Driver
 */
interface ConnectionDriverInterface
{
    /**
     * @return array
     */
    public function getConnectionConfig();

    /**
     * @param array $connectionConfig
     *
     * @return $this
     */
    public function setConnectionConfig(array $connectionConfig = []);
}
