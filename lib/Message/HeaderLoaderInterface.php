<?php

namespace Kuai6\EventBus\Message;

/**
 * Interface HeaderLoaderInterface
 * @package Kuai6\EventBus\Message
 */
interface HeaderLoaderInterface
{
    /**
     * Load registered plugin
     *
     * @param $name
     * @return string
     */
    public function load($name): string;

    /**
     * Check if plugin registered/loaded
     *
     * @param $name
     * @return bool
     */
    public function isLoaded($name): bool;
}
