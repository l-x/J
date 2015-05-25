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

class Invokeable  {
    public function __invoke($a)
    {
        return func_get_args();
    }

}

/**
 * Class InvokeTest
 *
 * @package J\Message\Command
 */
class InvokeTest extends \PHPUnit_Framework_TestCase {

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
    private function createCallbackMock($params, $return_value)
    {
        $callback = $this->getMockBuilder('stdClass')->setMethods(['__invoke'])->getMock();
        $callback->expects($this->once())
            ->method('__invoke')
            ->willReturnArgument(1);

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
            ->willReturnArgument(0);

        return $handler;
    }

    /**
     * @test
     * @testdox actOn() behaves well for valid data
     */
    public function actOnForValidData()
    {

        $callback = new EchoCallback();

        $tracer = $this->createTracerMock($callback, new Params(['argument']));
        $tracer->expects($this->never())->method('setException');
        $tracer->expects($this->atLeastOnce())->method('setResult');

        $params_handler = $this->createParamsHandlerMock(1);

        $command = new Invoke($params_handler);

        $command->actOn($tracer);
    }

    /**
     * @test
     * @testdox actOn() behaves well on exception in params handler
     */
    public function actOnForParamsHandlerException()
    {
        $exception = new InvalidParams();

        $callback = new EchoCallback();

        $tracer = $this->createTracerMock($callback, new Params(['param']), null);
        $tracer->expects($this->once())->method('setException')->with($exception);
        $tracer->expects($this->once())
            ->method('setException')
            ->with($exception);


        $params_handler = $this->getMock('J\Handler\ParamsHandlerInterface');
        $params_handler->expects($this->any())->method('handle')->willThrowException(new \Exception('fuuu'));

        $command = new Invoke($params_handler);

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
        $tracer->expects($this->any())->method('getCallback')->willReturn($callback);

        $params_handler = $this->createParamsHandlerMock(1);

        $command = new Invoke($params_handler);

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

        $tracer = $this->createTracerMock($callback, new Params([]));
        $tracer->expects($this->once())->method('setException')->with($exception);
        $tracer->expects($this->any())->method('getCallback')->willReturn($callback);

        $params_handler = $this->createParamsHandlerMock(0);

        $command = new Invoke($params_handler);

        $command->actOn($tracer);
    }

    /**
     * @test
     * @testdox actOn behaves well when there is allready an exception from previous commands
     */
    public function actOnForPreviousException()
    {
        $callback = new EchoCallback();
        $tracer = $this->createTracerMock($callback, new Params(['param']), null);
        $tracer->expects($this->any())->method('getException')->willReturn(new \Exception());
        $tracer->expects($this->never())->method('setResult');
        $params_handler = $this->createParamsHandlerMock(0);
        $command = new Invoke($params_handler);

        $command->actOn($tracer);

    }
}
