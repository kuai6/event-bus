<?php


namespace Kuai6\EventBus\PhpUnit\Test\Message;

use Kuai6\EventBus\Message\Header\Uuid;
use Kuai6\EventBus\Message\HeaderLoader;

class HeaderLoaderTest extends \PHPUnit_Framework_TestCase
{
    public function test()
    {
        $headerLoader = new HeaderLoader();

        static::assertTrue($headerLoader->isLoaded(Uuid::NAME));
        static::assertFalse($headerLoader->isLoaded('notLoadedHeader'));
        static::assertFalse($headerLoader->isLoaded(null));

        static::assertEquals(Uuid::class, $headerLoader->load(Uuid::NAME));
    }

    /**
     * @expectedException \Kuai6\EventBus\Message\Exception\InvalidArgumentException
     * @expectedExceptionMessage Header with name notLoadedHeader not registered
     */
    public function testLoadWrongClass()
    {
        $headerLoader = new HeaderLoader();
        $headerLoader->load('notLoadedHeader');
    }

    /**
     * @expectedException  \Kuai6\EventBus\Message\Exception\InvalidArgumentException
     * @expectedExceptionMessage Header with name  not registered
     */
    public function testLoadEmptyClass()
    {
        $headerLoader = new HeaderLoader();
        $headerLoader->load(null);
    }
}
