<?php

namespace Kuai6\EventBus\MetadataReader;

/**
 * Interface MetadataInterface
 * @package Kuai6\EventBus\MetadataReader
 */
interface MetadataInterface
{
    /**
     * Build metadata from content
     *
     * @param $metadata
     * @return mixed
     */
    public function __construct($metadata);

    /**
     * Return metadata as string
     *
     * @return string
     */
    public function toString();
}
