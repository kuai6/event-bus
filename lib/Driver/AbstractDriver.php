<?php

namespace Kuai6\EventBus\Driver;

use Kuai6\EventBus\Driver\Exception\InvalidArgumentException;
use Kuai6\EventBus\DriverInterface;

/**
 * Class AbstractDriver
 * @package Kuai6\EventBus\Driver
 */
abstract class AbstractDriver implements DriverInterface
{
    /**
     * @var DriverConfig
     */
    protected $driverConfig;

    /**
     * @param array|DriverConfig|null $config
     * @throws Exception\InvalidArgumentException
     * @throws Exception\InvalidDriverConfigException
     */
    public function __construct($config = null)
    {
        if (null === $config) {
            $config = [];
        }

        if (is_array($config)) {
            $config = new DriverConfig($config);
        }

        if (!$config instanceof DriverConfig) {
            throw new InvalidArgumentException(sprintf(
                'Config must be an array, %s or null, %s given',
                DriverConfig::class,
                is_object($config) ?  get_class($config) : gettype($config)
            ));
        }

        $this->setDriverConfig($config);
    }

    /**
     * @return DriverConfig
     */
    public function getDriverConfig()
    {
        return $this->driverConfig;
    }

    /**
     * @param DriverConfig $driverConfig
     * @return $this
     */
    public function setDriverConfig($driverConfig)
    {
        $this->driverConfig = $driverConfig;
        return $this;
    }
}
