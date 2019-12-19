<?php

namespace Kuai6\EventBus\Driver;

/**
 * Class DriverConfig
 * @package Kuai6\EventBus\Driver
 */
class DriverConfig
{
    const NAME      = 'name';

    const DRIVERS   = 'drivers';

    const ADAPTER_NAME      = 'adapterName';

    const ADAPTER_CONFIG    = 'adapterConfig';

    const CONNECTION        = 'connection';

    const CONNECTION_CONFIG = 'connectionConfig';

    const EXTRA_OPTIONS     = 'extraOptions';

    const METADATA_READER   = 'metadataReader';

    const METADATA_READER_CONFIG    = 'metadataReaderConfig';

    const METADATA_CLASS    = 'metadataClass';

    /**
     * Имя драйвера
     *
     * @var string
     */
    protected $name;

    /**
     * Adapter name for driver.
     *
     * @var string|null
     */
    protected $adapterName;


    /**
     * Adapter config
     *
     * @var array
     */
    protected $adapterConfig = [];

    /**
     * Секция описывает используемые драйвера. Используется только в DriverChain
     *
     * @var array
     */
    protected $drivers = [];

    /**
     * Имя соедения используемое для драйвера (в конфиге приложения event_bus|connection)
     *
     * @var string|null
     */
    protected $connection;

    /**
     * Настройки соеденения
     *
     * @var array
     */
    protected $connectionConfig = [];

    /**
     * Настройки компонента отвечающего за получение метаданных
     *
     * @var array
     */
    protected $metadataReaderConfig = [];

    /**
     * Настройки специфичные для конкретного драйвера
     *
     * @var array
     */
    protected $extraOptions = [];

    /**
     * Metadata object class name
     *
     * @var string
     */
    protected $metadataClass;

    /**
     * Имя ридера метаданных
     *
     * @var string
     */
    protected $metadataReader;

    /**
     * @param array $config
     *
     * @throws Exception\InvalidDriverConfigException
     * @throws Exception\InvalidArgumentException
     */
    public function __construct(array $config = [])
    {
        if (!array_key_exists(static::NAME, $config)) {
            $errMsg = sprintf('Config section %s not found', static::NAME);
            throw new Exception\InvalidDriverConfigException($errMsg);
        }
        $this->setName($config[static::NAME]);
        unset($config[static::NAME]);

        if (array_key_exists(static::DRIVERS, $config) && is_array($config[static::DRIVERS])) {
            $this->setDrivers($config[static::DRIVERS]);
            unset($config[static::DRIVERS]);
        }

        if (array_key_exists(static::CONNECTION, $config)) {
            $this->setConnection($config[static::CONNECTION]);
            unset($config[static::CONNECTION]);
        }

        if (array_key_exists(static::CONNECTION_CONFIG, $config) && is_array($config[static::CONNECTION_CONFIG])) {
            $this->setConnectionConfig($config[static::CONNECTION_CONFIG]);
            unset($config[static::CONNECTION_CONFIG]);
        }

        if (array_key_exists(static::ADAPTER_NAME, $config)) {
            $this->setAdapterName($config[static::ADAPTER_NAME]);
            unset($config[static::ADAPTER_NAME]);
        }

        if (array_key_exists(static::ADAPTER_CONFIG, $config) && is_array($config[static::ADAPTER_CONFIG])) {
            $this->setAdapterConfig($config[static::ADAPTER_CONFIG]);
            unset($config[static::ADAPTER_CONFIG]);
        }

        if (array_key_exists(static::METADATA_READER_CONFIG, $config) && is_array($config[static::METADATA_READER_CONFIG])) {
            $this->setMetadataReaderConfig($config[static::METADATA_READER_CONFIG]);
            unset($config[static::METADATA_READER_CONFIG]);
        }

        if (array_key_exists(static::METADATA_READER, $config) && is_string($config[static::METADATA_READER])) {
            $this->setMetadataReader($config[static::METADATA_READER]);
            unset($config[static::METADATA_READER]);
        }

        if (array_key_exists(static::METADATA_CLASS, $config) && is_string($config[static::METADATA_CLASS])) {
            $this->setMetadataClass($config[static::METADATA_CLASS]);
            unset($config[static::METADATA_CLASS]);
        }

        $this->setExtraOptions($config);
    }

