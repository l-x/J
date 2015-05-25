<?php

namespace J\Message\Command;

use J\Exception\MethodNotFound;
use J\Message\Value\Id;
use J\Message\Value\Jsonrpc;

/**
 * Class ExtractTest
 *
 * @package J\Message\Command
 */
class ExtractTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Extract
     */
    private $command;

    public function setUp()
    {
        $this->command = new Extract();
    }

    /**
     * @param mixed      $response_data
     * @param \Exception $exception
     *
     * @return mixed
     */
    private function createTracerMock($expected_result, $actual_result = null, \Exception $exception = null)
    {
        $message_mock = $this->getMock('J\Message\MessageInterface');
        $message_mock->expects($this->any())
            ->method('getId')
            ->willReturn(new Id('id'));
        $message_mock->expects($this->any())
            ->method('getJsonrpc')
            ->willReturn(new Jsonrpc('2.0'));

        $mock = $this->getMock('J\Message\TracerInterface');
        $mock->expects($this->any())
            ->method('getResult')
            ->willReturn($actual_result);
        $mock->expects($this->any())
            ->method('getException')
            ->willReturn($exception);
        $mock->expects($this->any())
            ->method('getMessage')
            ->willReturn($message_mock);
        $mock->expects($this->atLeastOnce())
            ->method('setResponseData')
            ->with($expected_result);

        return $mock;
    }

    /**
     * @test
     * @testdox actOn() behaves well on no exception an no result handler
     */
    public function actOnNoExceptionNoResultHandler()
    {
        $expected = (object) [
            'id'        => 'id',
            'jsonrpc'   => '2.0',
            'result'    => 'fu',
        ];

        $tracer = $this->createTracerMock($expected, $expected->result, null);
        $command = new Extract();
        $command->actOn($tracer);
    }

    /**
     * @stest
     * @testdox actOn() behaves well on no exception an with result handler
     */
    public function actOnNoExceptionWithResultHandler()
    {
        $expected = (object) [
            'id'        => 'id',
            'jsonrpc'   => '2.0',
            'result'    => 'fu',
        ];

        $tracer = $this->createTracerMock($expected, 'bar', null);
        $result_handler = $this->getMock('J\Handler\ResultHandlerInterface');
        $result_handler->expects($this->any())
            ->method('handle')
            ->with('bar')
            ->willReturn('fu');

        $command = new Extract($result_handler);
        $command->actOn($tracer);
    }

    /**
     * @test
     * @testdox actOn() behaves well on exception in result handler
     */
    public function actOnExceptionInResultHandler()
    {
        $expected = (object) [
            'id'        => 'id',
            'jsonrpc'   => '2.0',
            'error'    => (object) [
                'code'      => -32603,
                'message'   => 'Internal error',
            ],
        ];

        $tracer = $this->createTracerMock($expected, 'bar', null);
        $result_handler = $this->getMock('J\Handler\ResultHandlerInterface');
        $result_handler->expects($this->any())
            ->method('handle')
            ->with('bar')
            ->willThrowException(new \Exception());

        $command = new Extract($result_handler);
        $command->actOn($tracer);
    }

    /**
     * @test
     * @testdox actOn() behaves well on existing tracer exception
     */
    public function actOnTracerException()
    {
        $expected = (object) [
            'id'        => 'id',
            'jsonrpc'   => '2.0',
            'error'    => (object) [
                'code'      => -32603,
                'message'   => 'Internal error',
            ],
        ];

        $tracer = $this->createTracerMock($expected, null, new \Exception());
        $command = new Extract();
        $command->actOn($tracer);
    }

    /**
     * @test
     * @testdox actOn() behaves well on existing tracer jsonrpc exception
     */
    public function actOnTracerExceptionJsonrpc()
    {
        $expected = (object) [
            'id'        => 'id',
            'jsonrpc'   => '2.0',
            'error'    => (object) [
                'code'      => -32601,
                'message'   => 'Method not found',
            ],
        ];

        $tracer = $this->createTracerMock($expected, null, new MethodNotFound());
        $command = new Extract();
        $command->actOn($tracer);
    }

    /**
     * @test
     * @testdox actOn() behaves well on tracer exception and exception handler
     */
    public function actOnExceptionHandler()
    {
        $expected = (object) [
            'id'        => 'id',
            'jsonrpc'   => '2.0',
            'error'    => (object) [
                'code'      => 1337,
                'message'   => 'some fault',
            ],
        ];

        $exception = new \Exception();

        $exception_handler = $this->getMock('J\Handler\ExceptionHandlerInterface');
        $exception_handler->expects($this->once())
            ->method('handle')
            ->with($exception)
            ->willReturn(new \Exception('some fault', 1337));

        $tracer = $this->createTracerMock($expected, null, new \Exception());
        $command = new Extract(null, $exception_handler);
        $command->actOn($tracer);
    }

    /**
     * @test
     * @testdox actOn() behaves well on exception in exception handler
     */
    public function actOnExceptionHandlerException()
    {
        $expected = (object) [
            'id'        => 'id',
            'jsonrpc'   => '2.0',
            'error'    => (object) [
                'code'      => -32603,
                'message'   => 'Internal error',
            ],
        ];

        $exception = new \Exception();

        $exception_handler = $this->getMock('J\Handler\ExceptionHandlerInterface');
        $exception_handler->expects($this->once())
            ->method('handle')
            ->with($exception)
            ->willThrowException($exception);

        $tracer = $this->createTracerMock($expected, null, new \Exception());
        $command = new Extract(null, $exception_handler);
        $command->actOn($tracer);
    }
}
