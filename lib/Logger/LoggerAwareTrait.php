<?php

namespace Kuai6\EventBus\Logger;

use Psr\Log\LoggerInterface;

/**
 * Class LoggerAwareTrait
 * @package Kuai6\EventBus\Logger
 */
trait LoggerAwareTrait
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @return LoggerInterface
     */
    public function getLogger(): ?LoggerInterface
    {
        return $this->logger;
    }

    /**
     * @param LoggerInterface $logger
     * @return $this
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
        return $this;
    }
}
