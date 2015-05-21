<?php

namespace J\Message;

/**
 * Class TracerFactoryTest
 *
 * @package J\Message
 */
class TracerFactoryTest extends \PHPUnit_Framework_TestCase {

    /**
     * @test
     * @testdox createTracer() returns properly configured Tracer instance
     */
    public function createTracer()
    {
        $factory = new TracerFactory();
        $tracer = $factory->createTracer();

        $this->assertInstanceOf(Tracer::class, $tracer);
        $this->assertInstanceOf(Message::class, $tracer->getMessage());
    }
}
