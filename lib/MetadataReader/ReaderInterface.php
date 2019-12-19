<?php

namespace Kuai6\EventBus\MetadataReader;

/**
 * Interface ReaderInterface
 * @package Kuai6\EventBus\MetadataReader
 */
interface ReaderInterface
{
    /**
     * Возвращает все имена классов, которые могут быта обработанны данным драйвером
     *
     * @return array
     */
    public function getAllClassNames();

    /**
     * @param $class
     *
     * @return mixed
     */
    public function loadMetadataForClass($class);

    /**
     * Build and return MetadataObject
     *
     * @param $metadataClassName
     * @return mixed
     */
    public function buildMetadata($metadataClassName);
}
