<?php

namespace Kuai6\EventBus\Message\Header;

/**
 * Class AbstractHeader
 * @package Kuai6\EventBus\Message\Header
 */
abstract class AbstractHeader implements HeaderInterface
{
    const NAME = '';

    /**
     * @var string
     */
    protected $value;

    /**
     * Uuid constructor.
     * @param string $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Factory to generate a header object from a string
     *
     * @param string $headerLine
     * @return self
     * @throws  \Kuai6\EventBus\Message\Header\Exception\InvalidArgumentException
     */
    public static function fromString($headerLine)
    {
        list($name, $value) = GenericHeader::splitHeaderLine($headerLine);

        $class = get_called_class();
        // check to ensure proper header type for this factory
        if (strtolower($name) !== $class::NAME) {
            throw new Exception\InvalidArgumentException(sprintf(
                'Invalid header line string: "%s"',
                $name
            ));
        }

        return new static($value);
    }

    /**
     * Retrieve header name
     *
     * @return string
     */
    public function getFieldName(): string
    {
        return self::NAME;
    }

    /**
     * Retrieve header value
     *
     * @return string
     */
    public function getFieldValue()
    {
        return $this->value;
    }

    /**
     * Cast to string
     *
     * Returns in form of "NAME: VALUE"
     *
     * @return string
     */
    public function toString()
    {
        return $this->getFieldName() . ': '. $this->getFieldValue();
    }
}
