<?php

namespace Kuai6\EventBus\PhpUnit\Test\Logger;

use Kuai6\EventBus\Logger\LoggerAwareTrait;
use Psr\Log\LoggerInterface;

/**
 * Class LoggerAwareTraitTest
 * @package Kuai6\EventBus\PhpUnit\Test\Logger
 */
class LoggerAwareTraitTest extends \PHPUnit_Framework_TestCase
{
    use LoggerAwareTrait;

    public function test()
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)->getMock();

        static::assertInstanceOf(self::class, $this->setLogger($logger));
        static::assertEquals($logger, $this->getLogger());
    }
}
