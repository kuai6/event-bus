<?php

namespace Kuai6\EventBus\Message;

use Kuai6\EventBus\Message\Exception\InvalidArgumentException;
use Kuai6\EventBus\Message\Header\CorrelationId;
use Kuai6\EventBus\Message\Header\Hydrator;
use Kuai6\EventBus\Message\Header\MessageId;
use Kuai6\EventBus\Message\Header\ReplyTo;
use Kuai6\EventBus\Message\Header\Serializer;
use Kuai6\EventBus\Message\Header\Uuid;

/**
 * Class HeaderLoader
 * @package Kuai6\EventBus\Message
 */
class HeaderLoader implements HeaderLoaderInterface
{
    /**
     * @var array
     */
    protected $plugins = [
        Uuid::NAME          => Uuid::class,
        Serializer::NAME    => Serializer::class,
        Hydrator::NAME      => Hydrator::class,
        CorrelationId::NAME => CorrelationId::class,
        MessageId::NAME     => MessageId::class,
        ReplyTo::NAME       => ReplyTo::class,
    ];

    /**
     * @param $name
     * @return string
     * @throws  \Kuai6\EventBus\Message\Exception\InvalidArgumentException
     */
    public function load($name): string
    {
        if (!$this->isLoaded($name)) {
            throw new InvalidArgumentException(
                sprintf('Header with name %s not registered', $name)
            );
        }
        return $this->plugins[strtolower($name)];
    }

    /**
     * @param $name
     * @return bool
     */
    public function isLoaded($name): bool
    {
        $lookup = strtolower($name);
        return isset($this->plugins[$lookup]);
    }
}
