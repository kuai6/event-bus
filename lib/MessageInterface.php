<?php

namespace Kuai6\EventBus;

use Kuai6\EventBus\Message\Headers;

/**
 * Interface MessageInterface
 * @package Kuai6\EventBus
 */
interface MessageInterface
{
    /**
     * Get message content
     *
     * @return string
     */
    public function getContent();

    /**
     * Set message data
     *
     * @param $content
     * @return $this
     */
    public function setContent($content);

    /**
     * Get message headers
     *
     * @return Headers
     */
    public function getHeaders();

    /**
     * Set Raw data to store something...
     *
     * @param $raw
     * @return $this
     */
    public function setRaw($raw);

    /**
     * Get come Raw data
     *
     * @return mixed
     */
    public function getRaw();
}
