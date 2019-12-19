<?php


namespace Kuai6\EventBus\Driver;

/**
 * Class MetadataAwareTrait
 * @package Kuai6\EventBus\Driver
 */
trait MetadataAwareTrait
{
    /**
     * @var mixed
     */
    protected $metadata;

    /**
     * @return mixed
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param mixed $metadata
     * @return $this
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
        return $this;
    }
}
