<?php


namespace Kuai6\EventBus\PhpUnit\Test\Message;

use Kuai6\EventBus\Message\AbstractMessage;
use Kuai6\EventBus\Message\Header\Serializer;
use Kuai6\EventBus\Message\Header\Uuid;
use Kuai6\EventBus\Message\Headers;

class AbstractMessageTest extends \PHPUnit_Framework_TestCase
{
    public function test()
    {
        $mock = $this->getMockBuilder(AbstractMessage::class)->getMockForAbstractClass();

        /** @var Headers $headers */
        $headers = $mock->getHeaders();

        static::assertInstanceOf(Headers::class, $headers);
        static::assertCount(2, $headers);

        static::assertTrue($headers->has(Uuid::NAME));
        static::assertTrue($headers->has(Serializer::NAME));
        static::assertEquals('json', $headers->get(Serializer::NAME)->getFieldValue());

        $headers = new Headers();
        static::assertInstanceOf(get_class($mock), $mock->setHeaders($headers));
        static::assertEquals($headers, $mock->getHeaders());

        $content = '12354qwe';
        static::assertInstanceOf(get_class($mock), $mock->setContent($content));
        static::assertEquals($content, $mock->getContent());

        $raw = new \stdClass();
        static::assertInstanceOf(get_class($mock), $mock->setRaw($raw));
        static::assertEquals($raw, $mock->getRaw());
    }
}
