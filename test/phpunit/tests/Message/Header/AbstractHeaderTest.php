<?php

namespace Kuai6\EventBus\PhpUnit\Test\Message\Header;

use Kuai6\EventBus\Message\Header\AbstractHeader;

/**
 * Class AbstractHeaderTest
 * @package Kuai6\EventBus\PhpUnit\Test\Message\Header
 */
class AbstractHeaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testCreate()
    {
        $value = '123';

        $header = $this->getMockBuilder(AbstractHeader::class)
                        ->setConstructorArgs([$value])
                        ->getMockForAbstractClass();

        static::assertEquals('', $header->getFieldName());
        static::assertEquals($value, $header->getFieldValue());
    }

    /**
     *
     */
    public function testFromStringAndToString()
    {
        $line = ': 123';

        $header = $this->getMockBuilder(AbstractHeader::class)
            ->setConstructorArgs(['123'])
            ->getMockForAbstractClass();
        $header::fromString($line);

        static::assertEquals('', $header->getFieldName());
        //wrong tests:
        //::fromString create a new static instance  (mocked with constructor arg '123') .
        //think about this ...
        static::assertEquals('123', $header->getFieldValue());
        static::assertEquals($line, $header->toString());
    }


    /**
     * @expectedException  \Kuai6\EventBus\Message\Header\Exception\InvalidArgumentException
     * @expectedExceptionMessage Invalid header line string: "haha"
     */
    public function testFromStringFail()
    {
        $line = 'haha: 123';

        $header = $this->getMockBuilder(AbstractHeader::class)
            ->setConstructorArgs(['123'])
            ->getMockForAbstractClass();
        $header::fromString($line);
    }
}
