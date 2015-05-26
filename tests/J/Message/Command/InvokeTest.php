<?php

namespace J\Message\Command;

use J\Exception\InvalidParams;
use J\Message\TracerInterface;
use J\Message\Value\Params;
use J\Handler\ParamsHandlerInterface;

class EchoCallback {
    public function __invoke($argument)
    {
        return $argument;
    }
}

/**
 * Class InvokeTest
 *
 * @package J\Message\Command
 */
class InvokeTest extends \PHPUnit_Framework_TestCase {

    private $echo_callback;

    public function setUp()
    {
        $this->echo_callback = function ($params)
        {
            return $params;
        };
    }

    /**
     * @param Params|null $params
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|TracerInterface
     */
    private function createTracerMock($callback, $params)
    {
        $message_mock = $this->getMock('J\Message\MessageInterface');
        $tracer_mock = $this->getMock('J\Message\TracerInterface');

        $tracer_mock->expects($this->any())
            ->method('getMessage')
            ->willReturn($message_mock);
        $tracer_mock->expects($this->any())
            ->method('getCallback')
            ->willReturn($callback);

        $message_mock->expects($this->any())
            ->method('getParams')
            ->willReturn($params);


        return $tracer_mock;
    }

    /**
     * @param \PHPUnit_Framework_MockObject_MockObject|TracerInterface $tracer
     * @param mixed $return_value
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|callable
     */
    private function createCallbackMock()
    {
        $callback = $this->getMockBuilder('\stdClass')->setMethods(['__invoke'])->getMock();
        $callback->expects($this->once())
            ->method('__invoke')
            ->willReturnArgument(0);

        return $callback;
    }

    /**
     * @param int $times
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|ParamsHandlerInterface
     */
    private function createParamsHandlerMock($times)
    {
        $handler = $this->getMock('J\Handler\ParamsHandlerInterface');
        $handler->expects($this->exactly($times))
            ->method('handle')
            ->willReturnArgument(1);

        return $handler;
    }

    /**
     * @test
     * @testdox actOn() behaves well for valid data
     */
    public function actOnForValidData()
    {
        $tracer = $this->createTracerMock($this->echo_callback, new Params(['argument']));
        $tracer->expects($this->never())->method('setException');
        $tracer->expects($this->atLeastOnce())->method('setResult');

        $command = new Invoke();
        $command->actOn($tracer);

        $command->setParamsHandler($this->createParamsHandlerMock(1));
        $command->actOn($tracer);
    }

    /**
     * @test
     * @testdox actOn() behaves well on exception in params handler
     */
    public function actOnForParamsHandlerException()
    {
        $exception = new InvalidParams();

        $tracer = $this->createTracerMock($this->echo_callback, new Params(['param']), null);
        $tracer->expects($this->once())
            ->method('setException')
            ->with($exception);

        $params_handler = $this->getMock('J\Handler\ParamsHandlerInterface');
        $params_handler->expects($this->any())
            ->method('handle')
            ->willThrowException(new \Exception('fuuu'));

        $command = new Invoke();
        $command->setParamsHandler($params_handler);

        $command->actOn($tracer);
    }

    /**
     * @test
     * @testdox actOn() behaves well on exception in callback
     */
    public function actOnForCallbackException()
    {
        $exception = new \Exception();

        $callback = function () use ($exception) { throw $exception; };

        $tracer = $this->createTracerMock($callback, new Params(['param']));
        $tracer->expects($this->once())->method('setException')->with($exception);

        $command = new Invoke();
        $command->setParamsHandler($this->createParamsHandlerMock(1));
        $command->actOn($tracer);
    }

    /**
     * @test
     * @testdox actOn() behaves well on missing params
     */
    public function actOnForMissingParams()
    {
        $exception = new InvalidParams();

        $callback = new EchoCallback();

        $tracer = $this->createTracerMock($this->echo_callback, new Params([]));
        $tracer->expects($this->once())->method('setException')->with($exception);

        $command = new Invoke();
        $command->setParamsHandler($this->createParamsHandlerMock(0));

        $command->actOn($tracer);
    }

    /**
     * @test
     * @testdox actOn behaves well when there is allready an exception from previous commands
     */
    public function actOnForPreviousException()
    {
        $tracer = $this->createTracerMock($this->echo_callback, new Params(['param']), null);
        $tracer->expects($this->any())->method('getException')->willReturn(new \Exception());
        $tracer->expects($this->never())->method('setResult');

        $command = new Invoke();
        $command->setParamsHandler($this->createParamsHandlerMock(0));

        $command->actOn($tracer);
    }
}