    /**
     * @return string
     */
    public function getMetadataReader()
    {
        return $this->metadataReader;
    }

    /**
     * @param string $metadataReader
     *
     * @return $this
     */
    public function setMetadataReader($metadataReader)
    {
        $this->metadataReader = (string)$metadataReader;

        return $this;
    }

    /**
     * @return array
     */
    public function getMetadataReaderConfig()
    {
        return $this->metadataReaderConfig;
    }

    /**
     * @param array $metadataReaderConfig
     *
     * @return $this
     */
    public function setMetadataReaderConfig(array $metadataReaderConfig = [])
    {
        $this->metadataReaderConfig = $metadataReaderConfig;

        return $this;
    }

    /**
     * @return array
     */
    public function getExtraOptions()
    {
        return $this->extraOptions;
    }

    /**
     * @param array $extraOptions
     *
     * @return $this
     */
    public function setExtraOptions(array $extraOptions = [])
    {
        $this->extraOptions = $extraOptions;

        return $this;
    }


    /**
     * @return array
     */
    public function getConnectionConfig()
    {
        return $this->connectionConfig;
    }

    /**
     * @param array $connectionConfig
     *
     * @return $this
     */
    public function setConnectionConfig(array $connectionConfig = [])
    {
        $this->connectionConfig = $connectionConfig;

        return $this;
    }


    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = (string)$name;

        return $this;
    }

    /**
     * @return array
     */
    public function getDrivers()
    {
        return $this->drivers;
    }

    /**
     * @param array $drivers
     *
     * @return $this
     */
    public function setDrivers(array $drivers = [])
    {
        $this->drivers = $drivers;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param null|string $connection
     * @return $this
     * @throws Exception\InvalidArgumentException
     */
    public function setConnection($connection)
    {
        try {
            $flag = (string) $connection;
        } catch (\Exception $e) {
            $flag = false;
        }
        if (!$flag) {
            throw new Exception\InvalidArgumentException('Connection name must be a string');
        }
        $this->connection = $connection;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAdapterName()
    {
        return $this->adapterName;
    }

    /**
     * @param string $adapterName
     * @return $this
     */
    public function setAdapterName($adapterName)
    {
        $this->adapterName = $adapterName;
        return $this;
    }

    /**
     * @return array
     */
    public function getAdapterConfig()
    {
        return $this->adapterConfig;
    }

    /**
     * @param array $adapterConfig
     * @return $this
     */
    public function setAdapterConfig($adapterConfig)
    {
        $this->adapterConfig = $adapterConfig;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMetadataClass()
    {
        return $this->metadataClass;
    }

    /**
     * @param string $metadataClass
     * @return $this
     */
    public function setMetadataClass(string $metadataClass)
    {
        $this->metadataClass = $metadataClass;
        return $this;
    }

    /**
     * Конфиг  с найстройкой драйвера шины событий
     *
     * @return array
     */
    public function getPluginConfig()
    {
        $config = [
            static::NAME => $this->getName(),
            static::DRIVERS => $this->getDrivers(),
            static::ADAPTER_NAME => $this->getAdapterName(),
            static::ADAPTER_CONFIG => $this->getAdapterConfig(),
            static::CONNECTION => $this->getConnection(),
            static::CONNECTION_CONFIG => $this->getConnectionConfig(),
            static::EXTRA_OPTIONS => $this->getExtraOptions(),
            static::METADATA_CLASS => $this->getMetadataClass(),
            static::METADATA_READER => $this->getMetadataReader(),
            static::METADATA_READER_CONFIG => $this->getMetadataReaderConfig()
        ];

        return $config;
    }
}
