<?php

namespace J\Handler;

/**
 * Class ShortCircuitParamsHandlerTest
 *
 * @package J
 */
class ShortCircuitParamsHandlerTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var ShortCircuitParamsHandler
     */
    private $handler;

    /**
     * @return void
     */
    public function setUp()
    {
        $this->handler = new ShortCircuitParamsHandler();
    }

    /**
     * @test
     * @testdox handle() returns the argument casted to array
     */
    public function handle()
    {
        $this->assertEquals(['fu'], $this->handler->handle('fu'));
    }
}
