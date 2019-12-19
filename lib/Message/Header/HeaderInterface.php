<?php

namespace Kuai6\EventBus\Message\Header;

/**
 * Interface MessageHeaderInterface
 * @package Kuai6\EventBus\Message
 */
interface HeaderInterface
{
    /**
     * Factory to generate a header object from a string
     *
     * @param string $headerLine
     * @return self
     */
    public static function fromString($headerLine);

    /**
     * Retrieve header name
     *
     * @return string
     */
    public function getFieldName();

    /**
     * Retrieve header value
     *
     * @return string
     */
    public function getFieldValue();

    /**
     * Cast to string
     *
     * Returns in form of "NAME: VALUE"
     *
     * @return string
     */
    public function toString();
}
