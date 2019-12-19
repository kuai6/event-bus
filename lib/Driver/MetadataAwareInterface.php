<?php

namespace Kuai6\EventBus\Driver;

/**
 * Interface MetadataAwareInterface
 * @package Kuai6\EventBus\Driver
 */
interface MetadataAwareInterface
{
    /**
     * @return mixed
     */
    public function getMetadata();

    /**
     * @param $metadata
     * @return mixed
     */
    public function setMetadata($metadata);
}
