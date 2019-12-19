<?php

namespace Kuai6\EventBus\PhpUnit\Test\Message\Header;

use Kuai6\EventBus\Message\Header\GenericHeader;

/**
 * Class GenericHeaderTest
 * @package Kuai6\EventBus\PhpUnit\Test\Message\Header
 */
class GenericHeaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testCreate()
    {
        $header = new GenericHeader();
        static::assertNull($header->getFieldName());
        static::assertNull($header->getFieldValue());

        $header = new GenericHeader('name', 'value');
        static::assertEquals('name', $header->getFieldName());
        static::assertEquals('value', $header->getFieldValue());
    }

    /**
     *
     */
    public function testCreateFromString()
    {
        $header = GenericHeader::fromString('name: value');
        static::assertInstanceOf(GenericHeader::class, $header);
        static::assertEquals('name', $header->getFieldName());
        static::assertEquals('value', $header->getFieldValue());

        $header = GenericHeader::fromString("name:  \t\n\r \f \v");
        static::assertInstanceOf(GenericHeader::class, $header);
        static::assertEquals('name', $header->getFieldName());
        static::assertEquals('', $header->getFieldValue());
    }

    /**
     * @expectedException  \Kuai6\EventBus\Message\Header\Exception\InvalidArgumentException
     */
    public function testCreateFail()
    {
        new GenericHeader(new \stdClass(), new \stdClass());
    }

    /**
     * @expectedException  \Kuai6\EventBus\Message\Header\Exception\InvalidArgumentException
     */
    public function testCreateFromStringFail()
    {
        GenericHeader::fromString('name');
    }

    /**
     * @expectedException  \Kuai6\EventBus\Message\Header\Exception\InvalidArgumentException
     */
    public function testCreateFromStringFailWrongCharacters()
    {
        GenericHeader::fromString("\xA0:\xF0");
    }

    /**
     *
     */
    public function testToString()
    {
        $header = GenericHeader::fromString('name: value');
        static::assertEquals('name: value', $header->toString());
    }
}
