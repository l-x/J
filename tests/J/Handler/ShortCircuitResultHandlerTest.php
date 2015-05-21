<?php

namespace J\Handler;

/**
 * Class ShortCircuitResultHandlerTest
 *
 * @package J\Handler
 */
class ShortCircuitResultHandlerTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var ShortCircuitResultHandler
     */
    private $handler;

    /**
     * @return void
     */
    public function setUp()
    {
        $this->handler = new ShortCircuitResultHandler();
    }

    /**
     * @test
     * @testdox returns the given argument as is
     */
    public function handle()
    {
        $argument = new \stdClass();
        $this->assertSame($argument, $this->handler->handle($argument));
    }
}
