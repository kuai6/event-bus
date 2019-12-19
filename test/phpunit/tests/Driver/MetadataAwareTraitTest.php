<?php

namespace Kuai6\EventBus\PhpUnit\Test\Driver;

use Kuai6\EventBus\Driver\MetadataAwareTrait;

/**
 * Class MetadataAwareTraitTest
 * @package Kuai6\EventBus\PhpUnit\Test\Driver
 */
class MetadataAwareTraitTest extends \PHPUnit_Framework_TestCase
{
    use MetadataAwareTrait;

    /**
     *
     */
    public function test()
    {
        $metadata = ['key' => 'value', new \stdClass()];
        static::assertEquals($this, $this->setMetadata($metadata));
        static::assertEquals($metadata, $this->getMetadata());
    }
}
