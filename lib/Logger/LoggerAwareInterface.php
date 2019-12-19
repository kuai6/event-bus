<?php

namespace Kuai6\EventBus\Logger;

use Psr\Log\LoggerInterface;

/**
 * Interface LoggerAwareInterface
 * @package Kuai6\EventBus\Logger
 */
interface LoggerAwareInterface
{
    /**
     * Get configured logger
     *
     * @return LoggerInterface
     */
    public function getLogger(): ?LoggerInterface;

    /**
     * Set configured logger
     *
     * @param LoggerInterface $logger
     * @return self
     */
    public function setLogger(LoggerInterface $logger);
}
