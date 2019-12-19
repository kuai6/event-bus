<?php

namespace Kuai6\EventBus\Message;

use Kuai6\EventBus\Message\Header\Serializer;
use Kuai6\EventBus\Message\Header\Uuid;
use Kuai6\EventBus\MessageInterface;

/**
 * Class AbstractMessage
 * @package Kuai6\EventBus\Message
 */
abstract class AbstractMessage implements MessageInterface
{
    /**
     * Message Headers
     *
     * @var Headers
     */
    protected $headers;

    /**
     * Message content
     *
     * @var string
     */
    protected $content;

    /**
     * Storage for some raw data if you need
     *
     * @var mixed
     */
    protected $raw;

    /**
     * AbstractMessage constructor.
     * @throws  \Kuai6\EventBus\Message\Exception\InvalidArgumentException
     */
    public function __construct()
    {
        if (!$this->getHeaders()->has(Uuid::NAME)) {
            try {
                $uuid = \Ramsey\Uuid\Uuid::uuid4();
                $this->getHeaders()->addHeaderLine(Uuid::NAME . ': ' . $uuid->toString());
            } catch (\Exception $e) {
            }
        }

        if (!$this->getHeaders()->has(Serializer::NAME)) {
            $this->getHeaders()->addHeaderLine(Serializer::NAME .': json');
        }
    }

    /**
     * @return Headers
     */
    public function getHeaders(): Headers
    {
        if ($this->headers === null) {
            $this->headers = new Headers();
        }
        return $this->headers;
    }

    /**
     * @param Headers $headers
     * @return $this
     */
    public function setHeaders(Headers $headers)
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRaw()
    {
        return $this->raw;
    }

    /**
     * @param mixed $raw
     * @return $this
     */
    public function setRaw($raw)
    {
        $this->raw = $raw;
        return $this;
    }
}
