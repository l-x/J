<?php

namespace J\Message\Command;

use Interop\Container\ContainerInterface;
use J\Message\MessageInterface;
use J\Message\TracerInterface;
use J\Message\Value\Method;

/**
 * Class DetermineControllerCallbackTest
 *
 * @package J\Message\Command
 */
class DetermineControllerCallbackTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var DetermineControllerCallback
     */
    private $command;

    /**
     * @param string $method_name
     * @param mixed $callback
     * @param bool $is_available
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|ContainerInterface
     */
    private function createControllerContainerMock($method_name, $callback, $is_available)
    {
        $controller_container = $this->getMock('Interop\Container\ContainerInterface');
        $controller_container->expects($this->any())
            ->method('has')
            ->with($method_name)
            ->willReturn($is_available);

        if ($is_available) {
            $controller_container->expects($this->any())
                ->method('get')
                ->with($method_name)
                ->willReturn($callback);
        }

        return $controller_container;
    }

    /**
     * @param $method_name
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|TracerInterface
     */
    private function createTracerMock($method_name)
    {
        $method = new Method($method_name);

        $message_mock = $this->getMock('J\Message\MessageInterface');
        $message_mock->expects($this->any())
            ->method('getMethod')
            ->willReturn($method);

        $tracer = $this->getMock('J\Message\TracerInterface');
        $tracer->expects($this->any())
            ->method('getMessage')
            ->willReturn($message_mock);

        return $tracer;
    }

    /**
     * @test
     * @testdox actOn() behaves well on existing method
     */
    public function actOnOnExistingMethod()
    {
        $callback = function () {};
        $controller_container = $this->createControllerContainerMock('blah', $callback, true);
        $command = new DetermineControllerCallback($controller_container);
        $tracer = $this->createTracerMock('blah');
        $tracer->expects($this->atLeastOnce())
            ->method('setCallback')
            ->with($callback);
        $tracer->expects($this->never())->method('setException');

        $command->actOn($tracer);

    }

    /**
     * @test
     * @testdox actOn() behaves well on unknown method
     */
    public function actOnOnUnknownMethod()
    {
        $controller_container = $this->createControllerContainerMock('blah', null, false);
        $command = new DetermineControllerCallback($controller_container);
        $tracer = $this->createTracerMock('blah');
        $tracer->expects($this->never())->method('setCallback');

        $tracer->expects($this->atLeastOnce())->method('setException');

        $command->actOn($tracer);
    }

    /**
     * @test
     * @testdox actOn() behaves well on unknown method
     */
    public function actOnOnNonCallable()
    {
        $this->setExpectedException('\RuntimeException');
        $controller_container = $this->createControllerContainerMock('blah', 'non-callable', true);
        $command = new DetermineControllerCallback($controller_container);
        $tracer = $this->createTracerMock('blah');

        $command->actOn($tracer);
    }

    /**
     * @test
     * @testdox actOn() behaves well when there is an exception from a previous command
     */
    public function actOnOnPreviousException()
    {
        $controller_container = $this->createControllerContainerMock('blah', null, false);
        $command = new DetermineControllerCallback($controller_container);
        $tracer = $this->createTracerMock('blah');
        $tracer->expects($this->any())
            ->method('getException')
            ->willReturn(true);
        $tracer->expects($this->never())->method('setCallback');
        $tracer->expects($this->never())->method('setException');

        $command->actOn($tracer);
    }
}
