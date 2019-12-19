<?php

namespace Kuai6\EventBus\PhpUnit\Test\Message;

use Kuai6\EventBus\Message\Header\GenericHeader;
use Kuai6\EventBus\Message\HeaderLoader;
use Kuai6\EventBus\Message\Headers;

/**
 * Class HeadersTest
 * @package Kuai6\EventBus\PhpUnit\Test\Message
 */
class HeadersTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testFromString()
    {
        $headers = new Headers();
        static::assertEquals(0, $headers->count());

        $headersString = 'HeaderFieldName1: headerFieldName1Value';
        $actual = $headers->fromString($headersString);
        static::assertInstanceOf(Headers::class, $actual);
        static::assertEquals(1, $actual->count());
        $actualHeader = $actual->get('HeaderFieldName1');
        static::assertInstanceOf(GenericHeader::class, $actualHeader);
        static::assertEquals('HeaderFieldName1', $actualHeader->getFieldName());
        static::assertEquals('headerFieldName1Value', $actualHeader->getFieldValue());

        $headers = new Headers();
        $headersString = "HeaderFieldName1: headerFieldName1Value\r\nHeaderFieldName2: headerFieldName2Value";
        $actual = $headers->fromString($headersString);
        static::assertInstanceOf(Headers::class, $actual);
        static::assertEquals(2, $actual->count());
        $actualHeader = $actual->get('HeaderFieldName1');
        static::assertInstanceOf(GenericHeader::class, $actualHeader);
        static::assertEquals('HeaderFieldName1', $actualHeader->getFieldName());
        static::assertEquals('headerFieldName1Value', $actualHeader->getFieldValue());

        $actualHeader = $actual->get('HeaderFieldName2');
        static::assertInstanceOf(GenericHeader::class, $actualHeader);
        static::assertEquals('HeaderFieldName2', $actualHeader->getFieldName());
        static::assertEquals('headerFieldName2Value', $actualHeader->getFieldValue());
    }

    /**
     *
     */
    public function testAddHeader()
    {
        $headers = new Headers();
        $headers->addHeader(new GenericHeader('headerName', 'headerValue'));
        static::assertEquals(1, $headers->count());
        $actualHeader = $headers->get('headerName');
        static::assertInstanceOf(GenericHeader::class, $actualHeader);
    }

    /**
     *
     */
    public function testAddHeaderLine()
    {
        $headers = new Headers();
        $headers->addHeaderLine('headerName: headerValue');
        static::assertEquals(1, $headers->count());
        $actualHeader = $headers->get('headerName');
        static::assertInstanceOf(GenericHeader::class, $actualHeader);
        static::assertEquals('headerName', $actualHeader->getFieldName());
        static::assertEquals('headerValue', $actualHeader->getFieldValue());
    }

    /**
     *
     */
    public function testToArray()
    {
        $headers = new Headers();
        $headers->addHeaderLine('headerName: headerValue');
        $result = $headers->toArray();
        static::assertCount(1, $result);
        static::assertTrue(array_key_exists('headerName', $result));
        static::assertEquals('headerValue', $result['headerName']);
    }

    /**
     *
     */
    public function testToString()
    {
        $headers = new Headers();
        $headers->addHeaderLine('headerName: headerValue');
        $result = $headers->toString();
        static::assertEquals("headerName: headerValue\r\n", $result);
    }

    /**
     *
     */
    public function testSetLoader()
    {
        $headers = new Headers();
        static::assertInstanceOf(get_class($headers), $headers->setHeaderLoader(new HeaderLoader()));
    }
}
